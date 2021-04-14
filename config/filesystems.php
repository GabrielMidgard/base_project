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

    'default' => env('FILESYSTEM_DRIVER', 'local'),

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
    | Supported Drivers: "local", "ftp", "sftp", "s3"
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

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
        ],
        'product_imgs'=>[
            'driver' => 'local',
            'root' => storage_path('app/images_products'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'private',
        ], 
        'banner'=>[
            'driver' => 'local',
            'root' => storage_path('app/images_banner'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
        ],
        'courses'=>[
            'driver' => 'local',
            'root' => storage_path('app/images_courses'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'private',
        ],
        'testimonial'=>[
            'driver' => 'local',
            'root' => storage_path('app/images_testimonials'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'private',
        ],
        'blog'=>[
            'driver' => 'local',
            'root' => storage_path('app/images_blog'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'private',
        ],
        'users'=>[
            'driver' => 'local',
            'root' => storage_path('app/images_users'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'private',
        ],
        'instructor'=>[
            'driver' => 'local',
            'root' => storage_path('app/images_instructors'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'private',
        ],
        'site'=>[
            'driver' => 'local',
            'root' => storage_path('app/images_site'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'private',
        ],
        'category'=>[
            'driver' => 'local',
            'root' => storage_path('app/images_site'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'private',
        ],

        
    ],

];
