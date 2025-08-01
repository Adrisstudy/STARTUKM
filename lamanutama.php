<?php
date_default_timezone_set('Asia/Kuala_Lumpur');
include('header.php');

session_start();

$nama = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : '';
$email = isset($_SESSION['user_email']) ? $_SESSION['user_email'] : '';
$telefon = isset($_SESSION['user_phone']) ? $_SESSION['user_phone'] : '';

$sql = "INSERT INTO tempahan (nama, email, telefon, ...) VALUES ('$nama', '$email', '$telefon', ...)";

?>

<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laman Utama - START UKM</title>
    <link rel="icon" type="image/png" href="haha.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600&family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="header.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(160deg, #2986ff 0%, #3bb6c5 100%);
            margin: 0;
            padding: 0;
            min-height: 100vh;
        }

        .main-container {
            width: 92%;
            max-width: 1250px;
            margin: 2.5rem auto;
            padding: 32px 28px;
            background: rgba(255,255,255,0.85);
            border-radius: 22px;
            box-shadow: 0 8px 32px rgba(41,134,255,0.10);
        }

        .procedure-btn {
            background: linear-gradient(90deg, #2986ff 0%, #3bb6c5 100%);
            color: #fff;
            padding: 15px 30px;
            border: none;
            border-radius: 12px;
            font-size: 1.1rem;
            font-weight: 600;
            margin: 1rem 0 2rem;
            box-shadow: 0 4px 18px rgba(41,134,255,0.13);
            transition: all 0.3s;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }

        .procedure-btn:hover {
            background: linear-gradient(90deg, #3bb6c5 0%, #2986ff 100%);
            color: #fff;
            box-shadow: 0 8px 28px rgba(41,134,255,0.18);
        }

        /* kotak search */
        .search-container {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0px;
            margin: 2rem 0 2rem;
        }
        .search-box, .procedure-btn {
            width: 350px;
            max-width: 100%;
            min-width: 220px;
        }
        .search-box {
            position: relative;
            margin-right: 18px;
        }
        .search-input {
            width: 100%;
            padding: 15px 30px;
            border: 2px solid #2986ff;
            border-radius: 12px;
            font-size: 1.1rem;
            background: #fff;
            box-shadow: 0 4px 15px rgba(41,134,255,0.08);
            transition: all 0.3s;
        }
        .search-input:focus {
            border-color: #3bb6c5;
            outline: none;
            box-shadow: 0 0 0 2px #3bb6c533;
        }
        .procedure-btn {
            width: 350px;
            max-width: 100%;
            min-width: 220px;
            margin: 0;
            display: block;
        }
        @media (max-width: 800px) {
            .search-container {
                flex-direction: column;
                align-items: stretch;
                gap: 12px;
            }
            .search-box, .procedure-btn {
                width: 100%;
                min-width: unset;
                max-width: unset;
            }
            .search-box {
                margin-right: 0;
            }
        }

        .suggestions-dropdown {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: #fff;
            border-radius: 12px;
            margin-top: 5px;
            box-shadow: 0 4px 18px rgba(41,134,255,0.10);
            display: none;
            z-index: 1000;
            max-height: 300px;
            overflow-y: auto;
        }

        .suggestion-item {
            padding: 12px 20px;
            cursor: pointer;
            transition: all 0.2s ease;
            border-bottom: 1px solid #f0f0f0;
        }

        .suggestion-item:last-child {
            border-bottom: none;
        }

        .suggestion-item:hover {
            background: #eaf6ff;
        }

        .suggestion-item.active {
            background: #eaf6ff;
        }

        .suggestion-highlight {
            color: #2986ff;
        }

        /* College Grid Styling */
        .colleges-section {
            margin-top: 3rem;
        }

        #main-title, h2#main-title {
            color: #111 !important;
            text-align: center;
            font-size: 2.8rem;
            font-family: 'Poppins', sans-serif;
            font-weight: 900;
            margin: 56px 0 10px 0;
            padding: 0 0 8px 0;
            letter-spacing: 1.5px;
            background: none !important;
            border: none !important;
            text-shadow: 0 4px 18px #2986ff22, 0 2px 8px #0001;
            position: relative;
            animation: fadeInDown 0.7s cubic-bezier(.39,.575,.56,1.000);
        }
        .section-title {
            color: #2986ff !important;
            text-align: center;
            font-size: 2.2rem;
            font-family: 'Poppins', sans-serif;
            font-weight: 800;
            margin: 60px 0 8px 0;
            padding: 0 0 8px 0;
            letter-spacing: 1.2px;
            border: none !important;
            background: none !important;
            text-shadow: 0 4px 18px #2986ff22, 0 2px 8px #0001;
            position: relative;
            animation: fadeInDown 0.7s cubic-bezier(.39,.575,.56,1.000);
            display: block;
            width: 100%;
        }
        #main-title::after, .section-title::after {
            content: '';
            display: block;
            width: 120px;
            height: 5px;
            margin: 18px auto 0 auto;
            border-radius: 3px;
            background: linear-gradient(90deg, #2986ff 0%, #3bb6c5 100%);
            opacity: 0.7;
        }
        @keyframes fadeInDown {
            0% { opacity: 0; transform: translateY(-30px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        .section-divider {
            width: 120px;
            height: 5px;
            background: linear-gradient(90deg, #2986ff 0%, #3bb6c5 100%);
            margin: 18px auto 24px auto;
            border-radius: 3px;
            border: none;
            display: block;
        }

        .college-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            padding: 1rem;
        }

        .college-card {
            background: linear-gradient(120deg, #fafdff 60%, #eaf6ff 100%);
            border-radius: 18px;
            box-shadow: 0 5px 18px rgba(41,134,255,0.08);
            border: 1.5px solid #e0e7ef;
            overflow: hidden;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .college-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 12px 32px rgba(41,134,255,0.13);
            border: 1.5px solid #2986ff;
        }
        .college-image {
            width: 100%;
            height: 220px;
            object-fit: cover;
        }

        .college-name {
            padding: 1.2rem;
            font-family: 'Poppins', sans-serif;
            font-size: 1.1rem;
            color: #2986ff;
            text-align: center;
            font-weight: 600;
        }

        /* Popup Styling */
        .popup-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            display: none;
            z-index: 999;
            backdrop-filter: blur(5px);
        }

        .popup {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: #fff;
            width: 90%;
            max-width: 800px;
            max-height: 85vh;
            overflow-y: auto;
            padding: 2.5rem;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            display: none;
            z-index: 1000;
        }

        .popup h2 {
            color: #2986ff;
            text-align: center;
            margin-bottom: 2rem;
            font-family: 'Poppins', sans-serif;
            font-size: 1.8rem;
            border-bottom: 3px solid #2986ff;
            padding-bottom: 1rem;
        }

        .procedure-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .procedure-step {
            background: #fff;
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 0;
            border: none;
            box-shadow: 0 2px 10px rgba(41,134,255,0.07);
            transition: transform 0.3s ease;
        }

        .procedure-step:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(41,134,255,0.13);
        }

        .step-number {
            background: linear-gradient(90deg, #2986ff 0%, #3bb6c5 100%);
            color: white;
            width: 35px;
            height: 35px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-bottom: 1rem;
            font-size: 1.1rem;
        }

        .step-title {
            color: #2986ff;
            font-weight: 600;
            margin-bottom: 1rem;
            font-size: 1.2rem;
            line-height: 1.4;
        }

        .step-content {
            color: #666;
            line-height: 1.8;
            font-size: 1.1rem;
        }

        .step-content ul {
            list-style: none;
            padding-left: 0;
            margin-top: 0.5rem;
        }

        .step-content li {
            padding: 0.5rem 0;
            display: flex;
            align-items: center;
        }

        .step-content li:before {
            content: "✓";
            color: #2986ff;
            font-weight: bold;
            margin-right: 10px;
        }

        .warning-step {
            background: #eaf6ff;
            border-left: 4px solid #2986ff;
        }

        .warning-step .step-number {
            background: #2986ff;
        }

        .button-container {
            text-align: center;
            margin-top: 2rem;
            display: flex;
            justify-content: center;
            gap: 1rem;
        }

        .close-btn {
            background: linear-gradient(90deg, #2986ff 0%, #3bb6c5 100%);
            color: #fff;
            padding: 15px 40px;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            font-size: 1.1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            min-width: 200px;
            box-shadow: 0 4px 15px rgba(41,134,255,0.10);
        }

        .close-btn:hover {
            background: linear-gradient(90deg, #3bb6c5 0%, #2986ff 100%);
            color: #fff;
            box-shadow: 0 8px 28px rgba(41,134,255,0.18);
        }

        @media (max-width: 768px) {
            .main-container {
                width: 95%;
                padding: 10px;
            }

            .college-grid {
                grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
                gap: 1rem;
            }

            .popup {
                width: 95%;
                padding: 1.5rem;
                max-height: 90vh;
            }

            .procedure-container {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .step-title {
                font-size: 1.1rem;
            }

            .step-content {
                font-size: 1rem;
            }
        }

        .booking-container {
            max-width: 1000px;
            margin: 40px auto;
            padding: 40px;
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(41,134,255,0.10);
        }

        .booking-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .booking-header h2 {
            color: #111 !important;
            text-align: center;
            font-size: 2.2rem;
            font-family: 'Poppins', sans-serif;
            font-weight: 800;
            margin-bottom: 0.5rem;
        }

        .booking-header p {
            color:rgb(27, 47, 48);
            font-size: 1.1em;
        }

        .booking-form {
            display: flex;
            flex-direction: column;
            gap: 30px;
        }

        .date-picker-container {
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: flex-end;
            background: #fafdff;
            border: 1.5px solid #2986ff;
            border-radius: 22px;
            padding: 32px 24px;
            gap: 32px;
            box-shadow: 0 4px 18px #2986ff22;
        }

        .date-input-group {
            flex: 1;
            max-width: 270px;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 8px;
        }

        .date-input-group label {
            color: #2986ff;
            font-weight: 700;
            margin-bottom: 8px;
            font-size: 1.08em;
        }

        .date-input {
            width: 100%;
            border: 2.5px solid #2986ff;
            border-radius: 18px;
            background: linear-gradient(90deg, #eaf6ff 0%, #fff 100%);
            color: #1a355b;
            font-weight: 500;
            font-size: 1.13em;
            padding: 14px 18px;
            margin-top: 4px;
            box-shadow: 0 2px 8px #2986ff11;
            transition: border 0.2s, box-shadow 0.2s;
        }

        .date-input:focus, .date-input:hover {
            border-color: #3bb6c5;
            box-shadow: 0 0 0 4px #3bb6c533;
            outline: none;
        }

        .stay-duration {
            min-width: 120px;
            text-align: center;
            color: #2986ff;
            font-weight: 600;
        }

        @media (max-width: 900px) {
            .date-picker-container {
                flex-direction: column;
                align-items: stretch;
                gap: 18px;
                padding: 18px 8px;
            }
            .date-input-group {
                max-width: 100%;
            }
        }

        .check-availability-btn {
            background: #fff !important;
            color: #111 !important;
            font-weight: 700;
            border-radius: 14px;
            border: none;
            box-shadow: 0 2px 12px #2986ff22;
            font-size: 1.1em;
            padding: 15px 0;
            margin-top: 18px;
            transition: box-shadow 0.18s, transform 0.18s;
            letter-spacing: 1px;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }
        .check-availability-btn:active {
            box-shadow: 0 6px 24px #2986ff33;
            transform: scale(0.97);
        }

        .flatpickr-calendar {
            background: #fff !important;
            border: 1.5px solid #2986ff !important;
            box-shadow: 0 10px 30px rgba(41,134,255,0.13) !important;
            border-radius: 15px !important;
        }
        .flatpickr-months {
            background: linear-gradient(90deg, #2986ff 0%, #3bb6c5 100%) !important;
            border-radius: 15px 15px 0 0 !important;
            padding: 10px 0 !important;
        }
        .flatpickr-months .flatpickr-month,
        .flatpickr-current-month {
            color: #fff !important;
        }
        .flatpickr-weekday {
            color: #2986ff !important;
            font-weight: 600 !important;
        }
        .flatpickr-day {
            color: #2986ff !important;
            border-radius: 8px !important;
            margin: 2px !important;
        }
        .flatpickr-day.selected, .flatpickr-day.startRange, .flatpickr-day.endRange {
            background: linear-gradient(90deg, #2986ff 0%, #3bb6c5 100%) !important;
            border-color: #2986ff !important;
            color: #fff !important;
        }
        .flatpickr-day:hover, .flatpickr-day:focus {
            background: #eaf6ff !important;
            color: #2986ff !important;
        }
        .flatpickr-day.today {
            border-color: #3bb6c5 !important;
            color: #3bb6c5 !important;
        }
        .flatpickr-day.disabled {
            color: #ccc !important;
        }
        /* alihkan hover*/
        .nav-link, .nav-link:visited, .nav-link:active, .nav-link:hover {
            text-decoration: none !important;
            border: none !important;
            background: transparent !important;
            color: #fff !important;
            box-shadow: none !important;
        }
        .divider, hr, .section-title, .contact-card h2 {
            border-color: #2986ff !important;
            background: #2986ff !important;
            color: #2986ff !important;
            height: 4px;
            border-radius: 2px;
            width: 80px;
            margin: 0 auto 18px auto;
        }
        .section-title {
            color: #2986ff !important;
            background: none !important;
            display: block;
            text-align: center;
            font-size: 2rem;
            font-weight: 700;
            margin: 40px 0 0 0;
            padding: 0;
        }
        /*  tajuk lain seperti Pentadbiran, Kolej Kediaman */
        h2.section-title, h2 {
            color: #fff !important;
            background: none !important;
            border: none !important;
            display: block;
            font-size: 1.5rem;
            font-weight: 700;
            margin: 32px 0 12px 0;
            padding: 0;
        }
        .contact-card h2 {
            border-bottom: 2px solid #111 !important;
        }

        /*  tema utama */
        :root {
            --primary-color: #beae98;
            --primary-dark: #a89882;
            --primary-light: #f0e9e2;
            --secondary-color: #8b7355;
            --text-dark: #4a4a4a;
            --text-light: #7a7a7a;
            --background-light: #faf7f2;
        }

        .date-picker-container {
            background: var(--background-light);
            border: 1px solid var(--primary-light);
        }

        .date-input-group label i {
            color: var(--primary-color);
        }

        .date-input {
            border: 2px solid var(--primary-light);
        }

        .date-input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(190, 174, 152, 0.1);
        }

        .duration-line {
            background: var(--primary-color);
        }

        .duration-line::before,
        .duration-line::after {
            background: var(--primary-color);
        }

        .stay-duration span {
            color: var(--secondary-color);
        }

        .check-availability-btn {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
        }

        .check-availability-btn:hover {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--secondary-color) 100%);
            box-shadow: 0 5px 15px rgba(138, 115, 85, 0.3);
        }

        .booking-header h2 {
            color: rgb(0, 0, 0);;
        }

        .booking-header p {
            color: var(--text-light);
        }

        .date-input-group label {
            color: var(--text-dark);
        }

        .date-input:hover {
            border-color: var(--primary-color);
            background-color: var(--background-light);
        }

        .flatpickr-day.selected:hover {
            background: var(--primary-dark) !important;
        }

        .section-title {
            text-align: center;
            color: #2986ff;
            margin: 40px 0;
            font-size: 2em;
        }

        .colleges-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 25px;
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .college-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: transform 0.3s ease;
        }

        .college-card:hover {
            transform: translateY(-5px);
        }

        .college-header {
            background: #beae98;
            color: white;
            padding: 15px;
            text-align: center;
        }

        .college-header h3 {
            margin: 0;
            font-size: 1.2em;
        }

        .room-info {
            padding: 20px;
        }

        .room-type {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            padding: 10px;
            border-radius: 8px;
            background: #f8f9fa;
        }

        .room-icon {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            margin-right: 15px;
        }

        .room-icon.male {
            background: rgba(52, 152, 219, 0.1);
            color: #3498db;
        }

        .room-icon.female {
            background: rgba(232, 67, 147, 0.1);
            color: #e84393;
        }

        .room-icon i {
            font-size: 1.5em;
        }

        .room-details {
            flex: 1;
        }

        .room-label {
            display: block;
            color: #666;
            font-size: 0.9em;
            margin-bottom: 5px;
        }

        .room-count {
            display: block;
            color: #2c3e50;
            font-size: 1.2em;
            font-weight: 600;
        }

        @media (max-width: 768px) {
            .colleges-container {
                grid-template-columns: 1fr;
            }
        }

        /* --- Carian Destinasi & Kolej --- */
        .suggestion-group {
            padding: 10px 20px 5px 20px;
            font-weight: 600;
            color: #8b7355;
            background: #f8f9fa;
            border-bottom: 1px solid #eee;
        }
        .suggestion-college {
            padding: 8px 35px;
            cursor: pointer;
            color: #2c3e50;
            background: white;
            border-bottom: 1px solid #f0f0f0;
            transition: background 0.2s;
        }
        .suggestion-college:last-child {
            border-bottom: none;
        }
        .suggestion-college:hover {
            background: #f8f9fa;
            color: #beae98;
        }

        .blurred {
            filter: blur(6px) brightness(0.95);
            transition: filter 0.3s;
            pointer-events: none;
            user-select: none;
        }

        .colleges-section .section-title {
            color: #2986ff !important;
            text-align: center;
            font-size: 2rem;
            font-family: 'Poppins', sans-serif;
            font-weight: 800;
            margin: 40px 0 18px 0;
            border: none !important;
            background: none !important;
            box-shadow: none !important;
            text-shadow: 0 4px 18px #2986ff22, 0 2px 8px #0001;
            width: 100%;
            display: block;
        }
        .colleges-section .section-title::after {
            display: none !important;
        }
    </style>
</head>
<body>
    <div class="main-container">
        <div class="welcome-message">
            <?php if(isset($_SESSION['user_name'])): ?>
                <p>Selamat datang, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</p>
            <?php endif; ?>
        </div>

        <div class="booking-container">
            <div class="booking-header">
                <h2>Tempah Rumah Tamu</h2>
                <p>Pilih tarikh untuk menyemak ketersediaan</p>
            </div>

            <div class="booking-form">
                <div class="date-picker-container">
                    <div class="date-input-group">
                        <label>
                            <i class="fas fa-calendar-alt"></i>
                            Tarikh Daftar Masuk
                        </label>
                        <input type="text" id="checkIn" class="date-input" readonly placeholder="Pilih tarikh masuk">
                    </div>

                    <div class="stay-duration">
                        <span id="nightsCount">0 malam</span>
                        <div class="duration-line"></div>
                    </div>

                    <div class="date-input-group">
                        <label>
                            <i class="fas fa-calendar-alt"></i>
                            Tarikh Daftar Keluar
                        </label>
                        <input type="text" id="checkOut" class="date-input" readonly placeholder="Pilih tarikh keluar">
                    </div>
                </div>

                <button id="checkAvailability" class="check-availability-btn" style="display: none;">
                    
                    SEMAK KEKOSONGAN
                </button>
            </div>
        </div>

        <div class="search-container">
            <div class="search-box">
                <input type="text" class="search-input" placeholder="Taip Destinasi Anda Di sini " id="collegeSearch">
                <div class="suggestions-dropdown" id="suggestions"></div>
            </div>
            <button class="procedure-btn" onclick="openPopup()">TATACARA TEMPAHAN START UKM</button>
        </div>

        <div class="colleges-section">
            <h2 class="section-title">SENARAI KOLEJ</h2>
            
            <div class="college-grid">
                <div class="college-card" onclick="window.location.href='kpz.php'">
                    <img src="kpz.jpg" alt="Kolej Pendeta Za'ba" class="college-image">
                    <div class="college-name">KOLEJ PENDETA ZA'BA</div>
                </div>
                <div class="college-card" onclick="window.location.href='kkm.php'">
                    <img src=KKMA.jpg alt="Kolej Keris Mas" class="college-image">
                    <div class="college-name">KOLEJ KERIS MAS</div>
                </div>
                <div class="college-card" onclick="window.location.href='kuo.php'">
                    <img src="KUOA.jpg" alt="Kolej Ungku Omar" class="college-image">
                    <div class="college-name">KOLEJ UNGKU OMAR</div>
                </div>
                <div class="college-card" onclick="window.location.href='kiy.php'">
                    <img src="KIYA.jpg" alt="Kolej Ibrahim Yaakub" class="college-image">
                    <div class="college-name">KOLEJ IBRAHIM YAAKUB</div>
                </div>
                <div class="college-card" onclick="window.location.href='kbh.php'">
                    <img src="KBHA.jpg" alt="Kolej Burhanuddin Helmi" class="college-image">
                    <div class="college-name">KOLEJ BURHANUDDIN HELMI</div>
                </div>
                <div class="college-card" onclick="window.location.href='kiz.php'">
                    <img src="kiz.png" alt="Kolej Ibu Zain" class="college-image">
                    <div class="college-name">KOLEJ IBU ZAIN</div>
                </div>
                <div class="college-card" onclick="window.location.href='kdo.php'">
                    <img src="KDOA.jpg" alt="Kolej Dato Onn" class="college-image">
                    <div class="college-name">KOLEJ DATO ONN</div>
                </div>
                <div class="college-card" onclick="window.location.href='krk.php'">
                    <img src="KRKA.jpg" alt="Kolej Rahim Kajai" class="college-image">
                    <div class="college-name">KOLEJ RAHIM KAJAI</div>
                </div>
                <div class="college-card" onclick="window.location.href='kab.php'">
                    <img src="KABA.jpg" alt="Kolej Aminuddin Baki" class="college-image">
                    <div class="college-name">KOLEJ AMINUDDIN BAKI</div>
                </div>
            </div>
        </div>
    </div>

    <div class="popup-overlay" id="overlay"></div>
        <div class="popup" id="popup">
            <h2 style="text-align:center;color:#000000;font-family:'Poppins',sans-serif;font-size:2rem;font-weight:800;margin-bottom:24px;letter-spacing:1px;">TATACARA TEMPAHAN</h2>
        <div class="procedure-container">
            <div class="procedure-step">
                <div class="step-number">1</div>
                <div class="step-title">Semak Kolej Berdekatan</div>
                <div class="step-content">
                    <ul>
                        <li>Pilih lokasi program/aktiviti di kolej berdekatan UKM</li>
                        <li>Semak senarai kolej yang menyediakan rumah tamu</li>
                    </ul>
                </div>
        </div>

            <div class="procedure-step">
                <div class="step-number">2</div>
                <div class="step-title">Pilih Tarikh & Semak Kekosongan</div>
                <div class="step-content">
                    <ul>
                        <li>Masukkan tarikh daftar masuk</li>
                        <li>Masukkan tarikh daftar keluar</li>
                        <li>Semak status kekosongan bilik</li>
                    </ul>
            </div>
            </div>

            <div class="procedure-step">
                <div class="step-number">3</div>
                <div class="step-title">Pilih Rumah Tamu</div>
                <div class="step-content">
                    <ul>
                        <li>Tambah ke dalam troli</li>
                        <li>Pastikan bilagan tepat</li>
                        <li>Tekan butang "Teruskan tempahan"</li>
                    </ul>
            </div>
            </div>

            <div class="procedure-step">
                <div class="step-number">4</div>
                <div class="step-title">Baca Terma & Syarat</div>
                <div class="step-content">
                    <ul>
                        <li>Baca dengan teliti semua syarat</li>
                        <li>Fahami peraturan penginapan</li>
                    </ul>
            </div>
            </div>

            <div class="procedure-step">
                <div class="step-number">5</div>
                <div class="step-title">Selesaikan Pembayaran</div>
                <div class="step-content">
                    <ul>
                        <li>Pilih kaedah pembayaran (FPX/Kad debit)</li>
                        <li>Invois akan dijana secara automatik</li>
                    </ul>
            </div>
            </div>

            <div class="procedure-step">
                <div class="step-number">6</div>
                <div class="step-title">Simpan Bukti Tempahan</div>
                <div class="step-content">
                    <ul>
                        <li>Ambil tangkap layar bukti tempahan</li>
                        <li>Simpan untuk ditunjukkan semasa daftar masuk</li>
                    </ul>
            </div>
            </div>
        </div>

        <div class="procedure-step warning-step">
            <div class="step-number">!</div>
            <div class="step-title">Maklumat Tambahan</div>
            <div class="step-content">
                <ul>
                    <li>Maklumkan pihak pengurusan kolej jika tempahan lebih 30 peserta</li>
                    <li>Sila maklumkan kepada pihak pengurusan kolej jika terdapat sebarang perubahan</li>
                </ul>
            </div>
        </div>

        <div class="button-container">
            <button class="close-btn" onclick="closePopup()">SAYA FAHAM</button>
        </div>
    </div>

    <script>
        window.onload = function() {
            setTimeout(function() {
                openPopup();
            }, 500);
        };

        function openPopup() {
            document.getElementById("popup").style.display = "block";
            document.getElementById("overlay").style.display = "block";
            document.body.style.overflow = "hidden";
            document.querySelector('.main-header')?.classList.add('blurred');
            document.querySelector('.main-container')?.classList.add('blurred');
        }

        function closePopup() {
            document.getElementById("popup").style.display = "none";
            document.getElementById("overlay").style.display = "none";
            document.body.style.overflow = "auto";
            document.querySelector('.main-header')?.classList.remove('blurred');
            document.querySelector('.main-container')?.classList.remove('blurred');
        }

        document.addEventListener('DOMContentLoaded', function() {
            const config = {
                minDate: "today",
                dateFormat: "Y-m-d",
                disableMobile: false,
                animate: true
            };

            const checkInPicker = flatpickr("#checkIn", {
                ...config,
                onChange: function(selectedDates) {
                    checkOutPicker.set("minDate", selectedDates[0]);
                    updateNightsCount();
                }
            });

            const checkOutPicker = flatpickr("#checkOut", {
                ...config,
                onChange: function() {
                    updateNightsCount();
                }
            });

            function updateNightsCount() {
                const checkIn = checkInPicker.selectedDates[0];
                const checkOut = checkOutPicker.selectedDates[0];
                
                if (checkIn && checkOut) {
                    const nights = Math.ceil((checkOut - checkIn) / (1000 * 60 * 60 * 24));
                    document.getElementById('nightsCount').textContent = nights + ' malam';
                    document.getElementById('checkAvailability').style.display = 'flex';
                }
            }

            document.getElementById('checkAvailability').addEventListener('click', function() {
                const checkIn = document.getElementById('checkIn').value;
                const checkOut = document.getElementById('checkOut').value;
                
                if (checkIn && checkOut) {
                    window.location.href = `booking.php?checkin=${checkIn}&checkout=${checkOut}`;
                }
            });
        });

        const destinations = [
            {
                keyword: ["DECTAR", "Dewan Canselor Tun Abdul Razak"],
                display: "DECTAR / Dewan Canselor Tun Abdul Razak",
                colleges: [
                    { name: "Kolej Dato Onn", file: "kdo.php" }
                ]
            },
            {
                keyword: ["Fakulti Sains Dan Teknologi", "FST"],
                display: "Fakulti Sains Dan Teknologi (FST)",
                colleges: [
                    { name: "Kolej Ungku Omar", file: "kuo.php" },
                    { name: "Kolej Ibrahim Yaakub", file: "kiy.php" }
                ]
            },
            {
                keyword: ["Fakulti Sains Sosial Dan Kemanusiaan", "FSSK"],
                display: "Fakulti Sains Sosial Dan Kemanusiaan (FSSK)",
                colleges: [
                    { name: "Kolej Keris Mas", file: "kkm.php" },
                    { name: "Kolej Dato Onn", file: "kdo.php" }
                ]
            },
            {
                keyword: ["Fakulti Pendidikan", "FPEND"],
                display: "Fakulti Pendidikan (FPEND)",
                colleges: [
                    { name: "Kolej Burhanuddin Helmi", file: "kbh.php" },
                    { name: "Kolej Ibu Zain", file: "kiz.php" }
                ]
            },
            {
                keyword: ["Fakulti Ekonomi Dan Pengurusan", "FEP"],
                display: "Fakulti Ekonomi Dan Pengurusan (FEP)",
                colleges: [
                    { name: "Kolej Aminuddin Baki ", file: "kab.php" },
                    { name: "Kolej Ungku Omar", file: "kuo.php" }
                ]
            },
            {
                keyword: ["Fakulti Pengajian Islam", "FPI"],
                display: "Fakulti Pengajian Islam (FPI)",
                colleges: [
                    { name: "Kolej Dato Onn", file: "kdo.php" },
                    { name: "Kolej Ungku Omar", file: "kuo.php" }
                ]
            },
            {
                keyword: ["Fakulti Kejuruteraan Dan Alam Bina", "FKAB"],
                display: "Fakulti Kejuruteraan Dan Alam Bina (FKAB)",
                colleges: [
                    { name: "Kolej Pendeta Za'ba", file: "kpz.php" },
                    { name: "Kolej Ibrahim Yaakub", file: "kiy.php" }
                ]
            },
           
            {
                keyword: ["Fakulti Undang-Undang", "FUU"],
                display: "Fakulti Undang-Undang (FUU)",
                colleges: [
                    { name: "Kolej Ibrahim Yaakub", file: "kiy.php" },
                    { name: "Kolej Pendeta Za'ba", file: "kpz.php" }
                ]
            },
            {
                keyword: ["Fakulti Teknologi Dan Sains Maklumat", "FTSM"],
                display: "Fakulti Teknologi Dan Sains Maklumat (FTSM)",
                colleges: [
                    { name: "Kolej Ibrahim Yaakub", file: "kiy.php" },
                    { name: "Kolej Pendeta Za'ba", file: "kpz.php" }
                ]
            },
            {
                keyword: ["Pusat Sukan", "PSUKAN"],
                display: "Pusat Sukan UKM",
                colleges: [
                    { name: "Kolej Rahim Kajai", file: "krk.php" },
                    { name: "Kolej Ibu Zain", file: "kiz.php" }
                ]
            },
            {
                keyword: ["Pusat Islam", "PISLAM"],
                display: "Pusat Islam UKM",
                colleges: [
                    { name: "Kolej Burhanuddin Helmi", file: "kbh.php" },
                    { name: "Kolej Ibrahim Yaakub", file: "kiy.php" }
                ]
            },
            {
                keyword: ["Pusat Kesihatan Universiti Kebangsaan Malaysia", "PKU"],
                display: "Pusat Kesihatan Universiti Kebangsaan Malaysia (PKU)",
                colleges: [
                    { name: "Kolej Ungku Omar", file: "kuo.php" },
                    { name: "Kolej Ibrahim Yaakub", file: "kiy.php" }
                ]
            },
            {
                keyword: ["Perpustakaan Tun Seri Lanang", "PTSL"],
                display: "Perpustakaan Tun Seri Lanang (PTSL)",
                colleges: [
                    { name: "Kolej Aminuddin Baki", file: "kab.php" },
                    { name: "Kolej Ungku Omar", file: "kuo.php" }
                ]
            },
            {
                keyword: ["Pusat Kajian Cuaca", "PKC"],
                display: "Pusat Kajian Cuaca (PKC)",
                colleges: [
                    { name: "Kolej Ungku Omar", file: "kuo.php" },
                    { name: "Kolej Ibrahim Yaakub", file: "kiy.php" }
                ]
            },
            {
                keyword: ["Pusat Penyelidikan Iklim", "PPI"],
                display: "Pusat Penyelidikan Iklim (PPI)",
                colleges: [
                    { name: "Kolej Ungku Omar", file: "kuo.php" },
                    { name: "Kolej Ibrahim Yaakub", file: "kiy.php" }
                ]
            },
            {
                keyword: ["Pusat Penyelidikan Sains Bumi", "PPSB"],
                display: "Pusat Penyelidikan Sains Bumi (PPSB)",
                colleges: [
                    { name: "Kolej Ungku Omar", file: "kuo.php" },
                    { name: "Kolej Ibrahim Yaakub", file: "kiy.php" }
                ]
            },
            {
                keyword: ["Pusat Penyelidikan Biologi", "PPB"],
                display: "Pusat Penyelidikan Biologi (PPB)",
                colleges: [
                    { name: "Kolej Ungku Omar", file: "kuo.php" },
                    { name: "Kolej Ibrahim Yaakub", file: "kiy.php" }
                ]
            },
            {
                keyword: ["Pusat Penyelidikan Kimia", "PPK"],
                display: "Pusat Penyelidikan Kimia (PPK)",
                colleges: [
                    { name: "Kolej Ungku Omar", file: "kuo.php" },
                    { name: "Kolej Ibrahim Yaakub", file: "kiy.php" }
                ]
            },
            {
                keyword: ["Pusat Penyelidikan Fizik", "PPF"],
                display: "Pusat Penyelidikan Fizik (PPF)",
                colleges: [
                    { name: "Kolej Ungku Omar", file: "kuo.php" },
                    { name: "Kolej Ibrahim Yaakub", file: "kiy.php" }
                ]
            },
            {
                keyword: ["Pusat Penyelidikan Matematik", "PPM"],
                display: "Pusat Penyelidikan Matematik (PPM)",
                colleges: [
                    { name: "Kolej Ungku Omar", file: "kuo.php" },
                    { name: "Kolej Ibrahim Yaakub", file: "kiy.php" }
                ]
            },
            {
                keyword: ["Pusat Penyelidikan Sains Komputer", "PPSK"],
                display: "Pusat Penyelidikan Sains Komputer (PPSK)",
                colleges: [
                    { name: "Kolej Burhanuddin Helmi", file: "kbh.php" },
                    { name: "Kolej Ibrahim Yaakub", file: "kiy.php" }
                ]
            },
            {
                keyword: ["Pusat Penyelidikan Sains Sosial", "PPSS"],
                display: "Pusat Penyelidikan Sains Sosial (PPSS)",
                colleges: [
                    { name: "Kolej Keris Mas", file: "kkm.php" },
                    { name: "Kolej Pendeta Za'ba", file: "kpz.php" }
                ]
            },
            {
                keyword: ["Pusat Penyelidikan Pendidikan", "PPP"],
                display: "Pusat Penyelidikan Pendidikan (PPP)",
                colleges: [
                    { name: "Kolej Burhanuddin Helmi", file: "kbh.php" },
                    { name: "Kolej Ibrahim Yaakub", file: "kiy.php" }
                ]
            },
            {
                keyword: ["Pusat Penyelidikan Islam", "PPI"],
                display: "Pusat Penyelidikan Islam (PPI)",
                colleges: [
                    { name: "Kolej Burhanuddin Helmi", file: "kbh.php" },
                    { name: "Kolej Ibrahim Yaakub", file: "kiy.php" }
                ]
            },
            {
                keyword: ["Pusat Penyelidikan Ekonomi", "PPE"],
                display: "Pusat Penyelidikan Ekonomi (PPE)",
                colleges: [
                    { name: "Kolej Aminuddin Baki", file: "kab.php" },
                    { name: "Kolej Keris Mas", file: "kkm.php" },
                ]
            },
            {
                keyword: ["Pusat Penyelidikan Undang-Undang", "PPUU"],
                display: "Pusat Penyelidikan Undang-Undang (PPUU)",
                colleges: [
                    { name: "Kolej Keris Mas", file: "kkm.php" },
                    { name: "Kolej Pendeta Za'ba", file: "kpz.php" }
                ]
            },
            {
                keyword: ["Kolej Keris Mas", "KKM"],
                display: "Kolej Keris Mas(KKM)",
                colleges: [
                    { name: "Kolej Keris Mas", file: "kkm.php" }
                ]
            },
            {
                keyword: ["Kolej Dato Onn", "KDO"],
                display: "Kolej Dato Onn(KDO)",
                colleges: [
                    { name: "Kolej Dato Onn", file: "kdo.php" }
                ]
            },
            {
                keyword: ["Kolej Ibu Zain", "KIZ"],
                display: "Kolej Ibu Zain(KIZ)",
                colleges: [
                    { name: "Kolej Ibu Zain", file: "kiz.php" }
                ]
            },
            {
                keyword: ["Kolej Aminuddin Baki", "KAB"],
                display: "Kolej Aminuddin Baki(KAB)",
                colleges: [
                    { name: "Kolej Aminuddin Baki", file: "kab.php" }
                ]
            },
            {
                keyword: ["Kolej Rahim Kajai", "KRK"],
                display: "Kolej Rahim Kajai(KRK)",
                colleges: [
                    { name: "Kolej Rahim Kajai", file: "krk.php" }
                ]
            },
            {
                keyword: ["Kolej Pendeta Za'ba", "KPZ"],
                display: "Kolej Pendeta Za'ba(KPZ)",
                colleges: [
                    { name: "Kolej Pendeta Za'ba", file: "kpz.php" }
                ]
            },
            {
                keyword: ["Kolej Burhanuddin Helmi", "KBH"],
                display: "Kolej Burhanuddin Helmi(KBH)",
                colleges: [
                    { name: "Kolej Burhanuddin Helmi", file: "kbh.php" }
                ]
            },
            {
                keyword: ["Kolej Ibrahim Yaakub", "KIY"],
                display: "Kolej Ibrahim Yaakub(KIY)",
                colleges: [
                    { name: "Kolej Ibrahim Yaakub", file: "kiy.php" }
                ]
            },
            {
                keyword: ["Kolej Ungku Omar", "KUO"],
                display: "Kolej Ungku Omar(KUO)",
                colleges: [
                    { name: "Kolej Ungku Omar", file: "kuo.php" }
                ]
            }
        ];

        const searchInput = document.getElementById('collegeSearch');
        const suggestions = document.getElementById('suggestions');

        searchInput.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            if (searchTerm.length < 2) {
                suggestions.style.display = 'none';
                return;
            }
            // Cari destinasi yang padan
            const matched = destinations.filter(dest =>
                dest.keyword.some(k => k.toLowerCase().includes(searchTerm) || searchTerm.includes(k.toLowerCase()))
                || dest.display.toLowerCase().includes(searchTerm)
            );
            if (matched.length > 0) {
                suggestions.innerHTML = matched.map(dest => {
                    let group = `<div class='suggestion-group'>${dest.display}</div>`;
                    let colleges = dest.colleges.map(col =>
                        `<div class='suggestion-college' data-file='${col.file}'>${col.name}</div>`
                    ).join('');
                    return group + colleges;
                }).join('');
                suggestions.style.display = 'block';
            } else {
                suggestions.style.display = 'none';
            }
        });

        suggestions.addEventListener('click', function(e) {
            if (e.target.classList.contains('suggestion-college')) {
                const file = e.target.getAttribute('data-file');
                window.location.href = file;
            }
        });

        document.addEventListener('click', function(e) {
            if (!searchInput.contains(e.target) && !suggestions.contains(e.target)) {
                suggestions.style.display = 'none';
            }
        });
    </script>
</body>
</html>