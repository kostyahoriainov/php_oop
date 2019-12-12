<?php


namespace Controllers;


use Resource\Request;

class UserController extends Controller
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
        die;
    }

    public function signUpViewAction(): void
    {
        require_once '../views/sign-up/index.phtml';
    }

    public function signUpSaveAction()
    {
        $request = $this->getRequest();
        $request_params = $request->getRequestParams();

        $result = \Models\User::create($request);

        if (!$result['result']) {
            $error['message'] = $result['message'];
            require_once '../views/sign-up/index.phtml';
            die;
        }

        header('Location: /');
        die;
    }

    public function homeAction(): void
    {
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