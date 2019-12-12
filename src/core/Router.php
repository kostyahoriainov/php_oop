<?php

namespace Core;

use Controllers\UserController;
use Resource\Request;
use Middleware\Middleware;

class Router
{
    /**
     * @var Request
     */
    private $request;

    /**
     * @var Middleware
     */
    private $middleware;

    public function __construct()
    {
        $this->setRequest(Request::createRequestFromGlobals());
    }

    /**
     * @param Middleware $middleware
     * @return Router
     */
    public function setMiddleware(Middleware $middleware): Router
    {
        $this->middleware = $middleware;

        return $this;
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

        foreach (ROUTER_CONFIG as $path => $route_params) {
            if ($path === $uri) {

                if(!empty($route_params['middleware'])) {
                    $this->bindMiddleware($route_params['middleware'])
                        ->runMiddleware($this->middleware);
                }

                $controller = new $route_params['controller']($this->getRequest());

                $action = $route_params['action'] . 'Action';

                call_user_func(array($controller, $action));
                break;
            }
        }
    }

    private function bindMiddleware(array $middleware_list): Router
    {
        $middleware = array_shift($middleware_list);
        $middleware = new $middleware;

        $this->bindNext($middleware, $middleware_list);

        $this->setMiddleware($middleware);

        return $this;
    }

    private function bindNext(Middleware $middleware,array $middleware_list): void
    {
        if (count($middleware_list)) {
            $next_middleware = array_shift($middleware_list);
            $middleware->link(new $next_middleware);
            $this->bindNext($middleware->getNext(), $middleware_list);
        }
    }

    private function runMiddleware(Middleware $middleware)
    {
        $middleware->check();
    }

//    public function run1(): void
//    {
//        $uri = $this->request->getUri();
//
//        switch ($uri) {
//            case '/':
//                (new UserController($this->request))->indexAction();
//                break;
//            case '/login':
//                (new UserController($this->request))->loginAction();
//                break;
//            case '/sign-up':
//                (new UserController($this->request))->signUpViewAction();
//                break;
//            case '/sign-up/save':
//                (new UserController($this->request))->signUpSaveAction();
//                break;
//            case '/home':
//                (new UserController($this->request))->homeAction();
//                break;
//            case '/logout':
//                (new UserController($this->request))->logoutAction();
//                break;
//            default :
//                echo '404';
//        }
//    }

}