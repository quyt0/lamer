<?php
session_start();
header('Content-Type: application/json');

function format_price($price) {
    return number_format($price, 0, ',', '.') . 'đ';
}

$cart = $_SESSION['cart'] ?? [];

$formattedItems = [];

foreach ($cart as $item) {
    $formattedItems[] = [
        'id' => $item['id'],
        'name' => $item['name'],
        'price' => $item['price'], // giữ giá gốc nếu cần tính toán
        'price_formatted' => format_price($item['price']),
        'quantity' => $item['quantity']
    ];
}

echo json_encode(['items' => $formattedItems]);
