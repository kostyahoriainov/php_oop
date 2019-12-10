<?php

namespace Router;

use Controllers\User;
use Resourse\Request;

class Router
{
    /**
     * @var Request
     */
    private $request;

    public function __construct(Request $request)
    {
        $this->setRequest($request);
    }

    /**
     * @return Request
     */
    public function getRequest(): Request
    {
        return $this->request;
    }

    /**
     * @param mixed $request
     * @return Router
     */
    public function setRequest(Request $request): Router
    {
        $this->request = $request;
        return $this;
    }

    public function run(): void
    {
        $uri = $this->request->getUri();

        switch ($uri) {
            case '/':
                (new User($this->request))->indexAction();
                break;
            case '/login':
                (new User($this->request))->loginAction();
                break;
            case '/sign-up':
                (new User($this->request))->signUpViewAction();
                break;
            case '/sign-up/save':
                (new User($this->request))->signUpSaveAction();
                break;
            case '/home':
                (new User($this->request))->homeAction();
                break;
            case '/logout':
                (new User($this->request))->logoutAction();
                break;
            default :
                echo '404';
        }
    }

}