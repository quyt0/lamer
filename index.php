<!DOCTYPE html>
<html lang="vi">

<?php
include("head.php");
include('./database/dbconnect.php');
$sql = "SELECT * FROM products ORDER BY id DESC LIMIT 4";
$result = $conn->query($sql);
?>

<body>
    <?php include("header.php"); ?>

    <div id="home-body">
        <div class="home-intro">
            <img src="/assets/img/lamer-background.jpg" alt="" class="intro-first-img">
            <div class="intro-content-modal">
                <h2 class="intro-content-subtitle">Welcome To (어서오세요)</h2>
                <h1 class="intro-content-title">La'mer Coffee & Tea</h1>
                <p class="intro-content-desc">
                    La'mer là một quán nhỏ nằm bên con đường yên tĩnh, chuyên phục vụ trà và cà phê. Quán mang đến không
                    gian ấm cúng, nhẹ nhàng — lý tưởng cho những buổi tụ họp bạn bè, hẹn hò hay đơn giản là tìm một góc
                    yên tĩnh để học tập và làm việc.
                    <br>
                    Đến với La'mer, bạn sẽ được thưởng thức những ly trà thanh mát, cà phê đậm đà, cùng menu đa dạng
                    được pha chế tỉ mỉ. Không gian đẹp, nhạc nhẹ, và đồ uống chất lượng sẽ mang lại cho bạn những khoảnh
                    khắc thư giãn và đầy cảm hứng.
                </p>
                <p class="intro-content-last-desc">
                    La'mer có trà, cà phê và kem tươi
                </p>
            </div>
        </div>
        <div class="home-content container">
            <div id="home-new-item">
                <div class="new-item-heading-section main-heading-section">
                    <i class="fa-solid fa-mug-hot"></i>
                    <h2 class="new-item-heading">Món mới ra mắt</h2>
                </div>
                <div class="new-item-grid container">
                    <ul class="new-item-list row">
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <li class="new-item-drink col-lg-3 col-6">
                                <div class="new-item-drink-wrap">
                                    <img class="new-item-drink-img"
                                        src="/images/<?php echo htmlspecialchars($row['image_name'] ?? 'default.jpg'); ?>"
                                        alt="">
                                    <h4 class="new-item-drink-name"><?php echo htmlspecialchars($row['name']); ?></h4>
                                    <span
                                        class="new-item-drink-desc"><?php echo htmlspecialchars($row['description']); ?></span>
                                    <a href="#" class="new-item-drink-buy add-to-cart-btn" data-id="<?= $row['id'] ?>">Đặt
                                        mua</a>
                                </div>
                            </li>
                        <?php endwhile; ?>
                    </ul>
                </div>
            </div>

            <div id="home-story">
                <div class="home-story-heading-section2 main-heading-section">
                    <i class="fa-solid fa-circle-question"></i>
                    <h2 class="home-story-heading">Bạn có biết</h2>
                </div>
                <div class="home-story-heading-section main-heading-section">
                    <i class="fa-solid fa-hashtag"></i>
                    <h2 class="home-story-heading">Chuyện nhà La'mer</h2>
                </div>
                <div class="home-story-ques container">
                    <div class="row">
                        <div class="story-ques-left col-lg-4 col-md-6 col-12">
                            <img class="home-story-img" src="/images/default.jpg" alt="">
                        </div>
                        <div class="story-ques-right home-story-body col-lg-8 col-md-6 col-12">
                            La'mer có nghĩa là "lá mơ". Thông thường khi nói đến lá mơ, người ta nghĩ ngay đến thịt chó.
                            Tuy nhiên, ở La'mer không có thịt chó. Tất cả những gì chúng mình đem đến chỉ là trà và cà
                            phê, có khi là có cả kem tươi nữa
                            <br>
                            Nếu bạn muốn ăn thịt chó … thì xin lỗi, bạn đã đến nhầm chỗ mất rồi! Ở La'mer, tụi mình
                            không phục vụ thịt chó – nhưng bù lại, tụi mình có những ly trà dịu dàng như buổi sớm, những
                            tách cà phê đủ mạnh để kéo bạn ra khỏi cơn uể oải, và đôi khi là những viên kem mát lạnh
                            khiến lòng người dịu lại trong những ngày oi ả.
                            <br><br>
                            Lá mơ nghe có vẻ dân dã, nhưng cũng có chút gì đó mộng mơ. Tụi mình mong bạn sẽ đến đây
                            không chỉ để uống một ly nước, mà là để tìm chút nhẹ nhàng, yên tĩnh giữa bộn bề. Cứ đến,
                            gọi một món bạn thích, chọn một chỗ ngồi ưng ý, và để thời gian chậm lại một chút – vậy thôi
                            là đủ.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include("footer.php"); ?>
    <script>
        document.querySelectorAll('.add-to-cart-btn').forEach(btn => {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                const productId = this.dataset.id;

                fetch('/add_to_cart.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: 'product_id=' + productId
                })
                    .then(res => res.json())
                    .then(data => {
                        const button = this;
                        button.textContent = 'Đã thêm vào giỏ hàng';
                        button.style.backgroundColor = '#28a745'; // xanh lá
                        button.style.color = '#fff';

                        // Disable click tạm thời
                        button.style.pointerEvents = 'none';

                        // Sau 1.5s reset lại
                        setTimeout(() => {
                            button.textContent = 'Đặt mua';
                            button.style.backgroundColor = '';
                            button.style.color = '';
                            button.style.pointerEvents = 'auto';
                        }, 1500);
                    })
                    .catch(err => {
                        console.error('Lỗi:', err);
                        alert('Có lỗi xảy ra khi thêm vào giỏ.');
                    });
            });
        });
        <?php if (!empty($_SESSION['force_login'])): ?>
            document.getElementById('loginModal').style.display = 'block';
            <?php unset($_SESSION['force_login']); ?>
        <?php endif; ?>
    </script>
</body>

</html>