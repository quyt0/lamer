<?php
session_start();
require_once '../database/dbconnect.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] < 1) {
    die("Bạn không có quyền thực hiện thao tác này.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userId = intval($_POST['user_id']);
    $action = $_POST['action'];

    if ($action === 'approve') {
        // Duyệt user, set role = 0
        $stmt = $conn->prepare("UPDATE userdata SET role = 0 WHERE id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $stmt->close();
    } elseif ($action === 'delete') {
        // Xoá user
        $stmt = $conn->prepare("DELETE FROM userdata WHERE id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $stmt->close();
    }
    $conn->close();
    header("Location: edit-users.php"); // Trang duyệt user
    exit();
}
