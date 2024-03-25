<?php
session_start();


if (isset($_SESSION['username']) && !empty($_SESSION['username'])) {
    header("Location: manage.php");
    exit();
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $conn = new mysqli('mysql', 'root', 'rootpassword', 'QL_NhanSu');

    
    if ($conn->connect_error) {
        die("Kết nối thất bại: " . $conn->connect_error);
    }

    
    $username = $_POST['username'];
    $password = $_POST['password'];

    
    $sql = "SELECT * FROM user WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        
        $row = $result->fetch_assoc();
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $row['role'];

        
        header("Location: manage.php");
        exit();
    } else {
        
        $error_message = "Tên người dùng hoặc mật khẩu không chính xác.";
    }

    
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Đăng nhập</title>
</head>
<body>

<h2>Đăng nhập</h2>

<?php

if (isset($error_message)) {
    echo "<p style='color: red;'>$error_message</p>";
}
?>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
    <label for="username">Tên người dùng:</label><br>
    <input type="text" id="username" name="username" required><br>
    <label for="password">Mật khẩu:</label><br>
    <input type="password" id="password" name="password" required><br><br>
    <input type="submit" value="Đăng nhập">
</form>

</body>
</html>
