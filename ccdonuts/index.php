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

//ランキング仮置き(今後DBにて実装予定)
$rankingIds = [1, 7, 8, 2, 11, 6];

$rankingProducts = [];
foreach ($rankingIds as $id) {
  foreach ($products as $p) {
    if ((int)$p['id'] === (int)$id) {
      $rankingProducts[] = $p;
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
  <title>C.C.Donuts 公式サイト</title>
  <link rel="icon" href="" type="image/x-icon">
  <link rel="stylesheet" href="common/reset.css">
  <link rel="stylesheet" href="styles/common.css">
  <link rel="stylesheet" href="styles/top.css">
</head>
<body>
<?php require 'header.php'; ?>
<main>
  <div class="top">
    <p class="account">
      <p class="account">
        <?php
          if (isset($_SESSION['user']['name'])) {
            echo "ようこそ " . htmlspecialchars($_SESSION['user']['name'], ENT_QUOTES, 'UTF-8') . "　様";
          } else {
            echo "ようこそ　ゲスト　様";
          }
        ?>
      </p>
    </p>
  </div>

  <div class="hero">
    <h1>C.C.Donuts 公式サイト｜トップページ</h1>
    <img src="images/topImages/hero.jpg" alt="ヒーロー画像">
  </div>

  <section class="topicSec">
    <div class="innerWrap">
      <div class="topicCon">
        <?php if ($newProduct): ?>
        <div class="newItem">
          <a href="prodDetails.php?id=<?= htmlspecialchars($newProduct['id']) ?>">
            <p class="newTag">新商品</p>
            <img src="images/itemImages/donuts<?= htmlspecialchars($newProduct['id']) ?>.jpg" alt="<?= htmlspecialchars($newProduct['name']) ?>">
            <p class="topicName"><?= htmlspecialchars($newProduct['name']) ?></p>
          </a>
        </div>
        <?php else: ?>
        <div class="newItem">
          <a href="images/commonImages/goodBtn.svg">
            <!-- <p class="newTag">新商品</p> -->
            <img src="images/commonImages/goodBtn.svg" alt="">
            <p class="commingsoon">comming soon</p>
          </a>
        </div>
        <?php endif; ?>

        <div class="topicItem">
          <a href="#">
            <img src="images/topImages/topicItem.jpg" alt="新商品1">
            <p class="topicName">ドーナツのある生活</p>
          </a>
        </div>
        <div class="itemList">
          <a href="products.php">
            <img src="images/topImages/itemBanner.jpg" alt="新商品1">
            <p class="topicName">商品一覧</p>
          </a>
        </div>
      </div>
    </div>
  </section>

  <section class="introSec">
    <div class="introCon">
      <h2>Philosophy</h2>
      <h3>私たちの信念</h3>
      <div class="vision">
        <p>"Creating Connections"</p>
        <p>「ドーナツでつながる」</p>
      </div>
    </div>
  </section>

  <section class="bestSellingSec">
    <div class="innerWrap">
      <h2>人気ランキング</h2>
      <ul class="lankList">
        <?php 
        $rankClasses = ['lankNum1', 'lankNum2', 'lankNum3', 'lankNum4', 'lankNum5', 'lankNum6'];
        foreach ($rankingProducts as $index => $product): 
          $rank = $index + 1;
          $rankClass = $rankClasses[$index] ?? '';
        ?>
        <li>
          <p class="lankNum <?= $rankClass ?>"><?= $rank ?></p>
          <a href="prodDetails.php?id=<?= htmlspecialchars($product['id']) ?>" target="_blank">
            <img src="images/itemImages/donuts<?= htmlspecialchars($product['id']) ?>.jpg" alt="<?= htmlspecialchars($product['name']) ?>">
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
        <?php endforeach; ?>
      </ul>
    </div>
  </section>
</main>
<?php require 'footer.php'; ?>
<script src="scripts/script.js"></script>
</body>
</html>
