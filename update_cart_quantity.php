<?php
session_start();
header('Content-Type: application/json');

$id = intval($_POST['product_id'] ?? 0);
$delta = intval($_POST['delta'] ?? 0);

if (!isset($_SESSION['cart'][$id])) {
    echo json_encode(['success' => false, 'message' => 'Món không tồn tại trong giỏ hàng.']);
    exit;
}

$_SESSION['cart'][$id]['quantity'] += $delta;

// Tối thiểu là 1
if ($_SESSION['cart'][$id]['quantity'] < 1) {
    unset($_SESSION['cart'][$id]);
}

echo json_encode(['success' => true]);
