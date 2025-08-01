<?php
session_start();
date_default_timezone_set('Asia/Kuala_Lumpur');
include 'db.php';

//  kira ii  tempahan ikut kolej
$sql_college_bookings = "SELECT k.nama_kolej, COUNT(*) as total_bookings 
                        FROM tempahan_bilik2 tb 
                        LEFT JOIN kolej k ON tb.id_kolej = k.id_kolej 
                        GROUP BY tb.id_kolej";
$result_college = $conn->query($sql_college_bookings);
$college_data = array();
$college_labels = array();
$college_values = array();
while($row = $result_college->fetch_assoc()) {
    $college_labels[] = $row['nama_kolej'];
    $college_values[] = $row['total_bookings'];
}

// Jadual booking bulanan tahun semasa
$sql_monthly = "SELECT DATE_FORMAT(tarikh_mula, '%M') as month, 
                COUNT(*) as total_bookings,
                SUM(total_amount) as total_revenue
                FROM tempahan_bilik2 
                WHERE YEAR(tarikh_mula) = YEAR(CURRENT_DATE)
                GROUP BY MONTH(tarikh_mula)
                ORDER BY MONTH(tarikh_mula)";
$result_monthly = $conn->query($sql_monthly);
$monthly_labels = array();
$monthly_bookings = array();
$monthly_revenue = array();
while($row = $result_monthly->fetch_assoc()) {
    $monthly_labels[] = $row['month'];
    $monthly_bookings[] = $row['total_bookings'];
    $monthly_revenue[] = $row['total_revenue'];
}

// kiraan jenis bilik ikut jantina
$sql_rooms = "SELECT 
    SUM(bilik_lelaki) as total_male_rooms,
    SUM(bilik_perempuan) as total_female_rooms
    FROM tempahan_bilik2";
$result_rooms = $conn->query($sql_rooms);
$room_data = $result_rooms->fetch_assoc();

// Get payment status distribution
$sql_payment = "SELECT payment_status, COUNT(*) as total 
                FROM tempahan_bilik2 
                GROUP BY payment_status";
$result_payment = $conn->query($sql_payment);
$payment_labels = array();
$payment_values = array();
while($row = $result_payment->fetch_assoc()) {
    $payment_labels[] = ucfirst($row['payment_status']);
    $payment_values[] = $row['total'];
}

// aduan bulanan
$sql_complaints = "SELECT DATE_FORMAT(fld_lpr_date, '%M') as month, COUNT(*) as total_complaints 
                  FROM aduan 
                  WHERE YEAR(fld_lpr_date) = YEAR(CURRENT_DATE)
                  GROUP BY MONTH(fld_lpr_date)
                  ORDER BY MONTH(fld_lpr_date)";
$result_complaints = $conn->query($sql_complaints);
$complaint_labels = array();
$complaint_values = array();
if ($result_complaints) {
    while($row = $result_complaints->fetch_assoc()) {
        $complaint_labels[] = $row['month'];
        $complaint_values[] = $row['total_complaints'];
    }
}

// jumlah aduan
$sql_total_complaints = "SELECT COUNT(*) as total FROM aduan";
$result_total_complaints = $conn->query($sql_total_complaints);
$total_complaints = $result_total_complaints ? $result_total_complaints->fetch_assoc()['total'] : 0;

// --- TAMBAHAN: DATA TEMPAHAN BULANAN MENGIKUT KOLEJ ---
$all_colleges = [
    1 => 'KOLEJ PENDETA ZA\'BA',
    2 => 'KOLEJ UNGKU OMAR',
    3 => 'KOLEJ IBRAHIM YAAKUB',
    4 => 'KOLEJ BURHANUDDIN HELMI',
    5 => 'KOLEJ DATO ONN',
    6 => 'KOLEJ RAHIM KAJAI',
    7 => 'KOLEJ IBU ZAIN',
    8 => 'KOLEJ AMINUDDIN BAKI',
    9 => 'KOLEJ KERIS MAS'
];
$monthly_college_data = [];
$months = ['Januari','Februari','Mac','April','Mei','Jun','Julai','Ogos','September','Oktober','November','Disember'];
foreach ($all_colleges as $id => $name) {
    $sql = "SELECT MONTH(tarikh_mula) as m, COUNT(*) as total FROM tempahan_bilik2 WHERE id_kolej=$id AND YEAR(tarikh_mula)=YEAR(CURRENT_DATE) GROUP BY MONTH(tarikh_mula)";
    $res = $conn->query($sql);
    $arr = array_fill(0,12,0);
    while($row = $res->fetch_assoc()) { $arr[(int)$row['m']-1] = (int)$row['total']; }
    $monthly_college_data[$id] = $arr;
}

$sql_guesthouse_bookings = "SELECT r.nama_rumah_tamu, COUNT(*) as total_bookings 
                            FROM tempahan_bilik2 tb 
                            LEFT JOIN rumah_tamu r ON tb.id_rumah_tamu = r.id_rumah_tamu 
                            GROUP BY tb.id_rumah_tamu";
?>

<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Visual STARTUKM</title>
    <link rel="icon" type="image/png" href="haha.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background: #f5f5f5;
        }

        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 0 20px;
        }

        .dashboard-title {
            color: #333;
            margin-bottom: 30px;
            text-align: center;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: linear-gradient(135deg, #eaf6ff 0%, #fff 100%);
            padding: 18px;
            border-radius: 18px;
            box-shadow: 0 4px 18px #2986ff22;
            text-align: center;
            transition: box-shadow 0.2s, transform 0.2s;
        }
        .stat-card:hover {
            box-shadow: 0 8px 32px #2986ff33;
            transform: translateY(-2px) scale(1.03);
        }
        .stat-card h3 {
            margin: 0;
            color: #666;
            font-size: 14px;
            font-weight: 500;
        }

        .stat-card .value {
            font-size: 24px;
            font-weight: 600;
            color: #333;
            margin: 10px 0;
        }

        .stat-card .icon {
            font-size: 2.2rem;
            background: linear-gradient(90deg, #2986ff 0%, #3bb6c5 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-fill-color: transparent;
        }

        .chart-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }

        .chart-container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .chart-title {
            margin: 0 0 20px 0;
            color: #333;
            font-size: 18px;
            font-weight: 500;
            text-align: center;
        }

        @media (max-width: 768px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .chart-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 480px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }
        }

        .icon, .fa, .fas, .far, .bi, .material-icons {
            color: #2986ff !important;
            background: none !important;
            font-size: 2.2rem !important;
            vertical-align: middle;
        }
        h1, h2, h3, h4, .section-title { color: #2986ff !important; text-align: center; font-weight: 800; }
        footer { width:100%;background:transparent;color:#fff;text-align:center;padding:18px 0 10px 0;font-weight:500;font-size:0.98rem;letter-spacing:1px;margin-top:40px; }
    </style>
</head>
<body>
    <?php include 'headerstaf.php'; ?>

    <div class="container">
        <div class="dashboard-title">
            <h2>Laporan Visual STARTUKM</h2>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <h3>Jumlah Tempahan</h3>
                <div class="value">
                    <?php echo array_sum($college_values); ?>
                </div>
                <div class="icon">
                    <i class="fas fa-book"></i>
                </div>
            </div>
            <div class="stat-card">
                <h3>Jumlah Pendapatan (RM)</h3>
                <div class="value">
                    <?php echo number_format(array_sum($monthly_revenue), 2); ?>
                </div>
                <div class="icon">
                    <i class="fas fa-dollar-sign"></i>
                </div>
            </div>
            <div class="stat-card">
                <h3>Bilik Lelaki</h3>
                <div class="value">
                    <?php echo $room_data['total_male_rooms']; ?>
                </div>
                <div class="icon">
                    <i class="fas fa-male"></i>
                </div>
            </div>
            <div class="stat-card">
                <h3>Bilik Perempuan</h3>
                <div class="value">
                    <?php echo $room_data['total_female_rooms']; ?>
                </div>
                <div class="icon">
                    <i class="fas fa-female"></i>
                </div>
            </div>
            <div class="stat-card">
                <h3>Jumlah Aduan</h3>
                <div class="value">
                    <?php echo $total_complaints; ?>
                </div>
                <div class="icon">
                    <i class="fas fa-exclamation-circle"></i>
                </div>
            </div>
        </div>

        <div class="chart-grid">
            <div class="chart-container">
                <h3 class="chart-title">Tempahan Mengikut Rumah Tamu</h3>
                <canvas id="collegeChart"></canvas>
            </div>
            <div class="chart-container">
                <h3 class="chart-title">Status Pembayaran</h3>
                <canvas id="paymentChart"></canvas>
            </div>
            <div class="chart-container">
                <h3 class="chart-title">Trend Tempahan Bulanan</h3>
                <canvas id="monthlyChart"></canvas>
            </div>
            <div class="chart-container">
                <h3 class="chart-title">Trend Aduan Bulanan</h3>
                <canvas id="complaintsChart"></canvas>
            </div>
            <div class="chart-container">
                <h3 class="chart-title">Pendapatan Bulanan (RM)</h3>
                <canvas id="revenueChart"></canvas>
            </div>
            <div class="chart-container">
                <h3 class="chart-title">Tempahan Bulanan Mengikut Kolej</h3>
                <select id="kolejSelect" class="form-select mb-2" style="max-width:350px;">
                    <?php foreach($all_colleges as $id=>$name): ?>
                        <option value="<?php echo $id; ?>"><?php echo $name; ?></option>
                    <?php endforeach; ?>
                </select>
                <canvas id="collegeMonthlyChart"></canvas>
            </div>
        </div>
    </div>

    <script>
        const collegeChartColors = [
            '#2E86AB', // KPZ
            '#A23B72', // KUO
            '#F18F01', // KIY
            '#C73E1D', // KBH
            '#3B8EA5', // KDO
            '#F49F0A', // KRK
            '#55828B', // KIZ
            '#87C38F', // KAB
            '#E74C3C'  // KKM
        ];

        const paymentChartColors = ['#2ECC71', '#E74C3C']; 
        const monthlyChartColor = '#3498DB';     
        const complaintsChartColor = '#9B59B6';  
        const revenueChartColor = '#E67E22';     

        // College bookings pie chart
        new Chart(document.getElementById('collegeChart'), {
            type: 'pie',
            data: {
                labels: <?php echo json_encode($college_labels); ?>,
                datasets: [{
                    data: <?php echo json_encode($college_values); ?>,
                    backgroundColor: collegeChartColors
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'right'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.label || '';
                                let value = context.raw || 0;
                                let total = context.dataset.data.reduce((a, b) => a + b, 0);
                                let percentage = Math.round((value * 100) / total);
                                return `${label}: ${value} (${percentage}%)`;
                            }
                        }
                    }
                }
            }
        });

        // Payment status pie chart
        new Chart(document.getElementById('paymentChart'), {
            type: 'pie',
            data: {
                labels: <?php echo json_encode($payment_labels); ?>,
                datasets: [{
                    data: <?php echo json_encode($payment_values); ?>,
                    backgroundColor: paymentChartColors
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'right'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.label || '';
                                let value = context.raw || 0;
                                let total = context.dataset.data.reduce((a, b) => a + b, 0);
                                let percentage = Math.round((value * 100) / total);
                                return `${label}: ${value} (${percentage}%)`;
                            }
                        }
                    }
                }
            }
        });

        // Monthly bookings line chart
        new Chart(document.getElementById('monthlyChart'), {
            type: 'line',
            data: {
                labels: <?php echo json_encode($monthly_labels); ?>,
                datasets: [{
                    label: 'Jumlah Tempahan',
                    data: <?php echo json_encode($monthly_bookings); ?>,
                    borderColor: monthlyChartColor,
                    backgroundColor: `${monthlyChartColor}33`,
                    tension: 0.1,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });

        // graf aduan
        new Chart(document.getElementById('complaintsChart'), {
            type: 'line',
            data: {
                labels: <?php echo json_encode($complaint_labels); ?>,
                datasets: [{
                    label: 'Jumlah Aduan',
                    data: <?php echo json_encode($complaint_values); ?>,
                    borderColor: complaintsChartColor,
                    backgroundColor: `${complaintsChartColor}33`,
                    tension: 0.1,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });

        // pendapatan bulanan
        new Chart(document.getElementById('revenueChart'), {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($monthly_labels); ?>,
                datasets: [{
                    label: 'Pendapatan (RM)',
                    data: <?php echo json_encode($monthly_revenue); ?>,
                    backgroundColor: revenueChartColor
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        const collegeMonthlyData = <?php echo json_encode($monthly_college_data); ?>;
        const collegeMonthlyLabels = <?php echo json_encode($months); ?>;
        const collegeNames = <?php echo json_encode($all_colleges); ?>;
        const collegeColors = [
            '#2E86AB', // KPZ
            '#A23B72', // KUO
            '#F18F01', // KIY
            '#C73E1D', // KBH
            '#3B8EA5', // KDO
            '#F49F0A', // KRK
            '#55828B', // KIZ
            '#87C38F', // KAB
            '#E74C3C'  // KKM
        ];
        let selectedKolej = 1;
        const ctxCollegeMonthly = document.getElementById('collegeMonthlyChart').getContext('2d');
        let collegeMonthlyChart = new Chart(ctxCollegeMonthly, {
            type: 'bar',
            data: {
                labels: collegeMonthlyLabels,
                datasets: [{
                    label: 'Tempahan Bulanan',
                    data: collegeMonthlyData[selectedKolej],
                    backgroundColor: collegeColors[selectedKolej-1],
                    borderColor: collegeColors[selectedKolej-1],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: { beginAtZero: true, ticks: { stepSize: 1 } }
                }
            }
        });
        document.getElementById('kolejSelect').addEventListener('change', function() {
            selectedKolej = this.value;
            collegeMonthlyChart.data.datasets[0].data = collegeMonthlyData[selectedKolej];
            collegeMonthlyChart.data.datasets[0].backgroundColor = collegeColors[selectedKolej-1];
            collegeMonthlyChart.data.datasets[0].borderColor = collegeColors[selectedKolej-1];
            collegeMonthlyChart.update();
        });
    </script>
</body>
<head>
  <link rel="icon" type="image/png" href="hihi.png">
</head>
</html> 