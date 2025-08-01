<?php
$host = "sql311.infinityfree.com";
$user = "if0_39232870";  
$pass = "Awf1G8OrL2CcF";      
$dbname = "if0_39232870_startukm"; 

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Sambungan Gagal: " . $conn->connect_error);
}


if (isset($_POST['nama'], $_POST['aduan'], $_POST['tarikh_lapor'], $_POST['rumah_tamu'])) {
    $nama_pengguna = $_POST['nama']; 
    $aduan = $_POST['aduan'];
    $tarikh_lapor = $_POST['tarikh_lapor']; 
    $kolej = $_POST['rumah_tamu']; 
    
    $status = "Pending";
    $sql = "INSERT INTO aduan (fld_lpr_details, fld_lpr_date, fld_lpr_status, fld_user_id, fld_admin_id) 
            VALUES (?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssii", $aduan, $tarikh_lapor, $status, $nama_pengguna, $kolej);

    if ($stmt->execute()) {
        echo "<script>alert('Aduan berjaya dihantar!'); window.location.href='borang_aduan.html';</script>";
    } else {
        echo "Ralat: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Sila lengkapkan semua maklumat!";
}
