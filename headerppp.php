<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
 <link rel="icon" type="image/png" href="haha.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
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
            color: white;
            font-size: 24px;
            font-weight: 600;
            text-decoration: none;
            letter-spacing: 1px;
        }

        .nav-menu {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-left: auto;
        }

        .nav-link {
            color: white;
            text-decoration: none;
            padding: 8px 15px;
            border-radius: 20px;
            font-size: 15px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .nav-link:hover {
            background: rgba(255,255,255,0.1);
        }

        .nav-link.active {
            background: white;
            color:rgb(0, 0, 0);
        }

        .login-btn {
            background: white;
            color:rgb(0, 0, 0);
            padding: 8px 20px;
            border-radius: 20px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        /* Remove underlines from all links */
        a {
            text-decoration: none !important;
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
            <a href="lamanppp.php" class="brand-name">STARTUKM</a>
            <nav class="nav-menu">
                <a href="hubungippp.php" class="nav-link">
                    <i class="fas fa-envelope"></i>
                    <span>Hubungi Kami</span>
                </a>
                <a href="ringkasanppp.php" class="nav-link">
                    <i class="fas fa-info-circle"></i>
                    <span>Tentang Kami</span>
                </a>
                <a href="login.php" class="login-btn">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Log Keluar</span>
                </a>
            </nav>
        </div>
    </header>
</body>
</html>