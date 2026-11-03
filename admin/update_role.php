<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] < 1) {
    die("Bạn không có quyền thực hiện thao tác này.");
}

require_once '../database/dbconnect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userId = intval($_POST['user_id']);
    $newRole = intval($_POST['role']);

    // Không cho chỉnh sửa admin
    $stmt = $conn->prepare("UPDATE userdata SET role = ? WHERE id = ? AND role <> 2");
    $stmt->bind_param("ii", $newRole, $userId);

    if ($stmt->execute()) {
        header("Location: edit-users.php"); // Quay về trang phân quyền
        exit();
    } else {
        echo "Lỗi khi cập nhật quyền.";
    }

    $stmt->close();
    $conn->close();
}
?>
