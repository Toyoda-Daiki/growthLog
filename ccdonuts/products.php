<?php
session_start();
require 'productsData.php'; 

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
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>C.C.Donuts 公式サイト｜商品一覧</title>
  <link rel="icon" href="" type="image/x-icon">
  <link rel="stylesheet" href="common/reset.css">
  <link rel="stylesheet" href="styles/common.css">
  <link rel="stylesheet" href="styles/products.css">
</head>
<body>
<?php require 'header.php'; ?>
<?php require 'productsData.php'; ?>

<main>
  <div class="top">
    <p class="breadcrumb">TOP<span>&gt;</span>商品一覧</p>
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
  <h1>C.C.Donuts 公式サイト｜商品一覧ページ</h1>

  <section class="productsSec">
    <div class="innerWrap">

      <div class="title"><h2>商品一覧</h2></div>

      <section class="mainMenuSec">
        <h3>メインメニュー</h3>
        <ul class="prodList">
          <?php foreach ($products as $product): ?>
            <?php if ($product['category'] === 'main'): ?>
              <li>
                <a href="prodDetails.php?id=<?= htmlspecialchars($product['id']) ?>" target="_blank">
                  <img src="images/itemImages/donuts<?= htmlspecialchars($product['id']) ?>.jpg" alt="<?= htmlspecialchars($product['name'])?>">
                </a>
                <div class="prodInfo">
                  <p class="prodName">
                    <?php if (($product['is_new'] ?? 0) == 1): ?>
                      <span class="newLabel">【新商品】</span>
                    <?php endif; ?>
                    <?= htmlspecialchars($product['name']) ?>
                  </p>
                  <p class="prodPieces">（<?= htmlspecialchars($product['pieces']) ?>個入り）</p>
                </div>
                <p class="prodPrice">税込 ￥<?= number_format($product['price']) ?></p>
                <form method="POST" action="cart.php" class="toCart">
                  <input type="hidden" name="action" value="add">
                  <input type="hidden" name="product_id" value="<?= htmlspecialchars($product['id']) ?>">
                  <input type="hidden" name="quantity" value="1"> 
                  <button type="submit" class="btn cartBtn">カートに入れる</button>
                </form>
              </li>
            <?php endif; ?>
          <?php endforeach; ?>
        </ul>
      </section>

      <section class="varietyMenuSec">
        <h3>バラエティメニュー</h3>
        <ul class="prodList">
          <?php foreach ($products as $product): ?>
            <?php if ($product['category'] === 'variety'): ?>
              <li>
                <a href="prodDetails.php?id=<?= htmlspecialchars($product['id']) ?>" target="_blank">
                  <img src="images/itemImages/donuts<?= htmlspecialchars($product['id']) ?>.jpg" alt="<?= htmlspecialchars($product['name'])?>">
                </a>
                <div class="prodInfo">
                  <p class="prodName"><?= htmlspecialchars($product['name']) ?></p>
                  <p class="prodPieces">（<?= htmlspecialchars($product['pieces']) ?>個入り）</p>
                </div>
                <p class="prodPrice">税込 ￥<?= number_format($product['price']) ?></p>
                <form method="POST" action="cart.php" class="toCart">
                  <input type="hidden" name="action" value="add">
                  <input type="hidden" name="product_id" value="<?= htmlspecialchars($product['id']) ?>">
                  <input type="hidden" name="quantity" value="1"> 
                  <button type="submit" class="btn cartBtn">カートに入れる</button>
                </form>
              </li>
            <?php endif; ?>
          <?php endforeach; ?>
        </ul>
      </section>

    </div>
  </section>
</main>

<?php require 'footer.php'; ?>
<script src="scripts/script.js"></script>
</body>
</html>