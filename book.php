<?php
require 'db.php';

try {
    // Kiểm tra xem dữ liệu đã được gửi lên đầy đủ chưa
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = $_POST['name'] ?? '';
        $phone = $_POST['phone'] ?? '';
        $email = $_POST['email'] ?? '';
        $dob = $_POST['dob'] ?? '';
        $flight_id = $_POST['flight_id'] ?? '';
        $return_flight_id = $_POST['return_flight_id'] ?? null;

        // Kiểm tra các trường bắt buộc
        if (empty($name) || empty($phone) || empty($email) || empty($dob) || empty($flight_id)) {
            throw new Exception('Vui lòng điền đầy đủ thông tin bắt buộc.');
        }

        // Tách mã chuyến bay và hạng ghế từ flight_id
        [$selected_flight_id, $class] = explode('_', $flight_id);
        $selected_return_flight_id = null;
        $return_class = null;

        if ($return_flight_id) {
            [$selected_return_flight_id, $return_class] = explode('_', $return_flight_id);
        }

        // Thêm thông tin đặt vé vào cơ sở dữ liệu
        $sql_passengers = "INSERT INTO Passengers (FullName, PhoneNumber, Email, DateOfBirth) 
                VALUES (:name, :phone, :email, :dob)";

        $sql_tickets = "INSERT INTO Tickets (PassengerID, FlightID, Class, ReturnFlightID, ReturnClass, BookingDate) 
                VALUES (:passenger_id, :flight_id, :class, :return_flight_id, :return_class, NOW())";

        $stmt_passengers = $conn->prepare($sql_passengers);
        $stmt_passengers->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt_passengers->bindParam(':phone', $phone, PDO::PARAM_STR);
        $stmt_passengers->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt_passengers->bindParam(':dob', $dob, PDO::PARAM_STR);

        $stmt_passengers->execute();

        $passenger_id = $conn->lastInsertId();
        $booking_date = date_default_timezone_get();

        $stmt_tickets = $conn->prepare($sql_tickets);
        $stmt_tickets->bindParam(':passenger_id', $passenger_id, PDO::PARAM_INT);
        $stmt_tickets->bindParam(':flight_id', $selected_flight_id, PDO::PARAM_INT);
        $stmt_tickets->bindParam(':class', $class, PDO::PARAM_STR);
        $stmt_tickets->bindParam(':return_flight_id', $selected_return_flight_id, PDO::PARAM_INT);
        $stmt_tickets->bindParam(':return_class', $return_class, PDO::PARAM_STR);

        $stmt_tickets->execute();

        echo "<p>Đặt vé thành công! Chúng tôi sẽ liên hệ với bạn qua email hoặc số điện thoại đã cung cấp.</p>";
        header("Location: index.html");
    } else {
        echo "<p>Phương thức gửi dữ liệu không hợp lệ.</p>";
        header("Location: flight.html");
    }
} catch (Exception $e) {
    echo "<p>Đã xảy ra lỗi: " . htmlspecialchars($e->getMessage()) . "</p>";
}
?>
