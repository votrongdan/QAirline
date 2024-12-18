<?php
// Import file kết nối cơ sở dữ liệu
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Lấy dữ liệu từ form
        $flightNumber = $_POST['flight-number'] ?? '';
        // $aircraftId = $_POST['aircraft-id'] ?? '';
        $departure = $_POST['departure'] ?? '';
        $arrival = $_POST['arrival'] ?? '';
        $departureTime = $_POST['departure-time'] ?? '';

        // Câu lệnh SQL sử dụng Prepared Statements để ngăn chặn SQL Injection
        $sql = "INSERT INTO Flights (FlightNumber, DepartureCity, ArrivalCity, DepartureTime) VALUES (:flightNumber, :departure, :arrival, :departureTime)";

        // Chuẩn bị truy vấn
        $stmt = $conn->prepare($sql);

        // Gán giá trị cho các tham số trong truy vấn
        $stmt->bindParam(':flightNumber', $flightNumber, PDO::PARAM_STR);
        $stmt->bindParam(':departure', $departure, PDO::PARAM_STR);
        $stmt->bindParam(':arrival', $arrival, PDO::PARAM_STR);
        $stmt->bindParam(':departureTime', $departureTime, PDO::PARAM_STR);
        // $stmt->bindParam(':aircraftId', $aircraftId, PDO::PARAM_STR);

        // Thực thi truy vấn
        $stmt->execute();

        echo "Thêm dữ liệu thành công!";
        header("Location: admin.php#manage-flights");
    } catch (PDOException $e) {
        // Xử lý lỗi nếu truy vấn thất bại
        echo "Lỗi khi thêm dữ liệu: " . $e->getMessage();
    }
}
