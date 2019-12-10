<?php


namespace Controllers;


use Resourse\Request;

class User extends Controller
{

    public const ERROR_MESSAGES = [
        'empty_field' => 'Please, fulfill all fields',
        'password_validation' => 'Password must be more that 6 symbols',
        'different_passwords' => 'Passwords are different',
        'user_not_exist' => 'No such user!',
        'login_error' => 'Wrong email or password',
        'email_is_taker' => 'This email is already taken'
    ];

    public function __construct(Request $request)
    {
        parent::__construct($request);
    }

    public function indexAction(): void
    {
        if ($this->isUserAuth()) {
            header('Location: /home');
            die;
        }

        require_once '../views/auth/index.phtml';
    }

    public function loginAction(): void
    {
        if ($this->isUserAuth()) {
            header('Location: /home');
            die;
        }

        $request = $this->getRequest();
        $request_params = $request->getRequestParams();
        $error = $this->checkRequestParamsForEmpty($request_params);

        if (!empty($error)) {
            $error['message'] = self::ERROR_MESSAGES['empty_field'];
            require_once '../views/auth/index.phtml';
            die;
        }

        $result = \Models\User::find($request);

        if (!$result['result']) {
            $error['message'] = $result['message'];
            require_once '../views/auth/index.phtml';
            die;
        }

        if (!isset($_SESSION['auth'])) {
            $_SESSION['auth'] = $result['user']->getId();
        }

        header('Location: /home');
    }

    public function signUpViewAction(): void
    {
        if ($this->isUserAuth()) {
            header('Location: /home');
            die;
        }

        require_once '../views/sign-up/index.phtml';
    }

    public function signUpSaveAction()
    {
        if ($this->isUserAuth()) {
            header('Location: /home');
            die;
        }

        $request = $this->getRequest();
        $request_params = $request->getRequestParams();
        $error = $this->checkRequestParamsForEmpty($request_params);

        if (!empty($error)) {
            $error['message'] = self::ERROR_MESSAGES['empty_field'];
            require_once '../views/sign-up/index.phtml';
            die;
        }

        $password_length = strlen($request_params['password']);

        if ($password_length < 6) {
            $error['message'] = self::ERROR_MESSAGES['password_validation'];
            $error['password'] = $error['password_repeat'] = true;
            require_once '../views/sign-up/index.phtml';
            die;
        }

        if ($request_params['password'] !== $request_params['password_repeat']) {
            $error['message'] = self::ERROR_MESSAGES['different_passwords'];
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

        header('Location: /');
    }

    public function homeAction(): void
    {
        if (!$this->isUserAuth()) {
            header('Location: /');
            die;
        }

        $user_id = $this->getAuthUserId();

        $user = \Models\User::getById($user_id);

        $first_name = $user->getFirstName();

        require_once '../views/home/index.phtml';
    }

    public function logoutAction(): void
    {
        session_destroy();
        header('Location: /');
        die;
    }
}