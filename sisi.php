<?php
$host = "sql311.infinityfree.com";
$user = "if0_39232870";  
$pass = "Awf1G8OrL2CcF";      
$dbname = "if0_39232870_startukm"; 

$conn = new mysqli($host, $user, $pass, $dbname);
date_default_timezone_set('Asia/Kuala_Lumpur');

if ($conn->connect_error) {
    die("Sambungan Gagal: " . $conn->connect_error);
}
$kolej_list = [
    "1" => "Kolej Pendeta Za'ba",
    "2" => "Kolej Ungku Omar",
    "3" => "Kolej Ibrahim Yaakub",
    "4" => "Kolej Burhanuddin Helmi",
    "5" => "Kolej Dato Onn",
    "6" => "Kolej Rahim Kajai",
    "7" => "Kolej Ibu Zain",
    "8" => "Kolej Aminuddin Baki",
    "9" => "Kolej Keris Mas"
];

session_start(); 
if (isset($_POST['aduan'], $_POST['tarikh_lapor'], $_POST['rumah_tamu'])) {
    $aduan = $_POST['aduan']; 
    $tarikh_lapor = $_POST['tarikh_lapor'];
    $kolej_id = $_POST['rumah_tamu']; 

    $kolej_nama = isset($kolej_list[$kolej_id]) ? $kolej_list[$kolej_id] : "Kolej Tidak Dikenali";

    
    $status = "Pending";

    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

    
    $sql = "INSERT INTO aduan (fld_user_id, fld_lpr_details, fld_lpr_date, fld_lpr_status, fld_kolej) 
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $user_id, $aduan, $tarikh_lapor, $status, $kolej_nama);

    if ($stmt->execute()) {
        echo "<script>alert('Aduan berjaya dihantar!'); window.location.href='aduancus.php';</script>";
    } else {
        echo "Ralat: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Sila lengkapkan semua maklumat!";
}

$conn->close();
?>
