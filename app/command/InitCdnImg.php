<?php
declare (strict_types = 1);

namespace app\command;

use think\console\Command;
use think\console\Input;
use think\console\input\Argument;
use think\console\input\Option;
use think\console\Output;
use think\facade\App;

class InitCdnImg extends Command
{
    protected function configure()
    {
        // 指令配置
        $this->setName('init:cdn:img')
            ->setDescription('将 /public/cdn/img/ 目录下的JPG图片批量转换为PNG格式并删除原文件');
    }

    protected function execute(Input $input, Output $output)
    {
        // 检查 GD 扩展
        if (!extension_loaded('gd') || !function_exists('gd_info')) {
            $output->error("错误: PHP 的 GD 图像处理扩展未启用。");
            return;
        }

        $imageDirectory = App::getRootPath() . 'public/cdn/img/';

        if (!is_dir($imageDirectory)) {
            $output->error("错误: 目录不存在 '{$imageDirectory}'");
            return;
        }

        $output->writeln("开始扫描目录: " . $imageDirectory);

        // 查找所有 .jpg 和 .jpeg 文件
        $jpgFiles = glob($imageDirectory . '*.{jpg,jpeg}', GLOB_BRACE);

        if (empty($jpgFiles)) {
            $output->info("在指定目录中未找到 JPG 文件。");
            return;
        }

        $convertedCount = 0;
        foreach ($jpgFiles as $sourcePath) {
            $pathInfo = pathinfo($sourcePath);
            $destinationPath = $pathInfo['dirname'] . DIRECTORY_SEPARATOR . $pathInfo['filename'] . '.png';

            $image = @imagecreatefromjpeg($sourcePath);

            if ($image !== false) {
                imagepng($image, $destinationPath);
                imagedestroy($image);

                // 删除原JPG文件
                unlink($sourcePath);

                $output->info("转换成功: " . basename($sourcePath) . " -> " . basename($destinationPath) . " (原文件已删除)");
                $convertedCount++;
            } else {
                $output->warning("跳过失败文件: " . basename($sourcePath));
            }
        }

        $output->writeln("\n转换完成！共处理了 {$convertedCount} 个文件。");
    }
}
