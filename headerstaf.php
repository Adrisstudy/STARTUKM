<!DOCTYPE html>
 <link rel="icon" type="image/png" href="haha.png">
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .main-header {
            background: linear-gradient(160deg, #2986ff 0%, #3bb6c5 100%);
            padding: 10px 0;
            box-shadow: 0 2px 16px rgba(0,0,0,0.08);
            position: sticky;
            top: 0;
            z-index: 1000;
            border-bottom: 1.5px solid #e0e7ef;
        }

        .header-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .brand-name {
            color: #111;
            font-size: 19px;
            font-weight: 700;
            text-decoration: none;
            letter-spacing: 1px;
            font-family: 'Poppins', 'Roboto', Arial, sans-serif;
        }

        .nav-menu {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-left: auto;
        }

        .nav-link {
            color: #111;
            text-decoration: none;
            padding: 5px 10px;
            border-radius: 16px;
            font-size: 14px;
            font-family: 'Poppins', 'Roboto', Arial, sans-serif;
            font-weight: 500;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .nav-link i {
            color: #2986ff !important;
            font-size: 1.05em !important;
        }

        .nav-link span {
            font-size: 14px;
            font-family: 'Poppins', 'Roboto', Arial, sans-serif;
        }

        .nav-link:hover {
            background: rgba(255,255,255,0.08);
        }

        .nav-link.active {
            background: white;
            color: #2986ff;
        }

        .login-btn {
            color: #111 !important;
            background: #fff !important;
            border-radius: 14px;
            font-weight: 700;
            padding: 7px 16px;
            font-size: 14px;
            font-family: 'Poppins', 'Roboto', Arial, sans-serif;
            box-shadow: 0 2px 8px rgba(59,182,197,0.08);
            border: none;
            transition: background 0.2s, color 0.2s, box-shadow 0.2s;
            display: flex;
            align-items: center;
            gap: 4px;
        }
        .login-btn i {
            color: #2986ff !important;
            font-size: 1.1em !important;
        }
        .login-btn span {
            font-size: 14px;
            font-family: 'Poppins', 'Roboto', Arial, sans-serif;
        }
        .login-btn:hover {
            background: linear-gradient(90deg, #2986ff 0%, #3bb6c5 100%) !important;
            color: #fff !important;
            box-shadow: 0 4px 16px rgba(41,134,255,0.12);
        }

        a {
            text-decoration: none !important;
        }

        @media (max-width: 768px) {
            .header-container {
                padding: 0 6px;
            }
            .brand-name {
                font-size: 16px;
            }
            .nav-menu {
                gap: 6px;
            }
            .nav-link {
                padding: 4px 7px;
                font-size: 12.5px;
            }
            .nav-link span, .login-btn span {
                font-size: 12.5px;
            }
            .login-btn {
                padding: 5px 10px;
                font-size: 12.5px;
            }
        }
        @media (max-width: 480px) {
            .nav-menu {
                gap: 3px;
            }
            .nav-link {
                padding: 3px 5px;
            }
            .login-btn {
                padding: 4px 7px;
            }
        }
    </style>
</head>
<body>
    <header class="main-header">
        <div class="header-container">
            <a href="lamanstaf.php" class="brand-name">STARTUKM</a>
            <nav class="nav-menu">
                <a href="hubungistaf.php" class="nav-link">
                    <i class="fas fa-envelope"></i>
                    <span>Hubungi Kami</span>
                </a>
                <a href="ringkasanstaf.php" class="nav-link">
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