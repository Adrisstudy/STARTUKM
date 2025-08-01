<?php
session_start();
date_default_timezone_set('Asia/Kuala_Lumpur');
include 'db.php';

$items_per_page = 20;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $items_per_page;

$sql_kolej = "SELECT DISTINCT id_kolej, nama_kolej FROM kolej ORDER BY nama_kolej";
$result_kolej = $conn->query($sql_kolej);
$kolej_list = [];
while($row = $result_kolej->fetch_assoc()) {
    $kolej_list[] = $row;
}

$where_clause = "";
if(isset($_GET['kolej']) && !empty($_GET['kolej'])) {
    $kolej_id = intval($_GET['kolej']);
    $where_clause = "WHERE tb.id_kolej = $kolej_id";
}
//filter
$count_sql = "SELECT COUNT(*) as total FROM tempahan_bilik2 tb $where_clause";
$count_result = $conn->query($count_sql);
$total_records = $count_result->fetch_assoc()['total'];
$total_pages = ceil($total_records / $items_per_page);

// filter
$sql = "SELECT tb.*, k.nama_kolej, u.fld_user_name, tb.tarikh_tempahan
        FROM tempahan_bilik2 tb
        LEFT JOIN kolej k ON tb.id_kolej = k.id_kolej
        LEFT JOIN user u ON tb.user_id = u.fld_user_id
        $where_clause
        GROUP BY tb.id_tempahan
        ORDER BY tb.tarikh_mula DESC
        LIMIT $offset, $items_per_page";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Senarai Tempahan Rumah Tamu</title>
    <link rel="icon" type="image/png" href="haha.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body { background: linear-gradient(160deg, #2986ff 0%, #3bb6c5 100%); font-family: 'Roboto', Arial, sans-serif; margin:0; padding:0; }
        h1, h2, h3, h4, .section-title { color: #2986ff !important; text-align: center; font-weight: 800; }
        .container, .main-container, .card { background: #fff; border-radius: 18px; box-shadow: 0 8px 32px #2986ff22; padding: 32px 28px; margin: 40px auto 0 auto; max-width: 1100px; }
        table { width: 100%; border-collapse: separate; border-spacing: 0; background: #fafdff; border-radius: 12px; overflow: hidden; }
        th, td { padding: 14px 8px; text-align: center; font-size: 1.05em; }
        th { background: linear-gradient(90deg, #2986ff 0%, #3bb6c5 100%); color: #fff; border: none; }
        td { border-bottom: 1px solid #e0e7ef; background: #fff; }
        tr:last-child td { border-bottom: none; }
        .status-tersedia { background: #eaf6ff; color: #2986ff; border-radius: 8px; font-weight: 700; }
        .status-berjaya { background: #e0ffe7; color: #388e3c; border-radius: 8px; font-weight: 700; }
        .btn, button { background: linear-gradient(90deg, #2986ff 0%, #3bb6c5 100%); color: #fff; font-weight: 700; border-radius: 10px; border: none; transition: background 0.2s, color 0.2s; }
        .btn:hover, button:hover { background: linear-gradient(90deg, #3bb6c5 0%, #2986ff 100%); color: #fff; }
        footer { width:100%;background:transparent;color:#fff;text-align:center;padding:18px 0 10px 0;font-weight:500;font-size:0.98rem;letter-spacing:1px;margin-top:40px; }

        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 0 20px;
        }

        .page-title {
            color: #333;
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .filter-section {
            background: white;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .filter-dropdown {
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
            width: 300px;
        }

        .export-btn {
            padding: 8px 15px;
            border: none;
            border-radius: 4px;
            font-size: 14px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 5px;
            color: white;
            transition: all 0.3s ease;
        }

        .pdf-btn {
            background: #dc3545;
        }

        .excel-btn {
            background: #28a745;
        }

        .export-btn:hover {
            opacity: 0.9;
            transform: translateY(-1px);
        }

        .booking-table {
            width: 100%;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .booking-table th {
            background: linear-gradient(90deg, #2986ff 0%, #3bb6c5 100%);
            color: #fff;
            padding: 15px;
            text-align: left;
            border: none;
        }

        .booking-table td {
            padding: 15px;
            border-bottom: 1px solid #eee;
        }

        .booking-table tr:hover {
            background: #eaf6ff;
            transition: background 0.2s;
        }

        .status-badge {
            padding: 6px 14px;
            border-radius: 16px;
            font-size: 13px;
            font-weight: 600;
            background: linear-gradient(90deg, #2986ff 0%, #3bb6c5 100%);
            color: #fff;
            box-shadow: 0 2px 8px #2986ff22;
            border: none;
        }

        .status-confirmed {
            background: linear-gradient(90deg, #2986ff 0%, #3bb6c5 100%);
            color: #fff;
        }

        .status-pending {
            background: linear-gradient(90deg, #f7b42c 0%, #fc575e 100%);
            color: #fff;
        }

        .payment-paid {
            background: linear-gradient(90deg, #43e97b 0%, #38f9d7 100%);
            color: #fff;
        }

        .payment-pending {
            background: linear-gradient(90deg, #fc575e 0%, #f7b42c 100%);
            color: #fff;
        }

        .room-details {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 2px;
        }
        .room-icons-row {
            display: flex;
            align-items: center;
            gap: 16px;
        }
        .room-icon-block {
            display: flex;
            flex-direction: column;
            align-items: center;
            min-width: 38px;
        }
        .room-icon-block i {
            font-size: 1.25em;
            color: #2986ff;
            margin-bottom: 2px;
        }
        .room-icon-block .room-count-digit {
            font-size: 1.08em;
            font-weight: 700;
            color: #222;
            margin-top: 1px;
        }

        .pagination {
            display: flex;
            justify-content: center;
            gap: 5px;
            margin-top: 20px;
        }

        .pagination a {
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            text-decoration: none;
            color: #666;
            background: white;
        }

        .pagination a.active {
            background: linear-gradient(90deg, #2986ff 0%, #3bb6c5 100%);
            color: #fff;
            border-color: #2986ff;
        }

        .pagination a:hover:not(.active) {
            background: #f5f5f5;
        }

        @media (max-width: 768px) {
            .booking-table {
                display: block;
                overflow-x: auto;
            }

            .filter-section {
                flex-wrap: wrap;
            }

            .filter-dropdown {
                width: 100%;
            }

            .export-btn {
                width: calc(50% - 5px);
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <?php include 'headerstaf.php'; ?>

    <div class="container">
        <div class="page-title">
            <h2>Senarai Tempahan Rumah Tamu</h2>
        </div>

        <div class="filter-section">
            <form action="" method="GET" style="display: flex; gap: 10px; align-items: center; flex-grow: 1;">
                <select name="kolej" class="filter-dropdown" onchange="this.form.submit()">
                    <option value="">Semua Rumah Tamu</option>
                    <?php foreach($kolej_list as $kolej): ?>
                        <option value="<?php echo $kolej['id_kolej']; ?>" 
                                <?php echo (isset($_GET['kolej']) && $_GET['kolej'] == $kolej['id_kolej']) ? 'selected' : ''; ?>>
                            <?php echo $kolej['nama_kolej']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </form>
            <a href="export_pdf.php<?php echo isset($_GET['kolej']) ? '?kolej='.$_GET['kolej'] : ''; ?>" class="export-btn pdf-btn">
                <i class="fas fa-file-csv"></i> CSV
            </a>
            <a href="export_excel.php<?php echo isset($_GET['kolej']) ? '?kolej='.$_GET['kolej'] : ''; ?>" class="export-btn excel-btn">
                <i class="fas fa-file-excel"></i> Excel
            </a>
        </div>

        <table class="booking-table">
            <thead>
                <tr>
                    <th>Rumah Tamu</th>
                    <th>Penempah</th>
                    <th>Tarikh Masuk</th>
                    <th>Tarikh Keluar</th>
                    <th>Tarikh Tempahan</th>
                    <th>Bilik</th>
                    <th>Jumlah (RM)</th>
                    <th>Bayaran</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['nama_kolej']; ?></td>
                        <td><?php echo $row['fld_user_name']; ?></td>
                        <td><?php echo date('d/m/Y', strtotime($row['tarikh_mula'])); ?></td>
                        <td><?php echo date('d/m/Y', strtotime($row['tarikh_tamat'])); ?></td>
                        <td><?php echo date('d/m/Y H:i', strtotime($row['tarikh_tempahan'])); ?></td>
                        <td>
                            <div class="room-details">
                                <div class="room-icons-row">
                                    <div class="room-icon-block">
                                        <i class="fas fa-male"></i>
                                        <span class="room-count-digit"><?php echo $row['bilik_lelaki']; ?></span>
                                    </div>
                                    <div class="room-icon-block">
                                        <i class="fas fa-female"></i>
                                        <span class="room-count-digit"><?php echo $row['bilik_perempuan']; ?></span>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td><?php echo number_format($row['total_amount'], 2); ?></td>
                        <td>
                            <button 
                                class="status-badge payment-btn <?php echo $row['payment_status'] == 'paid' ? 'payment-paid' : 'payment-pending'; ?>" 
                                style="border:none;outline:none;min-width:90px;display:flex;align-items:center;gap:6px;font-weight:bold;cursor:pointer;"
                                data-id="<?php echo $row['id_tempahan']; ?>"
                                data-status="<?php echo $row['payment_status']; ?>"
                                onclick="togglePaymentStatus(this)"
                            >
                                <?php if ($row['payment_status'] == 'paid'): ?>
                                    <i class="fas fa-check-circle"></i> Selesai
                                <?php else: ?>
                                    <i class="fas fa-exclamation-circle"></i> Tangguh
                                <?php endif; ?>
                            </button>
                        </td>
                        <td>
                            <button 
                                class="status-badge status-btn <?php echo $row['status'] == 'confirmed' ? 'status-confirmed' : 'status-pending'; ?>" 
                                style="border:none;outline:none;min-width:110px;display:flex;align-items:center;gap:6px;font-weight:bold;cursor:pointer;"
                                data-id="<?php echo $row['id_tempahan']; ?>"
                                data-status="<?php echo $row['status']; ?>"
                                onclick="toggleBookingStatus(this)"
                            >
                                <?php if ($row['status'] == 'confirmed'): ?>
                                    <i class="fas fa-check-circle"></i> Terima
                                <?php else: ?>
                                    <i class="fas fa-times-circle"></i> Batal
                                <?php endif; ?>
                            </button>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <div class="pagination">
            <?php for($i = 1; $i <= $total_pages; $i++): ?>
                <a href="?page=<?php echo $i; ?><?php echo isset($_GET['kolej']) ? '&kolej='.$_GET['kolej'] : ''; ?>" 
                   class="<?php echo $page == $i ? 'active' : ''; ?>">
                    <?php echo $i; ?>
                </a>
            <?php endfor; ?>
        </div>
    </div>

    <script>
    function togglePaymentStatus(btn) {
        var id = btn.getAttribute('data-id');
        var currentStatus = btn.getAttribute('data-status');
        var newStatus = currentStatus === 'paid' ? 'pending' : 'paid';
        btn.disabled = true;
        fetch('update_payment_status.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'id=' + encodeURIComponent(id) + '&status=' + encodeURIComponent(newStatus)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                btn.setAttribute('data-status', newStatus);
                if (newStatus === 'paid') {
                    btn.className = 'status-badge payment-btn payment-paid';
                    btn.innerHTML = '<i class="fas fa-check-circle"></i> Selesai';
                } else {
                    btn.className = 'status-badge payment-btn payment-pending';
                    btn.innerHTML = '<i class="fas fa-exclamation-circle"></i> Tangguh';
                }
            } else {
                alert('Gagal kemaskini status!');
            }
            btn.disabled = false;
        })
        .catch(() => {
            alert('Ralat sambungan!');
            btn.disabled = false;
        });
    }

    function toggleBookingStatus(btn) {
        var id = btn.getAttribute('data-id');
        var currentStatus = btn.getAttribute('data-status');
        var newStatus = currentStatus === 'confirmed' ? 'cancelled' : 'confirmed';
        btn.disabled = true;
        fetch('update_booking_status.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'id=' + encodeURIComponent(id) + '&status=' + encodeURIComponent(newStatus)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                btn.setAttribute('data-status', newStatus);
                if (newStatus === 'confirmed') {
                    btn.className = 'status-badge status-btn status-confirmed';
                    btn.innerHTML = '<i class="fas fa-check-circle"></i> Terima';
                } else {
                    btn.className = 'status-badge status-btn status-pending';
                    btn.innerHTML = '<i class="fas fa-times-circle"></i> Batal';
                }
            } else {
                alert('Gagal kemaskini status!');
            }
            btn.disabled = false;
        })
        .catch(() => {
            alert('Ralat sambungan!');
            btn.disabled = false;
        });
    }
    </script>
</body>
<head>
  <link rel="icon" type="image/png" href="hihi.png">
</head>
</html> 