<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] < 1) {
    die("Bạn không có quyền truy cập.");
}

require_once '../database/dbconnect.php';

$users_query = $conn->query("SELECT * FROM userdata WHERE role <> 2 && role <> -1");
$users = [];
while ($row = $users_query->fetch_assoc()) {
    $users[] = $row;
}

$reg_query = $conn->query("SELECT * FROM userdata WHERE role = -1");
$reg_users = [];
while ($row = $reg_query->fetch_assoc()) {
    $reg_users[] = $row;
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý user</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>
    <div class="d-flex">
        <?php include('sidebar.php'); ?>

        <div class="ms-220 px-4 pt-4 w-100" style="margin-left: 220px; height: 100vh;">
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 2): ?>
                <h2 class="mb-4">Phân quyền người dùng</h2>

                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Tên đăng nhập</th>
                                <th>Họ tên</th>
                                <th>Vai trò</th>
                                <th>Quyền</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <th>
                                        <?php echo htmlspecialchars($user['id']) ?>
                                    </th>
                                    <td>
                                        <?php echo htmlspecialchars($user['username']) ?>
                                    </td>
                                    <td>
                                        <?php echo htmlspecialchars($user['fullname']) ?>
                                    </td>
                                    <td>
                                        <?= ($user['role'] == 1) ? "Nhân viên" : "Người dùng"; ?>
                                    </td>
                                    <td>
                                        <?php if ($user['role'] == 1): ?>
                                            <form method="POST" action="update_role.php" class="d-inline">
                                                <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                                <input type="hidden" name="role" value="0">
                                                <button type="submit" class="btn btn-danger">
                                                    <i class="bi bi-x-circle"></i> Xoá quyền nhân viên
                                                </button>
                                            </form>
                                        <?php else: ?>
                                            <form method="POST" action="update_role.php" class="d-inline">
                                                <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                                <input type="hidden" name="role" value="1">
                                                <button type="submit" class="btn btn-warning">
                                                    <i class="bi bi-person-check"></i> Gán nhân viên
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>

            <h2 class="mb-4">Duyệt đăng ký người dùng</h2>

            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Tên đăng nhập</th>
                            <th>Họ tên</th>
                            <th>Số ĐT</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($reg_users as $user): ?>
                            <tr>
                                <th>
                                    <?php echo htmlspecialchars($user['id']) ?>
                                </th>
                                <td>
                                    <?php echo htmlspecialchars($user['username']) ?>
                                </td>
                                <td>
                                    <?php echo htmlspecialchars($user['fullname']) ?>
                                </td>
                                <td>
                                    <?php echo htmlspecialchars($user['phone']) ?>
                                </td>
                                <td>
                                    <form method="POST" action="verify_user.php" class="d-inline">
                                        <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                        <input type="hidden" name="action" value="approve">
                                        <button type="submit" class="btn btn-warning">
                                            <i class="bi bi-person-check"></i> Duyệt
                                        </button>
                                    </form>
                                    <form method="POST" action="verify_user.php" class="d-inline">
                                        <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                        <input type="hidden" name="action" value="delete">
                                        <button type="submit" class="btn btn-danger">
                                            <i class="bi bi-x-circle"></i> Xoá
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>