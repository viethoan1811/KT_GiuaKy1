<!DOCTYPE html>
<html>
<head>
    <title>Thông tin nhân viên</title>

    <style>
        .login-button {
            position: fixed;
            top: 11px;
            right: 11px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 2px solid #dddddd;
            text-align: left;
            padding: 6px;
        }

        th {
            background-color: #f3f3f3;
        }
    </style>
</head>
<body>
<a href="login.php" class="login-button">Đăng nhập</a>
<h2>Thông tin nhân viên</h2>

<table>
    <tr>
        <th>Mã NV</th>
        <th>Tên NV</th>
        <th>Giới tính</th>
        <th>Nơi sinh</th>
        <th>Mã phòng</th>
        <th>Lương</th>
    </tr>
    <?php
    
    $conn = new mysqli('mysql', 'root', 'rootpassword', 'QL_NhanSu');

    
    if ($conn->connect_error) {
        die("Kết nối thất bại: " . $conn->connect_error);
    }

    
    $sql = "SELECT * FROM NHANVIEN";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['Ma_NV'] . "</td>";
            echo "<td>" . $row['Ten_NV'] . "</td>";
            echo "<td><img src='" . ($row['Phai'] == 'NU' ? 'https://upload.wikimedia.org/wikipedia/commons/0/05/Female-icon-2.png' : 'https://cdn-icons-png.freepik.com/256/3439/3439472.png') . "' width='50' height='50'></td>";
            echo "<td>" . $row['Noi_Sinh'] . "</td>";
            echo "<td>" . $row['Ma_Phong'] . "</td>";
            echo "<td>" . $row['Luong'] . "</td>";
            echo "</tr>";
        }
    } else {
        echo "Không có dữ liệu";
    }
    
    $conn->close();
    ?>
</table>

</body>
</html>