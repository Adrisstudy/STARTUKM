<?php
$host = "sql311.infinityfree.com";
$user = "if0_39232870";  
$pass = "Awf1G8OrL2CcF";   
$dbname = "if0_39232870_startukm"; 

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Sambungan Gagal: " . $conn->connect_error);
}