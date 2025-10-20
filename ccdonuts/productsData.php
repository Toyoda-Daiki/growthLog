<?php
require_once 'dbConnect.php';

try {
    // productsテーブルから全商品を取得（ID昇順）
    $stmt = $pdo->query("
        SELECT 
            id, 
            name, 
            pieces, 
            price, 
            description, 
            category, 
            is_new 
        FROM products 
        ORDER BY id ASC
    ");

    $products = [];

    while ($row = $stmt->fetch()) {
        $row['is_new'] = (bool)$row['is_new']; // 論理値に変換
        $products[] = $row;
    }

    // フロント用にJSON出力する場合
    // echo json_encode($products, JSON_UNESCAPED_UNICODE);

} catch (PDOException $e) {
    exit('データ取得に失敗しました：' . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8'));
}
?>
