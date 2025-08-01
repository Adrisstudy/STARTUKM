<?php include('header.php'); ?>
<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aduan - START UKM</title>
    <link rel="icon" type="image/png" href="haha.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600&family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background: linear-gradient(160deg, #2986ff 0%, #3bb6c5 100%); font-family: 'Roboto', Arial, sans-serif; margin:0; padding:0; }
        .container, .main-container, .form-card, .overlay {
            background: #fff;
            border-radius: 22px;
            box-shadow: 0 8px 32px #2986ff22;
            padding: 38px 32px;
            margin: 40px auto 0 auto;
            max-width: 700px;
        }
        h1, h2, h3, h4, .section-title { color: #2986ff !important; }
        hr, .divider { border-color: #2986ff !important; background: #2986ff !important; height:2px; }
        label, .form-label { color: #2986ff; font-weight: 600; }
        input, select, textarea { border: 2px solid #2986ff !important; border-radius: 10px; background: #fafdff; color: #2986ff; font-weight: 500; }
        input[type=date], .date-input { background: linear-gradient(90deg, #eaf6ff 0%, #fff 100%); color: #2986ff; border: 2px solid #2986ff; }
        input:focus, select:focus, textarea:focus { border-color: #3bb6c5 !important; box-shadow: 0 0 0 2px #3bb6c533; }
        .btn, button, .submit-btn { background: linear-gradient(90deg, #2986ff 0%, #3bb6c5 100%); color: #fff; font-weight: 600; border-radius: 10px; border: none; transition: background 0.2s, color 0.2s; }
        .btn:hover, button:hover, .submit-btn:hover { background: linear-gradient(90deg, #3bb6c5 0%, #2986ff 100%); color: #fff; }
        footer { width:100%;background:transparent;color:#fff;text-align:center;padding:18px 0 10px 0;font-weight:500;font-size:0.98rem;letter-spacing:1px;margin-top:40px; }

        .form-header {
            text-align: center;
            margin-bottom: 35px;
            padding-bottom: 0;
        }

        .form-header h2 {
            color: #1a355b;
            font-size: 2.1rem;
            font-weight: 800;
            margin-bottom: 8px;
            letter-spacing: 1px;
        }

        .form-subtitle {
            color: #2986ff;
            font-size: 1.08rem;
            margin-bottom: 18px;
        }

        .form-group label, .required-field {
            color: #2986ff;
            font-weight: 700;
            font-size: 1.08em;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .form-group label i, .required-field i {
            color: #3bb6c5;
            font-size: 1.1em;
        }

        .form-control, select {
            border: 2.5px solid #2986ff !important;
            border-radius: 16px;
            background: #fafdff;
            color: #1a355b;
            font-size: 1.13em;
            padding: 14px 18px;
            margin-top: 4px;
            box-shadow: 0 2px 8px #2986ff11;
            transition: border 0.2s, box-shadow 0.2s;
        }

        .form-control:focus, select:focus {
            border-color: #3bb6c5 !important;
            box-shadow: 0 0 0 4px #3bb6c533;
            outline: none;
        }

        .btn-submit {
            background: linear-gradient(90deg, #2986ff 0%, #3bb6c5 100%);
            color: #fff;
            font-weight: 700;
            border-radius: 16px;
            border: none;
            font-size: 1.15em;
            padding: 16px 0;
            margin-top: 18px;
            width: 100%;
            box-shadow: 0 4px 18px #2986ff22;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: background 0.2s, color 0.2s, box-shadow 0.2s;
        }

        .btn-submit:hover {
            background: linear-gradient(90deg, #3bb6c5 0%, #2986ff 100%);
            color: #fff;
            box-shadow: 0 8px 28px #2986ff33;
        }

        .form-text {
            color: #3bb6c5;
            font-size: 0.95rem;
            margin-top: 5px;
        }

        @media (max-width: 768px) {
            .container, .main-container, .form-card, .overlay {
                padding: 18px 6px;
            }
            .form-header h2 {
                font-size: 1.3rem;
            }
        }

        .alert {
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            display: none;
            transition: all 0.3s ease;
        }

        .alert-success {
            background-color: #d4edda;
            border-color: #c3e6cb;
            color: #155724;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert i {
            font-size: 1.2rem;
        }

        .fade-in {
            animation: fadeIn 0.5s ease-in;
            display: block !important;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .nav-link, .nav-link:visited, .nav-link:active, .nav-link:hover {
            text-decoration: none !important;
            border: none !important;
            background: transparent !important;
            color: #fff !important;
            box-shadow: none !important;
        }
        .divider, hr, .section-title, .contact-card h2 {
            border-color: #111 !important;
            background: #111 !important;
            color: #2986ff !important;
        }
        .contact-card h2 {
            border-bottom: 2px solid #111 !important;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="overlay">
            <div id="successMessage" class="alert alert-success" style="display: none;">
                <i class="fas fa-check-circle"></i> Aduan berjaya dihantar!
            </div>

            <div class="form-header">
                <h2>BORANG ADUAN</h2>
                <p class="form-subtitle">Sila beri nombor bilik dan aduan yang terpeinci untuk diajukan</p>
            </div>

            <form action="sisi.php" method="POST" id="aduanForm">
                <div class="form-group">
                    <label for="aduan" class="required-field">Perincian Aduan</label>
                    <textarea 
                        class="form-control" 
                        id="aduan" 
                        name="aduan" 
                        rows="4" 
                        placeholder="Sila beri nombor bilik dan aduan yang terperinci untuk diajukan"
                        required
                    ></textarea>
                    <small class="form-text">
                        <i class="fas fa-info-circle"></i> 
                        Sila berikan maklumat yang jelas untuk memudahkan tindakan
                    </small>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tarikh_lapor" class="required-field">Tarikh</label>
                            <div class="input-group">
                                <input 
                                    type="date" 
                                    class="form-control" 
                                    id="tarikh_lapor" 
                                    name="tarikh_lapor" 
                                    required
                                >
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="rumah_tamu" class="required-field">Kolej</label>
                            <select class="form-control" id="rumah_tamu" name="rumah_tamu" required>
                                <option value="">Pilih Kolej</option>
                                <option value="1">Kolej Pendeta Za'ba</option>
                                <option value="2">Kolej Ungku Omar</option>
                                <option value="3">Kolej Ibrahim Yaakub</option>
                                <option value="4">Kolej Burhanuddin Helmi</option>
                                <option value="5">Kolej Dato Onn</option>
                                <option value="6">Kolej Rahim Kajai</option>
                                <option value="7">Kolej Ibu Zain</option>
                                <option value="8">Kolej Aminuddin Baki</option>
                                <option value="9">Kolej Keris Mas</option>
                            </select>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn-submit">
                    <i class="fas fa-paper-plane"></i> HANTAR ADUAN
                </button>
            </form>
        </div>
    </div>

    <script>
        
        document.getElementById('tarikh_lapor').valueAsDate = new Date();

        
        document.getElementById('aduanForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const aduan = document.getElementById('aduan').value.trim();
            const kolej = document.getElementById('rumah_tamu').value;

           
            if (aduan.length < 15) {
                alert('Sila berikan perincian aduan yang mencukupi (minimum 15 huruf)');
                return false;
            }

            if (!kolej) {
                alert('Sila pilih kolej');
                return false;
            }

            
            const formData = new FormData(this);

            
            fetch('sisi.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
               
                const successMessage = document.getElementById('successMessage');
                successMessage.classList.add('fade-in');
                
                
                document.getElementById('aduanForm').reset();
                document.getElementById('tarikh_lapor').valueAsDate = new Date();
                
                
                document.querySelector('.overlay').scrollIntoView({ behavior: 'smooth' });

                
                setTimeout(() => {
                    successMessage.classList.remove('fade-in');
                }, 5000);
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Ralat semasa menghantar aduan. Sila cuba lagi.');
            });
        });
    </script>
</body>
</html>

