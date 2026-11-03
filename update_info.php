<?php
session_start();
require_once './database/dbconnect.php';
header('Content-Type: application/json');

if (!isset($_SESSION['username'])) {
    echo json_encode(['success' => false, 'message' => 'Bạn chưa đăng nhập.']);
    exit;
}

$username = $_SESSION['username'];
$fullname = $_POST['update_fullname'] ?? '';
$currentPassword = $_POST['current_password'] ?? '';
$newPassword = $_POST['new_password'] ?? '';
$phone = $_POST['update_phone'] ?? '';

if (empty($fullname) || empty($currentPassword)) {
    echo json_encode(['success' => false, 'message' => 'Vui lòng nhập đầy đủ thông tin.']);
    exit;
}

if (!preg_match('/^\d{10}$/', $phone)) {
    echo json_encode(['success' => false, 'message' => 'Số điện thoại không hợp lệ.']);
    exit;
}

// Lấy mật khẩu hiện tại từ DB
$stmt = $conn->prepare("SELECT password FROM userdata WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->bind_result($hashedPassword);
$stmt->fetch();
$stmt->close();

// Kiểm tra mật khẩu hiện tại
if (!password_verify($currentPassword, $hashedPassword)) {
    echo json_encode(['success' => false, 'message' => 'Mật khẩu hiện tại không đúng.']);
    exit;
}

// Nếu nhập mật khẩu mới thì hash lại, còn không giữ mật khẩu cũ
if (!empty($newPassword)) {
    $newHashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
} else {
    $newHashedPassword = $hashedPassword;
}

// Cập nhật thông tin
$updateStmt = $conn->prepare("UPDATE userdata SET phone = ?, fullname = ?, password = ? WHERE username = ?");
$updateStmt->bind_param("ssss", $phone, $fullname, $newHashedPassword, $username);

if ($updateStmt->execute()) {
    $_SESSION['fullname'] = $fullname; // Cập nhật lại session
    $_SESSION['phone'] = $phone;
    echo json_encode(['success' => true, 'message' => 'Cập nhật thông tin thành công.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Lỗi khi cập nhật thông tin.']);
}

$updateStmt->close();
$conn->close();
?>
