<?php
date_default_timezone_set('Asia/Kuala_Lumpur');
session_start();
include 'db.php';
require_once __DIR__ . '/phpmailer/PHPMailer.php';
require_once __DIR__ . '/phpmailer/SMTP.php';
require_once __DIR__ . '/phpmailer/Exception.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if (!isset($_SESSION['cart']) || empty($_SESSION['cart']['items'])) {
    header('Location: booking.php');
    exit();
}

try {
    $conn->begin_transaction();
    $bookingRef = 'BK' . date('Ymd') . rand(1000, 9999);

    $stmt = $conn->prepare("SELECT fld_user_name as name, fld_user_email as email, fld_user_phone as phone FROM user WHERE fld_user_id = ?");
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
    $userResult = $stmt->get_result();
    $userData = $userResult->fetch_assoc();

    foreach ($_SESSION['cart']['items'] as $item) {
        $stmt = $conn->prepare("INSERT INTO tempahan_bilik2 (
            id_kolej,
            tarikh_mula,
            tarikh_tamat,
            status,
            payment_status,
            total_amount,
            bilik_lelaki,
            bilik_perempuan,
            booking_ref,
            user_id
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $status = 'confirmed';
        $paymentStatus = $_POST['payment_method'] === 'card' ? 'paid' : 'pending';
        $maleBilik = $item['jenis'] == 'male' ? $item['bilik'] : 0;
        $femaleBilik = $item['jenis'] == 'female' ? $item['bilik'] : 0;
        
        // cara kira total malam
        $itemTotal = $item['bilik'] * $item['harga'] * $_SESSION['cart']['nights'];

        $stmt->bind_param(
            "issssdiiis",
            $item['kolej_id'],
            $_SESSION['cart']['checkin'],
            $_SESSION['cart']['checkout'],
            $status,
            $paymentStatus,
            $itemTotal, 
            $maleBilik,
            $femaleBilik,
            $bookingRef,
            $_SESSION['user_id']
        );

        $stmt->execute();
    }

    $message = '
    <html>
    <head>
        <style>
            body { 
                font-family: Arial, sans-serif;
                line-height: 1.6;
                color: #333;
            }
            .invoice-container { 
                max-width: 800px; 
                margin: 0 auto;
                padding: 20px;
            }
            .invoice-header {
                text-align: center;
                margin-bottom: 30px;
                padding-bottom: 20px;
                border-bottom: 2px solid #beae98;
            }
            .invoice-title {
                font-size: 24px;
                color: #2e7d32;
                margin: 10px 0;
            }
            .invoice-details {
                margin: 20px 0;
                padding: 20px;
                background: #f8f9fa;
                border-radius: 5px;
            }
            .customer-info {
                margin-bottom: 20px;
            }
            .invoice-table {
                width: 100%;
                border-collapse: collapse;
                margin: 20px 0;
            }
            .invoice-table th, .invoice-table td {
                padding: 12px;
                text-align: left;
                border-bottom: 1px solid #ddd;
            }
            .invoice-table th {
                background: #f1f8e9;
                color: #2e7d32;
            }
            .total-section {
                margin-top: 20px;
                padding: 15px;
                background: #f1f8e9;
                border-radius: 5px;
                text-align: right;
            }
            .payment-note {
                margin-top: 20px;
                padding: 15px;
                background: #fff3e0;
                border: 1px solid #ffe0b2;
                border-radius: 5px;
                color: #e65100;
            }
            .footer {
                margin-top: 30px;
                padding-top: 20px;
                border-top: 1px solid #ddd;
                text-align: center;
                color: #666;
            }
            @media print {
                body {
                    background: white;
                }
                .invoice-container {
                    margin: 0;
                    padding: 0;
                }
            }
        </style>
    </head>
    <body>
        <div class="invoice-container">
            <div class="invoice-header">
                <h1 style="color: #beae98; margin: 0;">STARTUKM</h1>
                <div class="invoice-title">INVOIS TEMPAHAN</div>
                <div>No. Invois: ' . $bookingRef . '</div>
                <div>Tarikh: ' . date('d/m/Y') . '</div>
            </div>

            <div class="customer-info">
                <h3 style="color: #2e7d32;">MAKLUMAT PELANGGAN</h3>
                <p><strong>Nama:</strong> ' . htmlspecialchars($userData['name']) . '<br>
                <strong>Email:</strong> ' . htmlspecialchars($userData['email']) . '<br>
                <strong>No. Telefon:</strong> ' . htmlspecialchars($userData['phone']) . '</p>
            </div>

            <div class="invoice-details">
                <h3 style="color: #2e7d32;">MAKLUMAT TEMPAHAN</h3>
                <p><strong>Tarikh Check-in:</strong> ' . date('d/m/Y', strtotime($_SESSION['cart']['checkin'])) . '<br>
                <strong>Tarikh Check-out:</strong> ' . date('d/m/Y', strtotime($_SESSION['cart']['checkout'])) . '<br>
                <strong>Tempoh Menginap:</strong> ' . $_SESSION['cart']['nights'] . ' malam</p>
            </div>

            <table class="invoice-table">
                <thead>
                    <tr>
                        <th>Kolej</th>
                        <th>Jenis Bilik</th>
                        <th>Jumlah Bilik</th>
                        <th>Harga/Malam</th>
                        <th>Tempoh</th>
                        <th>Jumlah (RM)</th>
                    </tr>
                </thead>
                <tbody>';

    $grandTotal = 0;
    foreach ($_SESSION['cart']['items'] as $item) {
        $itemTotal = $item['bilik'] * $item['harga'] * $_SESSION['cart']['nights'];
        $grandTotal += $itemTotal;
        
        $message .= '
                    <tr>
                        <td>' . htmlspecialchars($item['kolej_name']) . '</td>
                        <td>' . ($item['jenis'] == 'male' ? 'Bilik Lelaki' : 'Bilik Perempuan') . '</td>
                        <td>' . $item['bilik'] . '</td>
                        <td>RM' . number_format($item['harga'], 2) . '</td>
                        <td>' . $_SESSION['cart']['nights'] . ' malam</td>
                        <td>RM' . number_format($itemTotal, 2) . '</td>
                    </tr>';
    }

    $message .= '
                </tbody>
            </table>

            <div class="total-section">
                <h3 style="margin: 0;">JUMLAH BAYARAN: RM' . number_format($grandTotal, 2) . '</h3>
                <p style="margin: 5px 0;">Status Pembayaran: <strong>' . ($_POST['payment_method'] === 'card' ? 'DIBAYAR' : 'BELUM DIBAYAR') . '</strong></p>
            </div>';

    if ($_POST['payment_method'] === 'counter') {
        $message .= '
            <div class="payment-note">
                <strong>NOTA PENTING:</strong><br>
                Sila bawa invois ini ke kaunter untuk membuat pembayaran.<br>
                Nombor Rujukan: ' . $bookingRef . '
            </div>';
    }

    $message .= '
            <div class="footer">
                <p>STARTUKM<br>
                Universiti Kebangsaan Malaysia<br>
                43600 UKM Bangi, Selangor<br>
                Tel: 03-8921 5555</p>
                <p>Ini adalah invois yang dijana oleh komputer dan tidak memerlukan tandatangan.</p>
            </div>
        </div>
    </body>
    </html>';

    $_SESSION['invoice_html'] = $message;

    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'adrisroslan@gmail.com'; 
        $mail->Password = 'adrisroslan';    
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        $mail->CharSet = 'UTF-8';

        $mail->setFrom('adrisroslan@gmail.com', 'STARTUKM');
        $mail->addAddress($userData['email']);
        $mail->isHTML(true);
        $mail->Subject = 'Invois Tempahan - STARTUKM';
        $mail->Body    = $message;

        $mailSent = $mail->send();
    } catch (Exception $e) {
        $mailSent = false;
        error_log('Mailer Error: ' . $mail->ErrorInfo);
    }

    unset($_SESSION['cart']);

    $conn->commit();

    ?>
    <!DOCTYPE html>
    <html lang="ms">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Tempahan Berjaya - STARTUKM</title>
        <link rel="icon" type="image/png" href="haha.png">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        <style>
            body {
                font-family: 'Roboto', sans-serif;
                background-color: #f5f5f5;
                margin: 0;
                padding: 20px;
            }
            .success-card {
                max-width: 800px;
                margin: 40px auto;
                background: white;
                padding: 30px;
                border-radius: 10px;
                box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            }
            .success-icon {
                color: #4CAF50;
                font-size: 48px;
                margin-bottom: 20px;
                text-align: center;
            }
            h1 {
                color: #2e7d32;
                margin-bottom: 20px;
                text-align: center;
            }
            .button-container {
                display: flex;
                justify-content: center;
                align-items: center;
                gap: 20px;
                margin: 40px 0 20px;
                padding: 0 20px;
            }
            .print-button, .back-button {
                min-width: 200px;
                padding: 15px 30px;
                border-radius: 50px;
                font-size: 16px;
                font-weight: 500;
                text-align: center;
                text-decoration: none;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: 10px;
                transition: all 0.3s ease;
                text-transform: uppercase;
                letter-spacing: 0.5px;
                border: none;
                cursor: pointer;
                box-shadow: 0 3px 6px rgba(0,0,0,0.1);
            }
            .print-button {
                background: linear-gradient(145deg, #4CAF50, #45a049);
                color: white;
            }
            .print-button:hover {
                background: linear-gradient(145deg, #45a049, #3d8b40);
                transform: translateY(-2px);
                box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            }
            .back-button {
                background: linear-gradient(145deg, #757575, #616161);
                color: white;
            }
            .back-button:hover {
                background: linear-gradient(145deg, #616161, #515151);
                transform: translateY(-2px);
                box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            }
            .print-button i, .back-button i {
                font-size: 18px;
            }
            @media (max-width: 600px) {
                .button-container {
                    flex-direction: column;
                    gap: 15px;
                }
                .print-button, .back-button {
                    width: 100%;
                    max-width: 300px;
                }
            }
            @media print {
                .print-button, .back-button, .button-container, .success-icon, header {
                    display: none !important;
                }
                body {
                    background: white;
                }
                .success-card {
                    box-shadow: none;
                    margin: 0;
                    padding: 0;
                }
            }
        </style>
    </head>
    <body>
        <?php include 'header.php'; ?>
        
        <div class="success-card">
            <div class="success-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <h1>Tempahan Berjaya!</h1>
            
            <?php echo $_SESSION['invoice_html']; ?>
            
            <?php if ($mailSent): ?>
            <div style="text-align: center; margin: 20px 0; padding: 10px; background: #e8f5e9; color: #2e7d32; border-radius: 5px;">
                <i class="fas fa-envelope"></i> Satu salinan invois telah dihantar ke <?php echo htmlspecialchars($userData['email']); ?>
            </div>
            <?php else: ?>
            <div style="text-align: center; margin: 20px 0; padding: 10px; background: #fff3e0; color: #e65100; border-radius: 5px;">
                <i class="fa-solid fa-floppy-disk"></i>
                </i> Cetak atau simpan invois ini sebagai bukti tempahan.
            </div>
            <?php endif; ?>
            
            <div class="button-container">
                <button onclick="window.print()" class="print-button">
                    <i class="fas fa-print"></i>
                    <span>Cetak Invois</span>
                </button>
                <a href="lamanutama.php" class="back-button">
                    <i class="fas fa-home"></i>
                    <span>Kembali ke Laman Utama</span>
                </a>
            </div>
        </div>
    </body>
    </html>
    <?php

} catch (Exception $e) {
    $conn->rollback();
    die("Maaf, tempahan anda gagal: " . $e->getMessage());
}
