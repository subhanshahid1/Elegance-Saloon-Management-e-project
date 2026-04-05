<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact & Support | Elegance Salon</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/dashboard.css">

    <style>
        /* ===== CONTACT SPECIFIC STYLES ===== */
        .contact-icon-box {
            width: 45px;
            height: 45px;
            background: var(--cream);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--gold);
            font-size: 20px;
            margin-bottom: 15px;
        }
        .support-card {
            transition: transform 0.3s ease;
            cursor: pointer;
        }
        .support-card:hover {
            transform: translateY(-5px);
        }
        .form-label-custom {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #999;
            margin-bottom: 8px;
            display: block;
        }
        .map-placeholder {
            width: 100%;
            height: 250px;
            background: #eee;
            border-radius: var(--panel-radius);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #999;
            overflow: hidden;
            position: relative;
        }
    </style>
</head>
<body>

    <?php include('../includes/sidebar.php'); ?>

    <div class="main-area">
        <?php include('../includes/topbar.php'); ?>

        <div class="content-area">
            
            <div class="section-gap">
                <h2 class="panel-title fs-3">Contact & Support</h2>
                <p class="panel-subtitle">Get in touch with the Elegance administration or technical support</p>
            </div>

            <div class="row g-4">
                <div class="col-12 col-lg-5">
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="panel p-4 support-card">
                                <div class="contact-icon-box"><i class="bi bi-telephone"></i></div>
                                <div class="fw-bold small">Call Us</div>
                                <div class="small text-muted">+92 21 3456 7890</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="panel p-4 support-card">
                                <div class="contact-icon-box"><i class="bi bi-envelope-paper"></i></div>
                                <div class="fw-bold small">Email Support</div>
                                <div class="small text-muted">help@elegance.com</div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="panel p-4">
                                <div class="fw-bold mb-3">Main Branch Location</div>
                                <div class="d-flex gap-3 mb-4">
                                    <i class="bi bi-geo-alt text-gold"></i>
                                    <div class="small text-muted">
                                        Plot 12-C, Lane 4, Zamzama Commercial Area, <br>
                                        Phase 5, DHA, Karachi, Pakistan.
                                    </div>
                                </div>
                                <div class="map-placeholder">
                                    <div class="text-center">
                                        <i class="bi bi-map fs-1 mb-2"></i>
                                        <p class="mb-0">Interactive Map View</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-7">
                    <div class="panel p-4">
                        <div class="panel-title fs-5 mb-4">Send us a Message</div>
                        <form action="#">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label-custom">Full Name</label>
                                    <input type="text" class="form-input" placeholder="Enter your name">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label-custom">Email Address</label>
                                    <input type="email" class="form-input" placeholder="name@example.com">
                                </div>
                                <div class="col-12">
                                    <label class="form-label-custom">Subject</label>
                                    <select class="form-input">
                                        <option>Technical Issue</option>
                                        <option>Billing Inquiry</option>
                                        <option>Staff Management Query</option>
                                        <option>Other</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label class="form-label-custom">Your Message</label>
                                    <textarea class="form-input" rows="6" placeholder="How can we help you today?"></textarea>
                                </div>
                                <div class="col-12 pt-2">
                                    <button type="submit" class="btn-gold w-100">Send Message</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/dashboard.js"></script>
    <script>
        // Update Topbar Title
        document.getElementById('page-title').textContent = "Support Center";
    </script>
</body>
</html>