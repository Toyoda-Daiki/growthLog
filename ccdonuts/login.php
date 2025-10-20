<?php
session_start();

// =====================
// CSRFトークン検証
// =====================
if (
  !isset($_POST['csrf_token']) ||
  !isset($_SESSION['csrf_token']) ||
  $_POST['csrf_token'] !== $_SESSION['csrf_token']
) {
  header('Location: loginForm.php?error=1');
  exit();
}

// =====================
// 入力チェック
// =====================
$email = trim($_POST['email'] ?? '');
$password = trim($_POST['password'] ?? '');

if ($email === '' || $password === '') {
  header('Location: loginForm.php?error=2');
  exit();
}

// =====================
// （仮）ユーザーデータベース
// ※本番ではDBから取得してください
// =====================
$users = [
  [
    'email' => 'test@example.com',
    'password_hash' => password_hash('test1234', PASSWORD_DEFAULT),
    'name' => 'テストユーザー'
  ],
  [
    'email' => 'donuts@ccdonuts.jp',
    'password_hash' => password_hash('sweetlove', PASSWORD_DEFAULT),
    'name' => 'CCドーナツ会員'
  ]
];

// =====================
// 認証処理
// =====================
$loginSuccess = false;
foreach ($users as $user) {
  if ($user['email'] === $email && password_verify($password, $user['password_hash'])) {
    $loginSuccess = true;
    $_SESSION['user'] = [
      'name' => $user['name'],
      'email' => $user['email']
    ];
    break;
  }
}

// =====================
// 結果分岐
// =====================
if ($loginSuccess) {
  // 一度だけ使われるCSRFトークンを破棄
  unset($_SESSION['csrf_token']);
  
  header('Location: loginResult.php');
  exit();
} else {
  header('Location: loginForm.php?error=2');
  exit();
}
