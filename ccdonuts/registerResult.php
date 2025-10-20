<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>C.C.Donuts 公式サイト｜会員登録結果</title>
    <link rel="icon" href="" type="image/x-icon">
    <link rel="stylesheet" href="common/reset.css">
    <link rel="stylesheet" href="styles/common.css">
    <link rel="stylesheet" href="styles/result.css">
  </head>
  <body>
    <?php require 'header.php'; ?>
    <main>
      <div class="top">
        <p class="breadcrumb">TOP<span>&gt;</span>ログイン<span>&gt;</span>会員登録<span>&gt;</span>入力確認<span>&gt;</span>会員登録完了</p>
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
      <h1>C.C.Donuts 公式サイト｜会員登録｜登録結果</h1>
      <section class="registerResultSec">
        <div class="innerWrap">
          <?php
            // DB接続設定
            $dsn = 'mysql:host=localhost;dbname=ccdonuts;charset=utf8';
            $user = 'ccStaff';
            $password = 'ccDonuts';

            try {
              $pdo = new PDO($dsn, $user, $password);
              $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

              // POSTデータ受け取り
              $name = $_POST['name'] ?? '';
              $nameKana = $_POST['nameKana'] ?? '';
              $postalCode1 = $_POST['postalCode1'] ?? '';
              $postalCode2 = $_POST['postalCode2'] ?? '';
              $address = $_POST['address'] ?? '';
              $email = $_POST['email'] ?? '';
              $passwordPlain = $_POST['password'] ?? '';

              // バリデーション
              if (empty($name) || empty($nameKana) || empty($email) || empty($passwordPlain)) {
                throw new Exception('必要な項目が入力されていません。');
              }

              // 同一メールアドレス確認
              $check = $pdo->prepare("SELECT COUNT(*) FROM customers WHERE email = ?");
              $check->execute([$email]);
              $exists = $check->fetchColumn();

              if ($exists > 0) {
                echo '<div class="title"><h2>登録結果</h2></div>';
                echo '<div class="resultCon">';
                echo '<div class="resultCate">';
                echo '<div class="resultText">';
                echo '<p>このメールアドレスは既に登録されています。</p>';
                echo '<p>ログインページへお進みください。</p>';
                echo '</div></div>';
                echo '<a href="loginForm.php" class="backToTop">ログインページへすすむ</a>';
                echo '</div>';
              } else {
                // 登録処理
                $stmt = $pdo->prepare("
                  INSERT INTO customers (name, nameKana, postalCode1, postalCode2, address, email, password)
                  VALUES (:name, :nameKana, :postalCode1, :postalCode2, :address, :email, :password)
                ");
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':nameKana', $nameKana);
                $stmt->bindParam(':postalCode1', $postalCode1);
                $stmt->bindParam(':postalCode2', $postalCode2);
                $stmt->bindParam(':address', $address);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':password', $passwordPlain);
                $stmt->execute();

                // 成功時の表示（※あなた指定のHTMLをそのまま適用）
                echo '<div class="title"><h2>会員登録完了</h2></div>';
                echo '<div class="resultCon">';
                echo '<div class="resultCate">';
                echo '<div class="resultText">';
                echo '<p>会員登録が完了しました。</p>';
                echo '<p>ログインページへお進みください。</p>';
                echo '</div></div>';
                echo '<a href="cardForm.php" class="backToTop">クレジットカード登録へすすむ</a>';
                echo '<a href="purchaseConfirm.php" class="toPurchaseConfirm">購入確認ページへすすむ</a>';
                echo '</div>';
              }

            } catch (Exception $e) {
              echo '<div class="title"><h2>登録結果</h2></div>';
              echo '<div class="resultCon">';
              echo '<div class="resultCate">';
              echo '<div class="resultText">';
              echo '<p>登録処理中にエラーが発生しました。</p>';
              echo '<p>' . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . '</p>';
              echo '</div></div>';
              echo '<a href="registerForm.php" class="backToTop">入力フォームに戻る/</a>';
              echo '</div>';
            }
          ?>
        </div>
      </section>
    </main>
    <?php require 'footer.php'; ?>
    <script src="scripts/script.js"></script>
  </body>
</html>