<?php
session_start();
if (empty($_GET['ref'])) {
    header('Location: index.php');
    exit;
}

$bookingRef = $_GET['ref'];
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

    <div class="success-container">
        <div class="success-card">
            <div class="success-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <h1>Tempahan Berjaya!</h1>
            <p class="booking-ref">Rujukan Tempahan: <?php echo $bookingRef; ?></p>
            <p class="success-message">
                Satu email pengesahan telah dihantar ke alamat email anda.
                Sila simpan rujukan tempahan untuk kegunaan masa hadapan.
            </p>

            <div class="action-buttons">
                <button onclick="generateInvoice('<?php echo $bookingRef; ?>')" class="action-btn invoice">
                    <i class="fas fa-file-invoice"></i>
                    Muat Turun Invois
                </button>
                <a href="index.php" class="action-btn home">
                    <i class="fas fa-home"></i>
                    Laman Utama
                </a>
            </div>
        </div>
    </div>

    <style>
    .success-container {
        max-width: 800px;
        margin: 50px auto;
        padding: 0 20px;
    }

    .success-card {
        background: white;
        border-radius: 15px;
        padding: 40px;
        text-align: center;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }

    .success-icon {
        font-size: 80px;
        color: #27ae60;
        margin-bottom: 20px;
    }

    .success-icon i {
        animation: scaleIn 0.5s ease;
    }

    .booking-ref {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        font-size: 1.2em;
        margin: 20px 0;
    }

    .success-message {
        color: #666;
        margin-bottom: 30px;
    }

    .action-buttons {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-top: 30px;
    }

    .action-btn {
        padding: 15px 30px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-size: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        text-decoration: none;
        transition: all 0.3s;
    }

    .action-btn.invoice {
        background: #e74c3c;
        color: white;
    }

    .action-btn.home {
        background: #3498db;
        color: white;
    }

    .action-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    @keyframes scaleIn {
        from { transform: scale(0); }
        to { transform: scale(1); }
    }

    @media (max-width: 768px) {
        .action-buttons {
            grid-template-columns: 1fr;
        }
    }
    </style>

    <script>
    function generateInvoice(bookingRef) {
        fetch('generate_invoice.php?ref=' + bookingRef)
        .then(response => response.blob())
        .then(blob => {
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'invoice-' + bookingRef + '.pdf';
            document.body.appendChild(a);
            a.click();
            window.URL.revokeObjectURL(url);
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Ralat menjana invois. Sila cuba lagi.');
        });
    }
    </script>
</body>
<head>
  <link rel="icon" type="image/png" href="hihi.png">
</head>
</html> 
