<?php

return [
    'app_url_front' => env('APP_URL'),

    'author-email' => env('AUTHOR_EMAIL'),

    /*
    |--------------------------------------------------------------------------
    | maximum quantity of users
    |--------------------------------------------------------------------------
    | To prevent too much users, a school cannot have more than X
    | users. It is the default value when the school is created.
    */
    'max_users' => (int) env('MAX_USERS', 100),

    /*
    |--------------------------------------------------------------------------
    | maximum contact-the-author emails per day, per user (connected or not)
    |--------------------------------------------------------------------------
    | To prevent a user from sending too many emails per day,
    | which could generate a huge bill... or overload the server.
    */
    'max-contact-author-emails' => (int) env('MAX_CONTACT_AUTHOR_EMAILS', 5),
];
