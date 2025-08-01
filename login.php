<?php
session_start();
include 'db.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $password = $_POST['password'];
    
    require 'db.php';
    
   
    $sql = "SELECT * FROM user WHERE fld_user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        
        if ($password == $row['fld_user_pass']) { 
            $_SESSION['user_id'] = $row['fld_user_id'];
            $_SESSION['role'] = $row['fld_user_role'];
            $_SESSION['user_name'] = $row['fld_user_name'];
            $_SESSION['user_email'] = $row['fld_user_email'];
            $_SESSION['user_phone'] = $row['fld_user_phone'];
            
        
            switch ($row['fld_user_role']) {
                case 'PELAJAR':
                    echo "<script>window.location.href = 'lamanutama.php';</script>";
                    exit();
                case 'STAF KOLEJ':
                    echo "<script>window.location.href = 'lamanstaf.php';</script>";
                    exit();
                case 'PPP':
                    echo "<script>window.location.href = 'lamanppp.php';</script>";
                    exit();
                default:
                    echo "<script>alert('Peranan tidak sah.');</script>";
            }
        } else {
            echo "<script>alert('KATA LALUAN ANDA SALAH');</script>";
        }
    } else {
        echo "<script>alert('ID TIDAK DIJUMPAI.');</script>";
    }
    
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log Masuk - START UKM</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/png" href="haha.png">
    <link rel="stylesheet" href="header.css">
    <style>
        body {
            min-height: 100vh;
            margin: 0;
            padding: 0;
            font-family: 'Poppins', 'Roboto', Arial, sans-serif;
            background: linear-gradient(135deg, #e0eafc 0%, #cfdef3 100%, #b6e0fe 100%);
            background-size: cover;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }
        @keyframes gradientMove {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        .login-glass {
            background: rgba(255,255,255,0.18);
            box-shadow: 0 8px 32px #2986ff33, 0 0 0 2px #43e97b44;
            border-radius: 32px;
            padding: 54px 38px 38px 38px;
            max-width: 380px;
            width: 100%;
            margin: 0 auto;
            text-align: center;
            position: relative;
            animation: fadeInUp 0.8s cubic-bezier(.39,.575,.56,1.000);
            border: 2.5px solid #43e97b;
            backdrop-filter: blur(18px) saturate(160%);
            transition: box-shadow 0.3s, border 0.3s;
        }
        .login-glass:hover {
            box-shadow: 0 12px 48px #7f53ac44, 0 0 0 4px #43e97b99;
            border: 2.5px solid #7f53ac;
        }
        @keyframes fadeInUp {
            0% { opacity: 0; transform: translateY(40px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        .login-glass img {
            width: 76px;
            height: 76px;
            border-radius: 50%;
            margin-bottom: 18px;
            box-shadow: 0 2px 18px #2986ff33, 0 0 0 4px #43e97b55;
            object-fit: cover;
            border: 2.5px solid #7f53ac;
        }
        .login-title {
            font-size: 2.1rem;
            font-weight: 900;
            color: #111;
            margin-bottom: 18px;
            letter-spacing: 1.5px;
            text-shadow: 0 2px 12px #7f53ac11;
        }
        .login-form {
            margin-top: 10px;
        }
        .login-label {
            display: block;
            text-align: left;
            color: #111;
            font-weight: 700;
            margin-bottom: 6px;
            font-size: 1.08em;
        }
        .login-input {
            width: 100%;
            padding: 14px 18px;
            border-radius: 14px;
            border: 1.5px solid #e0e7ef;
            background: linear-gradient(90deg, #eaf6ff 0%, #fff 100%);
            color: #222;
            font-size: 1.12em;
            margin-bottom: 20px;
            font-family: inherit;
            transition: border 0.2s, box-shadow 0.2s;
            box-shadow: 0 2px 8px #2986ff11;
        }
        .login-input:focus {
            border-color: #7f53ac;
            outline: none;
            box-shadow: 0 0 0 3px #7f53ac33;
        }
        .login-btn {
            width: 100%;
            background: linear-gradient(90deg, #2986ff 0%, #43e97b 100%);
            color: #fff;
            font-weight: 800;
            border: none;
            border-radius: 14px;
            padding: 14px 0;
            font-size: 1.13em;
            margin-top: 8px;
            box-shadow: 0 2px 12px #43e97b33, 0 0 8px #7f53ac33 inset;
            transition: box-shadow 0.2s, background 0.2s;
            letter-spacing: 1px;
        }
        .login-btn:active {
            background: linear-gradient(90deg, #7f53ac 0%, #43e97b 100%);
            box-shadow: 0 0 18px #43e97b77, 0 0 8px #7f53ac55 inset;
        }
        .login-footer {
            margin-top: 26px;
            color: #7f53ac;
            font-size: 1em;
            opacity: 0.88;
            font-weight: 500;
        }
        @media (max-width: 500px) {
            .login-glass {
                padding: 28px 8px 18px 8px;
                max-width: 98vw;
            }
        }
    </style>
</head>
<>
<body>
    <div class="login-glass">
        <img src="haha.png" alt="Logo START UKM">
        <div class="login-title">LOG MASUK</div>
        <form method="POST" class="login-form">
            <label for="id" class="login-label">Nombor Matrik / UKM Per</label>
            <input type="text" id="id" name="id" placeholder="Nombor Matriks/ UKMPer" class="login-input" required>
            <label for="password" class="login-label">Kata Laluan</label>
            <input type="password" id="password" name="password" placeholder="Kata Laluan" class="login-input" required>
            <button type="submit" class="login-btn">Log Masuk</button>
        </form>
        <div class="login-footer">Lupa kata laluan? Sila ubah kata laluan anda di SMPWeb</div>
    </div>
</body>
</html>
