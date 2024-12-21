<?php
require 'db.php';

// Khởi tạo biến
$message = "";
$tickets = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];

    if (empty($name) || empty($phone) || empty($email)) {
        $message = "Vui lòng điền đầy đủ thông tin.";
    } else {
        try {
            // Kiểm tra người dùng
            $sql_passenger = "SELECT PassengerID FROM Passengers WHERE FullName = :name AND PhoneNumber = :phone AND Email = :email";
            $stmt = $conn->prepare($sql_passenger);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':phone', $phone);
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $passengerID = $row['PassengerID'];

                // Kiểm tra vé
                $sql_tickets = "SELECT * FROM Tickets WHERE PassengerID = :passengerID";
                $stmt_tickets = $conn->prepare($sql_tickets);
                $stmt_tickets->bindParam(':passengerID', $passengerID, PDO::PARAM_INT);
                $stmt_tickets->execute();

                if ($stmt_tickets->rowCount() > 0) {
                    while ($ticket = $stmt_tickets->fetch(PDO::FETCH_ASSOC)) {
                        // Lấy thông tin chuyến bay
                        $flightId = $ticket['FlightID'];
                        $sql_flight = "SELECT FlightNumber, DepartureTime FROM Flights WHERE FlightID = :flightID";
                        $stmt_flight = $conn->prepare($sql_flight);
                        $stmt_flight->bindParam(':flightID', $flightId, PDO::PARAM_INT);
                        $stmt_flight->execute();
                        $flight = $stmt_flight->fetch(PDO::FETCH_ASSOC);

                        // Lấy thông tin chuyến khứ hồi
                        $returnFlightId = $ticket['ReturnFlightID'];
                        $sql_returnFlight = "SELECT FlightNumber, DepartureTime FROM Flights WHERE FlightID = :returnFlightID";
                        $stmt_returnFlight = $conn->prepare($sql_returnFlight);
                        $stmt_returnFlight->bindParam(':returnFlightID', $returnFlightId, PDO::PARAM_INT);
                        $stmt_returnFlight->execute();
                        $returnFlight = $stmt_returnFlight->fetch(PDO::FETCH_ASSOC);

                        $tickets[] = [
                            'BookingDate' => $ticket['BookingDate'],
                            'Class' => $ticket['Class'],
                            'FlightNumber' => $flight['FlightNumber'],
                            'FlightDateTime' => $flight['DepartureTime'],
                            'ReturnClass' => $ticket['ReturnClass'],
                            'ReturnFlightNumber' => $returnFlight['FlightNumber'] ?? 'Không có',
                            'ReturnFlightDateTime' => $returnFlight['DepartureTime'] ?? 'Không có'
                        ];
                    }
                } else {
                    $message = "Người dùng chưa đặt vé nào.";
                }
            } else {
                $message = "Không tìm thấy người dùng với thông tin đã nhập.";
            }
        } catch (PDOException $e) {
            $message = "Lỗi khi truy vấn cơ sở dữ liệu: " . $e->getMessage();
        }
    }
}
include 'lookup.html';
?>

