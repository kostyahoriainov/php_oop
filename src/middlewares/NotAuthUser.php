<?php


namespace Middleware;

use \Resource\Request;

class NotAuthUser extends Middleware
{

    /**
     * @return bool
     */
    public function check(): bool
    {
        $session = (Request::createRequestFromGlobals())->getSession();
        if (empty($session['auth'])) {
            header('Location: /main');
            die;
        }

        return parent::check();
    }

}