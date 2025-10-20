<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>C.C.Donuts 公式サイト｜ログイン完了</title>
    <link rel="icon" href="" type="image/x-icon">
    <link rel="stylesheet" href="common/reset.css">
    <link rel="stylesheet" href="styles/common.css">
    <link rel="stylesheet" href="styles/result.css">
  </head>
  <body>
    <?php require 'header.php'; ?>
    <main>
      <div class="top">
        <p class="breadcrumb">TOP<span>&gt;</span>ログイン完了</p>
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
      <h1>C.C.Donuts 公式サイト｜ログイン完了</h1>
      <section class="resultSec">
        <div class="innerWrap">
          <div class="title"><h2>ログイン完了</h2></div>
          <div class="resultCon">
            <div class="resultCate">
              <div class="resultText">
                <p>ログインが完了しました。</p>
                <p>引き続きお楽しみください。</p>
              </div>
            </div>
            <a href="purchaseConfirm.php" class="toPurchaseConfirm">購入確認ページへすすむ</a>
            <a href="index.php" class="backToTop">TOPページにもどる</a>
          </div>
        </div>
      </section>
    </main>
   <?php require 'footer.php'; ?>
    <script src="scripts/script.js"></script>
  </body>
</html>
  