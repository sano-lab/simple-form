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

$validate_list = [
    'name' => [
        'require' => true,
        'max-length' => 32
    ],
    'email' => [
        'require' => true,
        'min-length' => 3,
        'max-length' => 32,
        'email-validation' => true
    ],
    'message' => [
        'require' => true,
        'max-length' => 128
    ]
];

$validate_message = [
    'name' => [
        'require' => 'お名前を入力してください',
        'max-length' => "お名前は{$validate_list['name']['max-length']}文字以下で入力してください"
    ],
    'email' => [
        'require' => 'メールアドレスを入力してください',
        'min-length' => 'メールアドレスは3文字以上で入力してください',
        'max-length' => 'メールアドレスは256文字以下で入力してください'
    ],
    'message' => [
        'require' => 'お問い合わせ内容を入力してください',
        'max-length' => 'お問い合わせ内容は128文字以下で入力してください'
    ]
];

// Todo
// 要修正
$errors = array();
$validate_data = validate($_POST, $validate_list);
foreach ($validate_data as $key => $value) {
    foreach ($validate_data[$key] as $k => $v) {
        if ($validate_data[$key][$k]) {
            if (($k === 'min-length' || $k === 'max-length') && $validate_data[$key]['require']) {
                continue;
            }
            $errors[] = '<li>' . $validate_message[$key][$k] . '</li>';
        }
    }
}

$name = isset($_POST['name']) ? h($_POST['name']) : '';
$email = isset($_POST['email']) ? h($_POST['email']) : '';
$message = isset($_POST['message']) ? h($_POST['message']) : '';
$edit = isset($_POST['edit']) ? true : false;

if ($email !== '' && !validateEmail($email)) {
    //$errors[] = "<li>不正なメールアドレスです。</li>";
}

// 初回読み込み時
if ($_SERVER ['REQUEST_METHOD'] === 'GET') {
    $errors = [''];
    require_once(__APPROOT__ . '/view/indexHtml.php');
} else {
    // 送信ボタンが押されたら または 修正ボタンが押されたら
    if (!empty($errors) || $edit) {
        require_once(__APPROOT__ . '/view/indexHtml.php');
    } else {
        unset($_SESSION['csrf_token']);
        Header('Location: /confirm.php', true, 307);
        exit();
    }
}
