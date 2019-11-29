<?php

require_once PUBLIC_PATH . '/../php/helpers/users.php';

$user = getUserByUsernameAndPassword($_POST['username'], $_POST['password']);

if (!$user) {
    $error = 'Invalid username or password';
    require_once PUBLIC_PATH . '/../views/login.phtml';
    die;
}
unset($user['password']);
$_SESSION['auth'] = $user;

setcookie(COOKIE_SESSION_ID, session_id(), time() + 3600 * 24 * 7);
header('Location: /views/welcome');
