<?php
require __DIR__ . '/parts/connect_db.php';
$stmt = $pdo->query("SELECT * FROM products_sale GROUP BY product_id ");
$raw_data = $stmt->fetchAll();

$product_sale_id = [];
// $product_sale_id[] = $raw_data;

foreach($raw_data as $r) {
    if($r['product_id']!=''){
        $product_sale_id[] = $r;
    }
}


echo json_encode($product_sale_id);