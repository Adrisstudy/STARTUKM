<?php
include 'db.php';

$conn = new mysqli("localhost", "root", "", "startukm");
if ($conn->connect_error) {
    die("Sambungan gagal: " . $conn->connect_error);
}

$sql = "SELECT * FROM tempahan ORDER BY fld_tarikh_tempah DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekod Tempahan</title>
    <link rel="icon" type="image/png" href="haha.png">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background: url('beige.jpg') no-repeat center center fixed;
            background-size: cover;
        }
        .container {
            background: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            margin: auto;
            margin-top: 50px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid gray;
            padding: 10px;
            text-align: center;
        }
        th {
            background: #f3f3f3;
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen">
    <div class="container bg-white p-6 rounded shadow-lg">
        <h2 class="text-center text-2xl font-bold">Rekod Tempahan</h2>

        <table class="w-full border-collapse mt-4">
            <tr class="bg-gray-200">
                <th class="border p-2">Tarikh Masuk</th>
                <th class="border p-2">Tarikh Keluar</th>
                <th class="border p-2">Rumah Tamu</th>
                <th class="border p-2">Jumlah Bilik</th>
                <th class="border p-2">Status</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td class="border p-2"><?= $row['fld_tarikh_masuk'] ?></td>
                    <td class="border p-2"><?= $row['fld_tarikh_keluar'] ?></td>
                    <td class="border p-2"><?= $row['fld_rumah_tamu'] ?></td>
                    <td class="border p-2"><?= $row['fld_jumlah_bilik'] ?></td>
                    <td class="border p-2"><?= $row['status'] ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>

<?php $conn->close(); ?>