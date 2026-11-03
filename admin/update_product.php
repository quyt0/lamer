<?php
session_start();

// Chỉ cho phép moderator (1) và admin (2) sửa
if (!isset($_SESSION['role']) || $_SESSION['role'] < 1) {
    die("Không có quyền truy cập.");
}

require_once '../database/dbconnect.php';

// Nhận dữ liệu từ form POST
$id          = $_POST['id'] ?? null;
$name        = $_POST['name'] ?? '';
$price       = $_POST['price'] ?? 0;
$description = $_POST['description'] ?? '';

$image_name = '';

// Nếu có ảnh mới
if (isset($_FILES['image_name']) && $_FILES['image_name']['error'] === UPLOAD_ERR_OK) {
    $filename = basename($_FILES['image_name']['name']);
    move_uploaded_file($_FILES['image_name']['tmp_name'], '../images/' . $filename);
    $image_name = $filename;
} else {
    $image_name = $_POST['old_image'] ?? '';
}

// Kiểm tra dữ liệu
if (!$id || !$name || !$price) {
    die("Thiếu thông tin bắt buộc.");
}

// Cập nhật vào database
$stmt = $conn->prepare("UPDATE products SET name = ?, price = ?, image_name = ?, description = ? WHERE id = ?");
$stmt->bind_param("sdssi", $name, $price, $image_name, $description, $id);

if ($stmt->execute()) {
    header("Location: edit-menu.php?success=1");
    exit;
} else {
    echo "Lỗi khi cập nhật dữ liệu: " . $conn->error;
}

$stmt->close();
$conn->close();
?>