<?php
include 'db_connection.php'; // Kết nối cơ sở dữ liệu

// Truy vấn lấy thống kê chuyến bay
$sql = "SELECT *
        FROM Aircrafts";

$result = $conn->query($sql);

if ($result === false) {
    echo "Lỗi truy vấn: " . $conn->error;
}

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['AircraftID'] . "</td>";
        echo "<td>" . $row['Model'] . "</td>";
        echo "<td>" . $row['Manufacturer'] . "</td>";
        echo "<td>" . $row['YearOfManufacture'] . "</td>";
        echo "<td>" . $row['EconomySeat'] . "</td>";
        echo "<td>" . $row['BusinessSeat'] . "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='5'>Không có tàu bay nào được tìm thấy</td></tr>";
}

$conn->close();
?>
