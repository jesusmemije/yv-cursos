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

    'default' => env('FILESYSTEM_DISK', 'local'),

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
            'url' => env('APP_URL') . '/storage',
            'visibility' => 'public',
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL', 'https://{bucket}.{region}.digitaloceanspaces.com'),
            'endpoint' => env('AWS_ENDPOINT', 'https://{region}.digitaloceanspaces.com'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
        ],
        'wasabi' => [
            'driver' => 's3',
            'key' => env('WASABI_ACCESS_KEY_ID'),
            'secret' => env('WASABI_SECRET_ACCESS_KEY'),
            'region' => env('WASABI_DEFAULT_REGION', 'ap-southeast-1'),
            'bucket' => env('WASABI_BUCKET'),
            'endpoint' => env('WASABI_ENDPOINT', 'https://s3.ap-southeast-1.wasabisys.com'),
        ],

        //for scorm
        'scorm-local' => [
            'driver'     => 'local',
            'root'       =>  public_path('scorm'), // set root dir
            'visibility' => 'public',
        ],

        's3-scorm' => [
            'driver' => 's3',
            'root'   => public_path('scorm'), // set root dir
            'key'    => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_SCORM_BUCKET'),
        ],

        'vultr' => [
            'driver' => 's3',
            'key' => env('VULTR_ACCESS_KEY_ID'),
            'secret' => env('VULTR_SECRET_ACCESS_KEY'),
            'region' => env('VULTR_DEFAULT_REGION', 'sgp1'),
            'bucket' => env('VULTR_BUCKET'),
            'endpoint' => env('VULTR_ENDPOINT', 'sgp1.vultrobjects.com'),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | Here you may configure the symbolic links that will be created when the
    | `storage:link` Artisan command is executed. The array keys should be
    | the locations of the links and the values should be their targets.
    |
    */

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],

];