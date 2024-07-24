<?php
session_start();
if (!isset($_SESSION['ten_dang_nhap']) || $_SESSION['vai_tro'] != 'admin') {
    header('Location: ../dangnhap.php');
    exit;
}
require '../config.php';

$id = $_GET['id'];
$sql = "SELECT * FROM sach WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$sach = $result->fetch_assoc();

// Lấy danh sách thể loại sách
$sql_the_loai = "SELECT * FROM the_loai";
$result_the_loai = $conn->query($sql_the_loai);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ten_sach = $_POST['ten_sach'];
    $tac_gia = $_POST['tac_gia'];
    $id_the_loai = $_POST['id_the_loai'];
    $mo_ta = $_POST['mo_ta'];
    $hinh_anh = $_POST['hinh_anh'];

    $sql = "UPDATE sach SET ten_sach = ?, tac_gia = ?, id_the_loai = ?, mo_ta = ?, hinh_anh = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssi", $ten_sach, $tac_gia, $id_the_loai, $mo_ta, $hinh_anh, $id);

    if ($stmt->execute()) {
        header('Location: quanly_sach.php');
    } else {
        echo "Lỗi: " . $stmt->error;
    }
}
?>

<?php require_once('header.php') ?>

</div>
</div>
</nav>
<div class="containerss">
    <h3 class="text-center">Sửa Thông Tin Sách</h3>
    <form action="sua_sach.php?id=<?php echo $id; ?>" method="POST">
        <label for="ten_sach">Tên Sách:</label>
        <input type="text" id="ten_sach" name="ten_sach" value="<?php echo $sach['ten_sach']; ?>" class="form-control" required>
        <br>
        <label for="tac_gia">Tác Giả:</label>
        <input type="text" id="tac_gia" name="tac_gia" value="<?php echo $sach['tac_gia']; ?>" class="form-control" required>
        <br>
        <label for="id_the_loai">Thể Loại:</label>
        <select id="id_the_loai" name="id_the_loai" class="form-control" required>
            <?php while ($row_the_loai = $result_the_loai->fetch_assoc()) : ?>
                <option value="<?php echo $row_the_loai['id']; ?>" <?php if ($row_the_loai['id'] == $sach['id_the_loai']) echo 'selected'; ?>><?php echo $row_the_loai['ten_the_loai']; ?></option>
            <?php endwhile; ?>
        </select>
        <br>
        <label for="mo_ta">Mô Tả:</label>
        <textarea class="form-control" id="mo_ta" name="mo_ta" required><?php echo $sach['mo_ta']; ?></textarea>
        <br>
        <label for="hinh_anh">Hình Ảnh (URL):</label>
        <input class="form-control" type="text" id="hinh_anh" name="hinh_anh" value="<?php echo $sach['hinh_anh']; ?>">
        <br>
        <div class="ctn d-flex">
            <button class="btn alert-success" type="submit">Lưu Thay Đổi</button>
            <a href="quanly_sach.php" class="btn btn-outline-success">Quay lại Quản Lý Sách</a>
        </div>
    </form>
</div>
</body>

</html>