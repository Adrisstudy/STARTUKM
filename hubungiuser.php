<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="icon" type="image/png" href="haha.png">
    <title>Hubungi Kami - STARTUKM</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background: linear-gradient(160deg, #2986ff 0%, #3bb6c5 100%); font-family: 'Roboto', Arial, sans-serif; margin:0; padding:0; }
        .section-title, h1, h2, h3, h4 { color: #2986ff !important; }
        .divider, hr { border-color: #2986ff !important; background: #2986ff !important; height:2px; }
        .card, .contact-card { background: #fff; border-radius: 18px; box-shadow: 0 4px 16px #2986ff22; border: 1.5px solid #e0e7ef; }
        .card i, .contact-card i { color: #2986ff !important; }
        footer { width:100%;background:transparent;color:#fff;text-align:center;padding:18px 0 10px 0;font-weight:500;font-size:0.98rem;letter-spacing:1px;margin-top:40px; }

        .contact-container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .contact-title {
            color: #111 !important;
            font-weight: 900;
            text-align: center;
            background: none !important;
            border: none !important;
            margin: 56px 0 18px 0;
            font-size: 2.7em;
            letter-spacing: 1.2px;
            text-shadow: 0 2px 8px #0001;
        }

        .contact-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 25px;
            margin-top: 20px;
            margin-bottom: 36px;
        }

        .contact-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: 1px solid rgba(190, 174, 152, 0.2);
        }

        .contact-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(190, 174, 152, 0.3);
        }

        .contact-card h2 {
            color: #333;
            font-size: 1.3em;
            margin-bottom: 20px;
            border-bottom: 2px solid #beae98;
            padding-bottom: 10px;
            text-transform: uppercase;
        }

        .contact-info {
            margin-top: 20px;
        }

        .contact-item {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            color: #555;
            padding: 8px;
            border-radius: 8px;
            transition: background-color 0.3s ease;
        }

        .contact-item:hover {
            background-color: rgba(190, 174, 152, 0.1);
        }

        .contact-item i {
            width: 30px;
            color: #beae98;
            font-size: 1.2em;
        }

        .contact-item a {
            color: #555;
            text-decoration: none;
            transition: color 0.3s ease;
            margin-left: 10px;
            font-size: 0.95em;
        }

        .contact-item a:hover {
            color: #8b7355;
        }

        .section-title {
            color: #333;
            margin: 40px 0 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #beae98;
            font-size: 1.8em;
        }

        .map-container {
            margin-top: 50px;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(190, 174, 152, 0.2);
        }

        .map-container iframe {
            width: 100%;
            height: 400px;
            border: none;
        }

        @media (max-width: 768px) {
            .contact-grid {
                grid-template-columns: 1fr;
            }

            .contact-title {
                font-size: 2em;
            }

            .contact-card {
                margin: 10px;
            }
        }

        .nav-link, .nav-link:visited, .nav-link:active, .nav-link:hover {
            text-decoration: none !important;
            border: none !important;
            background: transparent !important;
            color: #fff !important;
            box-shadow: none !important;
        }
        .divider, hr, .section-title, .contact-card h2 {
            border-color: #fff !important;
            background: #fff !important;
            color: #2986ff !important;
        }
        .contact-card h2 {
            border-bottom: 2px solid #fff !important;
        }

        h2.section-title, h2 {
            color: #111 !important;
            background: none !important;
            border: none !important;
            display: block;
            font-size: 1.7rem;
            font-weight: 800;
            margin: 48px 0 18px 0;
            padding: 0 0 8px 0;
            text-align: left;
            letter-spacing: 1.1px;
            text-shadow: 0 2px 8px #0001;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="contact-container">
        <h1 class="contact-title">Hubungi Kami</h1>
        
        <h2 class="section-title">Pentadbiran</h2>
        <div class="contact-grid">
            <div class="contact-card">
                <h2>Pusat Perumahan Pelajar</h2>
                <div class="contact-info">
                    <div class="contact-item">
                        <i class="fas fa-envelope"></i>
                        <a href="mailto:pppelajarukm@ukm.edu.my?subject=Pertanyaan%20STARTUKM&body=Salam%20sejahtera%2C%0A%0ASaya%20ingin%20membuat%20pertanyaan%20mengenai%20...%0A%0ATerima%20kasih.">pppelajarukm@ukm.edu.my</a>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-phone"></i>
                        <a href="tel:0389214367">03-8921 4367</a>
                    </div>
                </div>
            </div>

            <div class="contact-card">
                <h2>Pusat Kesihatan Universiti</h2>
                <div class="contact-info">
                    <div class="contact-item">
                        <i class="fas fa-envelope"></i>
                        <a href="mailto:pkesihatan@ukm.edu.my?subject=Pertanyaan%20STARTUKM&body=Salam%20sejahtera%2C%0A%0ASaya%20ingin%20membuat%20pertanyaan%20mengenai%20...%0A%0ATerima%20kasih.">pkesihatan@ukm.edu.my</a>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-phone"></i>
                        <a href="tel:0389215087">03-8921 5087</a>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-phone"></i>
                        <a href="tel:0389213666">03-8921 3666</a>
                    </div>
                </div>
            </div>
        </div>

        <h2 class="section-title">Kolej Kediaman</h2>
        <div class="contact-grid">
            <div class="contact-card">
                <h2>Kolej Pendeta Za'ba</h2>
                <div class="contact-info">
                    <div class="contact-item">
                        <i class="fas fa-envelope"></i>
                        <a href="mailto:pgtkpz@ukm.edu.my?subject=Pertanyaan%20STARTUKM&body=Salam%20sejahtera%2C%0A%0ASaya%20ingin%20membuat%20pertanyaan%20mengenai%20...%0A%0ATerima%20kasih.">pgtkpz@ukm.edu.my</a>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-phone"></i>
                        <a href="tel:0389213954">03-8921 3954</a>
                    </div>
                </div>
            </div>

            <div class="contact-card">
                <h2>Kolej Keris Mas</h2>
                <div class="contact-info">
                    <div class="contact-item">
                        <i class="fas fa-envelope"></i>
                        <a href="mailto:pgtkkm@ukm.edu.my?subject=Pertanyaan%20STARTUKM&body=Salam%20sejahtera%2C%0A%0ASaya%20ingin%20membuat%20pertanyaan%20mengenai%20...%0A%0ATerima%20kasih.">pgtkkm@ukm.edu.my</a>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-phone"></i>
                        <a href="tel:0389214011">03-8921 4011</a>
                    </div>
                </div>
            </div>

            <div class="contact-card">
                <h2>Kolej Ungku Omar</h2>
                <div class="contact-info">
                    <div class="contact-item">
                        <i class="fas fa-envelope"></i>
                        <a href="mailto:pgtkuo@ukm.edu.my?subject=Pertanyaan%20STARTUKM&body=Salam%20sejahtera%2C%0A%0ASaya%20ingin%20membuat%20pertanyaan%20mengenai%20...%0A%0ATerima%20kasih.">pgtkuo@ukm.edu.my</a>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-phone"></i>
                        <a href="tel:0389215344">03-8921 5344</a>
                    </div>
                </div>
            </div>

            <div class="contact-card">
                <h2>Kolej Ibrahim Yaakub</h2>
                <div class="contact-info">
                    <div class="contact-item">
                        <i class="fas fa-envelope"></i>
                        <a href="mailto:pgtkiy@ukm.edu.my?subject=Pertanyaan%20STARTUKM&body=Salam%20sejahtera%2C%0A%0ASaya%20ingin%20membuat%20pertanyaan%20mengenai%20...%0A%0ATerima%20kasih.">pgtkiy@ukm.edu.my</a>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-phone"></i>
                        <a href="tel:0389215269">03-8921 5269</a>
                    </div>
                </div>
            </div>

            <div class="contact-card">
                <h2>Kolej Burhanuddin Helmi</h2>
                <div class="contact-info">
                    <div class="contact-item">
                        <i class="fas fa-envelope"></i>
                        <a href="mailto:pgtkbh@ukm.edu.my?subject=Pertanyaan%20STARTUKM&body=Salam%20sejahtera%2C%0A%0ASaya%20ingin%20membuat%20pertanyaan%20mengenai%20...%0A%0ATerima%20kasih.">pgtkbh@ukm.edu.my</a>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-phone"></i>
                        <a href="tel:0389216475">03-8921 6475</a>
                    </div>
                </div>
            </div>

            <div class="contact-card">
                <h2>Kolej Ibu Zain</h2>
                <div class="contact-info">
                    <div class="contact-item">
                        <i class="fas fa-envelope"></i>
                        <a href="mailto:pgtkiz@ukm.edu.my?subject=Pertanyaan%20STARTUKM&body=Salam%20sejahtera%2C%0A%0ASaya%20ingin%20membuat%20pertanyaan%20mengenai%20...%0A%0ATerima%20kasih.">pgtkiz@ukm.edu.my</a>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-phone"></i>
                        <a href="tel:0389219943">03-8921 9943</a>
                    </div>
                </div>
            </div>

            <div class="contact-card">
                <h2>Kolej Dato Onn</h2>
                <div class="contact-info">
                    <div class="contact-item">
                        <i class="fas fa-envelope"></i>
                        <a href="mailto:pgtkdo@ukm.edu.my?subject=Pertanyaan%20STARTUKM&body=Salam%20sejahtera%2C%0A%0ASaya%20ingin%20membuat%20pertanyaan%20mengenai%20...%0A%0ATerima%20kasih.">pgtkdo@ukm.edu.my</a>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-phone"></i>
                        <a href="tel:0389213157">03-8921 3157</a>
                    </div>
                </div>
            </div>

            <div class="contact-card">
                <h2>Kolej Rahim Kajai</h2>
                <div class="contact-info">
                    <div class="contact-item">
                        <i class="fas fa-envelope"></i>
                        <a href="mailto:pgtkrk@ukm.edu.my?subject=Pertanyaan%20STARTUKM&body=Salam%20sejahtera%2C%0A%0ASaya%20ingin%20membuat%20pertanyaan%20mengenai%20...%0A%0ATerima%20kasih.">pgtkrk@ukm.edu.my</a>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-phone"></i>
                        <a href="tel:0389213103">03-8921 3103</a>
                    </div>
                </div>
            </div>

            <div class="contact-card">
                <h2>Kolej Aminuddin Baki</h2>
                <div class="contact-info">
                    <div class="contact-item">
                        <i class="fas fa-envelope"></i>
                        <a href="mailto:pgtkab@ukm.edu.my?subject=Pertanyaan%20STARTUKM&body=Salam%20sejahtera%2C%0A%0ASaya%20ingin%20membuat%20pertanyaan%20mengenai%20...%0A%0ATerima%20kasih.">pgtkab@ukm.edu.my</a>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-phone"></i>
                        <a href="tel:0389215384">03-8921 5384</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="map-container">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3984.103550927533!2d101.77791731475503!3d3.0561699977575163!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31cdce0fd89c5555%3A0xca2268e2edb3ca80!2sUniversiti%20Kebangsaan%20Malaysia!5e0!3m2!1sen!2smy!4v1647893457889!5m2!1sen!2smy" allowfullscreen="" loading="lazy"></iframe>
        </div>
    </div>

    <footer>
        <p>&copy; <?php echo date('Y'); ?> STARTUKM. All rights reserved.</p>
    </footer>
</body>
</html>
