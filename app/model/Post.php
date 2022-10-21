<?php

declare(strict_types=1);

namespace app\model;

use Parsedown;
use ScssPhp\ScssPhp\Compiler;
use think\facade\App;
use think\facade\Cache;
use think\facade\Env;
use think\facade\Request;
use think\facade\View;
use think\Model;
use think\model\concern\SoftDelete;

/**
 * @mixin think\Model
 */
class Post extends Model
{
    //

    public static $stausNameList = [
        0 => '不发布',
        1 => '发布'
    ];

    use SoftDelete;

    protected $defaultSoftDelete = 0;

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function categorys()
    {
        return $this->hasMany(PostCategory::class, 'post_id');
    }

    public function tags()
    {
        return $this->hasMany(PostTag::class, 'post_id');
    }

    public function setPublishTimeAttr($value)
    {
        return strtotime($value);
    }
    public function getPublishTimeTextAttr()
    {

        $value = $this->getData('publish_time');
        return date('Y-m-d', $value);
    }
    public function getPublishTimeDatetimeAttr()
    {

        $value = $this->getData('publish_time');
        return date('Y-m-d H:i:s', $value);
    }

    public function getCategorysListAttr()
    {
        $list_post_categorys = $this->getAttr('categorys');

        $list = array_column($list_post_categorys->append(['category'])->toArray(), 'category');

        $list = array2level($list, 0, 0);

        return $list;
    }

    public function getTagsListAttr()
    {
        $list_post_tags = $this->getAttr('tags');

        $list = array_column($list_post_tags->append(['tag'])->toArray(), 'tag');

        return $list;
    }

    public function getDescShortAttr()
    {
        $desc = $this->getData('desc');

        if (strlen($desc) > 100) {
            $desc = mb_substr($desc, 0, 100) . '...';
        }

        return $desc;
    }

    public function getDescListAttr()
    {
        $desc = $this->getData('desc');

        if (empty($desc)) {
            return '';
        }
        $list = explode("\n", $desc);

        return $list;
    }

    public function getDescHtmlAttr()
    {
        $desc = $this->getData('desc');

        if (empty($desc)) {
            return '';
        }

        return str_replace("\n", '<br>', $desc);
    }

    public function getStatusNameAttr()
    {
        return self::$stausNameList[$this->getData('status')];
    }

    public function setPubishTimeAttr($value)
    {
        return strtotime($value);
    }

    public function setContentAttr($value)
    {
        return json_encode($value);
    }
    public function setContentHtmlAttr($value)
    {
        return trim($value);
    }

    public function getContentAttr($value)
    {
        return json_decode($value, true);
    }

    public function getPosterAttr($value)
    {
        if (empty($value)) {
            $value = '/static/images/avatar.png';
        }

        return get_source_link($value);
    }

    public function getDemoPageAttr()
    {
        if (empty($this->getData('tpl_name'))) {
            return '';
        }

        $base_dir = App::getRootPath() . '/demo/' . $this->getAttr('category')->getData('tpl_name') . '/';

        $file_path = $base_dir . $this->getData('tpl_name') . '.html';
        if (!file_exists($file_path)) {
            return '';
        }

        View::assign('site_logo_src', get_source_link(get_system_config('site_logo')));

        return View::fetch($file_path);
    }

    public function getComponentsAttr()
    {
        if (empty($this->getData('tpl_name'))) {
            return [];
        }

        $tpl_name = $this->getData('tpl_name');

        $components_type_path = App::getRootPath() . '/source/components/' . $tpl_name;

        if (!is_dir($components_type_path)) {
            return [];
        }


        $cache_key = 'cache_components_data_' . $tpl_name;

        $list_components_data = Cache::get($cache_key);

        if (!is_null($list_components_data) && !Env::get('APP_DEBUG')) {
            return $list_components_data;
        }

        $list_components = scandir($components_type_path);



        $list_components_data = [];


        $scss_compiler = new Compiler();

        $markdown_parser = new Parsedown();

        foreach ($list_components as  $components_name) {
            if ($components_name == '.' || $components_name == '..') {
                continue;
            }
            $components_path = $components_type_path . '/' . $components_name;

            $list_components_data[$components_name]['title'] = file_get_contents($components_path . '/_title.txt');
            $list_components_data[$components_name]['html'] = file_get_contents($components_path . '/_index.html');
            $list_components_data[$components_name]['scss'] = file_get_contents($components_path . '/_index.scss');
            $list_components_data[$components_name]['css'] = $scss_compiler->compileString($list_components_data[$components_name]['scss'])->getCss();
            $list_components_data[$components_name]['markdown'] = file_get_contents($components_path . '/_index.md');
            $list_components_data[$components_name]['desc'] = $markdown_parser->text($list_components_data[$components_name]['markdown']);
        }

        Cache::set($cache_key, $list_components_data, 60);

        return $list_components_data;
    }


    public static function quickSelect($clear = false)
    {
        $cacke_key = 'post_list';

        $list_post = Cache::get($cacke_key);

        if (empty($list_post) || $clear) {

            $list_post = Category::with(['post'])->where('type', 'default')
                ->where('status', 1)
                ->order('sort asc')
                ->select();

            Cache::set($cacke_key, $list_post, 600);
        }

        return $list_post;
    }

    public static function quickFind($id, $clear = false)
    {
        $cache_key = 'post_item_' . $id;

        $model_post = Cache::get($cache_key);

        if (empty($model_post) || $clear) {
            $model_post = Post::with(['category'], 'left')->find($id);
            Cache::set($cache_key, $model_post, get_system_config('cache_expire_time'));
        }

        return $model_post;
    }
    public static function quickFindByTplName($tpl_name, $clear = false)
    {
        $cache_key = 'post_item_' . $tpl_name;

        $model_post = Cache::get($cache_key);

        if (empty($model_post) || $clear) {
            $model_post = Post::with(['category'], 'left')->where('tpl_name', $tpl_name)->find();

            Cache::set($cache_key, $model_post, get_system_config('cache_expire_time'));
        }
        return $model_post;
    }

    public function getReadUrlAttr()
    {
        $domain = Request::domain();

        $doc_name = $this->getData('tpl_name') ?: $this->getData('id');

        return $domain . '/index/doc/' . $doc_name . '.html';
    }
}
