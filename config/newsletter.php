<?php

return [

    /*
     * The driver to use to interact with MailChimp API.
     * You may use "log" or "null" to prevent calling the
     * API directly from your environment.
     */
    'driver' => Spatie\Newsletter\Drivers\MailchimpDriver::class,

    /**
     * These arguments will be given to the driver.
     */
    'driver_arguments' => [
        'api_key' => env('MAILCHIMP_API_KEY'),
    ],

    'lists' => [

        /*
         * This key is used to identify this list. It can be used
         * as the listName parameter provided in the various methods.
         *
         * You can set it to any string you want and you can add
         * as many lists as you want.
         */
        'next_posts' => [
            'id' => env('MAILCHIMP_ID_LIST_NEXT_POSTS'),
        ],
        
        'next_courses' => [
            'id' => env('MAILCHIMP_ID_LIST_NEXT_COURSES'),
        ],
    ],
];
