<?php

define('__DOCROOT__', $_SERVER['DOCUMENT_ROOT']);
define('__APPROOT__', realpath('../'));

require_once(__APPROOT__ . '/inc/init.php');
require_once(__APPROOT__ . '/inc/function.php');

// トークンチェック
if ($_SERVER ['REQUEST_METHOD'] === 'POST') {
    if (isset($_SESSION['csrf_token']) && ($_SESSION['csrf_token'] !== $_POST['csrf_token'])) {
        die('CSRF Token Error');
    }
}

// NULLバイト除去
sanitize($_POST);
// トークン発行
$csrf_token = bin2hex(random_bytes(128));
if (isset($_SESSION)) {
    $_SESSION = [];
}
$_SESSION['csrf_token'] = $csrf_token;
$name = isset($_POST['name']) ? h($_POST['name']) : '';
$email = isset($_POST['email']) ? h($_POST['email']) : '';
$message = isset($_POST['message']) ? h($_POST['message']) : '';

if (isset($_POST['edit']) && $_POST['edit'] === '') {
    unset($_SESSION['csrf_token']);
    Header('Location: /index.php', true, 307);
    exit();
}

if (isset($_POST['confirmed']) && $_POST['confirmed'] === '') {
    $dsn = 'mysql:dbname=db;host=db';
    $user = 'user';
    $password = 'pass';

    try {
        $sql = "INSERT INTO accounts (name, email, message) VALUES (:user_name, :user_email, :user_message)";
        $pdo = new PDO($dsn, $user, $password);
        $sth = $pdo->prepare($sql);
        $sth->bindValue(':user_name', $name, PDO::PARAM_STR);
        $sth->bindValue(':user_email', $email, PDO::PARAM_STR);
        $sth->bindValue(':user_message', $message, PDO::PARAM_STR);
        $sth->execute();
        Header('Location: /complete.php', true, 307);
    } catch (PDOException $e) {
        echo $e;
    }

    exit();
}

if ($_SERVER ['REQUEST_METHOD'] === 'GET') {
    Header('Location: /index.php');
    exit();
} else {
    require_once(__APPROOT__ . '/view/confirmHtml.php');
}
