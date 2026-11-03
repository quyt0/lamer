<?php
session_start();
include('./database/dbconnect.php');

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $_POST['register_fullname'] ?? '';
    $username = $_POST['register_username'] ?? '';
    $password = $_POST['register_password'] ?? '';
    $repassword = $_POST['register_repassword'] ?? '';
    $phone = trim($_POST['register_phone'] ?? '');

    if (strlen($phone) != 10 || !ctype_digit($phone)) {
        echo json_encode(['success' => false, 'message' => 'Số điện thoại không đúng định dạng']);
        exit;
    }

    if (empty($fullname) || empty($username) || empty($password)) {
        echo json_encode(['success' => false, 'message' => 'Vui lòng nhập đầy đủ thông tin.']);
        exit;
    }

    if ($password != $repassword) {
        echo json_encode(['success' => false, 'message' => 'Mật khẩu không khớp, vui lòng thử lại']);
        exit;
    }

    if (!preg_match('/^[a-zA-Z0-9]{4,20}$/', $username)) {
        echo json_encode(['success' => false, 'message' => 'Tên đăng nhập chỉ từ 4 đến 20 ký tự CHỮ HOẶC SỐ']);
        exit;
    }

    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    $checkUserStmt = $conn->prepare("SELECT username FROM userdata WHERE username = ?");
    $checkUserStmt->bind_param("s", $username);
    $checkUserStmt->execute();
    $checkUserStmt->store_result();

    if ($checkUserStmt->num_rows > 0) {
        echo json_encode(['success' => false, 'message' => 'Tên đăng nhập đã tồn tại.']);
    } else {
        $stmt = $conn->prepare("INSERT INTO userdata (username, fullname, password, phone) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $username, $fullname, $passwordHash, $phone);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Đăng ký thành công (chờ duyệt)']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Lỗi hệ thống: ' . $stmt->error]);
        }
        $stmt->close();
    }

    $checkUserStmt->close();
    $conn->close();
}
