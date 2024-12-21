<?php
include 'db_connection.php'; // Kết nối cơ sở dữ liệu

// Truy vấn lấy thống kê chuyến bay
$sql = "SELECT Flights.FlightNumber, Flights.DepartureCity, Flights.ArrivalCity, Flights.DepartureTime, COUNT(Tickets.TicketID) AS TotalTickets
        FROM Flights
        LEFT JOIN Tickets ON Flights.FlightID = Tickets.FlightID
        GROUP BY Flights.FlightID";

$sql_return = "SELECT Flights.FlightNumber, Flights.DepartureCity, Flights.ArrivalCity, Flights.DepartureTime, COUNT(Tickets.TicketID) AS TotalTickets
        FROM Flights
        LEFT JOIN Tickets ON Flights.FlightID = Tickets.ReturnFlightID
        GROUP BY Flights.FlightID";

$result = $conn->query($sql);
$result_return = $conn->query($sql_return);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $row_return = $result_return->fetch_assoc();
        $totalTickets = $row['TotalTickets'] + $row_return['TotalTickets'];
        echo "<tr>";
        echo "<td>" . $row['FlightNumber'] . "</td>";
        echo "<td>" . $row['DepartureCity'] . "</td>";
        echo "<td>" . $row['ArrivalCity'] . "</td>";
        echo "<td>" . $row['DepartureTime'] . "</td>";
        echo "<td>" . $totalTickets . "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='5'>Không có chuyến bay nào được tìm thấy</td></tr>";
}

$conn->close();
?>
