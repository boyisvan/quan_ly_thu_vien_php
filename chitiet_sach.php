<?php
require 'config.php';
session_start();
if (!isset($_SESSION['ten_dang_nhap'])) {
    header('Location: dangnhap.php');
    exit;
}

$ten_dang_nhap = $_SESSION['ten_dang_nhap'];
$id_sach = $_GET['id'];

$sql = "SELECT sach.*, the_loai.ten_the_loai FROM sach 
        JOIN the_loai ON sach.id_the_loai = the_loai.id 
        WHERE sach.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_sach);
$stmt->execute();
$result = $stmt->get_result();
$sach = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_nguoi_dung = $_SESSION['ten_dang_nhap'];
    $ngay_muon = date('Y-m-d H:i:s');
    $sql_muon = "INSERT INTO don_muon (id_nguoi_dung, id_sach, ngay_muon) VALUES (?, ?, ?)";
    $stmt_muon = $conn->prepare($sql_muon);
    $stmt_muon->bind_param("sis", $id_nguoi_dung, $id_sach, $ngay_muon);
    if ($stmt_muon->execute()) {
        echo "<script>
            Swal.fire({
                title: 'Đăng ký mượn sách thành công!',
                text: 'Tên người dùng: $id_nguoi_dung\\nTên sách: {$sach['ten_sach']}\\nNgày mượn: $ngay_muon',
                icon: 'success'
            }).then(function() {
                window.location = 'muontra.php';
            });
        </script>";
    } else {
        echo "<script>
            Swal.fire({
                title: 'Lỗi!',
                text: 'Lỗi: " . $stmt_muon->error . "',
                icon: 'error'
            });
        </script>";
    }
}
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
    <div class="container mt-5">
        <h1 class="mb-4"><?php echo $sach['ten_sach']; ?></h1>
        <div class="row">
            <div class="col-md-4">
                <img src="<?php echo $sach['hinh_anh']; ?>" class="img-fluid" alt="<?php echo $sach['ten_sach']; ?>">
            </div>
            <div class="col-md-8">
                <p><strong>Tác giả:</strong> <?php echo $sach['tac_gia']; ?></p>
                <p><strong>Thể loại:</strong> <?php echo $sach['ten_the_loai']; ?></p>
                <p><strong>Mô tả:</strong> <?php echo $sach['mo_ta']; ?></p>
                <button type="button" class="btn btn-primary" onclick="confirmMuonSach()">Đăng ký mượn sách</button>
            </div>
        </div>
    </div>

    <script>
        function confirmMuonSach() {
            Swal.fire({
                title: 'Xác nhận mượn sách',
                text: "Tên người dùng: <?php echo $ten_dang_nhap; ?>, Tên sách: <?php echo $sach['ten_sach']; ?>, Ngày mượn: <?php echo date('Y-m-d H:i:s'); ?>",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Đồng ý mượn'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.querySelector('form').submit();
                }
            });
        }
    </script>
</body>

</html>