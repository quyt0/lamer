<?php
require_once '../database/dbconnect.php';
header('Content-Type: application/json');

$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$message = trim($_POST['message'] ?? '');

if (empty($name) || empty($email) || empty($message)) {
    echo json_encode(['success' => false, 'message' => 'Vui lòng nhập đầy đủ thông tin.']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Email không hợp lệ.']);
    exit;
}

$stmt = $conn->prepare("INSERT INTO contacts (name, email, message) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $name, $email, $message);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Gửi liên hệ thành công! Cảm ơn bạn.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Lỗi khi gửi liên hệ.']);
}

$stmt->close();
$conn->close();
