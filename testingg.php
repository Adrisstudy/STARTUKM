<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $checkIn = $_POST['checkIn'] ?? null;
    $checkOut = $_POST['checkOut'] ?? null;

    if ($checkIn && $checkOut) {
        $response = file_get_contents('http://localhost/api/checkAvailability.php');
        echo $response;
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Tempahan Rumah Tamu UKM</title>
  <link rel="icon" type="image/png" href="haha.png">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" />
</head>
<body class="bg-light d-flex justify-content-center align-items-center" style="height: 100vh;">
  <div class="card p-4 shadow-lg" style="width: 100%; max-width: 500px;">
    <h2 class="mb-3">Tempahan Rumah Tamu UKM</h2>
    <p class="text-muted">Sila pilih tarikh masuk dan keluar.</p>

    <form id="bookingForm" method="post">
      <div class="mb-3">
        <label class="form-label">Check In</label>
        <input type="date" name="checkIn" id="checkIn" class="form-control" required />
      </div>

      <div class="mb-3">
        <label class="form-label">Check Out</label>
        <input type="date" name="checkOut" id="checkOut" class="form-control" required />
      </div>

      <button type="button" class="btn btn-danger w-100" onclick="handleSearch()">
        <i class="fa fa-search me-2"></i> Semak
      </button>
    </form>

    <div id="result" class="mt-4"></div>
  </div>

  <script>
    function handleSearch() {
      const checkIn = document.getElementById('checkIn').value;
      const checkOut = document.getElementById('checkOut').value;
      
      if (!checkIn || !checkOut) {
        alert('Sila pilih kedua-dua tarikh!');
        return;
      }

      const formData = new FormData();
      formData.append('checkIn', checkIn);
      formData.append('checkOut', checkOut);

      fetch('', { method: 'POST', body: formData })
        .then(response => response.json())
        .then(data => {
          const resultDiv = document.getElementById('result');
          if (data.length > 0) {
            const list = data.map(college => `<li>${college.name}</li>`).join('');
            resultDiv.innerHTML = `<h3>Kolej Tersedia:</h3><ul>${list}</ul>`;
          } else {
            resultDiv.innerHTML = '<p>Tiada kolej tersedia pada tarikh ini.</p>';
          }
        })
        .catch(error => {
          console.error('Error:', error);
        });
    }
  </script>
</body>
<head>
  <link rel="icon" type="image/png" href="hihi.png">
</head>
</html>
