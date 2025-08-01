<?php
session_start();
date_default_timezone_set('Asia/Kuala_Lumpur');
include 'db.php';

if (!isset($_GET['ref'])) {
    header('Location: index.php');
    exit();
}

$bookingRef = $_GET['ref'];
$stmt = $conn->prepare("
    SELECT tb.*, k.nama_kolej, u.fld_user_name, u.fld_user_email, u.fld_user_phone
    FROM tempahan_bilik tb
    JOIN kolej k ON tb.id_kolej = k.id_kolej
    JOIN user u ON tb.user_id = u.fld_user_id
    WHERE tb.booking_ref = ?
");

$stmt->bind_param("s", $bookingRef);
$stmt->execute();
$result = $stmt->get_result();
$booking = $result->fetch_assoc();

if (!$booking) {
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - STARTUKM</title>
     <link rel="icon" type="image/png" href="haha.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .invoice-container {
            max-width: 800px;
            margin: 40px auto;
            padding: 40px;
            background: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            border-radius: 10px;
        }

        .invoice-header {
            text-align: center;
            margin-bottom: 40px;
            padding-bottom: 20px;
            border-bottom: 2px solid #eee;
        }

        .invoice-details {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-bottom: 40px;
        }

        .booking-details, .customer-details {
            padding: 20px;
            background: #f8f9fa;
            border-radius: 8px;
        }

        .booking-items {
            margin: 30px 0;
            border: 1px solid #eee;
            border-radius: 8px;
            padding: 20px;
        }

        .item-row {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }

        .item-header {
            font-weight: bold;
            background: #f8f9fa;
            padding: 10px;
            border-radius: 4px;
        }

        .total-section {
            text-align: right;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 2px solid #eee;
        }

        .action-buttons {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 40px;
        }

        .action-button {
            padding: 12px 24px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            transition: all 0.3s;
        }

        .print-button {
            background: #4CAF50;
            color: white;
        }

        .home-button {
            background: #2196F3;
            color: white;
        }

        .success-message {
            background: #e8f5e9;
            color: #2e7d32;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 30px;
            text-align: center;
        }

        @media print {
            .action-buttons {
                display: none;
            }
            .success-message {
                display: none;
            }
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="invoice-container">
        <div class="success-message">
            <i class="fas fa-check-circle"></i>
            Tempahan anda telah berjaya! Sila simpan invois ini untuk rujukan.
        </div>

        <div class="invoice-header">
            <h1>STARTUKM</h1>
            <h2>Invois Tempahan</h2>
            <p>No. Rujukan: <?php echo $booking['booking_ref']; ?></p>
            <p>Tarikh: <?php echo date('d/m/Y'); ?></p>
        </div>

        <div class="invoice-details">
            <div class="customer-details">
                <h3>Maklumat Pelanggan</h3>
                <p>Nama: <?php echo $booking['fld_user_name']; ?></p>
                <p>Email: <?php echo $booking['fld_user_email']; ?></p>
                <p>No. Telefon: <?php echo $booking['fld_user_phone']; ?></p>
            </div>

            <div class="booking-details">
                <h3>Maklumat Tempahan</h3>
                <p>Check In: <?php echo date('d/m/Y', strtotime($booking['tarikh_mula'])); ?></p>
                <p>Check Out: <?php echo date('d/m/Y', strtotime($booking['tarikh_tamat'])); ?></p>
                <p>Status Bayaran: <?php echo $booking['payment_status'] === 'paid' ? 'Telah Dibayar' : 'Belum Dibayar'; ?></p>
            </div>
        </div>

        <div class="booking-items">
            <div class="item-row item-header">
                <div>Kolej</div>
                <div>Jenis Bilik</div>
                <div>Jumlah Bilik</div>
                <div>Jumlah (RM)</div>
            </div>

            <div class="item-row">
                <div><?php echo $booking['nama_kolej']; ?></div>
                <div><?php echo $booking['bilik_lelaki'] > 0 ? 'Bilik Lelaki' : 'Bilik Perempuan'; ?></div>
                <div><?php echo $booking['bilik_lelaki'] + $booking['bilik_perempuan']; ?></div>
                <div>RM<?php echo number_format($booking['total_amount'], 2); ?></div>
            </div>

            <div class="total-section">
                <h3>Jumlah Bayaran: RM<?php echo number_format($booking['total_amount'], 2); ?></h3>
            </div>
        </div>

        <div class="action-buttons">
            <button onclick="window.print()" class="action-button print-button">
                <i class="fas fa-print"></i>
                Cetak Invois
            </button>
            <a href="index.php" class="action-button home-button">
                <i class="fas fa-home"></i>
                Laman Utama
            </a>
        </div>
    </div>
</body>
</html> 