<?php
session_start();
include('./database/dbconnect.php');
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['login_username'] ?? '';
    $password = $_POST['login_password'] ?? '';

    if (empty($username) || empty($password)) {
        echo json_encode(['success' => false, 'message' => 'Vui lòng điền đầy đủ thông tin.']);
        exit;
    }

    $stmt = $conn->prepare("SELECT fullname, phone, password, role FROM userdata WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($fullname, $phone, $hashedPassword, $role);
    if ($stmt->fetch()) {
        if (password_verify($password, $hashedPassword)) {
            if ($role == -1) {
                echo json_encode(['success' => false, 'message' => 'Tài khoản của bạn đang chờ duyệt. Vui lòng quay lại sau.']);
                exit;
            }
            $_SESSION['username'] = $username;
            $_SESSION['fullname'] = $fullname;
            $_SESSION['phone'] = $phone;
            $_SESSION['role'] = $role;
            echo json_encode(['success' => true, 'fullname' => $fullname]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Tên đăng nhập hoặc mật khẩu không đúng.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Tên đăng nhập hoặc mật khẩu không đúng.']);
    }
    $stmt->close();
    $conn->close();
}
?>