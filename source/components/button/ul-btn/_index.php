<?php

$base_config = [
    'button_type'=>[
        '',
        'primary',
        'success',
        'danger',
        'warning',
        'info',
    ],
    'button_size'=>[
        'lg',
        '',
        'sm',
        'mini',
    ],
    'button_status'=>[
        'disabled'=>'禁用',
        'loading'=>'加载中',
        'plain'=>'镂空',
    ]
];

$button_list = [];

foreach ($base_config['button_type'] as $type) {
    $button_list[$type] = [];
    foreach ($base_config['button_size'] as $size) {
        $button_class = 'ul-btn';
        $button_name = "默认按钮";
        if($type){
            $button_class.=' ul-btn-'.$type;
            // $button_name .= "-{$type}";
        }
        if($size){
            $button_class.=' ul-btn-'.$size;
            // $button_name.= "-{$size}";
        }
        $button_list[$type][$size] = [
            'class'=>$button_class,
            'name'=>$button_name,
        ];
    }
}

$base_config['button_list'] = $button_list;

return $base_config;