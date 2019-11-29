<?php

const SALT = '22618c305f1428160beb042432b1e4d3';

function existLogin(string $login): bool
{
    $sql = "SELECT count(*) as cnt_rows 
                FROM users 
                WHERE login = '$login'";
    $query = mysqli_query($GLOBALS['main_connection'], $sql);
    $result = mysqli_fetch_assoc($query);

    return (bool)$result['cnt_rows'];
}

function existEmail(string $email)
{
    $sql = "SELECT count(*) as cnt_rows 
                FROM users 
                WHERE email = '$email'";
    $query = mysqli_query($GLOBALS['main_connection'], $sql);
    $result = mysqli_fetch_assoc($query);

    return (bool)$result['cnt_rows'];
}

function hashPassword(string $password)
{
    return md5($password . SALT);
}

function addUser(string $login, string $email, string $password): bool
{
    $password = hashPassword($password);
    $sql = "INSERT INTO users (`login`, `email`, `password`) 
                VALUES ('$login', '$email', '$password')";
    return mysqli_query($GLOBALS['main_connection'], $sql);
}

function getUserByUsernameAndPassword(string $userName, string $password): ?array
{
    $password = hashPassword($password);
    $sql = "SELECT * FROM users
                WHERE (login = '$userName' or email = '$userName') 
                    AND password = '$password'";
    $result = mysqli_query($GLOBALS['main_connection'], $sql);

    return mysqli_fetch_assoc($result);
}
