<?php


namespace Middleware;


use Resource\Request;

class Test extends Middleware
{

    public function check(): bool
    {
//        echo 'Test middleware';
        return parent::check();
    }
}