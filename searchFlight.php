<?php
require 'db.php';

try {
    // Lấy dữ liệu từ form
    $departureCity = $_GET['departure'];
    $arrivalCity = $_GET['destination'];
    $departureDate = $_GET['departure-date'];
    $returnDate = $_GET['return-date']; // Ngày về (có thể không có)
    $passengers = $_GET['passengers'];

    // Tạo câu truy vấn cho vé một chiều
    $sql_one_way = "SELECT FlightID, FlightNumber, DepartureCity, ArrivalCity, DepartureTime, AircraftID 
                    FROM Flights 
                    WHERE DepartureCity LIKE :departureCity 
                    AND ArrivalCity LIKE :arrivalCity
                    AND DATE(DepartureTime) = :departureDate";

    // Chuẩn bị truy vấn vé một chiều
    $stmt_one_way = $conn->prepare($sql_one_way);
    $stmt_one_way->bindValue(':departureCity', "%$departureCity%", PDO::PARAM_STR);
    $stmt_one_way->bindValue(':arrivalCity', "%$arrivalCity%", PDO::PARAM_STR);
    $stmt_one_way->bindValue(':departureDate', $departureDate, PDO::PARAM_STR);

    // Thực thi truy vấn vé một chiều
    $stmt_one_way->execute();
    $flights_one_way = $stmt_one_way->fetchAll(PDO::FETCH_ASSOC);

    // Nếu người dùng chọn vé khứ hồi, thêm truy vấn tìm chuyến về
    $flights_return = [];
    if (!empty($returnDate)) {
        $sql_return = "SELECT FlightID, FlightNumber, DepartureCity, ArrivalCity, DepartureTime, AircraftID 
                       FROM Flights 
                       WHERE DepartureCity LIKE :arrivalCity 
                       AND ArrivalCity LIKE :departureCity 
                       AND DATE(DepartureTime) = :returnDate";

        $stmt_return = $conn->prepare($sql_return);
        $stmt_return->bindValue(':arrivalCity', "%$arrivalCity%", PDO::PARAM_STR);
        $stmt_return->bindValue(':departureCity', "%$departureCity%", PDO::PARAM_STR);
        $stmt_return->bindValue(':returnDate', $returnDate, PDO::PARAM_STR);

        // Thực thi truy vấn vé khứ hồi
        $stmt_return->execute();
        $flights_return = $stmt_return->fetchAll(PDO::FETCH_ASSOC);
    }

    // Chuyển dữ liệu sang file HTML
    include 'flight.html';
} catch (PDOException $e) {
    echo "Lỗi kết nối: " . $e->getMessage();
}
?>
