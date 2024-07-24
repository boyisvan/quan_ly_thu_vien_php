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
$sql = "SELECT muon_tra.*, sach.ten_sach 
        FROM muon_tra 
        JOIN sach ON muon_tra.id_sach = sach.id 
        WHERE muon_tra.id_nguoi_dung = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $ten_dang_nhap);
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
            </div>

        </div>
    </nav>

    <marquee>Thư viện B-Book luôn cập nhật những đầu sách mới nhất thị trường , cho phép đọc giả mượn trả sách nhanh chóng</marquee>

    <div class="container mt-1">
        <h3 class="mb-4 text-center">Thông tin mượn trả sách</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Tên sách</th>
                    <th>Ngày mượn</th>
                    <th>Ngày trả</th>
                    <th>Trạng thái</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) : ?>
                    <tr>
                        <td><?php echo $row['ten_sach']; ?></td>
                        <td><?php echo $row['ngay_muon']; ?></td>
                        <td><?php echo $row['ngay_tra']; ?></td>
                        <td><?php echo $row['trang_thai']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>

</html>