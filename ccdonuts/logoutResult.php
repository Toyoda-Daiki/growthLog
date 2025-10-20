<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  die("不正なアクセスです。");
}

$_SESSION = array();

if (isset($_COOKIE[session_name()])) {
  setcookie(session_name(), '', time() - 42000, '/');
}

session_destroy();
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>C.C.Donuts 公式サイト｜ログアウト完了</title>
  <link rel="icon" href="" type="image/x-icon">
  <link rel="stylesheet" href="common/reset.css">
  <link rel="stylesheet" href="styles/common.css">
  <link rel="stylesheet" href="styles/result.css">
</head>
<body>
  <?php require 'header.php'; ?>
  <main>
    <div class="top">
      <p class="breadcrumb">TOP<span>&gt;</span>ログアウト<span>&gt;</span>ログアウト完了</p>
      <p class="account account2">ようこそ　ゲスト　様</p>
    </div>
    <h1>C.C.Donuts 公式サイト｜ログアウト完了</h1>
    <section class="logoutResultSec">
      <div class="innerWrap">
        <div class="title"><h2>ログアウト完了</h2></div>
        <div class="resultCon">
          <div class="resultCate">
            <div class="resultText">
              <p>ログアウトが完了しました。</p>
              <p>またのご利用を心よりお待ちしております。</p>
            </div>
          </div>
          <a href="loginForm.php" class="loginBtn">ログインページへすすむ</a>
          <a href="index.php" class="backToTop">トップページへすすむ</a>
        </div>
      </div>
    </section>
  </main>
  <?php require 'footer.php'; ?>
  <script src="scripts/script.js"></script>
</body>
</html>