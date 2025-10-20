<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<header>
  <div class="headerMain">
    <div class="logo">
      <img src="images/commonImages/iocnLogo.svg" alt="ロゴ画像">
    </div>
    <div class="drawer">
      <div class="menuBtn">
        <button class="openBtn"><img src="images/commonImages/drawerOpenIcon.svg" alt="メニューを開く"></button>
      </div>
      <div id="drawerID" class="drawerContent">
        <button class="drawerCloseBtn"><img src="images/commonImages/drawerCloseIcon.svg" alt="閉じる"></button>
        <div class="logo2">
          <img src="images/commonImages/iocnLogo.svg" alt="ロゴ画像">
        </div>
        <ul>
          <li><a href="index.php">TOP</a></li>
          <li><a href="products.php">商品一覧</a></li>
          <li><a href="#">よくある質問</a></li>
          <li><a href="#">お問い合わせ</a></li>
          <li><a href="#">当サイトのポリシー</a></li>
        </ul>
      </div>
    </div>
    <div class="login">
      <?php if (isset($_SESSION['user']['name'])): ?>
        <a href="logoutForm.php">
          <img src="images/commonImages/loginLogo.svg" alt="ログアウトアイコン">
          <p>ログアウト</p>
        </a>
      <?php else: ?>
        <a href="loginForm.php">
          <img src="images/commonImages/loginLogo.svg" alt="ログインアイコン">
          <p >ログイン</p>
        </a>
      <?php endif; ?>
    </div>
    <div class="cart">
      <a href="cart.php">
        <img src="images/commonImages/cartLogo.svg" alt="カートアイコン">
        <p>カート</p>
      </a>
    </div>
  </div>
  <div class="headerSub">
    <form class="searchForm" action="search.php" method="get">
      <button type="submit" class="searchBtn"><img src="images/commonImages/searchLogo.svg" alt="検索ボタン"></button>
      <input type="text" name="keyword" class="searchInput" placeholder="キーワードを入力">
    </form>
  </div>
</header>