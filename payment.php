<?php
date_default_timezone_set('Asia/Kuala_Lumpur');
session_start();
include 'db.php';

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [
        'items' => [],
        'total_rooms' => 0,
        'total' => 0
    ];
}

if (!isset($_SESSION['cart']['items']) || empty($_SESSION['cart']['items'])) {
    header('Location: booking.php');
    exit();
}

// semak login ke idok bro
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$grandTotal = 0;
foreach ($_SESSION['cart']['items'] as $item) {
    $itemTotal = $item['bilik'] * $item['harga'] * $_SESSION['cart']['nights'];
    $grandTotal += $itemTotal;
}
?>

<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran - STARTUKM</title>
    <link rel="icon" type="image/png" href="haha.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f5f5f5;
            color: #333;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
        }
        .payment-card {
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
        .booking-summary .booking-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid #dee2e6;
        }
        .booking-summary .booking-info p {
            margin: 5px 0;
        }
        .booking-summary .booking-info strong {
            color: #2e7d32;
        }
        .payment-options {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin: 30px 0;
        }
        .payment-option {
            background: white;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
        }
        .payment-option.active {
            border-color: #4CAF50;
            background: #f1f8e9;
        }
        .payment-option i {
            font-size: 24px;
            margin-bottom: 10px;
            color: #4CAF50;
        }
        .payment-details {
            margin-top: 20px;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #e0e0e0;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #333;
        }
        .form-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 16px;
            transition: border-color 0.3s;
        }
        .form-group input:focus {
            outline: none;
            border-color: #4CAF50;
            box-shadow: 0 0 0 2px rgba(76, 175, 80, 0.1);
        }
        .total-amount {
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            margin: 25px 0;
            padding: 20px;
            background: #f1f8e9;
            border-radius: 8px;
            border: 1px solid #c5e1a5;
        }
        .total-amount .nights-info {
            font-size: 16px;
            color: #666;
            margin-bottom: 10px;
            font-weight: normal;
        }
        .total-amount .total-price {
            font-size: 28px;
            color: #2e7d32;
            margin-top: 5px;
        }
        .pay-button {
            background: #4CAF50;
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 8px;
            font-size: 18px;
            width: 100%;
            cursor: pointer;
            transition: background 0.3s;
            font-weight: 500;
            margin-top: 20px;
        }
        .pay-button:hover {
            background: #45a049;
        }
        .item-card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin: 15px 0;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            border: 1px solid #e0e0e0;
        }
        .item-card p {
            margin: 8px 0;
            line-height: 1.5;
        }
        .item-card .item-total {
            color: #2e7d32;
            font-weight: 500;
            margin-top: 12px;
            padding-top: 12px;
            border-top: 1px dashed #e0e0e0;
        }
        h2, h3 {
            color: #2e7d32;
            margin-bottom: 20px;
        }
        @media (max-width: 768px) {
            .payment-options {
                grid-template-columns: 1fr;
            }
            .form-row {
                grid-template-columns: 1fr;
                gap: 10px;
            }
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="container">
        <div class="payment-card">
            <h2>📋 Ringkasan Tempahan</h2>
            <?php
            // kira semula utk double cnfirm
            $total_amount = 0;
            foreach($_SESSION['cart']['items'] as $item) {
                // kira ii jumlah termasuk malam
                $itemTotal = $item['bilik'] * $item['harga'] * $_SESSION['cart']['nights'];
                $total_amount += $itemTotal;
            ?>
                <div class="item-card">
                    <h3><?php echo $item['kolej_name']; ?></h3>
                    <p><?php echo $item['jenis'] == 'male' ? 'Bilik Lelaki' : 'Bilik Perempuan'; ?></p>
                    <p>
                        <?php echo $item['bilik']; ?> bilik × RM<?php echo number_format($item['harga'], 2); ?> × <?php echo $_SESSION['cart']['nights']; ?> malam
                        <br>
                        <small style="color: #666;">
                            (<?php echo $item['bilik']; ?> bilik × RM<?php echo number_format($item['harga'], 2); ?> × <?php echo $_SESSION['cart']['nights']; ?> malam = RM<?php echo number_format($itemTotal, 2); ?>)
                        </small>
                    </p>
                    <p class="item-total">Jumlah: RM<?php echo number_format($itemTotal, 2); ?></p>
                </div>
            <?php
            }
            // jumlah kemaskini
            $_SESSION['cart']['total'] = $total_amount;
            ?>

            <div class="booking-details">
                <p><strong>Tempoh Menginap:</strong> <?php echo $_SESSION['cart']['nights']; ?> malam</p>
                <p><strong>Jumlah Bilik:</strong> <?php echo $_SESSION['cart']['total_rooms']; ?></p>
                <div class="total-amount">
                    <div class="nights-info">
                        Tempoh Menginap: <?php echo $_SESSION['cart']['nights']; ?> malam
                    </div>
                    <div class="total-price">
                        Jumlah Bayaran: RM<?php echo number_format($total_amount, 2); ?>
                    </div>
                </div>
            </div>

            <form method="POST" action="process_booking.php" id="paymentForm" autocomplete="off">
                <h3>Pilih Kaedah Pembayaran</h3>
                <div class="payment-options">
                    <div class="payment-option active" data-method="card">
                        <i class="fas fa-credit-card"></i>
                        <div>Kad Kredit/Debit</div>
                    </div>
                    <div class="payment-option" data-method="counter">
                        <i class="fas fa-store"></i>
                        <div>Bayaran di Kaunter</div>
                    </div>
                </div>

                <div id="cardDetails" class="payment-details">
                    <div class="form-group">
                        <label>Nombor Kad</label>
                        <input type="text" id="cardNumber" name="card_number" placeholder="1234 5678 9012 3456" maxlength="16" required>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Tarikh Luput</label>
                            <input type="text" id="expiryDate" name="expiry_date" placeholder="MM/YY" maxlength="5" required>
                        </div>
                        <div class="form-group">
                            <label>CVV</label>
                            <input type="text" id="cvv" name="cvv" placeholder="123" maxlength="3" required>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="payment_method" id="paymentMethod" value="card">
                <div id="notifError" style="color:#fff; background:#e74c3c; padding:10px; border-radius:6px; margin-bottom:10px; display:none;"></div>
                <button type="submit" class="pay-button">
                    <i class="fas fa-lock"></i>
                    Bayar RM<?php echo number_format($total_amount, 2); ?>
                </button>
            </form>
        </div>
    </div>

    <script>
        function showError(msg) {
            const notif = document.getElementById('notifError');
            notif.innerText = msg;
            notif.style.display = 'block';
        }
        function hideError() {
            const notif = document.getElementById('notifError');
            notif.innerText = '';
            notif.style.display = 'none';
        }
        function validateCard() {
            const cardNumber = document.getElementById('cardNumber').value.replace(/\D/g, '');
            const cvv = document.getElementById('cvv').value.replace(/\D/g, '');
            const expiry = document.getElementById('expiryDate').value;
            const methodType = document.getElementById('paymentMethod').value;
            if (methodType === 'card') {
                if (cardNumber.length !== 16) {
                    return { valid: false, msg: 'Nombor kad mesti 16 digit.' };
                }
                if (!/^((0[1-9])|(1[0-2]))\/\d{2}$/.test(expiry)) {
                    return { valid: false, msg: 'Tarikh luput tidak sah. (MM/YY)' };
                }
                if (cvv.length !== 3) {
                    return { valid: false, msg: 'CVV mesti 3 digit.' };
                }
                return { valid: true, msg: '' };
            } else {
                return { valid: true, msg: '' };
            }
        }
        // Payment method switch
        document.querySelectorAll('.payment-option').forEach(option => {
            option.addEventListener('click', function() {
                document.querySelectorAll('.payment-option').forEach(opt => opt.classList.remove('active'));
                this.classList.add('active');
                const methodType = this.dataset.method;
                document.getElementById('paymentMethod').value = methodType;
                const cardDetails = document.getElementById('cardDetails');
                const payButton = document.querySelector('.pay-button');
                hideError();
                if (methodType === 'card') {
                    cardDetails.style.display = 'block';
                    document.querySelectorAll('#cardDetails input').forEach(input => input.required = true);
                    payButton.innerHTML = `<i class="fas fa-lock"></i> Bayar RM<?php echo number_format($total_amount, 2); ?>`;
                } else {
                    cardDetails.style.display = 'none';
                    document.querySelectorAll('#cardDetails input').forEach(input => input.required = false);
                    payButton.innerHTML = `<i class="fas fa-check"></i> Sahkan Tempahan`;
                }
            });
        });
        // Format input
        document.getElementById('expiryDate').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length >= 2) {
                value = value.slice(0, 2) + '/' + value.slice(2);
            }
            e.target.value = value;
            hideError();
        });
        document.getElementById('cardNumber').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            e.target.value = value;
            hideError();
        });
        document.getElementById('cvv').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            e.target.value = value;
            hideError();
        });
        // On form submit, block if not valid and show error
        document.getElementById('paymentForm').addEventListener('submit', function(e) {
            const methodType = document.getElementById('paymentMethod').value;
            if (methodType === 'card') {
                const result = validateCard();
                if (!result.valid) {
                    e.preventDefault();
                    showError(result.msg);
                }
            }
        });
    </script>
</body>
</html> 