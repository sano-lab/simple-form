<?php
ini_set('display_errors', 0);
header('X-FRAME-OPTIONS: DENY');
session_start();
session_regenerate_id(true);
$csrf_token = bin2hex(random_bytes(16));
$_SESSION = array();
$_SESSION['csrf_token'] = $csrf_token;
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>お問い合わせフォーム</title>
</head>
<body>
    <form action="form.php" method="post">
        <div class="form-list">
            <label for="id_fullname">お名前 <span class="badge badge-danger">必須</span></label>
            <input type="text" name="name" placeholder="お名前" required="">
        </div>
        <div class="form-list">
            <label for="id_fullname">メールアドレス <span class="badge badge-danger">必須</span></label>
            <input type="text" name="email" placeholder="メールアドレス" required="">
        </div>
        <div class="form-list">
            <label for="id_fullname">お問い合わせ内容 <span class="badge badge-danger">必須</span></label>
            <textarea name="message" placeholder="お問い合わせ内容" rows="8" required=""></textarea>
        </div>
        <input hidden name="csrf_token" value="<?= $csrf_token ?>">
        <button type="submit">送信</button>
    </form>
</body>
</html>