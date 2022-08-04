<?php

use app\model\Category;
use app\model\Post;
use think\facade\App;
use think\facade\Config;
use think\migration\Seeder;

class InitPost extends Seeder
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run()
    {
        $list_category = ['起步' => [], '组件' => ['tpl_name' => 'pc'], '扩展' => []];

        foreach ($list_category as $category_title => &$category_data) {
            $model_category =  Category::where('title', $category_title)->find();

            if (empty($model_category)) {
                $model_category = Category::create([
                    'title' => $category_title,
                    'tpl_name' => $category_data['tpl_name'] ?? '',
                    'status' => 1
                ]);
            }

            $category_data['model'] = $model_category;
        }

        $demo_pc_dir = App::getRootPath() . '/demo/pc';

        $list_demo_file = scandir($demo_pc_dir);

        foreach ($list_demo_file as  $file_name) {
            $file_name = str_replace(['.html', '.', '..',], '', $file_name);

            if (empty($file_name)) {
                continue;
            }

            $model_post = Post::where('tpl_name', $file_name)->find();
            if (empty($model_post)) {
                $model_post = new Post();
                $model_post->type = 'default';
                $model_post->tpl_name = $file_name;
                $model_post->title = Config::get("demo.{$file_name}.title", $file_name);
                $model_post->desc = Config::get("demo.{$file_name}.desc", $file_name);
                $model_post->category_id = $list_category['组件']['model']['id'];
                $model_post->save();
            }
        }
    }
}
