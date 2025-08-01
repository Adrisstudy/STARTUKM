<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang STARTUKM</title>
    <link rel="icon" type="image/png" href="haha.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-image: url('beige.jpg');
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: 100% 100%;
            background: linear-gradient(160deg, #2986ff 0%, #3bb6c5 100%);
        }

        .content-container {
            max-width: 1000px;
            margin: 60px auto;
            padding: 0 20px;
        }

        .title-section {
            text-align: center;
            margin-bottom: 60px;
            padding: 30px;
            background: linear-gradient(90deg, #eaf6ff 0%, #fff 100%);
            border-radius: 15px;
            box-shadow: 0 4px 6px #2986ff22;
        }

        .title-section h1 {
            font-size: 2.2em;
            margin-bottom: 15px;
            color: #2986ff;
        }

        .title-section p {
            font-size: 1.1em;
            color: #666;
            max-width: 700px;
            margin: 0 auto;
            line-height: 1.6;
        }

        .stats-row {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 18px;
            margin: 40px 0;
        }

        .stat-item {
            flex: 1;
            min-width: 200px;
            background: #fff;
            color: #2986ff;
            padding: 25px 20px;
            border-radius: 12px;
            text-align: center;
            transition: transform 0.3s ease;
            border: 2.5px solid #2986ff;
            box-shadow: 0 4px 12px #2986ff22;
        }

        .stat-item:hover {
            transform: translateY(-5px);
        }

        .stat-number {
            font-size: 2.2em;
            font-weight: bold;
            margin-bottom: 8px;
            color: #2986ff;
        }

        .stat-label {
            font-size: 1em;
            opacity: 0.85;
            letter-spacing: 0.5px;
            color: #2986ff;
        }

        .feature-row {
            display: flex;
            justify-content: center;
            gap: 25px;
            margin-top: 40px;
        }

        .feature-card {
            flex: 1;
            background: #fff;
            border-radius: 12px;
            padding: 30px;
            text-align: center;
            box-shadow: 0 4px 6px #2986ff22;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: 1px solid #e0e7ef;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(139, 115, 85, 0.2);
        }

        .feature-icon {
            width: 70px;
            height: 70px;
            background: #2986ff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 25px;
            transition: background-color 0.3s ease;
        }

        .feature-card:hover .feature-icon {
            background: #3bb6c5;
        }

        .feature-icon i {
            font-size: 2em;
            color: white;
        }

        .feature-card h3 {
            color: #2986ff;
            margin: 0 0 15px 0;
            font-size: 1.4em;
        }

        .feature-card p {
            color: #666;
            line-height: 1.7;
            margin: 0;
            font-size: 1em;
        }

        @media (max-width: 900px) {
            .feature-row {
                flex-direction: column;
            }

            .feature-card {
                margin: 0 auto;
                max-width: 400px;
                width: 100%;
            }

            .stats-row {
                justify-content: center;
            }

            .stat-item {
                min-width: 45%;
            }
        }

        @media (max-width: 480px) {
            .content-container {
                margin: 30px auto;
            }

            .title-section {
                padding: 20px;
                margin-bottom: 40px;
            }

            .title-section h1 {
                font-size: 1.8em;
            }

            .stat-item {
                min-width: 100%;
            }
        }

        .main-container, .popup, .card, .procedure-step {
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 8px 32px rgba(41,134,255,0.10);
        }
        .button, .btn, .close-btn, .procedure-btn {
            background: linear-gradient(90deg, #2986ff 0%, #3bb6c5 100%);
            color: #fff;
            font-weight: 600;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(41,134,255,0.10);
            border: none;
            transition: background 0.2s, color 0.2s;
        }
        .button:hover, .btn:hover, .close-btn:hover, .procedure-btn:hover {
            background: linear-gradient(90deg, #3bb6c5 0%, #2986ff 100%);
            color: #fff;
        }
        .section-title, .step-title {
            color: #2986ff;
        }
        .step-number {
            background: linear-gradient(90deg, #2986ff 0%, #3bb6c5 100%);
            color: #fff;
        }
        .warning-step {
            background: #eaf6ff;
            border-left: 4px solid #2986ff;
        }
        .warning-step .step-number {
            background: #2986ff;
        }
        footer { width:100%;background:transparent;color:#fff;text-align:center;padding:18px 0 10px 0;font-weight:500;font-size:0.98rem;letter-spacing:1px;margin-top:40px; }
        .nav-link, .nav-link:visited, .nav-link:active, .nav-link:hover {
            text-decoration: none !important;
            border: none !important;
            background: transparent !important;
            color: #fff !important;
            box-shadow: none !important;
        }
        .divider, hr, .section-title, .contact-card h2 {
            border-color: #111 !important;
            background: #111 !important;
            color: #2986ff !important;
        }
        .contact-card h2 {
            border-bottom: 2px solid #111 !important;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="content-container">
        <div class="title-section">
            <h1>Sistem Tempahan Akses Rumah Tamu UKM</h1>
            <p>Platform digital inovatif untuk pengurusan penginapan yang lebih efisien dan sistematik bagi warga UKM</p>
        </div>

        <div class="stats-row">
            <div class="stat-item">
                <div class="stat-number">9</div>
                <div class="stat-label">Rumah Tamu</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">24/7</div>
                <div class="stat-label">Perkhidmatan</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">100+</div>
                <div class="stat-label">Bilik Tersedia</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">1000+</div>
                <div class="stat-label">Pengguna</div>
            </div>
        </div>

        <div class="feature-row">
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <h3>Tempahan Masa Nyata</h3>
                <p>Sistem tempahan dalam talian yang beroperasi 24/7 untuk kemudahan pengguna. Akses mudah dan cepat untuk semua warga UKM.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h3>Keselamatan Terjamin</h3>
                <p>Sistem pembayaran yang selamat dan data pengguna yang dilindungi dengan teknologi keselamatan terkini.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-child"></i>
                </div>
                <h3>Adris</h3>
                <p>Pengasas sistem bagi memudahkan pelajar dan staf Universiti Kebangsaan Malaysia membuat tempahan dengan lebih teratur </p>
            </div>
        </div>
    </div>
    <footer>
        <p>&copy; <?php echo date('Y'); ?> STARTUKM. All rights reserved.</p>
    </footer>
</body>
<head>
  <link rel="icon" type="image/png" href="hihi.png">
</head>
</html>
