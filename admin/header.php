<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Quản Lý Sách</title>
    <link rel="stylesheet" href="../assets/css/quanlisach.css">
    <link rel="shortcut icon" href="https://th.bing.com/th?id=OIP.uIeaWdGmcmDcJM5CFJKQGwHaDp&w=349&h=172&c=8&rs=1&qlt=90&o=6&dpr=1.3&pid=3.1&rm=2" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Thư viện B-Book</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Trang chủ</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Quản lý
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="quanly_sach.php">Quản lí sách</a></li>
                            <li><a class="dropdown-item" href="quanly_muontra.php">Quản lí mượn trả sách</a></li>
                            <li><a class="dropdown-item" href="quanly_taikhoan.php">Quản lí đọc giả</a></li>
                            <li><a class="dropdown-item" href="quanly_theloai.php">Quản lí thể loại sách</a></li>
                            <li><a class="dropdown-item" href="duyet_muon_sach.php">Duyệt yêu cầu mượn sách</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="baocao.php">Xem báo cáo</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../dangxuat.php">Đăng xuất</a>
                    </li>
                </ul>