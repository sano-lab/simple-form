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


function validate($data, $rule)
{
    $arr = [];
    foreach ($data as $key => $value) {
        if (array_key_exists($key, $rule)) {
            if (array_key_exists('require', $rule[$key])) {
                $arr[$key]['require'] = $data[$key] === '';
            }
            if (array_key_exists('max-length', $rule[$key])) {
                $arr[$key]['max-length'] = $rule[$key]['max-length'] < mb_strlen($data[$key]);
            }
            if (array_key_exists('min-length', $rule[$key])) {
                $arr[$key]['min-length'] = $rule[$key]['min-length'] > mb_strlen($data[$key]);
            }
        }
    }
    return $arr;
}
