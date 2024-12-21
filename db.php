<?php
// Thông tin kết nối cơ sở dữ liệu
$host = 'localhost';
$dbname = 'QAirline';
$username = 'root';
$password = '';

try {
    // Kết nối đến cơ sở dữ liệu bằng PDO
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);

    // Cấu hình chế độ lỗi của PDO (hiển thị lỗi nếu có)
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    // Xử lý lỗi kết nối
    die("Kết nối cơ sở dữ liệu thất bại: " . $e->getMessage());
}
