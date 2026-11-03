<?php
session_start();
?>
<header id="main-header">
    <div class="main-header-wrap container">
        <div class="row">
            <div class="header-mobile-bar">
                <i class="fa-solid fa-bars-staggered"></i>
            </div>
            <div class="header-logo col-lg-3 col-md-3">
                <img class="header-logo-img" src="/assets/img/lamer-ico.png" alt="">
                <a href="/" class="header-site-link">La'mer<br>Coffe & Tea</a>
            </div>
            <nav class="header-nav col-lg-6 col-md-6">
                <a href="/" class="nav-item">Trang chủ</a>
                <a href="/menu" class="nav-item main-hover">Menu</a>
                <a href="/contact" class="nav-item main-hover">Liên hệ</a>
            </nav>
            <div class="header-account col-lg-2 col-md-2">
                <?php if (isset($_SESSION['username'])): ?>
                    <div class="header-account-user">
                        <div class="account-user-wrap">
                            <i class="fa-solid fa-circle-user"></i>
                            Xin chào
                        </div>
                        <b><?php echo htmlspecialchars($_SESSION['fullname']); ?></b>
                        <div class="account-options">
                            <ul class="acc-opt-body">
                                <?php if (isset($_SESSION['username']) && isset($_SESSION['role']) && ($_SESSION['role'] == 1 || $_SESSION['role'] == 2)): ?>
                                    <li class="acc-opt-item">
                                        <i class="fa-solid fa-bars-progress"></i>
                                        <a href="/admin" class="nav-item">Trang quản lý</a>
                                    </li>
                                <?php endif; ?>
                                <li class="acc-opt-item acc-opt-item-info">
                                    <i class="fa-solid fa-gear"></i> Đổi thông tin
                                </li>
                                <li class="acc-opt-item">
                                    <i class="fa-solid fa-right-from-bracket"></i>
                                    <a class="nav-item" href="/logout.php">Đăng xuất</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="header-account-login">
                        <i class="fa-solid fa-right-to-bracket"></i>
                        <span>Đăng nhập</span>
                    </div>
                <?php endif; ?>
            </div>
            <div class="header-cart col-lg-1 col-md-1">
                <i class="fa-solid fa-cart-shopping header-cart-icon"></i>
            </div>
        </div>
    </div>
</header>
<header class="mobile-header-wrap">
    <nav class="mobile-header-nav">
        <a href="" class="mobile-header-nav-item mobile-nav-close">
            <i class="fa-solid fa-xmark"></i>
        </a>
        <?php if (isset($_SESSION['username'])): ?>
            <div class="mobile-header-nav-item mobile-nav-account">
                <div class="mobile-nav-account-toggle">
                    <i class="fa-solid fa-circle-user"></i>
                    <?php echo htmlspecialchars($_SESSION['fullname']); ?>
                    <i class="fa-solid fa-chevron-down toggle-icon"></i>
                </div>
                <div class="mobile-nav-account-dropdown">
                    <a href="#" class="mobile-nav-account-sub mobile-nav-account-info">
                        <i class="fa-solid fa-gear"></i>
                        Đổi thông tin
                    </a>
                    <a href="/logout.php" class="mobile-nav-account-sub">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        Đăng xuất
                    </a>
                </div>
            </div>
        <?php else: ?>
            <div class="mobile-header-nav-item mobile-nav-signin">
                <i class="fa-solid fa-right-to-bracket"></i>
                Đăng nhập
            </div>
        <?php endif; ?>
        <?php if (isset($_SESSION['username']) && isset($_SESSION['role']) && ($_SESSION['role'] == 1 || $_SESSION['role'] == 2)): ?>
            <a href="/admin" class="mobile-header-nav-item mobile-nav-manage">
                <i class="fa-solid fa-bars-progress"></i>
                Trang quản lý
            </a>
        <?php endif; ?>
        <a href="/" class="mobile-header-nav-item mobile-nav-home">
            Trang chủ
        </a>
        <a href="/menu" class="mobile-header-nav-item mobile-nav-menu">
            Menu
        </a>
        <a href="/contact" class="mobile-header-nav-item mobile-nav-contact">
            Liên hệ
        </a>
        <a href="#" class="mobile-header-nav-item mobile-nav-cart">
            <i class="fa-solid fa-cart-shopping header-cart-icon"></i>
            Giỏ hàng
        </a>
    </nav>
</header>
<div id="loginModal" class="modal">
    <div class="modal-content">
        <span class="close-btn" id="closeLoginModalBtn">&times;</span>
        <h2>Đăng nhập</h2>
        <form id="loginForm">
            <label for="login_username">Tên đăng nhập</label>
            <input type="text" id="login_username" name="login_username" placeholder="Nhập tên đăng nhập" required>

            <label for="login_password">Mật khẩu</label>
            <input type="password" id="login_password" name="login_password" placeholder="Nhập mật khẩu" required>

            <button type="submit">Đăng nhập</button>
        </form>
        <span class="register-link">Bạn chưa có tài khoản? <b>Đăng ký ngay</b></span>
    </div>
</div>
<div id="registerModal" class="modal">
    <div class="modal-content">
        <span class="close-btn" id="closeRegisterModalBtn">&times;</span>
        <h2>Đăng ký</h2>
        <form id="registerForm" method="POST" action="register.php">
            <label for="register_fullname">Họ tên</label>
            <input type="text" id="register_fullname" name="register_fullname" placeholder="Nhập họ và tên" required>
            <label for="register_username">Tên đăng nhập</label>
            <input type="text" id="register_username" name="register_username" placeholder="Nhập tên đăng nhập"
                required>
            <label for="register_phone">Số điện thoại</label>
            <input type="text" id="register_phone" name="register_phone" placeholder="Nhập số điện thoại" required>
            <label for="register_password">Mật khẩu</label>
            <input type="password" id="register_password" name="register_password" placeholder="Nhập mật khẩu" required>
            <label for="register_repassword">Xác nhận</label>
            <input type="password" id="register_repassword" name="register_repassword" placeholder="Nhập lại mật khẩu"
                required>
            <button type="submit">Đăng ký</button>
            <span class="register-message">Đăng ký thành công</span>
            <span class="login-link">Đã có tài khoản? <b>Đăng nhập</b></span>
        </form>
    </div>
</div>
<div id="infoModal" class="modal">
    <div class="modal-content">
        <span class="close-btn" id="closeInfoModalBtn">&times;</span>
        <h2>Đổi thông tin cá nhân</h2>
        <form id="updateInfoForm" action="update_info.php" method="POST">
            <label for="update_fullname">Họ và tên</label>
            <input type="text" id="update_fullname" name="update_fullname" placeholder="Nhập họ và tên mới" required
                value="<?= htmlspecialchars($_SESSION['fullname']) ?>">

            <label for="update_phone">Số điện thoại</label>
            <input type="text" id="update_phone" name="update_phone" placeholder="Nhập SĐT mới" required
                value="<?= htmlspecialchars($_SESSION['phone']) ?>">

            <label for="current_password">Mật khẩu hiện tại</label>
            <input type="password" id="current_password" name="current_password" placeholder="Nhập mật khẩu hiện tại"
                required>

            <label for="new_password">Đổi mật khẩu (nếu có)</label>
            <input type="password" id="new_password" name="new_password" placeholder="Nhập mật khẩu mới">

            <button type="submit">Cập nhật</button>
            <span class="update-message"></span>
        </form>
    </div>
</div>
<div id="cartModal" class="modal">
    <form action="/process_order.php" method="POST">
        <div class="modal-content cart-modal-content">
            <span class="close-btn" id="closeCartModalBtn">&times;</span>
            <h2>Giỏ hàng của bạn</h2>
            <div id="cartItemsContainer"></div>
            <div class="cart-total">
                <strong>Tổng cộng:</strong> <span id="cartTotal">0đ</span>
            </div>
            <button class="cart-submit-btn" id="checkoutBtn">Đặt hàng</button>
        </div>
    </form>
</div>

<script>
    document.getElementById('registerForm').addEventListener('submit', function (e) {
        e.preventDefault();

        const fullname = document.getElementById('register_fullname').value;
        const username = document.getElementById('register_username').value;
        const password = document.getElementById('register_password').value;
        const repassword = document.getElementById('register_repassword').value;
        const phonenum = document.getElementById('register_phone').value;

        const formData = new FormData();
        formData.append('register_fullname', fullname);
        formData.append('register_username', username);
        formData.append('register_password', password);
        formData.append('register_repassword', repassword);
        formData.append('register_phone', phonenum);

        fetch('/register.php', {
            method: 'POST',
            body: formData
        })
            .then(res => res.json())
            .then(data => {
                const messageSpan = document.querySelector('.register-message');
                messageSpan.textContent = data.message;
                messageSpan.style.display = 'block';
                messageSpan.style.color = data.success ? 'green' : 'red';

                if (data.success) {
                    setTimeout(() => {
                        document.getElementById('registerModal').style.display = 'none';
                        document.getElementById('loginModal').style.display = 'block';
                    }, 1500);
                }
            })
            .catch(err => {
                console.error('Lỗi:', err);
            });
    });

    document.getElementById('loginForm').addEventListener('submit', function (e) {
        e.preventDefault();

        const username = document.getElementById('login_username').value;
        const password = document.getElementById('login_password').value;

        const formData = new FormData();
        formData.append('login_username', username);
        formData.append('login_password', password);

        fetch('/login.php', {
            method: 'POST',
            body: formData
        })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert(data.message);
                }
            })
            .catch(err => {
                console.error('Lỗi:', err);
            });
    });

    document.getElementById('updateInfoForm').addEventListener('submit', function (e) {
        e.preventDefault();

        const fullname = document.getElementById('update_fullname').value;
        const currentPassword = document.getElementById('current_password').value;
        const newPassword = document.getElementById('new_password').value;
        const phone = document.getElementById('update_phone').value;

        const formData = new FormData();
        formData.append('update_fullname', fullname);
        formData.append('current_password', currentPassword);
        formData.append('new_password', newPassword);
        formData.append('update_phone', phone);

        fetch('/update_info.php', {
            method: 'POST',
            body: formData
        })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    location.reload();
                } else {
                    alert(data.message);
                }
            })
            .catch(err => {
                console.error('Lỗi:', err);
                alert("Đã xảy ra lỗi. Vui lòng thử lại.");
            });
    });

    function loadCartItems() {
        fetch('/get_cart.php')
            .then(res => res.json())
            .then(data => {
                cartItemsContainer.innerHTML = '';
                let total = 0;

                if (data.items.length === 0) {
                    cartItemsContainer.innerHTML = '<p>Giỏ hàng trống.</p>';
                    cartTotal.textContent = '0đ';
                    return;
                }

                data.items.forEach(item => {
                    total += item.price * item.quantity;

                    const div = document.createElement('div');
                    div.className = 'cart-item';
                    div.innerHTML = `
  <div class="cart-item-line">
    <span class="cart-item-name">${item.name}</span>
    <span class="cart-item-qty">SL: ${item.quantity}</span>
    <span class="cart-item-price">= ${(item.price * item.quantity).toLocaleString()}đ</span>
    <div class="cart-item-controls">
      <button type="button" onclick="changeQty(${item.id}, -1)">−</button>
      <button type="button" onclick="changeQty(${item.id}, 1)">+</button>
      <button type="button" class="cart-item-remove" onclick="removeFromCart(${item.id})">Xoá</button>
    </div>
  </div>
`;

                    cartItemsContainer.appendChild(div);
                });

                cartTotal.textContent = total.toLocaleString() + 'đ';
            });
    }

    // Xoá món
    function removeFromCart(id) {
        fetch('/remove_from_cart.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'product_id=' + id
        })
            .then(res => res.json())
            .then(data => {
                loadCartItems();
            });
    }

    function changeQty(id, delta) {
        fetch('/update_cart_quantity.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `product_id=${id}&delta=${delta}`
        })
            .then(res => res.json())
            .then(data => {
                if (data.success) loadCartItems();
                else alert(data.message);
            });
    }

</script>