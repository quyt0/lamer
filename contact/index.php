<!DOCTYPE html>
<html lang="vi">

<?php
$customHead = '<link rel="stylesheet" href="style.css">';
$pageTitle = "Liên hệ - La'mer Coffe & Tea";
include("../head.php");
?>

<body>
    <div class="body-wrapper">
        <?php include("../header.php"); ?>

        <div id="contact-page" class="container">
            <div class="main-heading-section mt-5 mb-4 text-center">
                <i class="fa-solid fa-envelope"></i>
                <h2 class="home-story-heading">Liên hệ với La'mer</h2>
                <p class="main-heading-section-sub mt-2">Đừng ngần ngại nhắn cho chúng mình bất kỳ điều gì bạn đang nghĩ
                    nhé!</p>
            </div>

            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <form class="contact-form">
                        <div class="mb-3">
                            <label for="name">Họ và tên</label>
                            <input type="text" id="name" class="form-control" placeholder="Nhập tên của bạn" required>
                        </div>
                        <div class="mb-3">
                            <label for="email">Email</label>
                            <input type="email" id="email" class="form-control" placeholder="Nhập email" required>
                        </div>
                        <div class="mb-3">
                            <label for="message">Nội dung</label>
                            <textarea id="message" class="form-control" rows="5"
                                placeholder="Bạn muốn nhắn gì cho La'mer?" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-dark">Gửi tin nhắn</button>
                    </form>
                </div>

                <div class="col-lg-6 col-md-6">
                    <div class="contact-info">
                        <h4>Thông tin liên hệ</h4>
                        <p><i class="fa-solid fa-location-dot"></i> 123 Đường Yên Tĩnh, Quận Bình An</p>
                        <p><i class="fa-solid fa-phone"></i> 0123 456 789</p>
                        <p><i class="fa-solid fa-envelope"></i> contact@lamer.vn</p>

                        <h4 class="mt-4">Bản đồ</h4>
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3724.7259923563583!2d105.8414205!3d21.003038!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135ab6e33c6018f%3A0x32f3e1e3c9b1d401!2zVGjhuqNvIG5ndXnhu4VuIFbDoG8gU-G7kSAoVm9vIHR1cmkp!5e0!3m2!1svi!2s!4v1614501934839!5m2!1svi!2s"
                            width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                    </div>
                </div>
            </div>
        </div>

        <?php include("../footer.php"); ?>
    </div>

    <script>
        document.querySelector('.contact-form').addEventListener('submit', function (e) {
            e.preventDefault();

            const formData = new FormData();
            formData.append('name', document.getElementById('name').value);
            formData.append('email', document.getElementById('email').value);
            formData.append('message', document.getElementById('message').value);

            fetch('/contact/handle_contact.php', {
                method: 'POST',
                body: formData
            })
                .then(res => res.json())
                .then(data => {
                    alert(data.message);
                    if (data.success) {
                        this.reset();
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert('Gửi liên hệ thất bại.');
                });
        });
    </script>

</body>

</html>