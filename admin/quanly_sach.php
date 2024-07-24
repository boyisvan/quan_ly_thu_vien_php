<?php
session_start();
if (!isset($_SESSION['ten_dang_nhap']) || $_SESSION['vai_tro'] != 'admin') {
    header('Location: ../dangnhap.php');
    exit;
}
require '../config.php';

// Lấy danh sách thể loại
$sql_the_loai = "SELECT * FROM the_loai";
$result_the_loai = $conn->query($sql_the_loai);

// Thêm sách
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['them_sach'])) {
    $ten_sach = $_POST['ten_sach'];
    $tac_gia = $_POST['tac_gia'];
    $id_the_loai = $_POST['id_the_loai'];
    $mo_ta = $_POST['mo_ta'];
    $hinh_anh = $_POST['hinh_anh'];

    $sql = "INSERT INTO sach (ten_sach, tac_gia, id_the_loai, mo_ta, hinh_anh) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssiss", $ten_sach, $tac_gia, $id_the_loai, $mo_ta, $hinh_anh);

    if ($stmt->execute()) {
        header('Location: quanly_sach.php');
    } else {
        echo "Lỗi: " . $stmt->error;
    }
}

// Xóa sách
if (isset($_GET['xoa'])) {
    $id = $_GET['xoa'];
    $sql = "DELETE FROM sach WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header('Location: quanly_sach.php');
    } else {
        echo "Lỗi: " . $stmt->error;
    }
}

// Tìm kiếm sách
$tukhoa = "";
if (isset($_POST['tukhoa'])) {
    $tukhoa = $_POST['tukhoa'];
}
$sql = "SELECT sach.*, the_loai.ten_the_loai FROM sach 
        JOIN the_loai ON sach.id_the_loai = the_loai.id 
        WHERE ten_sach LIKE ?";
$stmt = $conn->prepare($sql);
$tukhoa_timkiem = "%" . $tukhoa . "%";
$stmt->bind_param("s", $tukhoa_timkiem);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="vi">

<?php require_once('header.php') ?>
<form action="quanly_sach.php" method="POST" class="d-flex">
    <input type="text" name="tukhoa" placeholder="Tìm kiếm sách" value="<?php echo $tukhoa; ?>" class="form-control">
    <button type="submit" class="btn btn-outline-primary" style="width: 150px;margin-left: 10px;">Tìm kiếm</button>
</form>
</div>
</div>
</nav>
<div class="containersach">
    <button class="btn btn-outline-success btn-toggle" onclick="toggleForm()">Thêm Đầu Sách Mới</button>
    <form action="quanly_sach.php" method="POST" class="formAdd" id="formAdd">
        <h2 class="text-center">Thêm Đầu Sách Mới</h2>
        <label for="ten_sach">Tên Sách:</label>
        <input type="text" id="ten_sach" name="ten_sach" class="form-control" required>
        <label for="tac_gia">Tác Giả:</label>
        <input type="text" id="tac_gia" name="tac_gia" class="form-control" required>
        <label for="id_the_loai">Thể Loại:</label>
        <select id="id_the_loai" name="id_the_loai" class="form-control" required>
            <?php while ($row_the_loai = $result_the_loai->fetch_assoc()) : ?>
                <option value="<?php echo $row_the_loai['id']; ?>"><?php echo $row_the_loai['ten_the_loai']; ?></option>
            <?php endwhile; ?>
        </select>
        <label for="mo_ta">Mô Tả:</label>
        <textarea id="mo_ta" name="mo_ta" class="form-control" required></textarea>
        <label for="hinh_anh">Hình Ảnh (URL):</label>
        <input type="text" id="hinh_anh" name="hinh_anh" class="form-control">
        <br>
        <button type="submit" name="them_sach" class="btn btn-success">Thêm Sách</button>
    </form>

    <h2 class="text-center">Danh Sách Sách Trong Thư Viện</h2>
    <table class="table table-bordered table-hover text-center">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên Sách</th>
                <th>Tác Giả</th>
                <th>Thể Loại</th>
                <th>Mô Tả</th>
                <th>Hình Ảnh</th>
                <th>Hành Động</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) : ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['ten_sach']; ?></td>
                    <td><?php echo $row['tac_gia']; ?></td>
                    <td><?php echo $row['ten_the_loai']; ?></td>
                    <td><?php echo $row['mo_ta']; ?></td>
                    <td><img src="<?php echo $row['hinh_anh']; ?>" alt="Hình ảnh sách" width="50"></td>
                    <td>
                        <a class="btn btn-warning" href="sua_sach.php?id=<?php echo $row['id']; ?>">Sửa</a> |
                        <a class="btn btn-danger" href="quanly_sach.php?xoa=<?php echo $row['id']; ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa sách này?');">Xóa</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>

</html>

<script>
    function toggleForm() {
        var form = document.getElementById('formAdd');
        var button = document.querySelector('.btn-toggle');
        if (form.style.display === "none" || form.style.display === "") {
            form.style.display = "block";
            button.innerHTML = "Hủy thêm";
        } else {
            form.style.display = "none";
            button.innerHTML = "Thêm Đầu Sách Mới";
        }
    }
</script>