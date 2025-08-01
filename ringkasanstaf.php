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
            font-family: 'Poppins', 'Roboto', Arial, sans-serif;
            background: linear-gradient(120deg, #e0eafc 0%, #cfdef3 100%);
            min-height: 100vh;
        }

        .content-container {
            max-width: 1000px;
            margin: 60px auto;
            padding: 0 20px;
        }

        .title-section {
            text-align: center;
            margin-bottom: 60px;
            padding: 48px 32px 32px 32px;
            background: #fff;
            border-radius: 24px;
            box-shadow: 0 8px 32px #2986ff22;
        }

        .title-section h1 {
            font-size: 2.5em;
            margin-bottom: 18px;
            color: #2986ff;
            font-weight: 800;
        }

        .title-section p {
            font-size: 1.2em;
            color: #444;
            max-width: 700px;
            margin: 0 auto;
            line-height: 1.6;
            font-weight: 500;
        }

        .stats-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 28px;
            margin: 40px 0;
        }

        .stat-item {
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 4px 18px #2986ff22;
            padding: 32px 18px;
            text-align: center;
            transition: box-shadow 0.2s, transform 0.2s;
            position: relative;
        }

        .stat-item:hover {
            box-shadow: 0 8px 32px #2986ff33;
            transform: translateY(-4px) scale(1.03);
        }

        .stat-icon {
            font-size: 2.5rem;
            color: #111 !important;
            background: none !important;
            -webkit-background-clip: unset !important;
            -webkit-text-fill-color: unset !important;
            background-clip: unset !important;
            text-fill-color: unset !important;
            margin-bottom: 10px;
        }

        .stat-number {
            font-size: 2.2em;
            font-weight: 800;
            color: #111 !important;
        }

        .stat-label {
            color: #111 !important;
            font-size: 1.1rem;
            font-weight: 600;
            margin-top: 6px;
        }

        .feature-row {
            display: flex;
            justify-content: center;
            gap: 25px;
            margin-top: 40px;
            flex-wrap: wrap;
        }

        .feature-card {
            flex: 1;
            background: white;
            border-radius: 12px;
            padding: 30px;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: 1px solid rgba(139, 115, 85, 0.1);
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(139, 115, 85, 0.2);
        }

        .feature-icon {
            width: 70px;
            height: 70px;
            background: #111 !important;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 25px;
            transition: background-color 0.3s ease;
        }

        .feature-card:hover .feature-icon {
            background: #222 !important;
        }

        .feature-icon i {
            font-size: 2em;
            color: #fff !important;
        }

        .feature-card h3 {
            color: #111 !important;
            margin: 0 0 15px 0;
            font-size: 1.4em;
        }

        .feature-card p {
            color: #111 !important;
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
    </style>
</head>
<body>
    <?php include 'headerstaf.php'; ?>

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
</body>
<head>
  <link rel="icon" type="image/png" href="hihi.png">
</head>
</html>
