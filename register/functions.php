<?php
session_start();

function get_user_by_email($email)
{
    require 'configDB.php';
    $statemant = $pdo->prepare("SELECT *FROM users WHERE email=:email");
    $statemant->execute(['email' => $email]);
    return $statemant->fetch(PDO::FETCH_ASSOC);
}

function add_user($email, $password)
{
    require 'configDB.php';
    $statement = $pdo->prepare("INSERT INTO users (email, password) VALUES (:email, :password)");
    $statement->execute(
        [
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT)
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
