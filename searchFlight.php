<?php
require 'db.php';
// Thông tin kết nối cơ sở dữ liệu
// $servername = "localhost"; // Địa chỉ server
// $username = "root";        // Tên người dùng cơ sở dữ liệu
// $password = "";            // Mật khẩu cơ sở dữ liệu
// $dbname = "skywings_db";   // Tên cơ sở dữ liệu

try {
//     // Tạo kết nối PDO
//     $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
//     // Thiết lập chế độ lỗi
//     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Lấy dữ liệu từ form
    $departureCity = $_GET['departure'] ?? '';
    $arrivalCity = $_GET['destination'] ?? '';
    $departureDate = $_GET['departure_date'] ?? '';
    $returnDate = $_GET['return_date'] ?? null; // Ngày về (có thể không có)
    $passengers = $_GET['passengers'] ?? '1';

    // Tạo câu truy vấn cho vé một chiều
    $sql_one_way = "SELECT FlightID, FlightNumber, DepartureCity, ArrivalCity, DepartureTime, AircraftID 
                    FROM Flights 
                    WHERE DepartureCity LIKE :departureCity 
                    AND ArrivalCity LIKE :arrivalCity
                    AND DATE_FORMAT(DepartureTime, '%Y-%m-%d') = :departureDate";

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
                       AND DATE_FORMAT(DepartureTime, '%Y-%m-%d') = :returnDate";

        $stmt_return = $conn->prepare($sql_return);
        $stmt_return->bindValue(':arrivalCity', "%$arrivalCity%", PDO::PARAM_STR);
        $stmt_return->bindValue(':departureCity', "%$departureCity%", PDO::PARAM_STR);
        $stmt_return->bindValue(':returnDate', $returnDate, PDO::PARAM_STR);

        // Thực thi truy vấn vé khứ hồi
        $stmt_return->execute();
        $flights_return = $stmt_return->fetchAll(PDO::FETCH_ASSOC);
    }

    // Hiển thị kết quả
    echo "<h1>Kết quả tìm kiếm:</h1>";

    // Hiển thị kết quả vé một chiều
    if (count($flights_one_way) > 0) {
        echo "<h2>Chuyến đi:</h2>";
        echo "<table border='1'>
                <tr>
                    <th>Mã chuyến bay</th>
                    <th>Số hiệu chuyến bay</th>
                    <th>Thành phố khởi hành</th>
                    <th>Điểm đến</th>
                    <th>Thời gian khởi hành</th>
                    <th>Mã máy bay</th>
                </tr>";
        foreach ($flights_one_way as $flight) {
            echo "<tr>
                    <td>" . htmlspecialchars($flight['FlightID']) . "</td>
                    <td>" . htmlspecialchars($flight['FlightNumber']) . "</td>
                    <td>" . htmlspecialchars($flight['DepartureCity']) . "</td>
                    <td>" . htmlspecialchars($flight['ArrivalCity']) . "</td>
                    <td>" . htmlspecialchars($flight['DepartureTime']) . "</td>
                    <td>" . htmlspecialchars($flight['AircraftID']) . "</td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>Không tìm thấy chuyến bay đi phù hợp.</p>";
    }

    // Hiển thị kết quả vé khứ hồi (nếu có)
    if (!empty($returnDate)) {
        if (count($flights_return) > 0) {
            echo "<h2>Chuyến về:</h2>";
            echo "<table border='1'>
                    <tr>
                        <th>Mã chuyến bay</th>
                        <th>Số hiệu chuyến bay</th>
                        <th>Thành phố khởi hành</th>
                        <th>Điểm đến</th>
                        <th>Thời gian khởi hành</th>
                        <th>Mã máy bay</th>
                    </tr>";
            foreach ($flights_return as $flight) {
                echo "<tr>
                        <td>" . htmlspecialchars($flight['FlightID']) . "</td>
                        <td>" . htmlspecialchars($flight['FlightNumber']) . "</td>
                        <td>" . htmlspecialchars($flight['DepartureCity']) . "</td>
                        <td>" . htmlspecialchars($flight['ArrivalCity']) . "</td>
                        <td>" . htmlspecialchars($flight['DepartureTime']) . "</td>
                        <td>" . htmlspecialchars($flight['AircraftID']) . "</td>
                      </tr>";
            }
            echo "</table>";
        } else {
            echo "<p>Không tìm thấy chuyến bay về phù hợp.</p>";
        }
    }

} catch (PDOException $e) {
    echo "Lỗi kết nối: " . $e->getMessage();
}
?>
