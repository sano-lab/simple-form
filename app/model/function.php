<?php

//------------------------------------------------------------
//  関数定義
//------------------------------------------------------------

// エスケープ
function h($s)
{
    return trim(htmlspecialchars($s, ENT_QUOTES, 'UTF-8'));
}

// メールフォーマットチェック
function validateEmail($s)
{
    $reg = "/^[\.!#%&\-_0-9a-zA-Z\?\/\+]+\@[!#%&\-_0-9a-z]+(\.[!#%&\-_0-9a-z]+)+$/";
    if (filter_var($s, FILTER_VALIDATE_EMAIL)) {
        return true;
    } elseif (preg_match($reg, "$s")) {
        return true;
    } else {
        return false;
    }
}

// Nullバイト除去
function sanitize($arr)
{
    if (is_array($arr)) {
        return array_map('sanitize', $arr);
    }
    return str_replace('\0', '', $arr);
}
