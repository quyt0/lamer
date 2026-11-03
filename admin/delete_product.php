<?php
session_start();

// Chỉ cho phép moderator (1) và admin (2)
if (!isset($_SESSION['role']) || $_SESSION['role'] < 1) {
    die("Không có quyền truy cập.");
}

require_once '../database/dbconnect.php';

$id = $_POST['id'] ?? null;

if (!$id || !is_numeric($id)) {
    die("ID không hợp lệ.");
}

// Xoá sản phẩm
$stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: edit-menu.php");
    exit;
} else {
    echo "Lỗi khi xoá sản phẩm: " . $conn->error;
}

$stmt->close();
$conn->close();
?>
