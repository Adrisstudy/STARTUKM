<?php
session_start();
include 'db.php';

$kolej_id = $_GET['kolej'] ?? '';
$jenis = $_GET['jenis'] ?? '';
$maxRooms = $_GET['max'] ?? 0;
$checkIn = $_GET['checkin'] ?? '';
$checkOut = $_GET['checkout'] ?? '';

if (empty($kolej_id) || empty($jenis) || empty($checkIn) || empty($checkOut) || $maxRooms == 0) {
    header('Location: lamanutama.php');
    exit();
}

// ssitem macam nak tarik maklumat kolej dari database
$stmt = $conn->prepare("SELECT * FROM kolej WHERE id_kolej = ?");
$stmt->bind_param("i", $kolej_id);
$stmt->execute();
$kolej = $stmt->get_result()->fetch_assoc();

// Kira malam menginap
$datetime1 = new DateTime($checkIn);
$datetime2 = new DateTime($checkOut);
$interval = $datetime1->diff($datetime2);
$nights = $interval->days;

// Kira harga
$pricePerNight = $kolej['harga_semalam'] ?? 20; // Default RM20 jika tiada
?>

<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Bilik - <?php echo $kolej['nama_kolej']; ?></title>
    <link rel="icon" type="image/png" href="haha.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        :root {
            --primary-color: #beae98;
            --primary-dark: #a89882;
            --primary-light: #f0e9e2;
            --secondary-color: #8b7355;
            --text-dark: #2c3e50;
            --text-light: #7a7a7a;
            --background-light: #faf7f2;
            --male-color: #3498db;
            --female-color: #e84393;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            color: var(--text-dark);
            margin: 0;
            padding: 0;
        }
        
        .booking-container {
            max-width: 800px;
            margin: 40px auto;
            padding: 0;
            background: transparent;
        }
        
        .booking-info {
            background: white;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
            margin-bottom: 30px;
            text-align: center;
        }
        
        .booking-info h1 {
            font-size: 2em;
            margin-bottom: 20px;
            color: var(--text-dark);
        }
        
        .booking-details {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            margin: 20px 0;
            padding: 15px;
            background: var(--background-light);
            border-radius: 15px;
        }
        
        .booking-detail {
            padding: 10px 20px;
            text-align: center;
        }
        
        .booking-detail span {
            display: block;
        }
        
        .detail-label {
            font-size: 0.9em;
            color: var(--text-light);
            margin-bottom: 5px;
        }
        
        .detail-value {
            font-size: 1.2em;
            font-weight: 600;
            color: var(--primary-dark);
        }
        
        .room-selector {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
            text-align: center;
        }
        
        .room-selector h2 {
            font-size: 1.8em;
            margin-bottom: 30px;
            color: <?php echo $jenis == 'lelaki' ? 'var(--male-color)' : 'var(--female-color)'; ?>;
        }
        
        .room-type-icon {
            font-size: 2.5em;
            margin-bottom: 20px;
            color: <?php echo $jenis == 'lelaki' ? 'var(--male-color)' : 'var(--female-color)'; ?>;
        }
        
        .room-counter {
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 40px 0;
        }
        
        .counter-btn {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            border: none;
            background: <?php echo $jenis == 'lelaki' ? 'var(--male-color)' : 'var(--female-color)'; ?>;
            color: white;
            font-size: 1.5em;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .counter-btn:hover {
            transform: scale(1.1);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .counter-btn:disabled {
            background: #ccc;
            cursor: not-allowed;
            transform: scale(1);
            box-shadow: none;
        }
        
        .room-count {
            font-size: 2.5em;
            font-weight: 600;
            margin: 0 30px;
            color: var(--text-dark);
            min-width: 60px;
        }
        
        .price-summary {
            margin: 30px 0;
            padding: 20px;
            background: var(--background-light);
            border-radius: 15px;
        }
        
        .price-row {
            display: flex;
            justify-content: space-between;
            margin: 10px 0;
            font-size: 1.1em;
        }
        
        .price-total {
            font-size: 1.3em;
            font-weight: 600;
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid #ddd;
        }
        
        .action-buttons {
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin-top: 40px;
        }
        
        .proceed-btn, .back-btn {
            padding: 15px 25px;
            border-radius: 30px;
            border: none;
            font-size: 1.1em;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        
        .proceed-btn {
            background: <?php echo $jenis == 'lelaki' ? 'var(--male-color)' : 'var(--female-color)'; ?>;
            color: white;
        }
        
        .proceed-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px <?php echo $jenis == 'lelaki' ? 'rgba(52, 152, 219, 0.3)' : 'rgba(232, 67, 147, 0.3)'; ?>;
        }
        
        .back-btn {
            background: transparent;
            color: var(--text-light);
            border: 1px solid #ddd;
        }
        
        .back-btn:hover {
            background: #f5f5f5;
        }
        
        @media (max-width: 768px) {
            .booking-container {
                padding: 20px;
            }
            
            .booking-details {
                flex-direction: column;
            }
            
            .booking-detail {
                margin: 5px 0;
            }
            
            .room-counter {
                flex-wrap: wrap;
            }
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="booking-container">
        <div class="booking-info">
            <h1><?php echo $kolej['nama_kolej']; ?></h1>
            
            <div class="booking-details">
                <div class="booking-detail">
                    <span class="detail-label">Tarikh Masuk</span>
                    <span class="detail-value"><?php echo date('d/m/Y', strtotime($checkIn)); ?></span>
                </div>
                
                <div class="booking-detail">
                    <span class="detail-label">Tarikh Keluar</span>
                    <span class="detail-value"><?php echo date('d/m/Y', strtotime($checkOut)); ?></span>
                </div>
                
                <div class="booking-detail">
                    <span class="detail-label">Tempoh Menginap</span>
                    <span class="detail-value"><?php echo $nights; ?> malam</span>
                </div>
            </div>
        </div>
        
        <div class="room-selector">
            <div class="room-type-icon">
                <i class="fas fa-<?php echo $jenis == 'lelaki' ? 'male' : 'female'; ?>"></i>
            </div>
            
            <h2>Bilik <?php echo $jenis == 'lelaki' ? 'Lelaki' : 'Perempuan'; ?></h2>
            
            <p>Sila pilih jumlah bilik yang diperlukan</p>
            
            <div class="room-counter">
                <button class="counter-btn" onclick="updateRooms(-1)" id="decreaseBtn">
                    <i class="fas fa-minus"></i>
                </button>
                <span class="room-count" id="roomCount">1</span>
                <button class="counter-btn" onclick="updateRooms(1)" id="increaseBtn">
                    <i class="fas fa-plus"></i>
                </button>
            </div>
            
            <div class="price-summary">
                <div class="price-row">
                    <span>Harga per malam</span>
                    <span>RM<?php echo number_format($pricePerNight, 2); ?></span>
                </div>
                
                <div class="price-row">
                    <span>Bilik</span>
                    <span id="roomCountText">1 x RM<?php echo number_format($pricePerNight, 2); ?></span>
                </div>
                
                <div class="price-row">
                    <span>Tempoh</span>
                    <span><?php echo $nights; ?> malam</span>
                </div>
                
                <div class="price-row price-total">
                    <span>Jumlah</span>
                    <span id="totalPrice">RM<?php echo number_format($pricePerNight * $nights, 2); ?></span>
                </div>
            </div>
            
            <div class="action-buttons">
                <button class="proceed-btn" onclick="proceedToPayment()">
                    <i class="fas fa-credit-card"></i>
                    Teruskan ke Pembayaran
                </button>
                
                <button class="back-btn" onclick="goBack()">
                    <i class="fas fa-arrow-left"></i>
                    Kembali
                </button>
            </div>
        </div>
    </div>

    <script>
    let currentRooms = 1;
    const maxRooms = <?php echo $maxRooms; ?>;
    const pricePerNight = <?php echo $pricePerNight; ?>;
    const nights = <?php echo $nights; ?>;
    
    function updateRooms(change) {
        const newCount = currentRooms + change;
        if (newCount >= 1 && newCount <= maxRooms) {
            currentRooms = newCount;
            document.getElementById('roomCount').textContent = currentRooms;
            document.getElementById('roomCountText').textContent = 
                currentRooms + " x RM" + pricePerNight.toFixed(2);
            document.getElementById('totalPrice').textContent = 
                "RM" + (currentRooms * pricePerNight * nights).toFixed(2);
            
            document.getElementById('decreaseBtn').disabled = currentRooms === 1;
            document.getElementById('increaseBtn').disabled = currentRooms === maxRooms;
        }
    }
    
    function proceedToPayment() {
        const params = new URLSearchParams({
            kolej: <?php echo $kolej_id; ?>,
            jenis: '<?php echo $jenis; ?>',
            bilik: currentRooms,
            checkin: '<?php echo $checkIn; ?>',
            checkout: '<?php echo $checkOut; ?>'
        });
        window.location.href = `payment.php?${params.toString()}`;
    }
    
    function goBack() {
        window.location.href = 'booking.php?checkin=<?php echo $checkIn; ?>&checkout=<?php echo $checkOut; ?>';
    }
    
    // Initialize buttons state
    document.getElementById('decreaseBtn').disabled = true;
    document.getElementById('increaseBtn').disabled = maxRooms === 1;
    </script>
</body>
<head>
  <link rel="icon" type="image/png" href="hihi.png">
</head>
</html> 