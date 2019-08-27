<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

//    'default' => env('FILESYSTEM_DRIVER', 'local'),
    'default' => env('FILESYSTEM_DRIVER', 'upload'),

    /*
    |--------------------------------------------------------------------------
    | Default Cloud Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Many applications store files both locally and in the cloud. For this
    | reason, you may specify a default "cloud" driver here. This driver
    | will be bound as the Cloud disk implementation in the container.
    |
    */

    'cloud' => env('FILESYSTEM_CLOUD', 's3'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been setup for each driver as an example of the required options.
    |
    | Supported Drivers: "local", "ftp", "s3", "rackspace"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
        ],

        'upload' => [
            'driver' => 'local',
            'root' => public_path('uploads'),
            'url' => env('APP_URL').'/uploads',
            'visibility' => 'public',
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
        ],

    ],

    'uploader' => [

        // 图片
        'image' => [
            'size' => 5242880, // 单位：字节，默认：5MB
            'ext' => ['png', 'jpg', 'gif', 'jpeg'],
        ],

        // 音频
        'voice' => [
            'size' => 5242880, // 单位：字节，默认：5MB
            'ext' => ['mp3','wmv', 'amr'],
        ],

        // 视频
        'video' => [
            'size' => 5242880, // 单位：字节，默认：5MB
            'ext' => ['mp4'],
        ],

        // 附件
        'annex' => [
            'size' => 5242880000, // 单位：字节，默认：500MB (5242880000 B)
            'ext' => ['zip','rar','7z','gz'],
        ],

        // 文件
        'file' => [
            'size' => 52428800, // 单位：字节，默认：50MB
            'ext' => ['pdf','doc','docx','xls','xlsx','ppt','pptx'],
        ],
    ]
];
