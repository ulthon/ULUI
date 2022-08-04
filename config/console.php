<?php
// +----------------------------------------------------------------------
// | 控制台配置
// +----------------------------------------------------------------------

use app\command\make\View;
use app\command\ScanDemo;

return [
    // 指令定义
    'commands' => [
        'app\command\ResetPassword',
        View::class,
        ScanDemo::class
    ],
];
