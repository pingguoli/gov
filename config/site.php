<?php

/* 站点默认设置 */

return [

    /* 作者 */
    'author' => '惠金网络科技有限公司',

    /* 作者站点 */
    'link' => 'http://www.jlweizhengyun.com',

    /* 调试模式下, 开启SQL日志 */
    'sql_log' => false,

    /* 站点基本设置 */
    'base' => [
        /* 名称 */
        'name' => '',

        /* 站点 LOGO */
        'logo' => '',

        /* 备案号 */
        'icp' => '',

        /* Copyright */
        'copyright' => '',

        /* 地址 */
        'address' => '',

        /* 电话 */
        'telephone' => '',

        /* 邮箱 */
        'email' => '',
    ],

    /* SEO 设置 */
    'seo' => [
        /* SEO 标题 */
        'title' => '',

        /* SEO 关键字 */
        'keywords' => '',

        /* SEO 描述 */
        'description' => '',
    ],

    /* 其他设置  */
    'other' => [
        /* 验证码设置 */
        'captcha' => false,

        /* 分页个数 */
        'paginate' => 2
    ],

    /* 注册设置 */
    'register' => [
        /* 注册时需要支付金额 */
        'money' => 0
    ],

    /* 加密配置 */
    'encrypt' => [
        /* 加密key */
        'key' => 'base64:MBRX01On6NgDYRy7cvYcGG77b6OwLKe5yCcxnOIMuLA=',
        /* 加密向量 */
        'iv' => 'base64:EwYdPo0rFnwel1AD4JR33g==',
    ],

    /* 模板设置 */
    'theme' => [
        /* 后台模板配置 */
        'backend' => '',
        /* 前台Web端配置 */
        'web' => '',
        /* 前台Mobile端配置 */
        'mobile' => ''
    ],

    /* 阿里云配置 */
    'aliyun' => [
        /* 短信配置 */
        'sms' => [
            /* 秘钥ID */
            'key' => env('ALIYUN_SMS_KEY', ''),
            /* 秘钥签名 */
            'key_secret' => env('ALIYUN_SMS_KEY_SECRET', ''),
            /* 签名 */
            'sign_name' => env('ALIYUN_SMS_SIGN_NAME', ''),
            /* 模板号 */
            'template_code' => env('ALIYUN_SMS_TEMPLATE_CODE', ''),
        ]
    ],

    /* face++ 配置 */
    'face' => [
        /* 秘钥ID */
        'key' => env('FACE_KEY', ''),
        /* 秘钥签名 */
        'key_secret' => env('FACE_KEY_SECRET', ''),
    ],

    /* 微信支付配置 */
    'wxpay' => [
        /* 扫码支付配置 */
        'native' => [
            'app_id' => env('WXPAY_NATIVE_APP_ID', ''),
            'app_secret' => env('WXPAY_NATIVE_APP_SECRET', ''),
            'mch_id' => env('WXPAY_NATIVE_MCH_ID', ''),
            'key' => env('WXPAY_NATIVE_KEY', ''),
        ]
    ]
];