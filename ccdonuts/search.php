<?php
session_start();
require 'productsData.php';

$keyword = '';
$results = [];

// --- 検索キーワードの取得と保持 ---
if (isset($_GET['keyword']) && $_GET['keyword'] !== '') {
  $keyword = trim($_GET['keyword']);
  $_SESSION['lastKeyword'] = $keyword;
} elseif (isset($_SESSION['lastKeyword'])) {
  $keyword = $_SESSION['lastKeyword'];
}

// --- 検索処理 ---
if ($keyword !== '') {
  foreach ($products as $product) {
    if (stripos($product['name'], $keyword) !== false) {
      $results[] = $product;
    }
  }
}

// --- 新商品情報 ---
$newProduct = null;
foreach ($products as $p) {
  if (!empty($p['is_new']) && $p['is_new'] == 1) {
    $newProduct = $p;
    break;
  }
}

// --- おすすめ商品 ---
$myBestIds = [1, 5, 6];
$myBestProducts = [];
foreach ($myBestIds as $id) {
  foreach ($products as $p) {
    if ((int)$p['id'] === (int)$id) {
      $myBestProducts[] = $p;
      break;
    }
  }
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>検索結果 | C.C.Donuts</title>
  <link rel="stylesheet" href="common/reset.css">
  <link rel="stylesheet" href="styles/common.css">
  <link rel="stylesheet" href="styles/search.css">
</head>
<body>
  <?php require 'header.php'; ?>

  <main>
    <div class="top">
      <p class="breadcrumb">TOP<span>&gt;</span>検索結果</p>
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

    <h1>検索結果</h1>

    <section class="searchResultSec">
      <div class="innerWrap">
        <div class="title"><h2>「<?= htmlspecialchars($keyword) ?>」の検索結果</h2></div>

        <?php if (empty($results)): ?>
          <div class="searchEmptyCon">
            <p class="noResult">該当する商品はありませんでした。</p>
            <p class="noResult">以下の商品がおすすめ商品となっております。</p>
          </div>

          <div class="myBestCon">
            <h3>おすすめの商品</h3>
            <ul class="myBestList">
              <?php foreach ($myBestProducts as $product): ?>
              <li>
                <a href="prodDetails.php?id=<?= htmlspecialchars($product['id']) ?>" target="_blank">
                  <img src="images/itemImages/donuts<?= htmlspecialchars($product['id']) ?>.jpg" alt="<?= htmlspecialchars($product['name']) ?>">
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
              <?php endforeach; ?>
            </ul>
          </div>
          <a href="products.php" class="toProductsBtn">商品一覧へ戻る</a>

        <?php else: ?>
          <div class="searchResultCon">
            <ul class="prodList">
              <?php foreach ($results as $product): ?>
              <li>
                <a href="prodDetails.php?id=<?= htmlspecialchars($product['id']) ?>" target="_blank">
                  <img src="images/itemImages/donuts<?= htmlspecialchars($product['id']); ?>.jpg" alt="<?= htmlspecialchars($product['name']) ?>">
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
              <?php endforeach; ?>
            </ul>
          </div>
          <a href="products.php" class="toProductsBtn">商品一覧はこちら</a>
          <a href="index.php" class="backToTop">TOPページにもどる</a>
        <?php endif; ?>
      </div>
    </section>
  </main>
  <?php require 'footer.php'; ?>
  <script src="scripts/script.js"></script>
</body>
</html>