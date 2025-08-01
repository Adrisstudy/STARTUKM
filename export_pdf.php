<?php
session_start();
include 'db.php';

header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="Senarai_Tempahan_'.date('Y-m-d').'.csv"');
$output = fopen('php://output', 'w');
fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
fputcsv($output, array(
    'Rumah Tamu',
    'Penempah',
    'Tarikh Masuk',
    'Tarikh Keluar',
    'Bilik Lelaki',
    'Bilik Perempuan',
    'Jumlah (RM)',
    'Status',
    'Bayaran'
));
$where_clause = "";
if(isset($_GET['kolej']) && !empty($_GET['kolej'])) {
    $kolej_id = intval($_GET['kolej']);
    $where_clause = "WHERE tb.id_kolej = $kolej_id";
}

$sql = "SELECT tb.*, k.nama_kolej, u.fld_user_name 
        FROM tempahan_bilik2 tb 
        LEFT JOIN kolej k ON tb.id_kolej = k.id_kolej 
        LEFT JOIN user u ON tb.user_id = u.fld_user_id 
        $where_clause 
        ORDER BY tb.tarikh_mula DESC";
$result = $conn->query($sql);

// Add data rows
while($row = $result->fetch_assoc()) {
    fputcsv($output, array(
        $row['nama_kolej'],
        $row['fld_user_name'],
        date('d/m/Y', strtotime($row['tarikh_mula'])),
        date('d/m/Y', strtotime($row['tarikh_tamat'])),
        $row['bilik_lelaki'],
        $row['bilik_perempuan'],
        number_format($row['total_amount'], 2),
        ucfirst($row['status']),
        ucfirst($row['payment_status'])
    ));
}

fclose($output);
?> 