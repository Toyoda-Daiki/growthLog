<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>C.C.Donuts 公式サイト｜会員登録入力確認</title>
    <link rel="icon" href="" type="image/x-icon">
    <link rel="stylesheet" href="common/reset.css">
    <link rel="stylesheet" href="styles/common.css">
    <link rel="stylesheet" href="styles/confirm.css">
  </head>
  <body>
    <?php require 'header.php'; ?>
    <main>
      <div class="top">
        <p class="breadcrumb">TOP<span>&gt;</span>ログイン<span>&gt;</span>会員登録<span>&gt;</span>入力確認</p>
         <p class="account account2">
          <?php
            if (isset($_SESSION['user']['name'])) {
              echo "ようこそ " . htmlspecialchars($_SESSION['user']['name'], ENT_QUOTES, 'UTF-8') . "　様";
            } else {
              echo "ようこそ　ゲスト　様";
            }
          ?>
        </p>
      </div>
      <h1>C.C.Donuts 公式サイト｜会員登録｜入力確認</h1>
      <section class="registerConfirmSec">
        <div class="innerWrap">
          <div class="title"><h2>入力確認</h2></div>
          <div class="registerConfirmCon">
            <form action="registerResult.php" method="post">
              <ul class="formGroup">
                <li>
                  <p>お名前</p>
                  <p class="output"><?php echo htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8'); ?></p>
                  <input type="hidden" name="name" value="<?php echo htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8'); ?>">
                </li>
                <li>
                  <p>お名前（フリガナ）</p>
                  <p class="output"><?php echo htmlspecialchars($_POST['nameKana'], ENT_QUOTES, 'UTF-8'); ?></p>
                  <input type="hidden" name="nameKana" value="<?php echo htmlspecialchars($_POST['nameKana'], ENT_QUOTES, 'UTF-8'); ?>">
                </li>
                <li>
                  <p>郵便番号</p>
                  <p class="output"><?php echo htmlspecialchars($_POST['postalCode1'] . $_POST['postalCode2'], ENT_QUOTES, 'UTF-8'); ?></p>
                  <input type="hidden" name="postalCode1" value="<?php echo htmlspecialchars($_POST['postalCode1'], ENT_QUOTES, 'UTF-8'); ?>">
                  <input type="hidden" name="postalCode2" value="<?php echo htmlspecialchars($_POST['postalCode2'], ENT_QUOTES, 'UTF-8'); ?>">
                </li>
                <li>
                  <p>住所</p>
                  <p class="output"><?php echo htmlspecialchars($_POST['address'], ENT_QUOTES, 'UTF-8'); ?></p>
                  <input type="hidden" name="address" value="<?php echo htmlspecialchars($_POST['address'], ENT_QUOTES, 'UTF-8'); ?>">
                </li>
                <li>
                  <p>メールアドレス</p>
                  <p class="output"><?php echo htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8'); ?></p>
                  <input type="hidden" name="email" value="<?php echo htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8'); ?>">
                </li>
                <li>
                  <p>メールアドレス確認用</p>
                  <p class="output"><?php echo htmlspecialchars($_POST['emailConfirm'], ENT_QUOTES, 'UTF-8'); ?></p>
                  <input type="hidden" name="emailConfirm" value="<?php echo htmlspecialchars($_POST['emailConfirm'], ENT_QUOTES, 'UTF-8'); ?>">
                </li>
                <li>
                  <p>パスワード</p>
                  <p class="output"><?php echo htmlspecialchars($_POST['password'], ENT_QUOTES, 'UTF-8'); ?></p>
                  <input type="hidden" name="password" value="<?php echo htmlspecialchars($_POST['password'], ENT_QUOTES, 'UTF-8'); ?>">
                </li>
                <li>
                  <p>パスワード確認用</p>
                  <p class="output"><?php echo htmlspecialchars($_POST['passwordConfirm'], ENT_QUOTES, 'UTF-8'); ?></p>
                  <input type="hidden" name="passwordConfirm" value="<?php echo htmlspecialchars($_POST['passwordConfirm'], ENT_QUOTES, 'UTF-8'); ?>">
                </li>
              </ul>
              <button type="submit" class="registerConfirmBtn">登録する</button>
            </form>
          </div>
        </div>
      </section>
    </main>
    <?php require 'footer.php'; ?>
    <script src="scripts/script.js"></script>
  </body>
</html>