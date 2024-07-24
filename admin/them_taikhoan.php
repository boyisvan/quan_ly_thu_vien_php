<?php
session_start();
if (!isset($_SESSION['ten_dang_nhap']) || $_SESSION['vai_tro'] != 'admin') {
    header('Location: ../dangnhap.php');
    exit;
}
require '../config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ten_dang_nhap = $_POST['ten_dang_nhap'];
    $mat_khau = password_hash($_POST['mat_khau'], PASSWORD_DEFAULT);
    $vai_tro = $_POST['vai_tro'];

    $sql = "INSERT INTO nguoi_dung (ten_dang_nhap, mat_khau, vai_tro) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $ten_dang_nhap, $mat_khau, $vai_tro);

    if ($stmt->execute()) {
        header('Location: quanly_taikhoan.php');
    } else {
        echo "Lỗi: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Thêm Tài Khoản</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>

<body>
    <div class="container mt-4">
        <h2 class="text-center">Thêm Tài Khoản Mới</h2>
        <form action="them_taikhoan.php" method="POST">
            <div class="mb-3">
                <label for="ten_dang_nhap" class="form-label">Tên Đăng Nhập</label>
                <input type="text" class="form-control" id="ten_dang_nhap" name="ten_dang_nhap" required>
            </div>
            <div class="mb-3">
                <label for="mat_khau" class="form-label">Mật Khẩu</label>
                <input type="password" class="form-control" id="mat_khau" name="mat_khau" required>
            </div>
            <div class="mb-3">
                <label for="vai_tro" class="form-label">Vai Trò</label>
                <select class="form-control" id="vai_tro" name="vai_tro" required>
                    <option value="nguoi_dung">Đọc giả</option>
                    <option value="admin">Quản trị viên</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success">Thêm Tài Khoản</button>
            <a href="quanly_taikhoan.php" class="btn btn-outline-secondary">Quay lại</a>
        </form>
    </div>
</body>

</html>