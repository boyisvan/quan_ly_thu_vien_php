<?php
session_start();
if (!isset($_SESSION['ten_dang_nhap']) || $_SESSION['vai_tro'] != 'admin') {
    header('Location: ../dangnhap.php');
    exit;
}
require '../config.php';

// Thêm thể loại
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['them_the_loai'])) {
    $ten_the_loai = $_POST['ten_the_loai'];

    $sql = "INSERT INTO the_loai (ten_the_loai) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $ten_the_loai);

    if ($stmt->execute()) {
        header('Location: quanly_theloai.php');
    } else {
        echo "Lỗi: " . $stmt->error;
    }
}

// Xóa thể loại
if (isset($_GET['xoa'])) {
    $id = $_GET['xoa'];
    $sql = "DELETE FROM the_loai WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header('Location: quanly_theloai.php');
    } else {
        echo "Lỗi: " . $stmt->error;
    }
}

// Tìm kiếm thể loại
$tukhoa = "";
if (isset($_POST['tukhoa'])) {
    $tukhoa = $_POST['tukhoa'];
}
$sql = "SELECT * FROM the_loai WHERE ten_the_loai LIKE ?";
$stmt = $conn->prepare($sql);
$tukhoa_timkiem = "%" . $tukhoa . "%";
$stmt->bind_param("s", $tukhoa_timkiem);
$stmt->execute();
$result = $stmt->get_result();
?>

<?php require_once('header.php') ?>
<form action="quanly_theloai.php" method="POST" class="d-flex">
    <input type="text" name="tukhoa" placeholder="Tìm kiếm thể loại" value="<?php echo $tukhoa; ?>" class="form-control">
    <button type="submit" class="btn btn-outline-primary" style="width: 150px;margin-left: 10px;">Tìm kiếm</button>
</form>
</div>
</div>
</nav>
<div class="containerss1">
    <button class="btn btn-outline-success btn-toggle" onclick="toggleForm()">Thêm Thể Loại Mới</button>
    <form action="quanly_theloai.php" method="POST" class="formAdd" id="formAdd">
        <h2 class="text-center">Thêm Thể Loại Mới</h2>
        <label for="ten_the_loai">Tên Thể Loại:</label>
        <input type="text" id="ten_the_loai" name="ten_the_loai" class="form-control" required>
        <br>
        <button type="submit" name="them_the_loai" class="btn btn-success">Thêm Thể Loại</button>
    </form>

    <h2 class="text-center">Danh Sách Thể Loại Sách</h2>
    <table class="table table-bordered table-hover text-center">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên Thể Loại</th>
                <th>Hành Động</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) : ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['ten_the_loai']; ?></td>
                    <td>
                        <a class="btn btn-danger" href="quanly_theloai.php?xoa=<?php echo $row['id']; ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa thể loại này?');">Xóa</a>
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
            button.innerHTML = "Thêm Thể Loại Mới";
        }
    }
</script>