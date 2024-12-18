<?php
session_start();
session_destroy(); // Xóa toàn bộ session
header("Location: login.html"); // Quay lại trang đăng nhập
exit;
?>
