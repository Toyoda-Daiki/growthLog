<?php
session_start();
require 'productsData.php';
require 'dbConnect.php'; 

if (empty($_SESSION['cart']) || !isset($_SESSION['user'])) {
  header("Location: cart.php");
  exit;
}

$userId = $_SESSION['user']['id'];
$stmt = $pdo->prepare("SELECT name, postalCode1, postalCode2, address FROM customers WHERE id = ?");
$stmt->execute([$userId]);
$userData = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$userData) {
  echo "<p>ユーザー情報を取得できませんでした。</p>";
  exit;
}

// 仮のカードデータ
// --------------------------------------------
// 登録がある場合
$cardData = [
  'cardCompany' => 'JCB',
  'cardNumber' => '**** **** **** 1234',
  'expiryMonth' => '12',
  'expiryYear' => '2028'
];

// 登録がない場合
//$cardData = null;
// --------------------------------------------

$cart = $_SESSION['cart'];
$total = 0;
$totalItems = 0;
$purchaseConfirmList = [];

foreach ($cart as $productId => $item) {
  foreach ($products as $p) {
    if ($p['id'] === $productId) {
      $subtotal = $p['price'] * $item['quantity'];
      $total += $subtotal;
      $totalItems += $item['quantity'];
      $purchaseConfirmList[] = [
        'name' => $p['name'],
        'pieces' => $p['pieces'],
        'price' => $p['price'],
        'quantity' => $item['quantity'],
        'is_new' => $p['is_new'] ?? 0
      ];
      break;
    }
  }
}

$newProduct = null;
foreach ($products as $p) {
  if (!empty($p['is_new']) && $p['is_new'] == 1) {
    $newProduct = $p;
    break;
  }
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>C.C.Donuts｜ご購入確認</title>
  <link rel="stylesheet" href="common/reset.css">
  <link rel="stylesheet" href="styles/common.css">
   <link rel="stylesheet" href="styles/confirm.css">
</head>
<body>
  <?php require 'header.php'; ?>

  <main>
    <div class="top">
      <p class="breadcrumb">TOP<span>&gt;</span>カート<span>&gt;</span>購入確認</p>
      <p class="account account2">
        <?= htmlspecialchars($userData['name'], ENT_QUOTES, 'UTF-8'); ?> 様
      </p>
    </div>

    <section class="purchaseConfirmSec">
      <div class="innerWrap">
        <h1>C.C.Donuts 公式サイト｜ご購入確認</h1>
        <div class="title"><h2>ご購入確認</h2></div>

        <h3>ご購入商品</h3>
        <div class="purchaseConfirmCon">
          <?php foreach ($purchaseConfirmList as $item): ?>
            <div class="purchaseConfirmCate purchaseConfirmItems">
              <div class="purchaseConfirmItem">
                <h4>商品名</h4>
                <p>
                  <?php if (!empty($item['is_new']) && $item['is_new'] == 1): ?>
                  <span class="newLabel">【新商品】</span>
                  <?php endif; ?><?= htmlspecialchars($item['name']); ?>（<?= htmlspecialchars($item['pieces']); ?>個入り）
                </p>
              </div>
              <div class="purchaseConfirmItem">
                <h4>数量</h4>
                <p><?= htmlspecialchars($item['quantity']); ?>個</p>
              </div>
              <div class="purchaseConfirmItem">
                <h4>金額</h4>
                <p>税込 ¥<?= number_format($item['price'] * $item['quantity']); ?></p>
              </div>
            </div>
          <?php endforeach; ?>
        </div>

        <div class="purchaseConfirmCon">
          <h3>お届け先</h3>
          <div class="purchaseConfirmCate">
            <div class="purchaseConfirmItem"><h4>お名前</h4><p><?= htmlspecialchars($userData['name']); ?></p></div>
            <div class="purchaseConfirmItem"><h4>郵便番号</h4><p><?= htmlspecialchars($userData['postalCode1']); ?> - <?= htmlspecialchars($userData['postalCode2']); ?></p></div>
            <div class="purchaseConfirmItem"><h4>住所</h4><p><?= htmlspecialchars($userData['address']); ?></p></div>
          </div>
        </div>

        <div class="purchaseCon">
          <h3>お支払い方法</h3>
          <?php if ($cardData): ?>
            <div class="purchaseConfirmCate">
              <div class="purchaseConfirmItem"><h4>お支払い方法</h4><p>クレジットカード</p></div>
              <div class="purchaseConfirmItem"><h4>カード会社</h4><p><?= htmlspecialchars($cardData['cardCompany']); ?></p></div>
              <form action="cardForm.php" method="post" class="registerNewCardForm">
                <button type="submit" class="registerCardBtn registerNewCardBtn">別のカードを登録する</button>
              </form>
              <p class="purchaseConfirmNote">ほかのカードを登録されたい場合はこちらへお進みください。</p>
            </div>
            
          <?php else: ?>
            <div class="purchaseConfirmCate">
              <form action="cardForm.php" method="post">
                <?php foreach ($purchaseConfirmList as $index => $item): ?>
                  <input type="hidden" name="items[<?= $index ?>][name]" value="<?= htmlspecialchars($item['name']); ?>">
                  <input type="hidden" name="items[<?= $index ?>][quantity]" value="<?= $item['quantity']; ?>">
                  <input type="hidden" name="items[<?= $index ?>][price]" value="<?= $item['price']; ?>">
                <?php endforeach; ?>
                <input type="hidden" name="total" value="<?= $total; ?>">
                <button type="submit" class="registerCardBtn">カード情報を登録する</button>
              </form>
              <p class="purchaseConfirmNote">カード情報登録がまだのお客様はこちらへお進みください。</p>
            </div>
          <?php endif; ?>
        </div>

        <form action="purchaseResult.php" method="post" class="purchaseResultForm">
          <button type="submit" class="purchaseResultBtn">購入確定する</button>
        </form>
      </div>
    </section>
  </main>

  <?php require 'footer.php'; ?>
  <script src="scripts/script.js"></script>
</body>
</html>