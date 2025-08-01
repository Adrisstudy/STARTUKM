<?php
session_start();
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if ($data && isset($_SESSION['cart']['items'])) {
    foreach ($_SESSION['cart']['items'] as $key => $item) {
        if ($item['kolej_id'] == $data['kolej_id'] && $item['jenis'] == $data['jenis']) {
            unset($_SESSION['cart']['items'][$key]);
            $_SESSION['cart']['items'] = array_values($_SESSION['cart']['items']);
            break;
        }
    }
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid data or empty cart']);
} 
