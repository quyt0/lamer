<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] < 1) {
    die("Bạn không có quyền truy cập.");
}

require_once '../database/dbconnect.php';

$orderQuery = $conn->query("SELECT * FROM orders ORDER BY order_time DESC");
$orders = [];
while ($row = $orderQuery->fetch_assoc()) {
    $orders[] = $row;
}

?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý đặt hàng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>
    <div class="d-flex">
        <?php include('sidebar.php'); ?>

        <div class="ms-220 px-4 pt-4 w-100" style="margin-left: 220px; height: 100vh;">
            <h2 class="mb-4">Quản lý đơn đặt hàng</h2>
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Người đặt</th>
                            <th>SĐT</th>
                            <th>Tổng tiền</th>
                            <th>Thời gian</th>
                            <th>Chi tiết</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $order): ?>
                            <tr>
                                <td><?= $order['id'] ?></td>
                                <td><?= htmlspecialchars($order['fullname']) ?></td>
                                <td><?= htmlspecialchars($order['phone']) ?></td>
                                <td><?= number_format($order['total_price'], 0, ',', '.') ?>đ</td>
                                <td><?= $order['order_time'] ?></td>
                                <td>
                                    <button class="btn btn-sm btn-primary" data-bs-toggle="collapse"
                                        data-bs-target="#items-<?= $order['id'] ?>">
                                        Xem
                                    </button>
                                </td>
                            </tr>
                            <tr class="collapse" id="items-<?= $order['id'] ?>">
                                <td colspan="7">
                                    <ul class="mb-0">
                                        <?php
                                        $oid = $order['id'];
                                        $itemQuery = $conn->query("SELECT * FROM order_items WHERE order_id = $oid");
                                        while ($item = $itemQuery->fetch_assoc()):
                                            ?>
                                            <li><?= $item['product_name'] ?> (x<?= $item['quantity'] ?>) -
                                                <?= number_format($item['price'], 0, ',', '.') ?>đ</li>
                                        <?php endwhile; ?>
                                    </ul>
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