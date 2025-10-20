<?php
session_start();

// カート情報をクリア（購入完了時）
if (isset($_SESSION['cart'])) {
    unset($_SESSION['cart']);
}

?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>C.C.Donuts 公式サイト｜ご購入完了</title>
    <link rel="icon" href="" type="image/x-icon">
    <link rel="stylesheet" href="common/reset.css">
    <link rel="stylesheet" href="styles/common.css">
    <link rel="stylesheet" href="styles/result.css">
  </head>
  <body>
    <?php require 'header.php'; ?>
    <main>
      <div class="top">
        <p class="breadcrumb">TOP<span>&gt;</span>カート<span>&gt;</span>購入確認<span>&gt;</span>購入完了</p>
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
      <h1>C.C.Donuts 公式サイト｜ご購入完了</h1>
      <section class="resultSec">
        <div class="innerWrap">
          <div class="title"><h2>ご購入完了</h2></div>
          <div class="resultCon">
            <div class="resultCate">
              <div class="resultText">
                <p>ご購入いただきありがとうございます</p>
                <p>今後ともご愛顧のほど、よろしくお願いいたします。</p>
              </div>
            </div>
            
            <a href="index.php" class="backToTop">TOPページにもどる</a>
          </div>
        </div>
      </section>
    </main>
   <?php require 'footer.php'; ?>
    <script src="scripts/script.js"></script>
  </body>
</html>
  