<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LamanStaf - STARTUKM</title>
    <link rel="icon" type="image/png" href="haha.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            background: linear-gradient(160deg, #2986ff 0%, #3bb6c5 100%);
            font-family: 'Roboto', Arial, sans-serif;
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

        :root {
            --primary-color: #beae98;
            --secondary-color: #2e7d32;
            --background-color: #f5f5f5;
            --card-color: #ffffff;
            --text-color: #333333;
            --shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .dashboard-container {
            margin-top: 0;
            padding-top: 30px;
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px 60px 20px;
        }

        .welcome-section {
            background: linear-gradient(120deg, #eaf6ff 60%, #cbe7ff 100%);
            color: #222;
            border-radius: 22px;
            margin-bottom: 40px;
            box-shadow: 0 8px 32px rgba(41,134,255,0.10);
            text-align: center;
            font-size: 2.2rem;
            font-weight: 700;
            padding: 36px 0 32px 0;
            letter-spacing: 1px;
        }

        .welcome-section h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 500;
        }

        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 36px;
            margin-top: 30px;
            padding: 0 10px;
        }

        .dashboard-card {
            background: linear-gradient(120deg, #e3f0ff 60%, #fafdff 100%);
            border-radius: 22px;
            box-shadow: 0 8px 32px rgba(41,134,255,0.10);
            border: 1.5px solid #e0e7ef;
            min-height: 220px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            transition: box-shadow 0.2s, border 0.2s, transform 0.2s;
            cursor: pointer;
            margin-bottom: 0;
            backdrop-filter: blur(2px);
        }

        .dashboard-card:hover {
            box-shadow: 0 16px 40px rgba(41,134,255,0.18);
            border: 2px solid #2986ff;
            transform: translateY(-8px) scale(1.04);
            background: linear-gradient(120deg, #d0eaff 60%, #eaf6ff 100%);
        }

        .dashboard-card i {
            font-size: 54px;
            color:rgb(0, 0, 0);
            margin-bottom: 18px;
        }

        .dashboard-card h2 {
            color:rgb(0, 0, 0);
            font-size: 1.25rem;
            font-weight: 800;
            margin: 0;
            letter-spacing: 1px;
        }

        .dashboard-card p {
            color: #444;
            margin: 0;
            font-size: 15px;
            font-weight: 400;
        }

        .close-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background: none;
            border: none;
            color: #999;
            cursor: pointer;
            font-size: 20px;
            padding: 5px;
            transition: color 0.3s ease;
        }

        .close-btn:hover {
            color: #666;
        }

        @media (max-width: 768px) {
            .dashboard-grid {
                grid-template-columns: 1fr;
            }

            .welcome-section {
                padding: 20px;
            }

            .dashboard-card {
                min-height: 180px;
            }
        }

        .main-header {
            background: linear-gradient(160deg, #2986ff 0%, #3bb6c5 100%);
            padding: 18px 0;
            box-shadow: 0 2px 16px rgba(0,0,0,0.08);
            position: sticky;
            top: 0;
            z-index: 1000;
            border-bottom: 1.5px solid #e0e7ef;
        }
        .nav-link:hover, .nav-link.active {
            background: transparent;
            color: #fff;
            font-weight: 600;
        }

        .dashboard-bg {
            background: rgba(255,255,255,0.88);
            border-radius: 28px;
            box-shadow: 0 8px 32px rgba(41,134,255,0.10);
            padding: 40px 20px 60px 20px;
            max-width: 1300px;
            margin: 48px auto 0 auto;
            border: 1.5px solid #e0e7ef;
            backdrop-filter: blur(4px);
        }
    </style>
</head>
<body>
    <?php include 'headerstaf.php'; ?>

    <div class="dashboard-bg">
        <div class="dashboard-container">
            <div class="welcome-section">
                <h1>Selamat Datang ke Laman Staf</h1>
            </div>

            <div class="dashboard-grid">
                <a href="statustempahan.php" class="dashboard-card">
                    <i class="fas fa-clipboard-check"></i>
                    <h2>STATUS TEMPAHAN</h2>
                </a>
                <a href="pengurusan.php" class="dashboard-card">
                    <i class="fas fa-cogs"></i>
                    <h2>PENGURUSAN</h2>
                </a>
                <a href="aduanstaf.php" class="dashboard-card">
                    <i class="fas fa-exclamation-circle"></i>
                    <h2>ADUAN</h2>
                </a>
                <a href="laporanvisual.php" class="dashboard-card">
                    <i class="fas fa-chart-bar"></i>
                    <h2>LAPORAN VISUAL</h2>
                </a>
            </div>
        </div>
    </div>

    <footer style="width:100%;background:transparent;color:#000000;text-align:center;padding:18px 0 10px 0;font-weight:500;font-size:0.98rem;letter-spacing:1px;">
        &copy; 2025 STARTUKM | HAK MILIK ADRIS ROSLAN
    </footer>

    <script>
        document.querySelectorAll('.close-btn').forEach(button => {
            button.addEventListener('click', (e) => {
                e.preventDefault();
                const card = button.closest('.dashboard-card');
                card.style.display = 'none';
            });
        });
    </script>
</body>
</html>


