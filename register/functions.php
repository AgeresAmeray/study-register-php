<?php
session_start();

function get_user_by_email($email)
{
    require 'configDB.php';
    $statemant = $pdo->prepare("SELECT *FROM users WHERE email=:email");
    $statemant->execute([':email' => $email]);
    $user = $statemant->fetch(PDO::FETCH_ASSOC);
    return $user;
}

function add_user($email, $password)
{
    require 'configDB.php';
    $password = password_hash($password, PASSWORD_DEFAULT);
    $statement = $pdo->prepare("INSERT INTO users (email, password) VALUES (:email, :password)");
    $statement->execute(
        [
            ':email' => $email,
            ':password' => $password
        ]
    );
}

function set_flash_message($name, $message)
{
    $_SESSION[$name] = $message;
}

function display_flash_message($name)
{
    if (isset($_SESSION[$name])) {
        echo "<div class='alert alert-{$name}'>$_SESSION[$name]</div>";
        unset($_SESSION[$name]);
    }
}

function redirect_to($path)
{
    header("Location: $path");
}

function login($email, $password)
{
    require 'configDB.php';
    $user = get_user_by_email($email);
    if (!empty($user))
    {
        if (password_verify($password, $user['password']))
        {
            $_SESSION['login'] = $email;
            return true;
        }
    }
    set_flash_message('danger', 'Неверный логин или пароль');
    return false;
}
