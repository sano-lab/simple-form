<?php

ini_set('display_errors', 1);

header('Permissions-Policy: interest-cohort=()');
header('X-FRAME-OPTIONS: DENY');

// DNS Rebinding
if ($_SERVER['SERVER_NAME'] !== 'localhost') {
    die('DNS Rebinding');
}

$cookieParams = session_get_cookie_params();
$cookieParams['samesite'] = "None";

session_set_cookie_params($cookieParams);
session_cache_limiter("private_no_expire");
session_status() === PHP_SESSION_NONE && session_start();
session_regenerate_id(true);
