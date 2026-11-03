<?php
session_start();
require_once '../database/dbconnect.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] < 1) {
    die("Bạn không có quyền thực hiện thao tác này.");
}

$name = trim($_POST['name'] ?? '');
$category = trim($_POST['category'] ?? '');
$price = floatval($_POST['price'] ?? 0);
$desc = trim($_POST['description'] ?? '');
$imageFile = $_FILES['image_name'] ?? null;

if (!$name || !$category || $price <= 0) {
    die("Vui lòng điền đầy đủ thông tin hợp lệ.");
}

// Xử lý ảnh
$image_name = '';
if ($imageFile && $imageFile['error'] === UPLOAD_ERR_OK) {
    $ext = pathinfo($imageFile['name'], PATHINFO_EXTENSION);
    $image_name = uniqid('product_') . '.' . $ext;
    move_uploaded_file($imageFile['tmp_name'], "../images/" . $image_name);
}

$stmt = $conn->prepare("INSERT INTO products (name, price, image_name, description, category) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sdsss", $name, $price, $image_name, $desc, $category);

if ($stmt->execute()) {
    header("Location: edit-menu.php?success=1");
    exit;
} else {
    echo "Lỗi: " . $conn->error;
}

$stmt->close();
$conn->close();
