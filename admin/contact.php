<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] < 1) {
    die("Bạn không có quyền truy cập.");
}

require_once '../database/dbconnect.php';

$contactQuery = $conn->query("SELECT * FROM contacts ORDER BY created_at DESC");
$contacts = [];
while ($row = $contactQuery->fetch_assoc()) {
    $contacts[] = $row;
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý liên hệ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>
    <div class="d-flex">
        <?php include('sidebar.php'); ?>

        <div class="ms-220 px-4 pt-4 w-100" style="margin-left: 220px; min-height: 100vh;">
            <h2 class="mb-4">Quản lý liên hệ</h2>
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Họ và tên</th>
                            <th>Email</th>
                            <th>Lời nhắn</th>
                            <th>Thời gian gửi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($contacts as $contact): ?>
                            <tr>
                                <td><?= $contact['id'] ?></td>
                                <td><?= htmlspecialchars($contact['name']) ?></td>
                                <td><?= htmlspecialchars($contact['email']) ?></td>
                                <td><?= nl2br(htmlspecialchars($contact['message'])) ?></td>
                                <td><?= date('d/m/Y H:i', strtotime($contact['created_at'])) ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (empty($contacts)): ?>
                            <tr><td colspan="5" class="text-center">Không có liên hệ nào.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>