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
    ],
    '/sign-up' => [
        'controller' => \Controllers\UserController::class,
        'action' => 'signUpView',
        'middleware' => [
            \Middleware\AuthUser::class
        ]
    ],
    '/sign-up/save' => [
        'controller' => \Controllers\UserController::class,
        'action' => 'signUpSave',
        'middleware' => [
            \Middleware\AuthUser::class
        ]
    ],
    '/logout' => [
        'controller' => \Controllers\UserController::class,
        'action' => 'logout',
        'middleware' => []
    ],
    '/home' => [
        'controller' => \Controllers\UserController::class,
        'action' => 'home',
        'middleware' => [
            \Middleware\NotAuthUser::class
        ]
    ]
];