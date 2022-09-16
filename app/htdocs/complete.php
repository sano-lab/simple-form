<?php

define('__DOCROOT__', $_SERVER['DOCUMENT_ROOT']);
define('__APPROOT__', realpath('../'));

require_once(__APPROOT__ . '/inc/init.php');
require_once(__APPROOT__ . '/inc/function.php');

// 多重送信防止
if (isset($_SESSION['csrf_token']) && isset($_POST['confirmed'])) {
    unset($_SESSION['csrf_token']);
    require_once(__APPROOT__ . '/view/complateHtml.php');
} else {
    die('不正なリクエストです');
}
