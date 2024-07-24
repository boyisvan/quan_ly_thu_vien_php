<?php
session_start();
if (!isset($_SESSION['ten_dang_nhap']) || $_SESSION['vai_tro'] != 'admin') {
    header('Location: ../dangnhap.php');
    exit;
}
require '../config.php';

// Xử lý trả sách
if (isset($_GET['tra'])) {
    $id = $_GET['tra'];
    $sql = "UPDATE muon_tra SET trang_thai = 'tra', ngay_tra = NOW() WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header('Location: quanly_muontra.php');
    } else {
        echo "Lỗi: " . $stmt->error;
    }
}

// Tìm kiếm thông tin mượn trả
$tukhoa = "";
if (isset($_POST['tukhoa'])) {
    $tukhoa = $_POST['tukhoa'];
}
$sql = "SELECT muon_tra.*, nguoi_dung.ten_dang_nhap, sach.ten_sach 
        FROM muon_tra 
        JOIN nguoi_dung ON muon_tra.id_nguoi_dung = nguoi_dung.id 
        JOIN sach ON muon_tra.id_sach = sach.id 
        WHERE nguoi_dung.ten_dang_nhap LIKE ? OR sach.ten_sach LIKE ?";
$stmt = $conn->prepare($sql);
$tukhoa_timkiem = "%" . $tukhoa . "%";
$stmt->bind_param("ss", $tukhoa_timkiem, $tukhoa_timkiem);
$stmt->execute();
$result = $stmt->get_result();
?>

<?php require_once('header.php') ?>
<form action="quanly_muontra.php" method="POST" class="d-flex">
    <input type="text" name="tukhoa" placeholder="Tìm kiếm thông tin mượn trả" value="<?php echo $tukhoa; ?>" class="form-control">
    <button type="submit" class="btn btn-outline-primary" style="width: 150px; margin-left: 10px;">Tìm kiếm</button>
</form>
</div>
</div>
</nav>
<div class="container mt-4">
    <h2 class="text-center">Danh Sách Mượn Trả</h2>
    <table class="table table-bordered table-hover text-center">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên Người Dùng</th>
                <th>Tên Sách</th>
                <th>Ngày Mượn</th>
                <th>Ngày Trả</th>
                <th>Trạng Thái</th>
                <th>Hành Động</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) : ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['ten_dang_nhap']; ?></td>
                    <td><?php echo $row['ten_sach']; ?></td>
                    <td><?php echo $row['ngay_muon']; ?></td>
                    <td><?php echo $row['ngay_tra']; ?></td>
                    <td><?php echo $row['trang_thai']; ?></td>
                    <td>
                        <?php if ($row['trang_thai'] == 'muon') : ?>
                            <a href="quanly_muontra.php?tra=<?php echo $row['id']; ?>" class="btn btn-success" onclick="return confirm('Bạn có chắc chắn muốn xác nhận trả sách này?');">Xác Nhận Đã Trả</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>

</html>