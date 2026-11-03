<!-- Sidebar -->
<div class="bg-dark text-white position-fixed top-0 start-0 h-100 p-3" style="width: 220px;">
  <h1 href="/admin" class="">
    <span class="fs-5 fw-bold">La'mer Admin</span>
  </h1>
  <hr>
  <ul class="nav nav-pills flex-column">
    <li class="nav-item">
      <a href="orders.php" class="nav-link text-white">
        <i class="bi bi-receipt"></i> Quản lý đặt món
      </a>
    </li>
    <li class="nav-item">
      <a href="edit-menu.php" class="nav-link text-white">
        <i class="bi bi-cup-hot-fill me-2"></i> Quản lý menu
      </a>
    </li>
    <li>
      <a href="contact.php" class="nav-link text-white">
        <i class="bi bi-chat-fill"></i> Quản lý liên hệ
      </a>
    </li>
    <?php if ($_SESSION['role'] > 0): ?>
      <li>
        <a href="edit-users.php" class="nav-link text-white">
          <i class="bi bi-people-fill me-2"></i> Quản lý người dùng
        </a>
      </li>
    <?php endif; ?>
  </ul>
</div>
