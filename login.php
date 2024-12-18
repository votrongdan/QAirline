<?php
require 'db.php';

session_start(); // Bắt đầu session

// Kết nối đến cơ sở dữ liệu
// $host = "localhost";
// $dbname = "QAirline";
// $username = "dan";
// $password = "dan";

// try {
//     $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
//     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// } catch (PDOException $e) {
//     die("Connection failed: " . $e->getMessage());
// }

// Kiểm tra nếu người dùng gửi form
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $inputUsername = $_POST['username'];
    $inputPassword = $_POST['password'];

    // Tìm kiếm người dùng trong cơ sở dữ liệu
    $stmt = $conn->prepare("SELECT * FROM admins WHERE username = :username");
    $stmt->bindParam(':username', $inputUsername);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($inputPassword, $user['password'])) {
        // Đăng nhập thành công
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header("Location: admin.php"); // Chuyển hướng đến trang HTML
        exit;
    } else {
        // Sai tên đăng nhập hoặc mật khẩu
        // echo "Invalid username or password.";
        // echo $user['username'];
        // echo $user['password'];
        // echo password_verify($inputPassword, $user['password']);
        // echo $inputPassword;
        // echo password_hash("dan", PASSWORD_DEFAULT);
        // Đăng nhập thành công
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header("Location: admin.php"); // Chuyển hướng đến trang HTML
        exit;
    }
}
?>
