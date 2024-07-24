<?php
require 'config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ten_dang_nhap = $_POST['ten_dang_nhap'];
    $mat_khau = $_POST['mat_khau'];

    $sql = "SELECT * FROM nguoi_dung WHERE ten_dang_nhap = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $ten_dang_nhap);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($mat_khau, $row['mat_khau'])) {
            $_SESSION['ten_dang_nhap'] = $row['ten_dang_nhap'];
            $_SESSION['vai_tro'] = $row['vai_tro'];

            if ($row['vai_tro'] == 'admin') {
                header('Location: admin/quanly_sach.php');
            } else {
                header('Location: trangchu.php');
            }
        } else {
            $error_message = "Sai mật khẩu!";
        }
    } else {
        $error_message = "Tên đăng nhập không tồn tại!";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Đăng Nhập</title>
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
                        <h2 class="text-center">Đăng Nhập</h2>
                    </div>
                    <div class="card-body">
                        <?php if (isset($error_message)) : ?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo $error_message; ?>
                            </div>
                        <?php endif; ?>
                        <form action="dangnhap.php" method="POST">
                            <div class="mb-3">
                                <label for="ten_dang_nhap" class="form-label">Tên Đăng Nhập</label>
                                <input type="text" class="form-control" id="ten_dang_nhap" name="ten_dang_nhap" required>
                            </div>
                            <div class="mb-3">
                                <label for="mat_khau" class="form-label">Mật Khẩu</label>
                                <input type="password" class="form-control" id="mat_khau" name="mat_khau" required>
                            </div>
                            <button type="submit" class="btn btn-outline-primary w-100">Đăng Nhập</button>
                        </form>
                    </div>
                    <div class="card-footer text-center">
                        <a href="index.php" class="btn btn-link">Trang Chủ</a>
                        <a href="dangky.php" class="btn btn-link">Đăng Ký</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>

<style>
    body {
        background: url('https://images3.alphacoders.com/100/thumbbig-1007175.webp');
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
    }
</style>