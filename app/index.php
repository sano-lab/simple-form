<?php
require_once('model/init.php');
require_once('model/function.php');

// NULLバイト除去
if(isset($_POST)) $_POST = sanitize($_POST);

// トークンチェック
if ($_SERVER ['REQUEST_METHOD'] === 'POST') {
  if($_SESSION['csrf_token'] !== $_POST['csrf_token']) {
    //die('トークンが不正です');
  }
}

// トークン発行
$csrf_token = bin2hex(random_bytes(32));
$_SESSION['csrf_token'] = $csrf_token;

$name = isset($_POST['name']) ? h($_POST['name']) : '';
$email = isset($_POST['email']) ? h($_POST['email']) : '';
$message = isset($_POST['message']) ? h($_POST['message']) : '';
$confirmed = isset($_POST['confirm']) ? h($_POST['confirm']) : false;
$edit = isset($_POST['edit']) ? true : false;

$errors = array();
if($name === '') $errors[] = '<li>お名前を入力して下さい。</li>';
if($email === '') $errors[] = '<li>メールアドレスを入力してください。</li>';
if($email !== '' && !validateEmail($email)) $errors[] = "<li><strong>${email}</strong>は、不正なメールアドレスです。</li>";
if($message === '') $errors[] = '<li>お問い合わせ内容を入力してください。</li>';

if ($_SERVER ['REQUEST_METHOD'] === 'GET') $errors = [''];

require_once('view/indexHtml.php');
?>