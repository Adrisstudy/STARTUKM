<?php
session_start();
include 'db.php';

if (empty($_GET['ref'])) {
    header('Location: booking.php');
    exit;
}

$bookingRef = $_GET['ref'];
$stmt = $conn->prepare("
    SELECT tb.*, k.nama_kolej 
    FROM tempahan_bilik tb 
    JOIN kolej k ON tb.id_kolej = k.id_kolej 
    WHERE tb.booking_ref = ?
");
$stmt->bind_param("s", $bookingRef);
$stmt->execute();
$booking = $stmt->get_result()->fetch_assoc();

if (!$booking) {
    header('Location: booking.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tempahan Berjaya - STARTUKM</title>
    <link rel="icon" type="image/png" href="haha.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="main-container">
        <div class="success-card">
            <div class="success-header">
                <i class="fas fa-check-circle"></i>
                <h1>Tempahan Berjaya!</h1>
                <p>Rujukan Tempahan: <?php echo $bookingRef; ?></p>
            </div>

            <div class="booking-details">
                <h2>Maklumat Tempahan</h2>
                <div class="details-grid">
                    <div class="detail-item">
                        <span class="label">Tarikh Check-in</span>
                        <span class="value"><?php echo date('d/m/Y', strtotime($booking['tarikh_mula'])); ?></span>
                    </div>
                    <div class="detail-item">
                        <span class="label">Tarikh Check-out</span>
                        <span class="value"><?php echo date('d/m/Y', strtotime($booking['tarikh_tamat'])); ?></span>
                    </div>
                    <div class="detail-item">
                        <span class="label">Status Pembayaran</span>
                        <span class="value <?php echo $booking['payment_status']; ?>">
                            <?php echo $booking['payment_status'] === 'paid' ? 'Telah Dibayar' : 'Bayar di Kaunter'; ?>
                        </span>
                    </div>
                </div>

                <div class="action-buttons">
                    <button onclick="generatePDF()" class="action-btn pdf">
                        <i class="fas fa-file-pdf"></i>
                        Muat Turun PDF
                    </button>
                    <button onclick="sendEmail()" class="action-btn email">
                        <i class="fas fa-envelope"></i>
                        Hantar ke Email
                    </button>
                </div>
            </div>
        </div>
    </div>

    <style>
    .main-container {
        max-width: 800px;
        margin: 40px auto;
        padding: 0 20px;
    }

    .success-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        overflow: hidden;
    }

    .success-header {
        background: linear-gradient(135deg, #27ae60 0%, #2ecc71 100%);
        color: white;
        padding: 40px;
        text-align: center;
    }

    .success-header i {
        font-size: 64px;
        margin-bottom: 20px;
    }

    .success-header h1 {
        margin: 0;
        font-size: 28px;
    }

    .success-header p {
        margin: 10px 0 0;
        opacity: 0.9;
    }

    .booking-details {
        padding: 30px;
    }

    .details-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin: 20px 0;
    }

    .detail-item {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 10px;
    }

    .detail-item .label {
        display: block;
        color: #666;
        font-size: 0.9em;
        margin-bottom: 5px;
    }

    .detail-item .value {
        font-size: 1.1em;
        font-weight: 600;
        color: #2c3e50;
    }

    .action-buttons {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
        margin-top: 30px;
    }

    .action-btn {
        padding: 15px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        font-size: 16px;
        transition: all 0.3s;
    }

    .action-btn.pdf {
        background: #e74c3c;
        color: white;
    }

    .action-btn.email {
        background: #3498db;
        color: white;
    }

    .action-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    @media (max-width: 768px) {
        .action-buttons {
            grid-template-columns: 1fr;
        }
    }
    </style>

    <script>
    function generatePDF() {
        fetch('generate_pdf.php?ref=<?php echo $bookingRef; ?>')
        .then(response => response.blob())
        .then(blob => {
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'tempahan-<?php echo $bookingRef; ?>.pdf';
            document.body.appendChild(a);
            a.click();
            window.URL.revokeObjectURL(url);
        });
    }

    function sendEmail() {
        fetch('send_email.php?ref=<?php echo $bookingRef; ?>')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Email telah dihantar!');
            } else {
                alert('Ralat menghantar email: ' + data.error);
            }
        });
    }
    </script>
</body>
</html> 