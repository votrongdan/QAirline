<?php
session_start();

// Kiểm tra nếu người dùng chưa đăng nhập
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Bao gồm file HTML (đây là nội dung trang sau khi đăng nhập)
include "admin.html";
?>
