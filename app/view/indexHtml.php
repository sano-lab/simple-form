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
<ul><?= implode(PHP_EOL, $errors) ?></ul>
<form action="<?= h($_SERVER['SCRIPT_NAME']); ?>" method="post">
  <div class="form-list">
    <label for="id_fullname">お名前 <span class="badge badge-danger">必須</span></label>
    <input type="text" name="name" value="<?= $name ?>" placeholder="お名前" data-required="true" data-maxlength="32">
    <ul class="validation">
        <li data-error="required">必須項目です</li>
        <li data-error="maxlength">32文字以下で入力してください</li>
    </ul>
  </div>
  <div class="form-list">
    <label for="id_mail">メールアドレス <span class="badge badge-danger">必須</span></label>
    <input type="text" name="email" value="<?= $email ?>" placeholder="メールアドレス" data-required="true" data-minlength="3" data-maxlength="256">
    <ul class="validation">
        <li data-error="required">必須項目です</li>
        <li data-error="minlength">3文字以上で入力してください</li>
        <li data-error="maxlength">256文字以下で入力してください</li>
    </ul>
  </div>
  <div class="form-list">
    <label for="id_message">お問い合わせ内容 <span class="badge badge-danger">必須</span></label>
    <textarea name="message" placeholder="お問い合わせ内容" data-required="true" data-maxlength="128"><?= $message ?></textarea>
    <ul class="validation">
        <li data-error="required">必須項目です</li>
        <li data-error="maxlength">128文字以下で入力してください</li>
    </ul>
  </div>
  <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
  <button type="submit">送信</button>
</form>
<script src="js/realtime-validation.js"></script>
<script src="js/app.js"></script>
</body>
</html>