<?php

return [
    '/' => [
        'controller' => \Controllers\UserController::class,
        'action' => 'index',
        'middleware' => [
            \Middleware\AuthUser::class,
            \Middleware\Test::class
        ]
    ]
];