<?php
session_start();

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Kiểm tra vai trò của người dùng, chỉ admin mới được truy cập trang quản lý nhân viên
if ($_SESSION['role'] !== 'admin') {
    echo "Bạn không có quyền truy cập trang này.";
    exit();
}

// Kết nối đến cơ sở dữ liệu
$conn = new mysqli('mysql', 'root', 'rootpassword', 'QL_NhanSu');

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Xử lý thêm nhân viên
if (isset($_POST['add_employee'])) {
    $ma_nv = $_POST['ma_nv'];
    $ten_nv = $_POST['ten_nv'];
    $phai = $_POST['phai'];
    $noi_sinh = $_POST['noi_sinh'];
    $ma_phong = $_POST['ma_phong'];
    $luong = $_POST['luong'];
    
    // Kiểm tra mã nhân viên đã tồn tại chưa
    $check_query = "SELECT * FROM NHANVIEN WHERE Ma_NV='$ma_nv'";
    $check_result = $conn->query($check_query);
    
    if ($check_result->num_rows > 0) {
        echo "Mã nhân viên đã tồn tại. Vui lòng chọn mã nhân viên khác.";
    } else {
        // Thêm nhân viên vào cơ sở dữ liệu
        $insert_query = "INSERT INTO NHANVIEN (Ma_NV, Ten_NV, Phai, Noi_Sinh, Ma_Phong, Luong) 
                         VALUES ('$ma_nv', '$ten_nv', '$phai', '$noi_sinh', '$ma_phong', '$luong')";
        if ($conn->query($insert_query) === TRUE) {
            echo "Thêm nhân viên thành công.";
        } else {
            echo "Lỗi: " . $insert_query . "<br>" . $conn->error;
        }
    }
}

// Xử lý chỉnh sửa nhân viên
if (isset($_POST['edit_employee'])) {
    $ma_nv = $_POST['ma_nv'];
    $ten_nv = $_POST['ten_nv'];
    $phai = $_POST['phai'];
    $noi_sinh = $_POST['noi_sinh'];
    $ma_phong = $_POST['ma_phong'];
    $luong = $_POST['luong'];

    $sql = "UPDATE NHANVIEN 
            SET Ten_NV='$ten_nv', Phai='$phai', Noi_Sinh='$noi_sinh', Ma_Phong='$ma_phong', Luong='$luong'
            WHERE Ma_NV='$ma_nv'";
    if ($conn->query($sql) === TRUE) {
        echo "Cập nhật thông tin nhân viên thành công.";
    } else {
        echo "Lỗi: " . $sql . "<br>" . $conn->error;
    }
}

// Xử lý xóa nhân viên
if (isset($_POST['delete_employee'])) {
    $ma_nv = $_POST['ma_nv'];

    $sql = "DELETE FROM NHANVIEN WHERE Ma_NV='$ma_nv'";
    if ($conn->query($sql) === TRUE) {
        echo "Xóa nhân viên thành công.";
    } else {
        echo "Lỗi: " . $sql . "<br>" . $conn->error;
    }
}

// Truy vấn danh sách nhân viên
$sql = "SELECT * FROM NHANVIEN";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý nhân viên</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h2>Quản lý nhân viên</h2>

<!-- Bảng hiển thị danh sách nhân viên -->
<table>
    <tr>
        <th>Mã NV</th>
        <th>Tên NV</th>
        <th>Giới tính</th>
        <th>Nơi sinh</th>
        <th>Mã phòng</th>
        <th>Lương</th>
        <th>Thao tác</th>
    </tr>
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['Ma_NV'] . "</td>";
            echo "<td>" . $row['Ten_NV'] . "</td>";
            echo "<td>" . $row['Phai'] . "</td>";
            echo "<td>" . $row['Noi_Sinh'] . "</td>";
            echo "<td>" . $row['Ma_Phong'] . "</td>";
            echo "<td>" . $row['Luong'] . "</td>";
            echo "<td>";
            echo "<button type='button' onclick='editEmployee(\"" . $row['Ma_NV'] . "\", \"" . $row['Ten_NV'] . "\", \"" . $row['Phai'] . "\", \"" . $row['Noi_Sinh'] . "\", \"" . $row['Ma_Phong'] . "\", \"" . $row['Luong'] . "\")'>Sửa</button>";
            echo "<button type='button' onclick='deleteEmployee(\"" . $row['Ma_NV'] . "\")'>Xóa</button>";
            echo "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='7'>Không có dữ liệu</td></tr>";
    }
    ?>
</table>

<!-- Form thêm nhân viên -->
<h3>Thêm nhân viên</h3>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
    <label for="ma_nv">Mã NV:</label>
    <input type="text" id="ma_nv" name="ma_nv" required><br>
    <label for="ten_nv">Tên NV:</label>
    <input type="text" id="ten_nv" name="ten_nv" required><br>
    <label for="phai">Giới tính:</label>
    <input type="text" id="phai" name="phai" required><br>
    <label for="noi_sinh">Nơi sinh:</label>
    <input type
    ="text" id="noi_sinh" name="noi_sinh" required><br>
    <label for="ma_phong">Mã phòng:</label>
    <input type="text" id="ma_phong" name="ma_phong" required><br>
    <label for="luong">Lương:</label>
    <input type="text" id="luong" name="luong" required><br>
    <button type="submit" name="add_employee">Thêm</button>
</form>

<!-- Form chỉnh sửa nhân viên -->
<form id="edit_form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <input type="hidden" id="edit_ma_nv" name="ma_nv">
    <input type="hidden" id="edit_ten_nv" name="ten_nv">
    <input type="hidden" id="edit_phai" name="phai">
    <input type="hidden" id="edit_noi_sinh" name="noi_sinh">
    <input type="hidden" id="edit_ma_phong" name="ma_phong">
    <input type="hidden" id="edit_luong" name="luong">
    <button type="submit" style="display: none;" id="edit_employee" name="edit_employee">Xác nhận chỉnh sửa</button>
</form>

<!-- Form xóa nhân viên -->
<form id="delete_form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <input type="hidden" id="delete_ma_nv" name="ma_nv">
    <button type="submit" style="display: none;" id="delete_employee" name="delete_employee">Xác nhận xóa</button>
</form>

<script>
    function editEmployee(ma_nv, ten_nv, phai, noi_sinh, ma_phong, luong) {
        document.getElementById('edit_ma_nv').value = ma_nv;
        document.getElementById('edit_ten_nv').value = ten_nv;
        document.getElementById('edit_phai').value = phai;
        document.getElementById('edit_noi_sinh').value = noi_sinh;
        document.getElementById('edit_ma_phong').value = ma_phong;
        document.getElementById('edit_luong').value = luong;
        document.getElementById('edit_employee').click();
    }

    function deleteEmployee(ma_nv) {
        if (confirm("Bạn có chắc chắn muốn xóa nhân viên này không?")) {
            document.getElementById('delete_ma_nv').value = ma_nv;
            document.getElementById('delete_employee').click();
        }
    }
</script>

</body>
</html>

<?php
// Đóng kết nối cơ sở dữ liệu
$conn->close();
?>
