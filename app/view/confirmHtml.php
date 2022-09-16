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
<p>以下の内容でよければ、「送信」ボタンを押してください。</p>
<p>お名前</p>
<p><?= $name ?></p>
<hr>
<p>メールアドレス</p>
<p><?= $email ?></p>
<hr>
<p>お問い合わせ内容</p>
<p><?= $message ?></p>
<hr>
<form method="POST" action="<?= h($_SERVER['SCRIPT_NAME']) ?>">
  <div class="box">
    <button type="submit" name="edit">修正</button>
    <button type="submit">送信</button>
  <div>
<input type="hidden" name="name" value="<?= $name ?>">
<input type="hidden" name="email" value="<?= $email ?>">
<input type="hidden" name="message" value="<?= $message ?>">
<input type="hidden" name="confirmed">
<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
<script src="js/realtime-validation.js"></script>
<script src="js/app.js"></script>
</body>
</html>