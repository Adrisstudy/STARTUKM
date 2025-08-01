<?php
session_start();
include 'db.php';
//staf je blh akses
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'STAF KOLEJ') {
    header('Location: login.php');
    exit();
}

// tambah/baca/kemaskini/padam info kolej
$msg = '';
$edit_data = null;
if (isset($_GET['edit'])) {
    $edit_id = intval($_GET['edit']);
    $res = $conn->query("SELECT * FROM inforumahtamu WHERE id_kolej=$edit_id");
    if ($res && $res->num_rows > 0) {
        $edit_data = $res->fetch_assoc();
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $nama = trim($_POST['nama']);
    $sejarah = trim($_POST['sejarah']);
    $kemudahan = isset($_POST['kemudahan']) ? json_encode(array_filter($_POST['kemudahan'])) : '[]';
    $gambar_arr = [];

    // Hadle upload gambar 
    if (isset($_FILES['gambar_kolej']) && is_array($_FILES['gambar_kolej']['name']) && count($_FILES['gambar_kolej']['name']) > 0) {
        foreach ($_FILES['gambar_kolej']['name'] as $key => $name) {
            if ($_FILES['gambar_kolej']['error'][$key] == 0 && $name != '') {
                $target_dir = "img/";
                if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);
                $target_file = $target_dir . basename($name);
                move_uploaded_file($_FILES["gambar_kolej"]["tmp_name"][$key], $target_file);
                $gambar_arr[] = $name;
            }
        }
    }

    if ($id > 0) {
        //  gambar lama
        $res = $conn->query("SELECT gambar FROM inforumahtamu WHERE id_kolej=$id");
        $row = $res->fetch_assoc();
        $gambar_lama = json_decode($row['gambar'] ?? '[]', true);
        if (!is_array($gambar_lama)) $gambar_lama = [];
        // Buang gambar 
        $gambar_buang = isset($_POST['gambar_buang']) ? json_decode($_POST['gambar_buang'], true) : [];
        if (!is_array($gambar_buang)) $gambar_buang = [];
        $gambar_lama = array_values(array_diff($gambar_lama, $gambar_buang));
        // Gabungkan gambar lama & baru
        $gambar_arr = array_merge($gambar_lama, $gambar_arr);
        // Pastikan max 20 gambar je
        $gambar_arr = array_slice($gambar_arr, 0, 20);
        $gambar_json = json_encode($gambar_arr);
        $sql = "UPDATE inforumahtamu SET nama_kolej=?, sejarah=?, kemudahan=?, gambar=? WHERE id_kolej=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssssi', $nama, $sejarah, $kemudahan, $gambar_json, $id);
        $stmt->execute();
        $msg = 'Maklumat Kolej berjaya dikemaskini!';
    } else {
        // Tambah info
        $gambar_json = json_encode($gambar_arr);
        $sql = "INSERT INTO inforumahtamu (nama_kolej, sejarah, kemudahan, gambar) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $nama, $sejarah, $kemudahan, $gambar_json);
        $stmt->execute();
        $msg = 'Kolej berjaya ditambah!';
    }
}
if (isset($_GET['padam'])) {
    $id = intval($_GET['padam']);
    $conn->query("DELETE FROM inforumahtamu WHERE id_kolej=$id");
    $msg = 'Kolej selesai dipadam!';
}
// 
$kolej = $conn->query("SELECT * FROM inforumahtamu ORDER BY nama_kolej");
?>
<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengurusan Kolej - START UKM</title>
    <link rel="icon" type="image/png" href="haha.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@700&family=Roboto:wght@400&display=swap" rel="stylesheet">
    <style>
        body { background: linear-gradient(120deg, #e0eafc 0%, #cfdef3 100%); font-family: 'Roboto', Arial, sans-serif; min-height: 100vh; }
        .container { max-width: 1100px; margin: 30px auto; background: #fff; border-radius: 16px; box-shadow: 0 4px 16px #0001; padding: 30px; }
        .kolej-card { box-shadow: 0 2px 8px #0002; border-radius: 10px; margin-bottom: 20px; overflow: hidden; display: flex; flex-direction: column; align-items: stretch; background: #f9f9f9; }
        .kolej-img-row { display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 8px; justify-content: flex-start; }
        .kolej-img { width: 80px; height: 60px; object-fit: cover; border-radius: 8px; box-shadow: 0 2px 8px #0001; background: #eee; }
        .kemudahan-badge { background: #beae98; color: #fff; border-radius: 20px; padding: 5px 15px; margin: 2px; display: inline-block; }
        .btn-action { min-width: 80px; font-size: 15px; margin-bottom: 5px; margin-right: 8px; border-radius: 8px; }
        .btn-warning.btn-action { background: #ffc107; color: #222; border: none; }
        .btn-danger.btn-action { background: #dc3545; color: #fff; border: none; }
        .btn-action:hover { opacity: 0.9; }
        .form-section { background: #f7f7f7; border-radius: 10px; padding: 20px; margin-bottom: 30px; }
        .chip { display: inline-block; background: #beae98; color: #fff; border-radius: 16px; padding: 4px 12px; margin: 2px; font-size: 14px; }
        .chip .remove { margin-left: 8px; cursor: pointer; color: #fff; }
        .form-label { font-weight: 500; }
        .btn-tambah { min-width: 120px; font-size: 16px; border-radius: 8px; margin-bottom: 18px; }
        .img-wrapper { position: relative; display: inline-block; }
        .remove-img {
            position: absolute; top: 0; right: 0; background: #dc3545; color: #fff; border-radius: 50%;
            width: 20px; height: 20px; text-align: center; line-height: 20px; cursor: pointer; font-weight: bold;
            font-size: 16px; box-shadow: 0 1px 4px #0002;
        }
        .img-wrapper img { display: block; }
    </style>
</head>
<body>
<?php include 'headerstaf.php'; ?>
<div class="container">
    <h2 class="mb-4">Pengurusan Kolej</h2>
    <div class="d-flex gap-2 mb-3">
        <button type="button" class="btn btn-success btn-tambah" onclick="window.location='pengurusan.php'">Tambah Kolej</button>
    </div>
    <?php if ($msg): ?><div class="alert alert-success"><?php echo $msg; ?></div><?php endif; ?>
    <div class="form-section">
        <form method="post" enctype="multipart/form-data" id="kolejForm">
            <input type="hidden" name="id" id="kolej_id" value="<?php echo $edit_data['id_kolej'] ?? ''; ?>">
            <div class="mb-3">
                <label class="form-label">Nama Kolej</label>
                <input type="text" class="form-control" name="nama" id="nama" required value="<?php echo htmlspecialchars($edit_data['nama_kolej'] ?? ''); ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Sejarah / Info</label>
                <textarea class="form-control" name="sejarah" id="sejarah" rows="3" required><?php echo htmlspecialchars($edit_data['sejarah'] ?? ''); ?></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Kemudahan</label>
                <div id="kemudahan-list"></div>
                <input type="text" class="form-control d-inline-block" id="kemudahan-input" placeholder="Contoh: Kafe, Dobi, Perpustakaan" style="width:70%;">
                <button type="button" class="btn btn-secondary" onclick="addKemudahan()">Tambah</button>
                <input type="hidden" name="kemudahan[]" id="kemudahan-hidden">
            </div>
            <div class="mb-3">
                <label class="form-label">Gambar Kolej</label>
                <input type="file" name="gambar_kolej[]" accept="image/*" multiple>
                <?php if ($edit_data && !empty($edit_data['gambar'])): ?>
                    <div class="mt-2" id="gambar-preview">
                        <label class="form-label">Gambar Sedia Ada:</label><br>
                        <?php
                        $gambar_list = json_decode($edit_data['gambar'], true);
                        if (is_array($gambar_list)) {
                            foreach ($gambar_list as $img) {
                                echo '<span class="img-wrapper" data-img="' . htmlspecialchars($img) . '">
                                        <img src="img/' . htmlspecialchars($img) . '" style="width:80px;height:60px;object-fit:cover;margin:2px;border-radius:6px;box-shadow:0 2px 8px #0001;">
                                        <span class="remove-img" onclick="removeGambar(this, \'' . htmlspecialchars($img) . '\')">&times;</span>
                                      </span>';
                            }
                        }
                        ?>
                    </div>
                    <input type="hidden" name="gambar_buang" id="gambar_buang">
                <?php endif; ?>
            </div>
            <button type="submit" class="btn btn-primary" style="min-width:120px;">
                <?php echo $edit_data ? 'Kemaskini' : 'Simpan'; ?>
            </button>
        </form>
    </div>
    <h4>Senarai Kolej</h4>
    <?php while($k = $kolej->fetch_assoc()): $kemudahan = json_decode($k['kemudahan'] ?? '[]', true); ?>
    <div class="kolej-card p-3 mb-3">
        <div class="kolej-img-row mb-2">
            <?php
            $gambar_list = json_decode($k['gambar'] ?? '[]', true);
            if (!is_array($gambar_list)) $gambar_list = [];
            foreach ($gambar_list as $img) {
                echo '<img src="img/' . htmlspecialchars($img) . '" class="kolej-img" alt="Gambar Kolej">';
            }
            ?>
        </div>
        <div class="d-flex w-100">
            <div class="flex-grow-1">
                <h5><?php echo $k['nama_kolej']; ?></h5>
                <div class="mb-2 text-muted" style="font-size:15px;"><?php echo $k['sejarah']; ?></div>
                <div class="kemudahan-chip-row">
                    <?php foreach($kemudahan as $item): ?>
                        <div class="kemudahan-chip">
                            <span class="kemudahan-icon"><i class="fas fa-check"></i></span>
                            <span class="kemudahan-text"><?php echo htmlspecialchars($item); ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="d-flex flex-column align-items-end gap-2">
                <a href="pengurusan.php?edit=<?php echo $k['id_kolej']; ?>" class="btn btn-warning btn-action">Edit</a>
                <a href="pengurusan.php?padam=<?php echo $k['id_kolej']; ?>" class="btn btn-danger btn-action" onclick="return confirm('Padam kolej ini?')">Padam</a>
                <button class="btn btn-info btn-action" onclick="showPreview(<?php echo htmlspecialchars(json_encode($k), ENT_QUOTES, 'UTF-8'); ?>)">Preview</button>
            </div>
        </div>
    </div>
    <?php endwhile; ?>
</div>
//preview kolej
<div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="previewModalLabel">Preview Kolej</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="previewBody">
   
      </div>
    </div>
  </div>
</div>
<script>
let kemudahanArr = [];
function addKemudahan() {
    const val = document.getElementById('kemudahan-input').value.trim();
    if(val && !kemudahanArr.includes(val)) {
        kemudahanArr.push(val);
        renderKemudahan();
        document.getElementById('kemudahan-input').value = '';
    }
}
function renderKemudahan() {
    const list = document.getElementById('kemudahan-list');
    list.innerHTML = kemudahanArr.map((k,i) => `<span class='chip'>${k} <span class='remove' onclick='removeKemudahan(${i})'>&times;</span></span>`).join(' ');
    document.getElementById('kemudahan-hidden').value = kemudahanArr.map(k=>k);
}
function removeKemudahan(idx) {
    kemudahanArr.splice(idx,1);
    renderKemudahan();
}
let gambarBuang = [];
function removeGambar(el, nama) {
    gambarBuang.push(nama);
    document.getElementById('gambar_buang').value = JSON.stringify(gambarBuang);
    el.parentElement.remove();
}
function showPreview(kolej) {
    let kemudahan = [];
    try { kemudahan = JSON.parse(kolej.kemudahan); } catch(e) {}
    let gambar = [];
    try { gambar = JSON.parse(kolej.gambar); } catch(e) {}
    let html = `<div class='row'><div class='col-md-5'><div style='display:flex;gap:8px;flex-wrap:wrap;'>`;
    if(gambar.length) {
        gambar.forEach(img => html += `<img src='img/${img}' style='width:90px;height:70px;object-fit:cover;border-radius:8px;margin-bottom:8px;'>`);
    } else {
        html += `<img src='img/default.jpg' style='width:90px;height:70px;object-fit:cover;border-radius:8px;'>`;
    }
    html += `</div></div><div class='col-md-7'><h4 style='font-family:Orbitron'>${kolej.nama_kolej}</h4><div style='margin-bottom:10px;'>${(kolej.sejarah||'').replace(/\n/g,'<br>')}</div></div></div>`;
    html += `<div class='mt-4'><b>Kemudahan:</b><div style='display:flex;flex-wrap:wrap;gap:12px;margin-top:8px;'>`;
    kemudahan.forEach(item => html += `<div style='background:#fff;border:2px solid #beae98;border-radius:18px;padding:10px 22px;font-family:Orbitron;font-weight:600;box-shadow:0 2px 12px #beae9822;'>${item}</div>`);
    html += `</div></div>`;
    document.getElementById('previewBody').innerHTML = html;
    var modal = new bootstrap.Modal(document.getElementById('previewModal'));
    modal.show();
}
<?php if ($edit_data): ?>
    kemudahanArr = <?php echo $edit_data['kemudahan'] ? $edit_data['kemudahan'] : '[]'; ?>;
    renderKemudahan();
    document.getElementById('btnKemaskini').disabled = false;
    document.getElementById('btnKemaskini').onclick = function() {
        document.getElementById('kolejForm').scrollIntoView({behavior: 'smooth'});
    };
<?php endif; ?>
</script>
<script src="https://kit.fontawesome.com/4e8e45b1b7.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>