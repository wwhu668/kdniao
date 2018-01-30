<?php

return [
    'business_id' => env('KDNIAO_EBUSINESS_ID'),

    'app_key' => env('KDNIAO_APP_KEY'),

    // 物流公司对应代号
    'codes' => [
        'SF'   => '顺丰', // 顺丰快递
        'ZTO'  => '中通',
        'STO'  => '申通',
        'YTO'  => '圆通',
        'YD'   => '韵达',
        'EMS'  => 'EMS',
        'HHTT' => '天天',
        'JD'   => '京东',
        // ...
    ]
];