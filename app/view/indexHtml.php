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

<?php if (!empty($errors) || $edit) : /* 入力値エラー時 */  ?>
  <ul><?= implode("\n", $errors) ?></ul>

  <form action="<?= h($_SERVER['SCRIPT_NAME']); ?>" method="post">
    <div class="form-list">
      <label for="id_fullname">お名前 <span class="badge badge-danger">必須</span></label>
      <input type="text" name="name" value="<?= $name ?>" placeholder="お名前" data-required="true" data-maxlength="32">
      <ul class="validation">
          <li data-error="required" style="display: block;">必須項目です</li>
          <li data-error="maxlength" style="display: none;">32文字以下で入力してください</li>
      </ul>
    </div>
    <div class="form-list">
      <label for="id_mail">メールアドレス <span class="badge badge-danger">必須</span></label>
      <input type="text" name="email" value="<?= $email ?>" placeholder="メールアドレス" data-required="true" data-minlength="3" data-maxlength="256">
      <ul class="validation">
          <li data-error="required" style="display: block;">必須項目です</li>
          <li data-error="minlength" style="display: none;">3文字以上で入力してください</li>
          <li data-error="maxlength" style="display: none;">256文字以下で入力してください</li>
      </ul>
    </div>
    <div class="form-list">
      <label for="id_message">お問い合わせ内容 <span class="badge badge-danger">必須</span></label>
      <textarea name="message" placeholder="お問合せ内容" data-required="true" data-maxlength="128"><?= $message ?></textarea>
      <ul class="validation">
          <li data-error="required" style="display: block;">必須項目です</li>
          <li data-error="maxlength" style="display: none;">128文字以下で入力してください</li>
      </ul>
    </div>
    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
    <button type="submit">送信</button>
  </form>
<?php elseif (!$confirmed) : /* フィールドエラーがなく、編集でもない場合（＝確認画面表示） */  ?>
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
      <input type="hidden" name="confirm" value="confirmed">
      <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
<?php elseif ($confirmed) : /* 送信完了 */  ?>
    <?php
  // 多重送信防止
    unset($_SESSION['csrf_token']);
    ?>
  <p>お問い合わせありがとうございます</p>
  <p>送信が完了しました。</p>
<?php else /* エラー画面 */ : ?>
  <p>申し訳ありません。送信処理ができませんでした。</p>
  <p>再度お試し下さい。</p>
  <p><a href="/">お問い合わせフォームのページへ戻る</a></p>
<?php endif; ?>
<script src="js/realtime-validation.js"></script>
<script src="js/app.js"></script>
</body>
</html>