<?php
date_default_timezone_set('Asia/Kuala_Lumpur');
session_start();
include 'db.php';

// Initialize cart if not exists
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [
        'items' => [],
        'total_rooms' => 0,
        'total' => 0
    ];
}

// Get dates from URL parameters
$checkin = isset($_GET['checkin']) ? $_GET['checkin'] : '';
$checkout = isset($_GET['checkout']) ? $_GET['checkout'] : '';

// Store dates in session
$_SESSION['cart']['checkin'] = $checkin;
$_SESSION['cart']['checkout'] = $checkout;

// Calculate nights
$nights = (strtotime($checkout) - strtotime($checkin)) / (60 * 60 * 24);
$_SESSION['cart']['nights'] = $nights;

// Handle room additions
if (isset($_POST['tambah'])) {
    $kolej_id = $_POST['kolej_id'];
    $room_type = $_POST['room_type'];
    $num_rooms = (int)$_POST['num_rooms'];
    
    // Get kolej details
    $stmt = $conn->prepare("SELECT nama_kolej, harga_semalam FROM kolej WHERE id_kolej = ?");
    $stmt->bind_param("i", $kolej_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $kolej = $result->fetch_assoc();

    // Add to cart
    $item_key = $kolej_id . '_' . $room_type;
    $_SESSION['cart']['items'][$item_key] = [
        'kolej_id' => $kolej_id,
        'kolej_name' => $kolej['nama_kolej'],
        'jenis' => $room_type,
        'bilik' => $num_rooms,
        'harga' => $kolej['harga_semalam']
    ];

    // Calculate cart totals
    $total_rooms = 0;
    $total_amount = 0;
    foreach($_SESSION['cart']['items'] as $item) {
        $total_rooms += $item['bilik'];
        // Calculate total including nights
        $total_amount += ($item['bilik'] * $item['harga'] * $_SESSION['cart']['nights']);
    }
    $_SESSION['cart']['total_rooms'] = $total_rooms;
    $_SESSION['cart']['total'] = $total_amount;

    // Update room availability in the database
    if ($room_type == 'male') {
        $update_sql = "UPDATE kolej SET had_bilik_lelaki = had_bilik_lelaki - ? WHERE id_kolej = ?";
    } else {
        $update_sql = "UPDATE kolej SET had_bilik_perempuan = had_bilik_perempuan - ? WHERE id_kolej = ?";
    }

    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("ii", $num_rooms, $kolej_id);
    $update_stmt->execute();
}

// Handle room removal
if (isset($_POST['remove'])) {
    $item_key = $_POST['item_key'];
    if (isset($_SESSION['cart']['items'][$item_key])) {
        // Dapatkan maklumat bilik yang dibuang
        $removed_item = $_SESSION['cart']['items'][$item_key];
        $kolej_id = $removed_item['kolej_id'];
        $room_type = $removed_item['jenis'];
        $num_rooms = $removed_item['bilik'];

        // Update availability dalam database
        if ($room_type == 'male') {
            $update_sql = "UPDATE kolej SET had_bilik_lelaki = had_bilik_lelaki + ? WHERE id_kolej = ?";
        } else {
            $update_sql = "UPDATE kolej SET had_bilik_perempuan = had_bilik_perempuan + ? WHERE id_kolej = ?";
        }
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("ii", $num_rooms, $kolej_id);
        $update_stmt->execute();

        // Buang bilik dari cart
        unset($_SESSION['cart']['items'][$item_key]);

        // Kira semula total_rooms dan total
        $total_rooms = 0;
        $total_amount = 0;
        foreach($_SESSION['cart']['items'] as $item) {
            $total_rooms += $item['bilik'];
            $total_amount += ($item['bilik'] * $item['harga'] * $_SESSION['cart']['nights']);
        }
        $_SESSION['cart']['total_rooms'] = $total_rooms;
        $_SESSION['cart']['total'] = $total_amount;
    }
}

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Check if dates are selected
if (empty($checkin) || empty($checkout)) {
    header('Location: lamanutama.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Bilik - STARTUKM</title>
    <link rel="icon" type="image/png" href="haha.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }
        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 0 20px;
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 30px;
        }

        .date-display {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 20px;
        }

        .college-list {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .college-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .college-header {
            background: #f8f9fa;
            padding: 15px 20px;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .college-name {
            font-size: 1.2em;
            font-weight: bold;
            color: #2c3e50;
        }

        .price-tag {
            background: #e8f5e9;
            color: #2e7d32;
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: 500;
        }

        .room-options {
            padding: 20px;
        }

        .room-type {
            display: grid;
            grid-template-columns: auto 1fr auto;
            align-items: center;
            gap: 20px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .gender-icon {
            font-size: 24px;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: #e3f2fd;
            color: #1976d2;
        }

        .gender-icon.female {
            background: #fce4ec;
            color: #c2185b;
        }

        .room-controls {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .room-controls button {
            border: none;
            padding: 8px 12px;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .control-btn {
            background: #f1f3f4;
            color: #5f6368;
        }

        .tambah-btn {
            background: #4CAF50;
            color: white;
        }

        .cart-summary {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            position: sticky;
            top: 20px;
            padding: 20px;
        }

        .cart-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #eee;
        }

        .cart-item {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 10px;
            position: relative;
        }

        .remove-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background: none;
            border: none;
            color: #dc3545;
            cursor: pointer;
            font-size: 1.2em;
        }

        .cart-total {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 2px solid #eee;
        }

        .continue-button {
            background: #4CAF50;
            color: white;
            border: none;
            padding: 15px;
            border-radius: 8px;
            width: 100%;
            font-size: 16px;
            cursor: pointer;
            margin-top: 20px;
            transition: background 0.3s;
        }

        .continue-button:hover {
            background: #45a049;
        }

        .empty-cart {
            text-align: center;
            padding: 30px;
            color: #666;
        }

        .availability {
            font-size: 0.9em;
            color: #666;
            margin-top: 5px;
        }

        .room-input {
            width: 60px;
            text-align: center;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 6px;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="container">
        <div class="main-content">
            <div class="date-display">
                <div>
                    <small>Check In</small>
                    <h3><?php echo date('d/m/Y', strtotime($checkin)); ?></h3>
                </div>
                <i class="fas fa-arrow-right"></i>
                <div>
                    <small>Check Out</small>
                    <h3><?php echo date('d/m/Y', strtotime($checkout)); ?></h3>
                </div>
                <div class="price-tag">
                    <?php echo $nights; ?> malam
                </div>
            </div>

            <div class="college-list">
                <?php
                $sql = "SELECT * FROM kolej ORDER BY id_kolej";
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()):
                ?>
                <div class="college-card">
                    <div class="college-header">
                        <div class="college-name"><?php echo $row['nama_kolej']; ?></div>
                        <div class="price-tag">RM<?php echo number_format($row['harga_semalam'], 2); ?> / malam</div>
                    </div>

                    <div class="room-options">
                        <div class="room-type">
                            <div class="gender-icon">
                                <i class="fas fa-male"></i>
                            </div>
                            <div>
                                <div>Bilik Lelaki</div>
                                <div class="availability"><?php echo $row['had_bilik_lelaki']; ?> bilik tersedia</div>
                            </div>
                            <form method="POST" class="room-controls">
                                <input type="hidden" name="kolej_id" value="<?php echo $row['id_kolej']; ?>">
                                <input type="hidden" name="room_type" value="male">
                                <button type="button" class="control-btn" onclick="decrementRooms(this)">-</button>
                                <input type="number" name="num_rooms" value="1" min="1" max="<?php echo $row['had_bilik_lelaki']; ?>" class="room-input">
                                <button type="button" class="control-btn" onclick="incrementRooms(this)">+</button>
                                <button type="submit" name="tambah" class="tambah-btn">
                                    <i class="fas fa-plus"></i> Tambah
                                </button>
                            </form>
                        </div>

                        <div class="room-type">
                            <div class="gender-icon female">
                                <i class="fas fa-female"></i>
                            </div>
                            <div>
                                <div>Bilik Perempuan</div>
                                <div class="availability"><?php echo $row['had_bilik_perempuan']; ?> bilik tersedia</div>
                            </div>
                            <form method="POST" class="room-controls">
                                <input type="hidden" name="kolej_id" value="<?php echo $row['id_kolej']; ?>">
                                <input type="hidden" name="room_type" value="female">
                                <button type="button" class="control-btn" onclick="decrementRooms(this)">-</button>
                                <input type="number" name="num_rooms" value="1" min="1" max="<?php echo $row['had_bilik_perempuan']; ?>" class="room-input">
                                <button type="button" class="control-btn" onclick="incrementRooms(this)">+</button>
                                <button type="submit" name="tambah" class="tambah-btn">
                                    <i class="fas fa-plus"></i> Tambah
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        </div>

        <div class="cart-summary">
            <div class="cart-header">
                <i class="fas fa-shopping-cart"></i>
                <h2>Ringkasan Tempahan</h2>
            </div>

            <?php if (!empty($_SESSION['cart']['items'])): ?>
                <?php foreach($_SESSION['cart']['items'] as $key => $item): ?>
                <div class="cart-item">
                    <form method="POST" style="float: right;">
                        <input type="hidden" name="item_key" value="<?php echo $key; ?>">
                        <button type="submit" name="remove" class="remove-btn" title="Buang tempahan">
                            <i class="fas fa-times"></i>
                        </button>
                    </form>
                    <strong><?php echo $item['kolej_name']; ?></strong><br>
                    <?php echo $item['jenis'] == 'male' ? 'Bilik Lelaki' : 'Bilik Perempuan'; ?><br>
                    <?php echo $item['bilik']; ?> bilik × RM<?php echo number_format($item['harga'], 2); ?> × <?php echo $_SESSION['cart']['nights']; ?> malam
                </div>
                <?php endforeach; ?>

                <div class="cart-total">
                    <p>Tempoh Menginap: <?php echo $_SESSION['cart']['nights']; ?> malam</p>
                    <p>Jumlah Bilik: <?php echo $_SESSION['cart']['total_rooms']; ?></p>
                    <h3>Jumlah Bayaran: RM<?php echo number_format($_SESSION['cart']['total'], 2); ?></h3>
                </div>

                <form action="terms.php" method="POST">
                    <button type="submit" class="continue-button">
                        <i class="fas fa-arrow-right"></i> Teruskan Tempahan
                    </button>
                </form>
            <?php else: ?>
                <div class="empty-cart">
                    <i class="fas fa-shopping-cart" style="font-size: 3em; color: #ddd; margin-bottom: 15px;"></i>
                    <p>Tiada tempahan ditambah</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
        function incrementRooms(button) {
            const input = button.parentElement.querySelector('input[name="num_rooms"]');
            const max = parseInt(input.getAttribute('max'));
            const currentValue = parseInt(input.value);
            if (currentValue < max) {
                input.value = currentValue + 1;
            }
        }

        function decrementRooms(button) {
            const input = button.parentElement.querySelector('input[name="num_rooms"]');
            const currentValue = parseInt(input.value);
            if (currentValue > 1) {
                input.value = currentValue - 1;
            }
        }
    </script>
</body>
</html>
