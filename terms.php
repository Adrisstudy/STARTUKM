<?php
date_default_timezone_set('Asia/Kuala_Lumpur');
session_start();
include 'db.php';

// semak troli dulu brooo
if (!isset($_SESSION['cart']) || empty($_SESSION['cart']['items'])) {
    header('Location: index.php');
    exit();
}


foreach ($_SESSION['cart']['items'] as $key => $item) {
    $stmt = $conn->prepare("SELECT nama_kolej FROM kolej WHERE id_kolej = ?");
    $stmt->bind_param("i", $item['kolej_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $kolej = $result->fetch_assoc();
    $_SESSION['cart']['items'][$key]['kolej_name'] = $kolej['nama_kolej'];
}

// kira balik mdalam troli
$totalAmount = 0;
foreach ($_SESSION['cart']['items'] as $item) {
    $totalAmount += ($item['bilik'] * $item['harga'] * $_SESSION['cart']['nights']);
}
$_SESSION['cart']['total'] = $totalAmount;

if (isset($_POST['agree'])) {
    header('Location: payment.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terma & Syarat - STARTUKM</title>
    <link rel="icon" type="image/png" href="haha.png">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }
        .terms-container {
            max-width: 800px;
            margin: 40px auto;
            padding: 20px;
        }

        .terms-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 30px;
        }

        .booking-summary {
            background: #f8f9fa;
            padding: 25px;
            border-radius: 12px;
            margin-bottom: 30px;
            border: 1px solid #e9ecef;
        }

        .booking-details {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin: 15px 0;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            border: 1px solid #e0e0e0;
        }

        .booking-details h3 {
            color: #2e7d32;
            margin: 0 0 10px 0;
        }

        .booking-details p {
            margin: 8px 0;
            line-height: 1.5;
        }

        .stay-info {
            margin: 20px 0;
            padding: 15px;
            background: #f1f8e9;
            border-radius: 8px;
            border: 1px solid #c5e1a5;
        }

        .stay-info p {
            margin: 5px 0;
            color: #2e7d32;
        }

        .total-amount {
            text-align: right;
            padding: 20px;
            background: #f1f8e9;
            border-radius: 8px;
            margin-top: 20px;
            border: 1px solid #c5e1a5;
        }

        .total-amount h3 {
            color: #2e7d32;
            font-size: 24px;
            margin: 0;
        }

        .terms-section {
            margin-bottom: 30px;
        }

        .terms-section h3 {
            color: #2e7d32;
            margin-bottom: 15px;
        }

        .terms-section ul {
            list-style-type: none;
            padding: 0;
        }

        .terms-section li {
            margin-bottom: 10px;
            padding-left: 20px;
            position: relative;
        }

        .terms-section li:before {
            content: "•";
            color: #2e7d32;
            position: absolute;
            left: 0;
        }

        .agreement-section {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }

        .checkbox-container {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .checkbox-container input[type="checkbox"] {
            margin-right: 10px;
        }

        .submit-button {
            background: #4CAF50;
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 8px;
            font-size: 16px;
            width: 100%;
            cursor: pointer;
            transition: background 0.3s;
        }

        .submit-button:disabled {
            background: #cccccc;
            cursor: not-allowed;
        }

        .submit-button:hover:not(:disabled) {
            background: #45a049;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="terms-container">
        <div class="terms-card">
            <h2>📋 Ringkasan Tempahan</h2>
            <div class="booking-summary">
                <?php foreach($_SESSION['cart']['items'] as $item): 
                    $itemTotal = $item['bilik'] * $item['harga'] * $_SESSION['cart']['nights'];
                ?>
                    <div class="booking-details">
                        <h3><?php echo $item['kolej_name']; ?></h3>
                        <p><?php echo $item['jenis'] == 'male' ? 'Bilik Lelaki' : 'Bilik Perempuan'; ?></p>
                        <p><?php echo $item['bilik']; ?> bilik × RM<?php echo number_format($item['harga'], 2); ?> × <?php echo $_SESSION['cart']['nights']; ?> malam</p>
                        <p>Jumlah: RM<?php echo number_format($itemTotal, 2); ?></p>
                    </div>
                <?php endforeach; ?>

                <div class="stay-info">
                    <p>Tempoh Menginap: <?php echo $_SESSION['cart']['nights']; ?> malam</p>
                    <p>Jumlah Bilik: <?php echo $_SESSION['cart']['total_rooms']; ?></p>
                </div>

                <div class="total-amount">
                    <h3>Jumlah Bayaran: RM<?php echo number_format($_SESSION['cart']['total'], 2); ?></h3>
                </div>
            </div>

            <div class="terms-section">
                <h3>🕰 Waktu Daftar Masuk & Keluar</h3>
                <ul>
                    <li>Waktu daftar masuk: 3:00 PM - 10:00 PM</li>
                    <li>Waktu daftar keluar: 9:00 AM - 12:00 PM</li>
                </ul>
            </div>

            <div class="terms-section">
                <h3>💰 Polisi Pembayaran</h3>
                <ul>
                    <li>Pembayaran boleh dibuat melalui kad kredit/debit atau tunai di kaunter</li>
                    <li>Deposit keselamatan RM50 diperlukan semasa daftar masuk per bilik</li>
                </ul>
            </div>

            <div class="terms-section">
                <h3>❌ Polisi Pembatalan</h3>
                <ul>
                    <li>Pembatalan percuma 48 jam sebelum tarikh daftar masuk (maklumkan kepada staf kolej)</li>
                    <li>Tiada bayaran balik untuk pembatalan kurang 24 jam</li>
                </ul>
            </div>

            <div class="terms-section">
                <h3>⚠️ Peraturan Am</h3>
                <ul>
                    <li>Dilarang sesama sekali merokok di dalam bilik</li>
                    <li>Dilarang sesama sekali alihkan perabot di dalam bilik</li>
                    <li>Tetamu bertanggungjawab atas sebarang kerosakan</li>
                    <li>Kunci pintu dan tingkap semasa keluar dari bilik</li>
                </ul>
            </div>

            <form method="POST" class="agreement-section">
                <div class="checkbox-container">
                    <input type="checkbox" id="agree" name="agree" required>
                    <label for="agree">Saya telah membaca dan bersetuju dengan terma dan syarat di atas</label>
                </div>
                <button type="submit" class="submit-button" id="submitBtn" disabled>
                    Teruskan ke Pembayaran
                </button>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('agree').addEventListener('change', function() {
            document.getElementById('submitBtn').disabled = !this.checked;
        });
    </script>
</body>
<head>
  <link rel="icon" type="image/png" href="hihi.png">
</head>
</html>