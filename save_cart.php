<?php
session_start();
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if ($data) {
    $_SESSION['cart'] = [
        'items' => $data['items'],
        'checkin' => $data['checkin'],
        'checkout' => $data['checkout'],
        'nights' => $data['nights']
    ];
    
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'No data received']);
} 