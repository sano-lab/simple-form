<?php

define('__DOCROOT__', $_SERVER['DOCUMENT_ROOT']);
define('__APPROOT__', realpath('../'));

require_once(__APPROOT__ . '/inc/init.php');
require_once(__APPROOT__ . '/inc/function.php');

// 直接アクセス時はトップページへリダイレクト
if(!isset($_SESSION['csrf_token']) || !isset($_POST)) {
    Header('Location: /index.php');
// 正常時
}else if (isset($_SESSION['csrf_token']) && isset($_POST['confirmed'])) {
    unset($_SESSION['csrf_token']);
    require_once(__APPROOT__ . '/view/completeHtml.php');
// エラー時
}else {
    die('不正なリクエストです');
}
