<?php


namespace Middleware;


use Resource\Request;

class AuthUser extends Middleware
{

    /**
     * @return bool
     */
    public function check(): bool
    {
        $session = (Request::createRequestFromGlobals())->getSession();
        if (!empty($session['auth'])) {
            header('Location: /test');
            die;
        }

        return parent::check();
    }

}