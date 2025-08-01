<?php
include 'db.php';
header('Content-Type: application/json');

if (!isset($_POST['id']) || !isset($_POST['status'])) {
    echo json_encode(['success' => false, 'msg' => 'Parameter tidak lengkap']);
    exit;
}

$id = intval($_POST['id']);
$status = ($_POST['status'] === 'paid') ? 'paid' : 'pending';

$stmt = $conn->prepare("UPDATE tempahan_bilik2 SET payment_status = ? WHERE id_tempahan = ?");
$stmt->bind_param('si', $status, $id);
$success = $stmt->execute();
$stmt->close();

if ($success) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'msg' => 'Gagal update database']);
} 