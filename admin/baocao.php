<?php
session_start();
if (!isset($_SESSION['ten_dang_nhap']) || $_SESSION['vai_tro'] != 'admin') {
    header('Location: ../dangnhap.php');
    exit;
}
require '../config.php';

// Tổng số sách
$sql_tong_sach = "SELECT COUNT(*) AS total_books FROM sach";
$result_tong_sach = $conn->query($sql_tong_sach);
$tong_sach = $result_tong_sach->fetch_assoc()['total_books'];

// Số lượng sách theo thể loại
$sql_sach_the_loai = "SELECT the_loai.ten_the_loai, COUNT(sach.id) AS total_books FROM sach JOIN the_loai ON sach.id_the_loai = the_loai.id GROUP BY the_loai.ten_the_loai";
$result_sach_the_loai = $conn->query($sql_sach_the_loai);

// Tổng số tài khoản
$sql_tong_taikhoan = "SELECT COUNT(*) AS total_users FROM nguoi_dung";
$result_tong_taikhoan = $conn->query($sql_tong_taikhoan);
$tong_taikhoan = $result_tong_taikhoan->fetch_assoc()['total_users'];

// Số lượng tài khoản theo vai trò
$sql_taikhoan_vaitro = "SELECT vai_tro, COUNT(id) AS total_users FROM nguoi_dung GROUP BY vai_tro";
$result_taikhoan_vaitro = $conn->query($sql_taikhoan_vaitro);

// Số lượng sách đang được mượn
$sql_sach_dang_muon = "SELECT COUNT(*) AS total_borrowed_books FROM muon_tra WHERE trang_thai = 'muon'";
$result_sach_dang_muon = $conn->query($sql_sach_dang_muon);
$sach_dang_muon = $result_sach_dang_muon->fetch_assoc()['total_borrowed_books'];

// Lịch sử mượn trả sách
$sql_lich_su_muon_tra = "SELECT muon_tra.*, nguoi_dung.ten_dang_nhap, sach.ten_sach FROM muon_tra JOIN nguoi_dung ON muon_tra.id_nguoi_dung = nguoi_dung.id JOIN sach ON muon_tra.id_sach = sach.id ORDER BY muon_tra.ngay_muon DESC";
$result_lich_su_muon_tra = $conn->query($sql_lich_su_muon_tra);
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Báo Cáo Thống Kê</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script>
        function printReport() {
            window.print();
        }
    </script>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Báo Cáo Thống Kê</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php">Trang chủ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="quanly_sach.php">Quản lý sách</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="quanly_taikhoan.php">Quản lý tài khoản</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="quanly_muontra.php">Quản lý mượn trả sách</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="quanly_theloai.php">Quản lý thể loại sách</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="baocao.php">Báo cáo</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../dangxuat.php">Đăng xuất</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mt-4">
        <h2 class="text-center">Báo Cáo Thống Kê</h2>
        <button class="btn btn-primary mb-3" onclick="printReport()">In Báo Cáo</button>

        <div class="mb-4">
            <h4>Tổng Số Sách: <?php echo $tong_sach; ?></h4>
            <h5>Theo Thể Loại:</h5>
            <ul>
                <?php while ($row = $result_sach_the_loai->fetch_assoc()) : ?>
                    <li><?php echo $row['ten_the_loai']; ?>: <?php echo $row['total_books']; ?></li>
                <?php endwhile; ?>
            </ul>
        </div>

        <div class="mb-4">
            <h4>Tổng Số Tài Khoản: <?php echo $tong_taikhoan; ?></h4>
            <h5>Theo Vai Trò:</h5>
            <ul>
                <?php while ($row = $result_taikhoan_vaitro->fetch_assoc()) : ?>
                    <li><?php echo ($row['vai_tro'] == 'admin') ? 'Quản trị viên' : 'Đọc giả'; ?>: <?php echo $row['total_users']; ?></li>
                <?php endwhile; ?>
            </ul>
        </div>

        <div class="mb-4">
            <h4>Số Lượng Sách Đang Được Mượn: <?php echo $sach_dang_muon; ?></h4>
        </div>

        <div class="mb-4">
            <h4>Lịch Sử Mượn Trả Sách</h4>
            <table class="table table-bordered table-hover text-center">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên Người Dùng</th>
                        <th>Tên Sách</th>
                        <th>Ngày Mượn</th>
                        <th>Ngày Trả</th>
                        <th>Trạng Thái</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result_lich_su_muon_tra->fetch_assoc()) : ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['ten_dang_nhap']; ?></td>
                            <td><?php echo $row['ten_sach']; ?></td>
                            <td><?php echo $row['ngay_muon']; ?></td>
                            <td><?php echo $row['ngay_tra']; ?></td>
                            <td><?php echo $row['trang_thai']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>