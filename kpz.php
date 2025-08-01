<?php include('header.php'); ?>
<?php
include('db.php');
$id_kolej = 4; 
$sql = "SELECT * FROM inforumahtamu WHERE id_kolej = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $id_kolej);
$stmt->execute();
$result = $stmt->get_result();
$kolej = $result->fetch_assoc();
if (!$kolej) {
    echo "<div style='color:red;text-align:center;margin:40px 0;'>Maklumat Kolej Pendeta Za'ba belum dimasukkan oleh staf.<br>Sila hubungi pentadbir untuk kemaskini info.</div>";
    exit;
}
$kemudahan = json_decode($kolej['kemudahan'] ?? '[]', true);
$gambar_list = json_decode($kolej['gambar'] ?? '[]', true);
if (!is_array($gambar_list)) $gambar_list = [];
?>
<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $kolej['nama_kolej']; ?> - START UKM</title>
     <link rel="icon" type="image/png" href="haha.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@700&family=Roboto:wght@400&display=swap" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(120deg, #e0eafc 0%, #cfdef3 100%);
            font-family: 'Roboto', Arial, sans-serif;
            min-height: 100vh;
        }
        .futuristic-card {
            background: rgba(255,255,255,0.7);
            box-shadow: 0 8px 32px 0 rgba(31,38,135,0.18);
            border-radius: 20px;
            padding: 32px 40px;
            margin: 40px auto 30px auto;
            max-width: 1100px;
            backdrop-filter: blur(6px);
            border: 1.5px solid rgba(255,255,255,0.25);
            transition: box-shadow 0.3s;
        }
        .futuristic-card:hover {
            box-shadow: 0 12px 40px 0 rgba(31,38,135,0.25);
        }
        .college-title {
            font-family: 'Orbitron', Arial, sans-serif;
            font-size: 2.5rem;
            letter-spacing: 2px;
            color: #2d3a4b;
            margin-bottom: 10px;
        }
        .college-desc {
            font-size: 1.15rem;
            color: #444;
            margin-bottom: 18px;
        }
        .slideshow-container {
            position: relative;
            width: 100%;
            max-width: 420px;
            height: 320px;
            margin: 0 auto 30px auto;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 4px 24px #0002;
        }
        .slide-img {
            width: 100%;
            height: 320px;
            object-fit: cover;
            display: block;
        }
        .info-section {
            display: flex;
            flex-wrap: wrap;
            gap: 32px;
            align-items: flex-start;
        }
        .info-text {
            flex: 1 1 350px;
        }
        .kemudahan-section {
            margin-top: 40px;
        }
        .kemudahan-title {
            font-family: 'Orbitron', Arial, sans-serif;
            font-size: 1.5rem;
            color: #2d3a4b;
            margin-bottom: 18px;
        }
        .kemudahan-grid-wide {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 24px;
            width: 100%;
            margin: 0 auto;
            padding: 0 10px;
        }
        .kemudahan-block {
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255,255,255,0.95);
            border-radius: 18px;
            box-shadow: 0 2px 16px #beae9822;
            padding: 28px 0;
            font-size: 1.3rem;
            font-family: 'Orbitron', Arial, sans-serif;
            color: #2d3a4b;
            font-weight: 600;
            letter-spacing: 1px;
            transition: box-shadow 0.2s, transform 0.2s;
            border: 2px solid #beae98;
            min-height: 70px;
        }
        .kemudahan-block:hover {
            box-shadow: 0 8px 32px #beae98aa;
            background: #f7f3ed;
            transform: translateY(-4px) scale(1.03);
        }
        .kemudahan-icon {
            font-size: 2.1rem;
            color: #beae98;
            margin-right: 18px;
        }
        .kemudahan-block .kemudahan-text {
            font-size: 1.25rem;
            color: #2d3a4b;
        }
        .map-section {
            margin: 50px 0 0 0;
            text-align: center;
        }
        .map-title {
            font-family: 'Orbitron', Arial, sans-serif;
            font-size: 1.5rem;
            color: #2d3a4b;
            margin-bottom: 18px;
        }
        .map-frame {
            border: 4px solid #beae98;
            border-radius: 16px;
            width: 90%;
            max-width: 800px;
            height: 400px;
            box-shadow: 0 4px 24px #0001;
        }
        @media (max-width: 900px) {
            .info-section { flex-direction: column; }
            .slideshow-container { margin-bottom: 20px; }
        }
    </style>
</head>
<body>
    <div class="futuristic-card">
        <div class="info-section">
            <div class="slideshow-container">
                <?php if (!empty($gambar_list)): ?>
                    <div id="slideshow">
                        <?php foreach ($gambar_list as $i => $gambar): ?>
                            <img src="img/<?php echo $gambar; ?>" class="slide-img" alt="<?php echo $kolej['nama_kolej']; ?>" style="display:<?php echo $i === 0 ? 'block' : 'none'; ?>;">
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <img src="img/<?php echo $kolej['gambar'] ?: 'default.jpg'; ?>" class="slide-img" alt="<?php echo $kolej['nama_kolej']; ?>">
                <?php endif; ?>
            </div>
            <div class="info-text">
                <div class="college-title"><?php echo $kolej['nama_kolej']; ?></div>
                <div class="college-desc"><?php echo nl2br($kolej['sejarah']); ?></div>
            </div>
        </div>
        <div class="kemudahan-section">
            <div class="kemudahan-title">KEMUDAHAN</div>
            <div class="kemudahan-grid-wide">
                <?php foreach($kemudahan as $item): ?>
                    <div class="kemudahan-block">
                        <span class="kemudahan-icon"><i class="fas fa-check"></i></span>
                        <span class="kemudahan-text"><?php echo htmlspecialchars($item); ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="map-section">
            <div class="map-title">PETA</div>
            <iframe src="https://www.google.com/maps?q=<?php echo urlencode($kolej['nama_kolej']); ?>&output=embed" class="map-frame" allowfullscreen="" loading="lazy"></iframe>
        </div>
    </div>
    <script src="https://kit.fontawesome.com/4e8e45b1b7.js" crossorigin="anonymous"></script>
    <script>
    
    document.addEventListener('DOMContentLoaded', function() {
        var slides = document.querySelectorAll('#slideshow .slide-img');
        if (slides.length > 1) {
            let idx = 0;
            setInterval(function() {
                slides[idx].style.display = 'none';
                idx = (idx + 1) % slides.length;
                slides[idx].style.display = 'block';
            }, 3000);
        }
    });
    </script>
</body>
</html>