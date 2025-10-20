<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>C.C.Donuts 公式サイト｜カード情報入力確認</title>
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
              echo "ようこそ　ゲスト様";
            }
          ?>
        </p>
      </div>
      <h1>C.C.Donuts 公式サイト｜会員登録｜カード情報入力確認</h1>
      <section class="cardConfirmSec">
        <div class="innerWrap">
          <div class="title"><h2>入力情報確認</h2></div>
          <div class="cardConfirmCon">
            <form action="cardResult.php" method="post">
              <ul class="formGroup">
                <li>
                  <p>お名前</p>
                  <p class="output"><?php echo htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8'); ?></p>
                  <input type="hidden" name="name" value="<?php echo htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8'); ?>">
                </li>
                <li>
                  <p>カード番号</p>
                  <p class="output"><?php echo htmlspecialchars($_POST['cardNumber'], ENT_QUOTES, 'UTF-8'); ?></p>
                  <input type="hidden" name="cardNumber" value="<?php echo htmlspecialchars($_POST['cardNumber'], ENT_QUOTES, 'UTF-8'); ?>">
                </li>
                <li>
                  <p>カード会社</p>
                  <p class="output"><?php echo htmlspecialchars($_POST['cardCompany'], ENT_QUOTES, 'UTF-8'); ?></p>
                  <input type="hidden" name="cardCompany" value="<?php echo htmlspecialchars($_POST['cardCompany'], ENT_QUOTES, 'UTF-8'); ?>">
                </li>
                <li>
                  <p>有効期限</p>
                  <p class="output"><?php echo htmlspecialchars($_POST['expiryMonth'], ENT_QUOTES, 'UTF-8'); ?><span class="expiryLabel">年</span></p>
                  <input type="hidden" name="expiryMonth" value="<?php echo htmlspecialchars($_POST['expiryMonth'], ENT_QUOTES, 'UTF-8'); ?>">
                  <p class="output"><?php echo htmlspecialchars($_POST['expiryYear'], ENT_QUOTES, 'UTF-8'); ?><span class="expiryLabel">年</span></p>
                  <input type="hidden" name="expiryYear" value="<?php echo htmlspecialchars($_POST['expiryYear'], ENT_QUOTES, 'UTF-8'); ?>">
                </li>
                <li>
                  <p>セキュリティコード</p>
                  <p class="output"><?php echo htmlspecialchars($_POST['securityCode'], ENT_QUOTES, 'UTF-8'); ?></p>
                  <input type="hidden" name="securityCode" value="<?php echo htmlspecialchars($_POST['securityCode'], ENT_QUOTES, 'UTF-8'); ?>">
                </li>
              </ul>
              <button type="submit" class="cardConfirmBtn">登録する</button>
            </form>
          </div>
        </div>
      </section>
    </main>
    <?php require 'footer.php'; ?>
    <script src="scripts/script.js"></script>
  </body>
</html>