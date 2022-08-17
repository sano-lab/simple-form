<?php
ini_set('display_errors', 0);
header('X-FRAME-OPTIONS: DENY');
session_start();
session_regenerate_id(true);

// トークンチェック
if(!isset($_SESSION['csrf_token']) || !isset($_POST['csrf_token']) ||
    h($_POST['csrf_token']) !== $_SESSION['csrf_token']) {
      //exit();
}

$csrf_token = bin2hex(random_bytes(16));
$_SESSION['csrf_token'] = $csrf_token;  

// NULLバイト除去
if(isset($_POST)) $_POST = sanitize($_POST);

$name = isset($_POST['name']) ? h($_POST['name']) : '';
$email = isset($_POST['email']) ? h($_POST['email']) : '';
$message = isset($_POST['message']) ? h($_POST['message']) : '';
$confirmed = isset($_POST['confirm']) ? h($_POST['confirm']) : false;
$edit = isset($_POST['edit']) ? true : false;

$errors = array();
if($name === '') $errors[] = '<li>お名前を入力して下さい。</li>';
if($email === '') $errors[] = '<li>メールアドレスを入力してください。</li>';
if($email !== '' && !validateEmail($email)) $errors[] = "<li><strong>${email}</strong>は、不正なメールアドレスです。</li>";
if($message === '') $errors[] = '<li>お問い合わせ内容を入力してください。</li>';


//------------------------------------------------------------
//  関数定義(START)
//------------------------------------------------------------
function h($s) {
  return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}

function validateEmail($s){
  $reg = "/^[\.!#%&\-_0-9a-zA-Z\?\/\+]+\@[!#%&\-_0-9a-z]+(\.[!#%&\-_0-9a-z]+)+$/";
  if (filter_var($s, FILTER_VALIDATE_EMAIL)){
    return true;
  } elseif (preg_match($reg, "$s")) {
    return true;
  } else {
    return false;
  }
}

function sanitize($arr) {
	if(is_array($arr)){
		return array_map('sanitize', $arr);
	}
	return str_replace('\0', '', $arr);
}

//------------------------------------------------------------
//  関数定義(END)
//------------------------------------------------------------
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

<?php if (!empty($errors) || $edit) /* 入力値エラー時 */ : ?>
  <ul><?= implode("\n", $errors) ?></ul>

  <form action="<?= h($_SERVER['SCRIPT_NAME']); ?>" method="post">
    <div class="form-list">
      <label for="id_fullname">お名前 <span class="badge badge-danger">必須</span></label>
      <input type="text" name="name" value="<?= $name ?>" placeholder="お名前" required="">
    </div>
    <div class="form-list">
      <label for="id_fullname">メールアドレス <span class="badge badge-danger">必須</span></label>
      <input type="text" name="email" value="<?= $email ?>" placeholder="メールアドレス" required="">
    </div>
    <div class="form-list">
      <label for="id_fullname">お問い合わせ内容 <span class="badge badge-danger">必須</span></label>
      <textarea name="message" placeholder="お問合せ内容" required=""><?= $message ?></textarea>
    </div>
    <input hidden name="csrf_token" value="<?= $csrf_token ?>">
    <button type="submit">送信</button>
  </form>
<?php elseif(!$confirmed) /* フィールドエラーがなく、編集でもない場合（＝確認画面表示） */ : ?>
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
      <input hidden name="name" value="<?= $name ?>">
      <input hidden name="email" value="<?= $email ?>">
      <input hidden name="message" value="<?= $message ?>">
      <input hidden name="confirm" value="confirmed">
      <input hidden name="csrf_token" value="<?= $csrf_token ?>">
      <div class="box">
        <button type="submit" name="edit">修正</button>
        <button type="submit">送信</button>
      <div>
<?php elseif($confirmed) /* 送信完了 */ : ?>
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
</body>
</html>