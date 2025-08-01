<?php
session_start();
include 'db.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $password = $_POST['password'];
    

    $conn = new mysqli("localhost", "root", "", "startukm");
    if ($conn->connect_error) {
        die("Sambungan gagal: " . $conn->connect_error);
    }
    
    $sql = "SELECT * FROM user WHERE fld_user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        if ($password == $row['fld_user_pass']) {
            $_SESSION['id'] = $row['fld_user_id'];
            $_SESSION['role'] = $row['fld_user_role'];
            
            switch ($row['fld_user_role']) {
                case 'PELAJAR':
                    header("Location: lamanutama_pelajar.php");
                    break;
                case 'STAFKOLEJ':
                    header("Location: lamanutama_staf.php");
                    break;
                case 'PENTADBIR':
                    header("Location: lamanutama_ppp.php");
                    break;
                default:
                    echo "<script>alert('Peranan tidak sah.'); window.location.href='login.php';</script>";
            }
            exit();
        } else {
            echo "<script>alert('Kata laluan salah.'); window.location.href='login.php';</script>";
        }
    } else {
        echo "<script>alert('ID tidak dijumpai.'); window.location.href='login.php';</script>";
    }
    
    $stmt->close();
    $conn->close();
}
?>
