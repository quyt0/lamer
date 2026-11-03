<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] < 1) {
    die("Bạn không có quyền truy cập.");
}

require_once '../database/dbconnect.php';

// Lấy category
$cat_result = $conn->query("SELECT DISTINCT category FROM products ORDER BY category ASC");
$categories = [];
while ($row = $cat_result->fetch_assoc()) {
    $categories[] = $row['category'];
}

// Lấy toàn bộ món ăn
$product_result = $conn->query("SELECT * FROM products ORDER BY id, category ASC");
$products = [];
while ($row = $product_result->fetch_assoc()) {
    $products[] = $row;
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Quản lý Menu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>

    <div class="d-flex">
        <?php include('sidebar.php'); ?>

        <div class="ms-220 px-4 pt-4" style="margin-left: 220px; width: calc(100% - 220px);">
            <h2 class="mb-4">Quản lý Menu</h2>

            <div class="mb-3">
                <label for="categorySelect" class="form-label">Chọn danh mục:</label>
                <select class="form-select w-50" id="categorySelect">
                    <option value="" selected>-- Tất cả --</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?php echo htmlspecialchars($cat); ?>"><?php echo htmlspecialchars($cat); ?></option>
                    <?php endforeach; ?>
                </select>
                <hr>
                <button type="button" class="btn btn-dark mb-3" id="addNewProductBtn" data-bs-toggle="modal" data-bs-target="#addModal">Thêm món mới</button>
            </div>

            <table class="table table-striped" id="menuTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên món</th>
                        <th>Ảnh</th>
                        <th>Giá</th>
                        <th>Danh mục</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $item): ?>
                        <tr data-category="<?php echo htmlspecialchars($item['category']); ?>">
                            <td><?php echo $item['id']; ?></td>
                            <td><?php echo htmlspecialchars($item['name']); ?></td>
                            <td>
                                <img src="/images/<?php echo htmlspecialchars($item['image_name'] ?? 'default.jpg'); ?>"
                                    alt="<?php echo htmlspecialchars($item['name']); ?>" style="width: 60px"
                                    class="img-thumbnail mx-auto d-block"
                                    onerror="this.onerror=null;this.src='/images/default.jpg';">
                            </td>
                            <td><?php echo number_format($item['price']); ?> đ</td>
                            <td><?php echo htmlspecialchars($item['category']); ?></td>
                            <td class="">
                                <button class="btn btn-sm btn-warning btn-edit" data-id="<?php echo $item['id']; ?>"
                                    data-name="<?php echo htmlspecialchars($item['name']); ?>"
                                    data-price="<?php echo $item['price']; ?>"
                                    data-img="<?php echo htmlspecialchars($item['image_name']); ?>"
                                    data-desc="<?php echo htmlspecialchars($item['description'] ?? ''); ?>">
                                    <i class="bi bi-pencil-square"></i>
                                </button>

                                <form method="POST" action="delete_product.php"
                                    onsubmit="return confirm('Xác nhận xoá món này?');" class="m-0 p-0 d-inline">
                                    <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>

                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Sửa -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form class="modal-content" method="POST" action="update_product.php" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title">Sửa món</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="edit-id">
                    <div class="mb-3">
                        <label for="edit-name" class="form-label">Tên món</label>
                        <input type="text" class="form-control" name="name" id="edit-name" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-price" class="form-label">Giá</label>
                        <input type="number" class="form-control" name="price" id="edit-price" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-img" class="form-label">Ảnh</label>
                        <input type="hidden" name="old_image" id="edit-old-img">
                        <input type="file" class="form-control" name="image_name" id="edit-img">
                    </div>
                    <div class="mb-3">
                        <label for="edit-desc" class="form-label">Mô tả</label>
                        <textarea class="form-control" name="description" id="edit-desc" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Lưu</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="addModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form class="modal-content" method="POST" action="add_product.php" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title">Thêm món mới</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="edit-id">
                    <div class="mb-3">
                        <label for="edit-name" class="form-label">Tên món</label>
                        <input type="text" class="form-control" name="name" id="edit-name" required>
                    </div>
                    <label for="category-add" class="form-label">Chọn danh mục:</label>
                    <select class="form-select w-50" name="category" id="category-add" required>
                        <option value="" disabled selected>-- Chọn danh mục --</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= htmlspecialchars($cat) ?>"><?= htmlspecialchars($cat) ?></option>
                        <?php endforeach; ?>
                    </select>

                    <div class="mb-3">
                        <label for="edit-price" class="form-label">Giá</label>
                        <input type="number" class="form-control" name="price" id="edit-price" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-img" class="form-label">Ảnh</label>
                        <input type="hidden" name="old_image" id="edit-old-img">
                        <input type="file" class="form-control" name="image_name" id="edit-img">
                    </div>
                    <div class="mb-3">
                        <label for="edit-desc" class="form-label">Mô tả</label>
                        <textarea class="form-control" name="description" id="edit-desc" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Lưu</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('categorySelect').addEventListener('change', function () {
            const selected = this.value;
            const rows = document.querySelectorAll('#menuTable tbody tr');
            rows.forEach(row => {
                const cat = row.getAttribute('data-category');
                row.style.display = (!selected || selected === cat) ? '' : 'none';
            });
        });

        const editModal = new bootstrap.Modal(document.getElementById('editModal'));
        document.querySelectorAll('.btn-edit').forEach(button => {
            button.addEventListener('click', () => {
                document.getElementById('edit-id').value = button.dataset.id;
                document.getElementById('edit-name').value = button.dataset.name;
                document.getElementById('edit-price').value = button.dataset.price;
                document.getElementById('edit-old-img').value = button.dataset.img; // Gán vào hidden
                document.getElementById('edit-desc').value = button.dataset.desc;
                editModal.show();
            });
        });
    </script>
</body>

</html>