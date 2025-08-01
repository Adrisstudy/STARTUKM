<?php
session_start();
include 'db.php';
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename="Senarai_Tempahan_'.date('Y-m-d').'.xls"');
echo '
<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!--[if gte mso 9]>
    <xml>
        <x:ExcelWorkbook>
            <x:ExcelWorksheets>
                <x:ExcelWorksheet>
                    <x:Name>Senarai Tempahan</x:Name>
                    <x:WorksheetOptions>
                        <x:DisplayGridlines/>
                    </x:WorksheetOptions>
                </x:ExcelWorksheet>
            </x:ExcelWorksheets>
        </x:ExcelWorkbook>
    </xml>
    <![endif]-->
    <style>
        td { border: 0.5pt solid #000000; }
        th { 
            border: 0.5pt solid #000000;
            background-color: #BEAE98;
            color: white;
            font-weight: bold;
        }
        .number { mso-number-format:"0.00"; }
    </style>
</head>
<body>
    <table>
        <tr>
            <th>Rumah Tamu</th>
            <th>Penempah</th>
            <th>Tarikh Masuk</th>
            <th>Tarikh Keluar</th>
            <th>Bilik Lelaki</th>
            <th>Bilik Perempuan</th>
            <th>Jumlah (RM)</th>
            <th>Status</th>
            <th>Bayaran</th>
        </tr>';

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

while($row = $result->fetch_assoc()) {
    echo '<tr>';
    echo '<td>' . htmlspecialchars($row['nama_kolej']) . '</td>';
    echo '<td>' . htmlspecialchars($row['fld_user_name']) . '</td>';
    echo '<td>' . date('d/m/Y', strtotime($row['tarikh_mula'])) . '</td>';
    echo '<td>' . date('d/m/Y', strtotime($row['tarikh_tamat'])) . '</td>';
    echo '<td style="text-align: center">' . $row['bilik_lelaki'] . '</td>';
    echo '<td style="text-align: center">' . $row['bilik_perempuan'] . '</td>';
    echo '<td class="number">' . number_format($row['total_amount'], 2) . '</td>';
    echo '<td>' . ucfirst($row['status']) . '</td>';
    echo '<td>' . ucfirst($row['payment_status']) . '</td>';
    echo '</tr>';
}

echo '</table></body></html>';
?> 