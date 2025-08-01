<?php
include 'db.php';

header('Content-Type: application/json');

if (!isset($_POST['id']) || !isset($_POST['status'])) {
    echo json_encode(['success' => false, 'msg' => 'Parameter tidak lengkap']);
    exit;
}

$id = intval($_POST['id']);
$status = ($_POST['status'] === 'confirmed') ? 'confirmed' : 'cancelled';

$sql = "UPDATE tempahan_bilik2 SET status='$status' WHERE id_tempahan=$id";
if ($conn->query($sql)) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'msg' => $conn->error]);
} 