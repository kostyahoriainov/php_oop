<?php


namespace Controllers;


use Resourse\Request;

class User extends Controller
{

    public function __construct(Request $request)
    {
        parent::__construct($request);
    }

    public function indexAction(): void
    {

        require_once '../views/auth/index.phtml';
    }

    public function loginAction(): void
    {
        $request = $this->getRequest();
        $request_params = $request->getRequestParams();
        $error = $this->checkRequestParamsForEmpty($request_params);

        if (!empty($error)) {
            $error['message'] = 'Please, fulfill all fields';
            require_once '../views/auth/index.phtml';
            die;
        }

        $result = \Models\User::find($request);

        if (!$result['result']) {
            $error['message'] = $result['message'];
            require_once '../views/auth/index.phtml';
            die;
        }

        dump($result);
    }

    public function signUpViewAction(): void
    {

        require_once '../views/sign-up/index.phtml';
    }

    public function signUpSaveAction()
    {
        $request = $this->getRequest();
        $request_params = $request->getRequestParams();
        $error = $this->checkRequestParamsForEmpty($request_params);

        if (!empty($error)) {
            $error['message'] = 'Please, fulfill all fields';
            require_once '../views/sign-up/index.phtml';
            die;
        }

        $password_length = strlen($request_params['password']);

        if ($password_length < 6) {
            $error['message'] = 'Password must be more that 6 symbols';
            $error['password'] = $error['password_repeat'] = true;
            require_once '../views/sign-up/index.phtml';
            die;
        }

        if ($request_params['password'] !== $request_params['password_repeat']) {
            $error['message'] = 'Passwords are different';
            $error['password'] = $error['password_repeat'] = true;
            require_once '../views/sign-up/index.phtml';
            die;
        }

        $result = \Models\User::create($request);

        if (!$result['result']) {
            $error['message'] = $result['message'];
            require_once '../views/sign-up/index.phtml';
            die;
        }

    }
}