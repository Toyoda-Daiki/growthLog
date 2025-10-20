<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>C.C.Donuts 公式サイト｜カード情報登録フォーム</title>
    <link rel="icon" href="" type="image/x-icon">
    <link rel="stylesheet" href="common/reset.css">
    <link rel="stylesheet" href="styles/common.css">
    <link rel="stylesheet" href="styles/form.css">
  </head>
  <body>
    <?php require 'header.php'; ?>
    <main>
      <div class="top">
        <p class="breadcrumb">TOP<span>&gt;</span>カード情報登録</p>
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

      <h1>C.C.Donuts 公式サイト｜カード情報登録フォーム</h1>
      <section class="cardFormSec">
        <div class="innerWrap">
          <div class="title"><h2>カード情報登録</h2></div>
          <div class="cardFormCon">
            <form action="cardConfirm.php" method="POST" class="cardFormCate" id="cardForm">

              <div class="formGroup">
                <label for="customerName" class="formLabel">お名前<span class="requiredMark">（必須）</span></label>
                <input type="text" id="customerName" name="name" class="formInput" placeholder="ドーナツ太郎" autocomplete="cc-name" required>
              </div>

              <div class="formGroup">
                <label for="cardNumber" class="formLabel">カード番号<span class="requiredMark">（必須）</span></label>
                <input type="text" id="cardNumber" name="cardNumber" class="formInput" placeholder="1234567890123456" maxlength="19" pattern="\d{13,19}" autocomplete="cc-number" required>
              </div>

              <div class="formGroup">
                <label class="formLabel">カード会社<span class="requiredMark">（必須）</span></label>
                <div class="radioGroup">
                  <div class="radioItem">
                    <input type="radio" id="companyJcb" name="cardCompany" class="radioInput" value="JCB" checked>
                    <label for="companyJcb" class="radioLabel">JCB</label>
                  </div>
                  <div class="radioItem">
                    <input type="radio" id="companyVisa" name="cardCompany" class="radioInput" value="VISA">
                    <label for="companyVisa" class="radioLabel">Visa</label>
                  </div>
                  <div class="radioItem">
                    <input type="radio" id="companyMastercard" name="cardCompany" class="radioInput" value="MASTERCARD">
                    <label for="companyMastercard" class="radioLabel">Mastercard</label>
                  </div>
                </div>
              </div>

              <div class="formGroup">
                <label class="formLabel">有効期限<span class="requiredMark">（必須）</span></label>
                <div class="expiryGroup">
                  <div class="expiryItem">
                    <input type="text" name="expiryMonth" id="expiryMonth" class="expiryInput" placeholder="04" maxlength="2" pattern="^(0[1-9]|1[0-2])$" autocomplete="cc-exp-month" required>
                    <span class="expiryLabel">月</span>
                  </div>
                  <div class="expiryItem">
                    <input type="text" name="expiryYear" id="expiryYear" class="expiryInput" placeholder="25" maxlength="2" pattern="\d{2}" autocomplete="cc-exp-year" required>
                    <span class="expiryLabel">年</span>
                  </div>
                </div>
              </div>

              <div class="formGroup">
                <label for="securityCode" class="formLabel">セキュリティコード<span class="requiredMark">（必須）</span></label>
                <input type="text" id="securityCode" name="securityCode" class="formInput" placeholder="1234" maxlength="4" pattern="\d{3,4}" autocomplete="cc-csc" required>
              </div>

              <button type="submit" class="cardConfirmBtn">入力確認する</button>

            </form>
          </div>
        </div>
      </section>
    </main>
    <?php require 'footer.php'; ?>
    <script src="scripts/script.js"></script>
  </body>
</html>

