<!DOCTYPE html>
<html lang="vi">

<?php
$pageTitle = "Menu - La'mer Coffee & Tea";
$customHead = '<link rel="stylesheet" href="style.css">';
include("../head.php");
include("../database/dbconnect.php");

// Lấy toàn bộ category
$category_query = $conn->query("SELECT DISTINCT category FROM products ORDER BY category ASC");
$categories = [];

while ($row = $category_query->fetch_assoc()) {
    $cat = $row['category'];
    if ($cat === 'Khác')
        continue; // Tạm bỏ "Khác", xử lý sau
    $categories[] = $cat;
}

if ($conn->query("SELECT 1 FROM products WHERE category = 'Khác' LIMIT 1")->num_rows > 0) {
    $categories[] = 'Khác';
}
?>

<body>
    <?php include('../header.php') ?>

    <div id="menu-page" class="container mt-5 mb-5">
        <div class="row">
            <!-- Sidebar -->
            <aside class="col-lg-3 menu-sidebar">
                <h4 class="menu-category-title">Danh mục</h4>
                <ul class="menu-category-list">
                    <?php foreach ($categories as $cat):
                        $cat_id = strtolower(str_replace(' ', '', $cat)); ?>
                        <li><a href="#<?= $cat_id ?>" class="menu-category-item"><?= htmlspecialchars($cat) ?></a></li>
                    <?php endforeach; ?>
                </ul>
                <input type="text" id="searchInput" style="width: 100%;" class="form-control" placeholder="Tìm món...">
            </aside>

            <!-- Menu content -->
            <section class="col-lg-9 menu-content">
                <?php foreach ($categories as $cat):
                    $cat_id = strtolower(str_replace(' ', '', $cat));
                    $stmt = $conn->prepare("SELECT * FROM products WHERE category = ?");
                    $stmt->bind_param("s", $cat);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    ?>
                    <div id="<?= $cat_id ?>" class="menu-section mb-5">
                        <h3 class="menu-section-title"><?= htmlspecialchars($cat) ?></h3>
                        <div class="row">
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <div class="col-lg-4 col-6 menu-item">
                                    <div class="menu-item-wrap add-to-cart-item" data-id="<?= $row['id'] ?>"
                                        data-name="<?= htmlspecialchars($row['name']) ?>" data-price="<?= $row['price'] ?>"
                                        data-img="<?= htmlspecialchars($row['image_name'] ?? 'default.jpg') ?>"
                                        data-desc="<?= htmlspecialchars($row['description'] ?? '') ?>">
                                        <img src="/images/<?= htmlspecialchars($row['image_name'] ?? 'default.jpg') ?>"
                                            class="menu-item-img" alt="<?= htmlspecialchars($row['name']) ?>"
                                            onerror="this.onerror=null;this.src='/images/default.jpg';">
                                        <h5><?= htmlspecialchars($row['name']) ?></h5>
                                        <p>Giá: <?= number_format($row['price']) ?>đ</p>
                                        <button class="view-menu-item-detail" onclick="event.stopPropagation()">Xem chi
                                            tiết</button>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </section>
        </div>
    </div>

    <!-- Modal -->
    <div id="productModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" id="closeProductModalBtn">&times;</span>
            <h3 id="modalProductName">Tên món</h3>
            <img id="modalProductImg" src="" alt="" style="width: 100px; height: auto; margin-bottom: 10px;">
            <p id="modalProductPrice">Giá: 0đ</p>
            <p id="modalProductDesc">Mô tả món ở đây...</p>
        </div>
    </div>

    <?php include('../footer.php') ?>

    <script>
        // ===== Thêm vào giỏ hàng =====
        document.querySelectorAll('.add-to-cart-item').forEach(item => {
            item.addEventListener('click', function () {
                const productId = this.dataset.id;

                fetch('/add_to_cart.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: 'product_id=' + productId
                })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            const priceEl = this.querySelector('p');
                            const originalPrice = priceEl.textContent;

                            this.classList.add('added');
                            priceEl.textContent = 'Đã thêm!';

                            setTimeout(() => {
                                priceEl.textContent = originalPrice;
                                this.classList.remove('added');
                            }, 1500);
                        } else {
                            alert(data.message || 'Lỗi khi thêm vào giỏ.');
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        alert('Không thể thêm vào giỏ hàng.');
                    });
            });
        });

        // ===== Modal chi tiết món =====
        const modal = document.getElementById('productModal');
        const closeModalBtn = document.getElementById('closeProductModalBtn');
        const modalProductName = document.getElementById('modalProductName');
        const modalProductImg = document.getElementById('modalProductImg');
        const modalProductPrice = document.getElementById('modalProductPrice');
        const modalProductDesc = document.getElementById('modalProductDesc');

        function showProductModal(id, name, price, img, desc) {
            modalProductName.textContent = name;
            modalProductImg.src = `/images/${img}`;
            modalProductPrice.textContent = `Giá: ${price.toLocaleString()} đ`;
            modalProductDesc.textContent = desc || 'Không có mô tả.';
            modal.style.display = 'block';
        }

        closeModalBtn.onclick = () => modal.style.display = 'none';
        window.onclick = e => { if (e.target === modal) modal.style.display = 'none'; };

        document.querySelectorAll('.view-menu-item-detail').forEach(button => {
            button.addEventListener('click', function (e) {
                e.stopPropagation(); // Ngăn click vào menu-item
                const parent = this.closest('.menu-item-wrap');
                const id = parent.dataset.id;
                const name = parent.dataset.name;
                const price = parseInt(parent.dataset.price);
                const img = parent.dataset.img;
                const desc = parent.dataset.desc;

                showProductModal(id, name, price, img, desc);
            });
        });

        const searchInput = document.getElementById('searchInput');

        searchInput.addEventListener('input', function () {
            const keyword = this.value.trim().toLowerCase();
            const items = document.querySelectorAll('.menu-item');

            items.forEach(item => {
                const name = item.querySelector('h5')?.textContent.toLowerCase() || '';
                const desc = item.querySelector('p')?.textContent.toLowerCase() || '';
                const match = name.includes(keyword) || desc.includes(keyword);
                item.style.display = match ? '' : 'none';
            });
        });
    </script>

</body>

</html>