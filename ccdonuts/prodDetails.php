<?php
session_start();
require 'productsData.php';

$id = $_GET['id'] ?? '';
$product = null;

foreach ($products as $p) {
  if ((string)$p['id'] === (string)$id) {
    $product = $p;
    if (empty($product['image'])) {
      $product['image'] = "images/products/{$product['id']}.jpg";
    }
    break;
  }
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>C.C.Donuts 公式サイト｜商品詳細ページ</title>
  <link rel="icon" href="" type="image/x-icon">
  <link rel="stylesheet" href="common/reset.css">
  <link rel="stylesheet" href="styles/common.css">
  <link rel="stylesheet" href="styles/style.css">
  <link rel="stylesheet" href="styles/prodDetails.css">
</head>
<body>
<?php require 'header.php'; ?>

<main>
  <div class="top">
    <p class="breadcrumb">TOP<span>&gt;</span>商品一覧<span>&gt;</span>
      <?= $product ? htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8') : '商品が見つかりません' ?>
    </p>
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
  <h1>C.C.Donuts 公式サイト｜商品詳細ページ</h1>

  <?php if ($product): ?>
    <section class="prodDetailsSec">
      <div class="innerWrap">
        <div class="prodDetailsCon">
          <div class="prodImg">
            <img src="images/itemImages/donuts<?= htmlspecialchars($product['id']) ?>.jpg" alt="<?= htmlspecialchars($product['name']) ?>" target="_blank">
          </div>
          <div class="prodDetailsCate">
            <h2 class="prodDetailTitle">
              <?php if (($product['is_new'] ?? 0) == 1): ?>
                <span class="newLabel">【新商品】</span>
              <?php endif; ?>
              <?= htmlspecialchars($product['name']) ?>（<?= htmlspecialchars($product['pieces']) ?>個入り）
            </h2>
            <div class="prodDetailText">
              <p><?= htmlspecialchars($product['description']) ?></p>
            </div>
            <div class="prodDetailActCate">
              <p class="prodPrice">税込 ￥<?= number_format($product['price']) ?></p>
              <div class="prodDetailActs">
                <form method="POST" action="cart.php" class="toCart">
                  <input type="hidden" name="action" value="add">
                  <input type="hidden" name="product_id" value="<?= htmlspecialchars($product['id']) ?>">
                  <label class="prodPieces">
                    <input type="number" name="quantity" min="1" value="1"><span>個</span>
                  </label>
                  <button type="submit" class="btn cartBtn">カートに入れる</button>
                </form>
                <button class="btn favoriteBtn">
                  <img src="images/commonImages/favoriteBtn.svg" alt="お気に入り">
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  <?php else: ?>
    <p>商品が見つかりませんでした。</p>
  <?php endif; ?>
</main>

<?php require 'footer.php'; ?>
<script src="scripts/script.js"></script>
</body>
</html>
