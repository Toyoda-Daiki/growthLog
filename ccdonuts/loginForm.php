<?php
session_start();

if (empty($_SESSION['csrf_token'])) {
  $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$errors = [];

$dsn = 'mysql:host=localhost;dbname=ccdonuts;charset=utf8';
$dbUser = 'ccStaff';
$dbPass = 'ccDonuts';

try {
  $pdo = new PDO($dsn, $dbUser, $dbPass);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  die("DB接続エラー: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    $errors[] = "不正アクセスが検出されました。";
  } else {
    $email = trim($_POST['useremail'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($email === '' || $password === '') {
      $errors[] = "メールアドレスとパスワードを入力してください。";
    } else {
      $stmt = $pdo->prepare("SELECT * FROM customers WHERE email = :email");
      $stmt->execute(['email' => $email]);
      $user = $stmt->fetch(PDO::FETCH_ASSOC);

      if ($user && $user['password'] === $password) {
        $_SESSION['user'] = [
          'id' => $user['id'],
          'email' => $user['email'],
          'name' => $user['name'],
          'postalCode1' => $user['postalCode1'] ?? '',
          'postalCode2' => $user['postalCode2'] ?? '',
          'address' => $user['address'] ?? ''
        ];

        if (isset($_SESSION['redirect_after_login'])) {
          $redirect = $_SESSION['redirect_after_login'];
          unset($_SESSION['redirect_after_login']);
          header("Location: " . $redirect);
          exit;
        } else {
          header("Location: loginResult.php");
          exit;
        }
      } else {
        $errors[] = "メールアドレスまたはパスワードが正しくありません。";
      }
    }
  }
}
?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>C.C.Donuts 公式サイト｜ログイン</title>
    <link rel="icon" href="" type="image/x-icon">
    <link rel="stylesheet" href="common/reset.css">
    <link rel="stylesheet" href="styles/common.css">
    <link rel="stylesheet" href="styles/form.css">
  </head>
  <body>
    <?php require 'header.php'; ?>
    <main>
      <div class="top">
        <p class="breadcrumb">TOP<span>&gt;</span>ログイン</p>
        <p class="account account2">
          <?php
            if (isset($_SESSION['user_name'])) {
              echo "ようこそ " . htmlspecialchars($_SESSION['user_name'], ENT_QUOTES, 'UTF-8') . " 様";
            } else {
              echo "ようこそ　ゲスト　様";
            }
          ?>
        </p>
      </div>
      <h1>C.C.Donuts 公式サイト｜ログイン</h1>
      <section class="loginFormSec">
        <div class="innerWrap">
          <div class="title"><h2>ログイン</h2></div>
          <div class="loginFormCon">

            <?php if (!empty($errors)): ?>
              <div class="errorMessages">
                <?php foreach ($errors as $err): ?>
                  <p><?php echo htmlspecialchars($err, ENT_QUOTES, 'UTF-8'); ?></p>
                <?php endforeach; ?>
              </div>
            <?php endif; ?>

            <form method="POST" action="" class="loginFormCate">
              <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
              <div class="formGroup">
                <div class="formGroup2">
                  <label for="useremail">メールアドレス</label>
                  <input type="email" id="email" name="useremail" class="formInput" placeholder="123@gmail.com" required>
                </div>

                <div class="formGroup2">
                  <label for="password">パスワード</label>
                  <input type="password" id="password" name="password" class="formInput" placeholder="ps1234" required>
                </div>
              </div>

              <button type="submit" class="loginBtn">ログイン</button>
            </form>
            <a href="registerForm.php" class="newAccount">会員登録はこちら</a>
          </div>
        </div>
      </section>
    </main>
    <?php require 'footer.php'; ?>
    <script src="scripts/script.js"></script>
  </body>
</html>
