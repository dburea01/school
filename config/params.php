<?php

return [
    'app_url_front' => env('APP_URL'),

    /*
    |--------------------------------------------------------------------------
    | maximum quantity of users
    |--------------------------------------------------------------------------
    | To prevent too much users, a school cannot have more than X
    | users. It is the default value when the school is created.
    */
    'max_users' => (int) env('MAX_USERS', 100),
];
