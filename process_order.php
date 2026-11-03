<?php
session_start();
require_once './database/dbconnect.php'; // Đảm bảo đã kết nối CSDL

// Kiểm tra đăng nhập
if (!isset($_SESSION['username']) || !isset($_SESSION['role']) || $_SESSION['role'] < 0) {
    $_SESSION['force_login'] = true;
    echo "<script>alert('Bạn cần đăng nhập để đặt hàng.'); window.location.href = '/';</script>";
    exit;
}

// Kiểm tra giỏ hàng
if (empty($_SESSION['cart'])) {
    echo "<script>alert('Giỏ hàng đang trống!'); window.history.back();</script>";
    exit;
}

$username = $_SESSION['username'];
$fullname = $_SESSION['fullname'];
$phone = $_SESSION['phone'];
$cart = $_SESSION['cart'];
$total = 0;

foreach ($cart as $item) {
    $total += $item['price'] * $item['quantity'];
}

// ✅ Thêm đơn hàng vào bảng `orders`
$stmtOrder = $conn->prepare("INSERT INTO orders (username, fullname, phone, total_price) VALUES (?, ?, ?, ?)");
$stmtOrder->bind_param("sssd", $username, $fullname, $phone, $total);
$stmtOrder->execute();
$order_id = $stmtOrder->insert_id; // ID của đơn hàng vừa tạo
$stmtOrder->close();

// ✅ Thêm từng món vào bảng `order_items`
$stmtItem = $conn->prepare("INSERT INTO order_items (order_id, product_id, product_name, quantity, price) VALUES (?, ?, ?, ?, ?)");

foreach ($cart as $item) {
    $stmtItem->bind_param("iisid", $order_id, $item['id'], $item['name'], $item['quantity'], $item['price']);
    $stmtItem->execute();
}
$stmtItem->close();

// ✅ Xoá giỏ hàng khỏi session
unset($_SESSION['cart']);

echo "<script>
    alert('Đặt hàng thành công! La\\'mer sẽ liên hệ với bạn qua SĐT $phone');
    window.location.href = '/';
</script>";