<?php
session_start();
require_once './database/dbconnect.php';

header('Content-Type: application/json');

$productId = intval($_POST['product_id'] ?? 0);
if ($productId <= 0) {
    echo json_encode(['success' => false, 'message' => 'ID sản phẩm không hợp lệ']);
    exit;
}

// Lấy thông tin sản phẩm từ DB
$stmt = $conn->prepare("SELECT id, name, price, image_name FROM products WHERE id = ?");
$stmt->bind_param("i", $productId);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();
$stmt->close();

if (!$product) {
    echo json_encode(['success' => false, 'message' => 'Sản phẩm không tồn tại']);
    exit;
}

// Thêm vào giỏ hàng session
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Nếu đã có thì tăng số lượng
if (isset($_SESSION['cart'][$productId])) {
    $_SESSION['cart'][$productId]['quantity'] += 1;
} else {
    $_SESSION['cart'][$productId] = [
        'id' => $product['id'],
        'name' => $product['name'],
        'price' => $product['price'],
        'image' => $product['image_name'],
        'quantity' => 1
    ];
}

echo json_encode(['success' => true, 'message' => 'Đã thêm vào giỏ hàng!']);
?>
