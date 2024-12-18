<?php
// Import file kết nối cơ sở dữ liệu
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Lấy dữ liệu từ form
        $aircraftId = $_POST['aircraftId'] ?? '';
        $model = $_POST['model'] ?? '';
        $manufacturer = $_POST['manufacturer'] ?? '';
        $economySeats = $_POST['economy-seats'] ?? '';
        $businessSeats = $_POST['business-seats'] ?? '';
        $YearOfManufacture = $_POST['year'] ?? '';

        // Câu lệnh SQL sử dụng Prepared Statements để ngăn chặn SQL Injection
        $sql = "INSERT INTO Aircrafts (AircraftID, Model, Manufacturer, EconomySeat, BusinessSeat, YearOfManufacture) VALUES (:aircraftId, :model, :manufacturer, :economySeats, :businessSeats, :YearOfManufacture)";

        // Chuẩn bị truy vấn
        $stmt = $conn->prepare($sql);

        // Gán giá trị cho các tham số trong truy vấn
        $stmt->bindParam(':aircraftId', $aircraftId, PDO::PARAM_STR);
        $stmt->bindParam(':model', $model, PDO::PARAM_STR);
        $stmt->bindParam(':manufacturer', $manufacturer, PDO::PARAM_STR);
        $stmt->bindParam(':economySeats', $economySeats, PDO::PARAM_STR);
        $stmt->bindParam(':businessSeats', $businessSeats, PDO::PARAM_STR);
        $stmt->bindParam(':YearOfManufacture', $YearOfManufacture, PDO::PARAM_STR);

        // Thực thi truy vấn
        $stmt->execute();

        echo "Thêm dữ liệu thành công!";
        header("Location: admin.php#manage-aircraft");
    } catch (PDOException $e) {
        // Xử lý lỗi nếu truy vấn thất bại
        echo "Lỗi khi thêm dữ liệu: " . $e->getMessage();
    }
}
