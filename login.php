<?php
require 'db.php';

session_start(); // Bắt đầu session

// Validate input
if (empty($_POST['username']) || empty($_POST['password'])) {
    $_SESSION['error'] = "Please enter both username and password";
    header("Location: login.html");
    exit;
}

// Kiểm tra nếu người dùng gửi form
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $inputUsername = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
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

        echo "Invalid username or password.";

    }
}
?>
