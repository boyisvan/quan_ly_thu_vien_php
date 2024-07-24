<?php
require 'config.php';
session_start();
if (!isset($_SESSION['ten_dang_nhap'])) {
    header('Location: dangnhap.php');
    exit;
}
$ten_dang_nhap = $_SESSION['ten_dang_nhap'];

// Xử lý tìm kiếm sách
$tukhoa = "";
$the_loai = "";
if (isset($_POST['tukhoa'])) {
    $tukhoa = $_POST['tukhoa'];
}
if (isset($_POST['the_loai'])) {
    $the_loai = $_POST['the_loai'];
}

$sql = "SELECT sach.*, the_loai.ten_the_loai FROM sach 
        JOIN the_loai ON sach.id_the_loai = the_loai.id 
        WHERE (sach.ten_sach LIKE ? OR sach.tac_gia LIKE ?) AND the_loai.ten_the_loai LIKE ?";
$stmt = $conn->prepare($sql);
$tukhoa_timkiem = "%" . $tukhoa . "%";
$the_loai_timkiem = "%" . $the_loai . "%";
$stmt->bind_param("sss", $tukhoa_timkiem, $tukhoa_timkiem, $the_loai_timkiem);
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
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><?php echo 'Xin chào, ' . $ten_dang_nhap; ?></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="trangchu.php">Trang chủ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="muontra.php">Mượn trả sách</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="dangxuat.php">Đăng xuất</a>
                    </li>
                </ul>

                <form action="trangchu.php" method="POST" class="d-flex" style="align-items: center;">
                    <select name="the_loai" class="form-control me-2">
                        <option value="">Tất cả thể loại</option>
                        <option value="Ngôn tình" <?php if ($the_loai == "Ngôn tình") echo "selected"; ?>>Ngôn tình</option>
                        <option value="Kinh doanh" <?php if ($the_loai == "Kinh doanh") echo "selected"; ?>>Kinh doanh</option>
                        <option value="Văn học" <?php if ($the_loai == "Văn học") echo "selected"; ?>>Văn học</option>
                        <!-- Thêm các thể loại khác nếu cần -->
                    </select>
                    <button type="submit" style="width: 150px;" class="btn btn-outline-primary">Lọc</button>
                </form>
            </div>
        </div>
    </nav>

    <marquee>Thư viện B-Book luôn cập nhật những đầu sách mới nhất thị trường , cho phép đọc giả mượn trả sách nhanh chóng</marquee>

    <div class="container">
        <h2 class="mb-4">Tìm kiếm sách theo thể loại</h2>
        <form action="trangchu.php" method="POST" class="d-flex" style="align-items: center;">
            <input type="text" name="tukhoa" class="form-control me-2" placeholder="Tìm kiếm theo tên sách hoặc tác giả" value="<?php echo $tukhoa; ?>">
            <button type="submit" style="width: 150px;" class="btn btn-outline-primary">Tìm kiếm</button>
        </form>
        <br>
        <table class="table table-bordered">
            <thead class="text-center">
                <tr>
                    <th>Tên sách</th>
                    <th>Tác giả</th>
                    <th>Thể loại</th>
                    <th>Mô tả</th>
                    <th>Hình ảnh</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) : ?>
                    <tr>
                        <td><?php echo $row['ten_sach']; ?></td>
                        <td><?php echo $row['tac_gia']; ?></td>
                        <td><?php echo $row['ten_the_loai']; ?></td>
                        <td><?php echo $row['mo_ta']; ?></td>
                        <td class="text-center"><img src="<?php echo $row['hinh_anh']; ?>" alt="<?php echo $row['ten_sach']; ?>" style="height: 100px;"></td>
                        <td class="text-center" style="width:150px"><a href="chitiet_sach.php?id=<?php echo $row['id']; ?>" class="btn btn-outline-dark">Xem chi tiết</a></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
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