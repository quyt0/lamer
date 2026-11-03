<?php
session_start();
header('Content-Type: application/json');

$id = intval($_POST['product_id'] ?? 0);

if (isset($_SESSION['cart'][$id])) {
    unset($_SESSION['cart'][$id]);
    echo json_encode(['success' => true, 'message' => 'Đã xoá sản phẩm khỏi giỏ.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Sản phẩm không tồn tại trong giỏ.']);
}
