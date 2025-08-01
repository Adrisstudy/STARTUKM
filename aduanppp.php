<?php
include('headerppp.php');
?>

<?php
$host = "sql311.infinityfree.com";
$user = "if0_39232870";  
$pass = "Awf1G8OrL2CcF";      
$dbname = "if0_39232870_startukm"; 

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Sambungan Gagal: " . $conn->connect_error);
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['aduan_id']) && isset($_POST['status'])) {
    $aduan_id = intval($_POST['aduan_id']); 
	$status = $_POST['status'];


    $sql_update = "UPDATE aduan SET fld_lpr_status = ? WHERE fld_lpr_id = ?";
    $stmt = $conn->prepare($sql_update);
    $stmt->bind_param("si", $status, $aduan_id);

    if ($stmt->execute()) {
    echo "success"; 
} else {
    echo "error: " . $stmt->error;
}

    $stmt->close();
    exit();
}


$sql = "SELECT fld_lpr_id, fld_lpr_details, fld_lpr_date, fld_lpr_status, fld_kolej 
        FROM aduan 
        ORDER BY 
            CASE fld_lpr_status 
                WHEN 'Pending' THEN 1 
                ELSE 2 
            END, fld_lpr_date DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Senarai Aduan Tetamu</title>
    <link rel="icon" type="image/png" href="haha.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body { background: linear-gradient(160deg, #2986ff 0%, #3bb6c5 100%); font-family: 'Roboto', Arial, sans-serif; margin:0; padding:0; }
        .aduan-container { background: #fff; border-radius: 18px; box-shadow: 0 8px 32px rgba(41,134,255,0.10); padding: 32px 28px; margin: 40px auto 0 auto; max-width: 900px; }
        .aduan-title { color: #2986ff; font-size: 2rem; font-weight: 700; text-align: center; margin-bottom: 30px; }
        .aduan-list { display: flex; flex-wrap: wrap; gap: 24px; justify-content: center; }
        .aduan-card { background: #fafdff; border-radius: 18px; box-shadow: 0 4px 16px #2986ff22; padding: 28px 32px 22px 32px; min-width: 320px; max-width: 480px; flex: 1 1 340px; display: flex; flex-direction: column; gap: 12px; position: relative; transition: box-shadow 0.2s; }
        .aduan-card:hover { box-shadow: 0 8px 32px #2986ff44; }
        .aduan-header { display: flex; align-items: center; gap: 14px; margin-bottom: 6px; }
        .aduan-icon { font-size: 2.1rem; color: #2986ff; }
        .aduan-id { font-size: 1.1rem; color: #888; font-weight: 600; }
        .aduan-status { display: flex; align-items: center; gap: 8px; margin-top: 6px; }
        .badge-status { padding: 6px 18px; border-radius: 16px; font-weight: 600; font-size: 1rem; letter-spacing: 1px; }
        .badge-pending { background: #eaf6ff; color: #2986ff; border: 1.5px solid #2986ff; }
        .badge-resolved { background: #e0ffe7; color: #388e3c; border: 1.5px solid #388e3c; }
        .aduan-details { font-size: 1.13rem; color: #222; margin-bottom: 4px; }
        .aduan-meta { display: flex; gap: 18px; font-size: 0.98rem; color: #555; align-items: center; margin-bottom: 2px; }
        .aduan-meta i { margin-right: 5px; color: #2986ff; }
        .toggle-switch { position: relative; width: 54px; height: 28px; }
        .toggle-switch input { opacity: 0; width: 0; height: 0; }
        .slider { position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background: #e57373; border-radius: 28px; transition: .4s; }
        .slider:before { position: absolute; content: ""; height: 22px; width: 22px; left: 3px; bottom: 3px; background: white; border-radius: 50%; transition: .4s; box-shadow: 0 2px 8px #0002; }
        input:checked + .slider { background: #66bb6a; }
        input:checked + .slider:before { transform: translateX(26px); }
        .toggle-label { margin-left: 12px; font-weight: 600; font-size: 1rem; }
        footer { width:100%;background:transparent;color:#2986ff;text-align:center;padding:18px 0 10px 0;font-weight:500;font-size:0.98rem;letter-spacing:1px;margin-top:40px; }
        @media (max-width: 700px) { .aduan-list { flex-direction: column; gap: 18px; } .aduan-card { min-width: 0; max-width: 100%; padding: 18px 10px; } }
    </style>
</head>
<body>
<div class="aduan-container">
    <div class="aduan-title"><i class="fas fa-clipboard-list"></i> Senarai Aduan Tetamu</div>
    <div class="aduan-list">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $isResolved = strtolower($row['fld_lpr_status']) === 'resolved';
                echo "<div class='aduan-card' id='aduan-{$row['fld_lpr_id']}'>";
                echo "<div class='aduan-header'><span class='aduan-icon'><i class='fas fa-exclamation-circle'></i></span><span class='aduan-id'>#{$row['fld_lpr_id']}</span></div>";
                echo "<div class='aduan-details'>{$row['fld_lpr_details']}</div>";
                echo "<div class='aduan-meta'><span><i class='fas fa-calendar-alt'></i> {$row['fld_lpr_date']}</span><span><i class='fas fa-university'></i> {$row['fld_kolej']}</span></div>";
                echo "<div class='aduan-status'>";
                echo "<label class='toggle-switch'><input type='checkbox' onchange='updateStatus({$row['fld_lpr_id']}, this)'".($isResolved?" checked":"")."><span class='slider'></span></label>";
                echo $isResolved ? "<span class='badge-status badge-resolved'>Resolved</span>" : "<span class='badge-status badge-pending'>Pending</span>";
                echo "</div>";
                echo "</div>";
            }
        } else {
            echo "<div style='text-align:center;width:100%;color:#888;font-size:1.2rem;padding:40px 0;'>Tiada aduan direkodkan.</div>";
        }
        ?>
    </div>
</div>
<script>
function updateStatus(aduanId, checkbox) {
    let status = checkbox.checked ? "Resolved" : "Pending";
    fetch("aduanppp.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: "aduan_id=" + aduanId + "&status=" + status
    })
    .then(response => response.text())
    .then(data => {
        let card = document.getElementById('aduan-' + aduanId);
        let badge = card.querySelector('.badge-status');
        if (status === "Resolved") {
            badge.textContent = "Resolved";
            badge.className = "badge-status badge-resolved";
        } else {
            badge.textContent = "Pending";
            badge.className = "badge-status badge-pending";
        }
    })
    .catch(error => alert("Ralat rangkaian: " + error.message));
}
</script>
</body>
</html>

