<?php
$host = '';
$db   = '';
$user = '';
$pass = '';
$charset = '';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    // 開発時は詳細表示、本番はログ出力に変更可
    exit('データベース接続に失敗しました：' . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8'));
}
?>
