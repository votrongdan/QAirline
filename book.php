<?php
require 'db.php';

function validateInput($data) {
    if (empty($data['name']) || empty($data['phone']) || 
        empty($data['email']) || empty($data['dob']) || 
        empty($data['flight_id'])) {
        throw new Exception('All required fields must be filled.');
    }
    return $data;
}

function parseFlightData($flight_id, $return_flight_id = null) {
    [$selected_flight_id, $class] = explode('_', $flight_id);
    $return_data = [null, null];
    
    if ($return_flight_id) {
        $return_data = explode('_', $return_flight_id);
    }
    
    return [
        'flight_id' => $selected_flight_id,
        'class' => $class,
        'return_flight_id' => $return_data[0],
        'return_class' => $return_data[1]
    ];
}

function getOrCreatePassenger($conn, $data) {
    $stmt = $conn->prepare("SELECT PassengerID FROM Passengers 
                           WHERE FullName = :name 
                           AND PhoneNumber = :phone 
                           AND Email = :email");
    
    $stmt->execute([
        ':name' => $data['name'],
        ':phone' => $data['phone'],
        ':email' => $data['email']
    ]);

    if ($passenger = $stmt->fetch(PDO::FETCH_ASSOC)) {
        return $passenger['PassengerID'];
    }

    $stmt = $conn->prepare("INSERT INTO Passengers 
                           (FullName, PhoneNumber, Email, DateOfBirth) 
                           VALUES (:name, :phone, :email, :dob)");
    
    $stmt->execute([
        ':name' => $data['name'],
        ':phone' => $data['phone'],
        ':email' => $data['email'],
        ':dob' => $data['dob']
    ]);

    return $conn->lastInsertId();
}

function createTicket($conn, $passenger_id, $flight_data) {
    $stmt = $conn->prepare("INSERT INTO Tickets 
                           (PassengerID, FlightID, Class, 
                            ReturnFlightID, ReturnClass, BookingDate) 
                           VALUES (:passenger_id, :flight_id, :class, 
                                   :return_flight_id, :return_class, NOW())");
    
    $stmt->execute([
        ':passenger_id' => $passenger_id,
        ':flight_id' => $flight_data['flight_id'],
        ':class' => $flight_data['class'],
        ':return_flight_id' => $flight_data['return_flight_id'],
        ':return_class' => $flight_data['return_class']
    ]);
}

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header("Location: flight.html");
        exit();
    }

    $input = validateInput([
        'name' => $_POST['name'] ?? '',
        'phone' => $_POST['phone'] ?? '',
        'email' => $_POST['email'] ?? '',
        'dob' => $_POST['dob'] ?? '',
        'flight_id' => $_POST['flight_id'] ?? '',
        'return_flight_id' => $_POST['return_flight_id'] ?? null
    ]);

    $flight_data = parseFlightData($input['flight_id'], $input['return_flight_id']);
    
    $conn->beginTransaction();
    $passenger_id = getOrCreatePassenger($conn, $input);
    createTicket($conn, $passenger_id, $flight_data);
    $conn->commit();

    header("Location: booking.html");
    exit();

} catch (Exception $e) {
    if (isset($conn)) {
        $conn->rollBack();
    }
    echo "<p>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
}