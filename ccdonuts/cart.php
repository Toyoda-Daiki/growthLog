<?php
session_start();
require 'productsData.php';

if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $action = $_POST['action'] ?? '';
  $id = (int)($_POST['product_id'] ?? 0);
  $qty = (int)($_POST['quantity'] ?? 0);

  if ($action === 'add' && $id > 0 && $qty > 0) {
    if (isset($_SESSION['cart'][$id])) {
      $_SESSION['cart'][$id]['quantity'] += $qty;
    } else {
      $_SESSION['cart'][$id] = ['quantity' => $qty];
    }
  }
  elseif ($action === 'update' && $id > 0 && $qty > 0) {
    $_SESSION['cart'][$id]['quantity'] = $qty;
  }
  elseif ($action === 'delete' && $id > 0) {
    unset($_SESSION['cart'][$id]);
  }
  elseif ($action === 'checkout') {
    if (!isset($_SESSION['user']['name'])) {
      $_SESSION['redirect_after_login'] = 'purchaseConfirm.php';
      header("Location: loginForm.php");
      exit;
    } else {
      header("Location: purchaseConfirm.php");
      exit;
    }
  }

  header("Location: cart.php");
  exit;
}

$total = $totalItems = 0;
foreach ($_SESSION['cart'] as $itemId => $item) {
  foreach ($products as $p) {
    if ($p['id'] === $itemId) {
      $total += $p['price'] * $item['quantity'];
      $totalItems += $item['quantity'];
      break;
    }
  }
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>ショッピングカート | C.C.Donuts</title>
  <link rel="stylesheet" href="common/reset.css" />
  <link rel="stylesheet" href="styles/common.css" />
  <link rel="stylesheet" href="styles/cart.css" />
</head>
<body>
  <?php require 'header.php'; ?>

  <main>
    <div class="top">
      <p class="breadcrumb">TOP<span>&gt;</span>カート</p>
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

    <h1>ショッピングカート</h1>

    <section class="cartSec">
      <div class="innerWrap">
        <div class="cartCon">

          <?php if (empty($_SESSION['cart'])): ?>
            <div class="cartEmptyCon">
              <p class="emptyText">カートは空です。</p>
              <p class="emptyText">引き続き、お楽しみください。</p>
              <img src="images/commonImages/animals.jpg" alt="動物たち" />
            </div>
            <div class="toproducts">
              <a href="products.php" class="backBtn">
                <button class="toproductsBtn">商品一覧へ戻る</button>
              </a>
            </div>

          <?php else: ?>
            <div class="cartSummary bottom">
              <p class="cartTotalItems">現在　<?= $totalItems; ?>点</p>
              <p class="cartTotalPrice">ご注文小計：<span>税込 ￥<?= number_format($total); ?></span></p>
              <form method="POST">
                <button type="submit" name="action" value="checkout" class="checkoutBtn">購入手続きへ進む</button>
              </form>
            </div>

            <ul class="cartList">
              <?php foreach ($_SESSION['cart'] as $itemId => $item):
                $product = null;
                foreach ($products as $p) {
                  if ($p['id'] === $itemId) { $product = $p; break; }
                }
                if (!$product) continue;
              ?>
              <li class="cartItem">
                <img src="images/itemImages/donuts<?= htmlspecialchars($product['id']); ?>.jpg" alt="<?= htmlspecialchars($product['name']); ?>" />

                <div class="itemInfo">
                  <div class="itemName">
                    <p class="itemName2">
                      <?php if (!empty($product['is_new']) && $product['is_new'] == 1): ?>
                        <span class="newLabel">【新商品】</span>
                      <?php endif; ?>
                      <?= htmlspecialchars($product['name']) ?>
                    </p>
                    <p class="itemName2">
                      （<?= htmlspecialchars($product['pieces']); ?>個入り）
                    </p>
                  </div>

                  <div class="itemInfo2">
                    <div class="priceQtyBox">
                      <p class="itemPrice">税込 ￥<?= number_format($product['price']); ?></p>
                      <form method="POST" class="updateForm" data-id="<?= $itemId; ?>">
                        <input type="hidden" name="action" value="update">
                        <input type="hidden" name="product_id" value="<?= $itemId; ?>">
                        <p>数量 
                          <input type="number" name="quantity_<?= $itemId; ?>" value="<?= $item['quantity']; ?>" min="1" class="quantityInput" data-id="<?= $itemId; ?>"> 個
                        </p>
                      </form>
                    </div>

                    <div class="updateCon">
                      <button type="button" class="updateBtn" data-id="<?= $itemId; ?>">再計算</button>
                    </div>

                    <div class="deleteCon">
                      <form method="POST" class="deleteForm">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="product_id" value="<?= $itemId; ?>">
                        <button type="submit" class="deleteBtn">削除する</button>
                      </form>
                    </div>
                  </div>
                </div>
              </li>
              <?php endforeach; ?>
            </ul>

            <div class="cartSummary bottom">
              <p class="cartTotalItems">現在　<?= $totalItems; ?>点</p>
              <p class="cartTotalPrice">ご注文小計：<span>税込 ￥<?= number_format($total); ?></span></p>
              <form method="POST">
                <button type="submit" name="action" value="checkout" class="checkoutBtn">購入手続きへ進む</button>
              </form>
            </div>

            <div class="toproducts">
              <a href="products.php" class="toproductsBtn">商品一覧へ戻る</a>
            </div>
          <?php endif; ?>

        </div>
      </div>
    </section>
  </main>

  <?php require 'footer.php'; ?>

  <script>
    document.querySelectorAll('.updateBtn').forEach(btn => {
      btn.addEventListener('click', () => {
        const id = btn.dataset.id;
        const form = document.querySelector(`.updateForm[data-id="${id}"]`);
        const qtyInput = form.querySelector(`.quantityInput[data-id="${id}"]`);

        if (form && qtyInput) {
          let hidden = form.querySelector('input[name="quantity"]');
          if (!hidden) {
            hidden = document.createElement('input');
            hidden.type = 'hidden';
            hidden.name = 'quantity';
            form.appendChild(hidden);
          }
          hidden.value = qtyInput.value;
          form.submit();
        }
      });
    });
  </script>
  <script src="scripts/script.js"></script>
</body>
</html>