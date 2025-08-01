<?php

date_default_timezone_set('Asia/Kuala_Lumpur');
session_start();
include 'db.php';

header('Content-Type: application/json');

$kolej_id = $_POST['kolej_id'] ?? null;
$jenis = $_POST['jenis'] ?? null;
$bilik = $_POST['bilik'] ?? 0;
$checkIn = $_POST['checkin'] ?? null;
$checkOut = $_POST['checkout'] ?? null;

if (!$kolej_id || !$jenis || !$checkIn || !$checkOut) {
    echo json_encode(['error' => 'Missing parameters']);
    exit;
}

$sql = "SELECT 
    COALESCE(SUM(bilik_lelaki), 0) as booked_male,
    COALESCE(SUM(bilik_perempuan), 0) as booked_female
    FROM tempahan_bilik 
    WHERE id_kolej = ? 
    AND status != 'cancelled'
    AND ((tarikh_mula BETWEEN ? AND ?) 
    OR (tarikh_tamat BETWEEN ? AND ?)
    OR (tarikh_mula <= ? AND tarikh_tamat >= ?))";

$stmt = $conn->prepare($sql);
$stmt->bind_param("issssss", 
    $kolej_id, 
    $checkIn, $checkOut,
    $checkIn, $checkOut,
    $checkIn, $checkOut
);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();

// jumhlah blik
$sql_kolej = "SELECT had_bilik_lelaki, had_bilik_perempuan FROM kolej WHERE id_kolej = ?";
$stmt_kolej = $conn->prepare($sql_kolej);
$stmt_kolej->bind_param("i", $kolej_id);
$stmt_kolej->execute();
$kolej = $stmt_kolej->get_result()->fetch_assoc();

$available = [
    'lelaki' => $kolej['had_bilik_lelaki'] - $result['booked_male'],
    'perempuan' => $kolej['had_bilik_perempuan'] - $result['booked_female']
];

echo json_encode($available); 