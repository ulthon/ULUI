<?php

declare(strict_types=1);

namespace app\command;

use app\model\Category;
use app\model\Post;
use think\console\Command;
use think\console\Input;
use think\console\input\Argument;
use think\console\input\Option;
use think\console\Output;
use think\facade\App;
use think\facade\Config;

class ScanDemo extends Command
{
    protected function configure()
    {
        // 指令配置
        $this->setName('scan:demo')
            ->setDescription('the scan:demo command');
    }

    protected function execute(Input $input, Output $output)
    {
        // 指令输出
        $output->writeln('scan:demo');


        $model_category = Category::where('title', '组件')->find();

        $demo_pc_dir = App::getRootPath() . '/demo/pc';
        
        $list_demo_file = scandir($demo_pc_dir);

        foreach ($list_demo_file as  $file_name) {
            $file_name = str_replace(['.html', '.', '..',], '', $file_name);

            if (empty($file_name)) {
                continue;
            }

            $model_post = Post::where('tpl_name', $file_name)->find();
            if (empty($model_post)) {
                $output->writeln('新组件：' . $file_name);
                $model_post = new Post();
                $model_post->type = 'default';
                $model_post->tpl_name = $file_name;
                $model_post->title = Config::get("demo.{$file_name}.title", $file_name);
                $model_post->desc = Config::get("demo.{$file_name}.desc", $file_name);
                $model_post->category_id = $model_category['id'];
                $model_post->save();
            }
        }
    }
}
