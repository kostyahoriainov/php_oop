<?php

return [
    '/' => [
        'controller' => \Controllers\UserController::class,
        'action' => 'index',
        'middleware' => [
            \Middleware\AuthUser::class,
            \Middleware\Test::class
        ]
    ],
    '/login' => [
        'controller' => \Controllers\UserController::class,
        'action' => 'login',
        'middleware' => [
            \Middleware\AuthUser::class
        ]
    ]
];