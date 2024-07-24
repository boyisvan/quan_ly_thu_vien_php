<?php
session_start();
if (!isset($_SESSION['ten_dang_nhap']) || $_SESSION['vai_tro'] != 'admin') {
    header('Location: ../dangnhap.php');
    exit;
}
require '../config.php';

// Xóa tài khoản
if (isset($_GET['xoa'])) {
    $id = $_GET['xoa'];
    $sql = "DELETE FROM nguoi_dung WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header('Location: quanly_taikhoan.php');
    } else {
        echo "Lỗi: " . $stmt->error;
    }
}

// Tìm kiếm tài khoản
$tukhoa = "";
if (isset($_POST['tukhoa'])) {
    $tukhoa = $_POST['tukhoa'];
}
$sql = "SELECT * FROM nguoi_dung WHERE ten_dang_nhap LIKE ?";
$stmt = $conn->prepare($sql);
$tukhoa_timkiem = "%" . $tukhoa . "%";
$stmt->bind_param("s", $tukhoa_timkiem);
$stmt->execute();
$result = $stmt->get_result();
?>

<?php require_once('header.php') ?>
<form action="quanly_taikhoan.php" method="POST" class="d-flex">
    <input type="text" name="tukhoa" placeholder="Tìm kiếm tài khoản" value="<?php echo $tukhoa; ?>" class="form-control">
    <button type="submit" class="btn btn-outline-primary" style="width: 150px;margin-left: 10px;">Tìm kiếm</button>
</form>
</div>
</div>
</nav>
<div class="container mt-4">
    <h2 class="text-center">Danh Sách Tài Khoản</h2>
    <button class="btn btn-outline-success mb-3" onclick="window.location.href='them_taikhoan.php'">Thêm Tài Khoản Mới</button>
    <table class="table table-bordered table-hover text-center">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên Đăng Nhập</th>
                <th>Vai Trò</th>
                <th>Hành Động</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) : ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['ten_dang_nhap']; ?></td>
                    <td>
                        <?php
                        if ($row['vai_tro'] == 'admin') {
                            echo '<span class="btn alert-success">Quản trị viên</span>';
                        } else {
                            echo 'Đọc giả';
                        }
                        ?>
                    </td>
                    <td>
                        <a href="sua_taikhoan.php?id=<?php echo $row['id']; ?>" class="btn btn-warning">Sửa</a>
                        <a href="quanly_taikhoan.php?xoa=<?php echo $row['id']; ?>" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa tài khoản này?');">Xóa</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>

</html>