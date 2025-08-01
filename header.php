<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="icon" type="image/png" href="haha.png">
    <style>
        .main-header {
            background: linear-gradient(160deg, #2986ff 0%, #3bb6c5 100%);
            padding: 18px 0;
            box-shadow: 0 2px 16px rgba(0,0,0,0.08);
            position: sticky;
            top: 0;
            z-index: 1000;
            border-bottom: 1.5px solid #e0e7ef;
        }

        .header-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .brand-name {
            color: #fff;
            font-size: 28px;
            font-weight: 700;
            text-shadow: 0 2px 8px rgba(0,0,0,0.08);
            letter-spacing: 1.5px;
        }

        .nav-menu {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .nav-link {
            color: #fff;
            background: transparent;
            border-radius: 18px;
            font-size: 16px;
            padding: 10px 18px;
            transition: background 0.2s, color 0.2s;
        }

        .nav-link:hover, .nav-link.active {
            background: #fff;
            color: #2986ff;
            font-weight: 600;
        }

        .login-btn {
            background: #fff;
            color: #2986ff;
            border-radius: 18px;
            font-weight: 600;
            padding: 10px 22px;
            box-shadow: 0 2px 8px rgba(59,182,197,0.08);
            border: none;
            transition: background 0.2s, color 0.2s, box-shadow 0.2s;
        }

        .login-btn:hover {
            background: #2986ff;
            color: #fff;
            box-shadow: 0 4px 16px rgba(41,134,255,0.12);
        }

        @media (max-width: 768px) {
            .header-container {
                padding: 0 10px;
            }

            .brand-name {
                font-size: 20px;
            }

            .nav-menu {
                gap: 10px;
            }

            .nav-link {
                padding: 6px 12px;
                font-size: 14px;
            }

            .nav-link span {
                display: none; /* Hide text, show only icons on mobile */
            }

            .login-btn {
                padding: 6px 15px;
            }
        }

        @media (max-width: 480px) {
            .nav-menu {
                gap: 5px;
            }

            .nav-link {
                padding: 6px 10px;
            }

            .login-btn {
                padding: 6px 12px;
            }
        }
    </style>
</head>
<body>
    <header class="main-header">
        <div class="header-container">
            <a href="lamanutama.php" class="brand-name">STARTUKM</a>
            
            <nav class="nav-menu">
                <a href="lamanutama.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'lamanutama.php' ? 'active' : ''; ?>">
                    <i class="fas fa-home"></i>
                    <span>Utama</span>
                </a>
                <a href="aduancus.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'about.php' ? 'active' : ''; ?>">
                <i class="fa fa-list-alt" aria-hidden="true"></i>
                    <span>Aduan</span>
                </a>
                <a href="hubungiuser.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'contact.php' ? 'active' : ''; ?>">
                    <i class="fas fa-envelope"></i>
                    <span>Hubungi Kami</span>
                </a>
                <a href="ringkasanuser.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'about.php' ? 'active' : ''; ?>">
                    <i class="fas fa-info-circle"></i>
                    <span>Tentang Kami</span>
                </a>
                
                
                    <a href="login.php" class="login-btn">
                        <i class="fas fa-sign-in-alt"></i>
                        <span>Log Keluar</span>
                    </a>
                
            </nav>
        </div>
    </header>
</body>
</html>