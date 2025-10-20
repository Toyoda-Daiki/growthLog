<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>C.C.Donuts 公式サイト｜会員登録フォーム</title>
    <link rel="icon" href="" type="image/x-icon">
    <link rel="stylesheet" href="common/reset.css">
    <link rel="stylesheet" href="styles/common.css">
    <link rel="stylesheet" href="styles/form.css">
  </head>
  <body>
    <?php require 'header.php'; ?>
    <main>
      <div class="top">
        <p class="breadcrumb">TOP<span>&gt;</span>ログイン&gt;</span>会員登録</p>
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
      <h1>C.C.Donuts 公式サイト｜会員登録フォーム</h1>
      <section class="registerFormSec">
        <div class="innerWrap">
          <div class="title"><h2>会員登録フォーム</h2></div>
          <div class="registerFormCon">
            <form action="registerConfirm.php" method="post" class="registerFormCate">
              <div class="formGroup">
                <div class="formGroup2">
                  <label for="name">お名前<span>（必須）</span></label>
                  <input type="text" id="name" name="name" placeholder="ドーナツ太郎" required>
                </div>

                <div class="formGroup2">
                  <label for="nameKana">お名前（フリガナ）<span>（必須）</span></label>
                  <input type="text" id="nameKana" name="nameKana" placeholder="ドーナツタロウ" required pattern="[\u30A1-\u30F6ー\s]+">
                </div>

                <div class="formGroup2">
                  <label>郵便番号<span>（必須）</span></label>
                  <div class="postalGroup">
                    <input type="text" id="postalCode1" class="postalCode1" name="postalCode1" maxlength="3" pattern="\d{3}" placeholder="000" required>
                    <input type="text" id="postalCode2" class="postalCode2" name="postalCode2" maxlength="4" pattern="\d{4}" placeholder="0000" required>
                  </div>
                </div>

                <div class="formGroup2">
                  <label for="address">住所<span>（必須）</span></label>
                  <input type="text" id="address" name="address" placeholder="千葉県○○市中央1-1-1" required>
                </div>

                <div class="formGroup2">
                  <label for="email">メールアドレス<span>（必須）</span></label>
                  <input type="email" id="email" name="email" placeholder="123@gmail.com" required>
                </div>

                <div class="formGroup2">
                  <label for="emailConfirm">メールアドレス確認用<span>（必須）</span></label>
                  <input type="email" id="emailConfirm" name="emailConfirm" placeholder="123@gmail.com" required>
                </div>

                <div class="formGroup2">
                  <label for="password">パスワード<span>（必須）</span></label>
                  <p class="passwordNote">半角英数字8文字以上20文字以内で入力してください。記号の使用はできません</p>
                  <input type="password" id="password" name="password" placeholder="123456abcd" required minlength="8">
                </div>

                <div class="formGroup2">
                  <label for="passwordConfirm">パスワード確認用<span>（必須）</span></label>
                  <input type="password" id="passwordConfirm" name="passwordConfirm" placeholder="123456abcd" required minlength="8">
                </div>
              </div>

              <button type="submit" class="registerConfirmBtn">入力確認する</button>
            </form>
          </div>
        </div>
      </section>
    </main>
   <?php require 'footer.php'; ?>
    <script src="scripts/script.js"></script>
    <script>
      document.addEventListener("DOMContentLoaded", function() {
      const form = document.querySelector(".registerFormCate");

      form.addEventListener("submit", function(e) {
        const email = document.getElementById("email").value;
        const emailConfirm = document.getElementById("emailConfirm").value;
        const password = document.getElementById("password").value;
        const passwordConfirm = document.getElementById("passwordConfirm").value;

        let errors = [];

        if (email !== emailConfirm) {
          errors.push("メールアドレスが一致しません。");
        }

        if (password !== passwordConfirm) {
          errors.push("パスワードが一致しません。");
        }

        if (errors.length > 0) {
          e.preventDefault();
          alert(errors.join("\n"));
        }
      });
    });
    </script>
  </body>
</html>