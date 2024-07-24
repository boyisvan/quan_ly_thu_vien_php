<?php
require 'config.php';

// Xử lý tìm kiếm sách
$tukhoa = "";
if (isset($_POST['tukhoa'])) {
    $tukhoa = $_POST['tukhoa'];
}
$sql = "SELECT sach.*, the_loai.ten_the_loai FROM sach 
        JOIN the_loai ON sach.id_the_loai = the_loai.id 
        WHERE ten_sach LIKE ? AND the_loai.ten_the_loai = 'Truyện ngôn tình'";
$stmt = $conn->prepare($sql);
$tukhoa_timkiem = "%" . $tukhoa . "%";
$stmt->bind_param("s", $tukhoa_timkiem);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Thư viện B-Book</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="shortcut icon" href="https://th.bing.com/th?id=OIP.uIeaWdGmcmDcJM5CFJKQGwHaDp&w=349&h=172&c=8&rs=1&qlt=90&o=6&dpr=1.3&pid=3.1&rm=2" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css">

    <style>
        .carousel-item img {
            height: 600px;
            object-fit: cover;
        }

        .card img {
            height: 400px;
            object-fit: cover;
        }
    </style>
</head>

<body>
    <header class="bg-light p-3 mb-2">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <i class="fa-solid fa-book"></i>
                    <h1 class="h3 mb-0">Thư viện B-Book</h1>
                </div>
                <form action="index.php" method="POST" class="d-flex" style="align-items: center;">
                    <input type="text" name="tukhoa" class="form-control me-2" placeholder="Tìm kiếm sách" value="<?php echo $tukhoa; ?>">
                    <button type="submit" style="width: 150px;" class="btn btn-outline-primary">Tìm kiếm</button>
                </form>
                <div>
                    <a href="dangnhap.php" class="btn btn-outline-secondary me-2">Đăng Nhập</a>
                    <a href="dangky.php" class="btn btn-primary">Đăng Ký</a>
                </div>
            </div>
        </div>
    </header>

    <marquee>Thư viện B-Book luôn cập nhật những đầu sách mới nhất thị trường , cho phép đọc giả mượn trả sách nhanh chóng</marquee>

    <div class="container mb-4">
        <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="3" aria-label="Slide 4"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="4" aria-label="Slide 5"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="https://images8.alphacoders.com/136/thumb-1920-1360758.jpeg" class="d-block w-100" alt="Banner 1">
                </div>
                <div class="carousel-item">
                    <img src="https://images5.alphacoders.com/100/thumb-1920-1006726.jpg" class="d-block w-100" alt="Banner 2">
                </div>
                <div class="carousel-item">
                    <img src="https://images4.alphacoders.com/100/thumb-1920-1007179.jpg" class="d-block w-100" alt="Banner 3">
                </div>
                <div class="carousel-item">
                    <img src="https://images6.alphacoders.com/100/thumb-1920-1007172.jpg" class="d-block w-100" alt="Banner 4">
                </div>
                <div class="carousel-item">
                    <img src="https://images3.alphacoders.com/100/thumb-1920-1006664.jpg" class="d-block w-100" alt="Banner 5">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>

    <div class="container">
        <h2 class="mb-4">Truyện Ngôn Tình Mới Nhất</h2>
        <div id="ngonTinhCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <?php
                $active = 'active';
                $counter = 0;
                echo '<div class="carousel-item ' . $active . '"><div class="row">';
                while ($row = $result->fetch_assoc()) {
                    if ($counter > 0 && $counter % 4 == 0) {
                        echo '</div></div><div class="carousel-item"><div class="row">';
                    }
                ?>
                    <div class="col-md-3 mb-4">
                        <div class="card">
                            <img src="<?php echo $row['hinh_anh']; ?>" class="card-img-top imgcard" alt="<?php echo $row['ten_sach']; ?>">
                            <div class="card-body">
                                <h5 class="card-title tensach">
                                    <?php echo $row['ten_sach']; ?>
                                </h5>
                                <span class="text-warning">
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                </span>
                                <p class="card-text">Tác giả : <?php echo $row['tac_gia']; ?></p>
                                <a href="dangnhap.php" class="btn btn-outline-primary">Xem Chi Tiết</a>
                            </div>
                        </div>
                    </div>

                <?php
                    $counter++;
                }
                echo '</div></div>';
                ?>
            </div>
            <button class="carousel-control-prev " type="button" data-bs-target="#ngonTinhCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden ct">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#ngonTinhCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden ct">Next</span>
            </button>
        </div>
    </div>

    <div class="container mb-5">
        <h2 class="mb-4">Sách Kinh Doanh Tư Duy Khởi Nghiệp</h2>
        <div id="kinhDoanhCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <?php
                // $sql_kinh_doanh = "SELECT * FROM sach WHERE id_the_loai = 'Kinh doanh' LIMIT 12";
                $sql_kinh_doanh  = "SELECT sach.*, the_loai.ten_the_loai FROM sach 
        JOIN the_loai ON sach.id_the_loai = the_loai.id 
        WHERE the_loai.ten_the_loai = 'Kinh doanh'";
                $result_kinh_doanh = $conn->query($sql_kinh_doanh);
                $active = 'active';
                $counter = 0;
                echo '<div class="carousel-item ' . $active . '"><div class="row">';
                while ($row = $result_kinh_doanh->fetch_assoc()) {
                    if ($counter > 0 && $counter % 4 == 0) {
                        echo '</div></div><div class="carousel-item"><div class="row">';
                    }
                ?>
                    <div class="col-md-3 mb-4">
                        <div class="card">
                            <img src="<?php echo $row['hinh_anh']; ?>" class="card-img-top imgcard" alt="<?php echo $row['ten_sach']; ?>">
                            <div class="card-body">
                                <h5 class="card-title tensach"><?php echo $row['ten_sach']; ?></h5>
                                <p class="card-text">Tác giả : <?php echo $row['tac_gia']; ?></p>
                                <a href="dangnhap.php" class="btn btn-outline-primary">Xem Chi Tiết</a>
                            </div>
                        </div>
                    </div>
                <?php
                    $counter++;
                }
                echo '</div></div>';
                ?>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#kinhDoanhCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#kinhDoanhCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
    <div class="container mb-5">
        <h2 class="mb-4">Sách Văn Học</h2>
        <div id="kinhDoanhCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <?php
                $sql_kinh_doanh  = "SELECT sach.*, the_loai.ten_the_loai FROM sach 
        JOIN the_loai ON sach.id_the_loai = the_loai.id 
        WHERE the_loai.ten_the_loai = 'Văn học'";
                $result_kinh_doanh = $conn->query($sql_kinh_doanh);
                $active = 'active';
                $counter = 0;
                echo '<div class="carousel-item ' . $active . '"><div class="row">';
                while ($row = $result_kinh_doanh->fetch_assoc()) {
                    if ($counter > 0 && $counter % 4 == 0) {
                        echo '</div></div><div class="carousel-item"><div class="row">';
                    }
                ?>
                    <div class="col-md-3 mb-4">
                        <div class="card">
                            <img src="<?php echo $row['hinh_anh']; ?>" class="card-img-top imgcard" alt="<?php echo $row['ten_sach']; ?>">
                            <div class="card-body">
                                <h5 class="card-title tensach"><?php echo $row['ten_sach']; ?></h5>
                                <p class="card-text">Tác giả : <?php echo $row['tac_gia']; ?></p>
                                <a href="dangnhap.php" class="btn btn-outline-primary">Xem Chi Tiết</a>
                            </div>
                        </div>
                    </div>
                <?php
                    $counter++;
                }
                echo '</div></div>';
                ?>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#kinhDoanhCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#kinhDoanhCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>


    <footer class="bg-light text-center text-lg-start mt-5">
        <div class="container p-4">
            <div class="row">
                <div class="col-lg-6 col-md-12 mb-4 mb-md-0">
                    <h5 class="text-uppercase">Thư viện B-Book</h5>
                    <p>
                        Địa chỉ: 123 Đường ABC, Phường XYZ, Quận 1, TP. HCM<br>
                        Điện thoại: (012) 345-6789<br>
                        Email: info@bbooklibrary.com
                    </p>
                </div>

                <div class="col-lg-6 col-md-12 mb-4 mb-md-0">
                    <h5 class="text-uppercase">Bản đồ</h5>
                    <div class="map-container" style="height: 300px;">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d387144.0075838207!2d-74.25987568740629!3d40.697670067742254!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c24fa5e33f083b%3A0xefd5c0a71e987f12!2sNew%20York%2C%20NY%2C%20USA!5e0!3m2!1sen!2s!4v1609781464990!5m2!1sen!2s" width="100%" height="100%" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center p-3 bg-dark text-white">
            © 2024 B-Book Library. All Rights Reserved.
        </div>
    </footer>

</body>

</html>

<style>
    marquee {
        font-size: 14px;
        padding: 0 10%;
    }

    body {
        font-family: Arial, sans-serif;
        background-color: #f8f9fa;
    }

    .header {
        background-color: #f8f9fa;
        padding: 20px 0;
    }

    header {
        box-shadow: 0 0 4px gray;
    }

    .header .logo {
        width: 50px;
        height: 50px;
    }

    .header .search-bar {
        width: 50%;
    }

    .header .btn {
        margin-left: 10px;
    }

    .carousel-item img {
        height: 550px;
        object-fit: cover;
        border-radius: 10px;
    }

    .card img {
        height: 200px;
        object-fit: cover;
    }

    .ct {
        box-shadow: 0 0 5px gray;
        color: red;
    }

    .card .imgcard {
        min-height: 400px;
    }

    .mota {
        height: 60px;
    }

    .tensach {
        height: 50px;
    }

    @media(max-width:768px) {

        body,
        .body,
        .container {
            padding: 5px;
        }
    }
</style>