<?php
require '../config.php';
session_start();
if (!isset($_SESSION['ten_dang_nhap']) || $_SESSION['vai_tro'] != 'admin') {
    header('Location: ../dangnhap.php');
    exit;
}

// Duyệt đơn mượn sách
if (isset($_GET['duyet'])) {
    $id = $_GET['duyet'];
    $ngay_tra = date('Y-m-d', strtotime('+7 days'));
    $sql_duyet = "UPDATE don_muon SET trang_thai = 'da_duyet' WHERE id = ?";
    $stmt_duyet = $conn->prepare($sql_duyet);
    $stmt_duyet->bind_param("i", $id);
    if ($stmt_duyet->execute()) {
        $sql_muon_tra = "INSERT INTO muon_tra (id_nguoi_dung, id_sach, ngay_muon, ngay_tra, trang_thai) 
                         SELECT id_nguoi_dung, id_sach, ngay_muon, ?, 'muon' FROM don_muon WHERE id = ?";
        $stmt_muon_tra = $conn->prepare($sql_muon_tra);
        $stmt_muon_tra->bind_param("si", $ngay_tra, $id);
        $stmt_muon_tra->execute();
    }
}

$sql = "SELECT don_muon.*, sach.ten_sach, nguoi_dung.ten_dang_nhap 
        FROM don_muon 
        JOIN sach ON don_muon.id_sach = sach.id 
        JOIN nguoi_dung ON don_muon.id_nguoi_dung = nguoi_dung.ten_dang_nhap";
$result = $conn->query($sql);
?>

<?php require_once('header.php') ?>
</div>
</div>
</nav>
<div class="container mt-5">
    <h3 class="mb-4 text-center">Quản lý mượn trả sách</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Tên người dùng</th>
                <th>Tên sách</th>
                <th>Ngày mượn</th>
                <th>Trạng thái</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) : ?>
                <tr>
                    <td><?php echo $row['ten_dang_nhap']; ?></td>
                    <td><?php echo $row['ten_sach']; ?></td>
                    <td><?php echo $row['ngay_muon']; ?></td>
                    <td><?php echo $row['trang_thai']; ?></td>
                    <td>
                        <?php if ($row['trang_thai'] == 'chua_duyet') : ?>
                            <a href="quanly_muontra.php?duyet=<?php echo $row['id']; ?>" class="btn btn-success">Duyệt</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>

</html>