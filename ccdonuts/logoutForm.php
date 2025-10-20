<?php
session_start();

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>C.C.Donuts 公式サイト｜ログアウト</title>
    <link rel="icon" href="" type="image/x-icon">
    <link rel="stylesheet" href="common/reset.css">
    <link rel="stylesheet" href="styles/common.css">
    <link rel="stylesheet" href="styles/form.css">
  </head>
  <body>
  <?php require 'header.php'; ?>
  <main>
    <div class="top">
      <p class="breadcrumb">TOP<span>&gt;</span>ログアウト</p>
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
    <h1>C.C.Donuts 公式サイト｜ログアウト</h1>
    <section class="logoutFormSec">
      <div class="innerWrap">
        <div class="title"><h2>ログアウト</h2></div>
        <div class="logoutFormCon">
          <div class="logoutFormCate">
            <div class="logoutText">
              <img src="images/commonImages/animals.jpg" alt="動物たち" />
              <p>ご覧いただきありがとうございました。</p>
              <p>ログアウトしますか？</p>
            </div>
            <form method="POST" action="logoutResult.php" class="logoutBtnCate">
              <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
              <button type="submit" class="logoutBtn">ログアウトする</button>
            </form>
          </div>
          <a href="index.php" class="newAccount">トップページへ戻る</a>
        </div>
      </div>
    </section>
  </main>
  <?php require 'footer.php'; ?>
  <script src="scripts/script.js"></script>
  </body>
</html>