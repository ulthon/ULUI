<?php

declare(strict_types=1);

namespace app\command\make;

use think\console\Command;
use think\console\Input;
use think\console\input\Argument;
use think\console\input\Option;
use think\console\Output;
use think\facade\App;
use think\facade\View;

class Component extends Command
{
    protected function configure()
    {
        // 指令配置
        $this->setName('make:component')

            ->addArgument('tpl', Argument::REQUIRED, '组件类型')
            ->addArgument('component', Argument::REQUIRED, '组件文件名')
            ->addArgument('component-title', Argument::OPTIONAL, '组件名称')
            ->addOption('force', 'f', Option::VALUE_NONE, '强制覆盖')
            ->addOption('delete', 'd', Option::VALUE_NONE, '删除')
            ->setDescription('the make:component command');
    }

    protected function execute(Input $input, Output $output)
    {
        // 指令输出
        $output->writeln('make:component');

        $tpl = $input->getArgument('tpl');
        $component = $input->getArgument('component');
        $component_title = $input->getArgument('component-title') ?: $component;

        $component_tpl_dir = App::getRootPath() . '/source/components/';
        $target_dir = $component_tpl_dir . $tpl . '/' . $component;

        if (is_dir($target_dir)) {
            if (!$input->hasOption('force') && !$input->hasOption('delete')) {
                $output->error('目标组件已存在:' . $target_dir);
                $output->error('如需覆盖请添加参数 -f');

                return false;
            }
        } else {
            if ($input->hasOption('delete')) {
                $output->writeln('组件不存在:' . $target_dir);

                return;
            }
            mkdir($target_dir, 0777, true);
        }

        $assign_data = [
            'component' => $component,
            'component_title' => $component_title,
        ];

        $files = [
            '_index.env',
            '_index.html',
            '_index.md',
            '_index.scss',
            '_index.php',
        ];

        foreach ($files as  $file_name) {
            $file_path = __DIR__ . '/component/tpl/' . $file_name;
            $target_file_path = $target_dir . '/' . $file_name;

            if ($input->hasOption('delete')) {
                @unlink($target_file_path);
                $output->info('删除：' . $target_file_path);
                continue;
            } else {
                if (pathinfo($file_name, PATHINFO_EXTENSION) == 'php') {
                    $file_content = file_get_contents($file_path);
                } else {
                    $file_content = View::fetch($file_path, $assign_data);
                }

                file_put_contents($target_file_path, $file_content);

                $output->info('创建：' . $target_file_path);
            }
        }
        if($input->hasOption('delete')) {
            $output->info('删除：'. $target_dir);
            rmdir($target_dir);
            // 如果父目录为空，删除父目录
            $parent_dir = dirname($target_dir);
            if (count(scandir($parent_dir)) == 2) {
                rmdir($parent_dir);
            }
        }

        $dir_tpl = scandir($component_tpl_dir);
        $index_scss = '';

        foreach ($dir_tpl as  $dir_name) {
            if (in_array($dir_name, ['.', '..', '_index.scss'])) {
                continue;
            }

            $list_component = scandir($component_tpl_dir . '/' . $dir_name);

            foreach ($list_component as  $component_name) {
                if (in_array($component_name, ['.', '..', '_index'])) {
                    continue;
                }

                $index_scss .= "@import './{$dir_name}/{$component_name}/index';\n";
            }
        }

        file_put_contents(App::getRootPath() . '/source/components/_index.scss', $index_scss);

        $output->info('执行完成');
    }
}
