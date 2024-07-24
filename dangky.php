<?php
require 'config.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ten_dang_nhap = $_POST['ten_dang_nhap'];
    $mat_khau = password_hash($_POST['mat_khau'], PASSWORD_BCRYPT);
    $vai_tro = 'nguoi_dung';

    $sql = "INSERT INTO nguoi_dung (ten_dang_nhap, mat_khau, vai_tro) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $ten_dang_nhap, $mat_khau, $vai_tro);

    if ($stmt->execute()) {
        header('Location: dangnhap.php');
    } else {
        echo "Lỗi: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Đăng Ký Tài Khoản</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h2 class="text-center">Đăng Ký Tài Khoản</h2>
                    </div>
                    <div class="card-body">
                        <form action="dangky.php" method="POST">
                            <div class="mb-3">
                                <label for="ten_dang_nhap" class="form-label">Tên Đăng Nhập</label>
                                <input type="text" class="form-control" id="ten_dang_nhap" name="ten_dang_nhap" required>
                            </div>
                            <div class="mb-3">
                                <label for="mat_khau" class="form-label">Mật Khẩu</label>
                                <input type="password" class="form-control" id="mat_khau" name="mat_khau" required>
                            </div>
                            <button type="submit" class="btn btn-outline-primary w-100">Đăng Ký</button>
                        </form>
                    </div>
                    <div class="card-footer text-center">
                        <a href="index.php" class="btn btn-link">Trang Chủ</a>
                        <a href="dangnhap.php" class="btn btn-link">Đăng Nhập</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>

<style>
    body {
        background: url('https://images4.alphacoders.com/100/thumbbig-1007089.webp');
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
    }
</style>