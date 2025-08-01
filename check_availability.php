<?php
session_start();
date_default_timezone_set('Asia/Kuala_Lumpur');
include 'db.php';

header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'), true);
$checkIn = $data['checkIn'];
$checkOut = $data['checkOut'];
$availability = [];

try {
    $stmt = $conn->prepare("SELECT id_kolej, had_bilik FROM kolej");
    $stmt->execute();
    $colleges = $stmt->get_result();

    while ($college = $colleges->fetch_assoc()) {
        $stmt2 = $conn->prepare("
            SELECT COUNT(*) as booked_rooms 
            FROM tempahan_bilik 
            WHERE id_kolej = ? 
            AND status != 'cancelled'
            AND (
                (tarikh_mula BETWEEN ? AND ?) 
                OR (tarikh_tamat BETWEEN ? AND ?)
                OR (tarikh_mula <= ? AND tarikh_tamat >= ?)
            )
        ");
        
        $stmt2->bind_param("issssss", 
            $college['id_kolej'], 
            $checkIn, $checkOut, 
            $checkIn, $checkOut,
            $checkIn, $checkOut
        );
        
        $stmt2->execute();
        $result = $stmt2->get_result();
        $booked = $result->fetch_assoc();

        $available = $college['had_bilik'] - $booked['booked_rooms'];
        $availability[$college['id_kolej']] = max(0, $available);
    }

    echo json_encode($availability);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
} 
