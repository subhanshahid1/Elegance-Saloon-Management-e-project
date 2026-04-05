<?php
require_once '../includes/auth.php';
checkAccess(['admin']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings | Elegance Salon</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/dashboard.css">

    <style>
        /* ===== ADMIN SPECIFIC STYLES ===== */
        .settings-nav {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }
        .settings-link {
            padding: 12px 15px;
            border-radius: 8px;
            color: var(--charcoal);
            text-decoration: none;
            font-size: 14px;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .settings-link:hover {
            background: var(--cream);
            color: var(--gold-dark);
        }
        .settings-link.active {
            background: var(--gold);
            color: white;
        }
        .admin-avatar-upload {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: var(--cream);
            border: 2px dashed var(--gold-light);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            margin-bottom: 15px;
        }
        .admin-avatar-upload i { font-size: 24px; color: var(--gold); }
        .admin-avatar-upload span { font-size: 10px; color: var(--gold-dark); margin-top: 5px; }

        /* --- Re-using toggle styles from global CSS --- */
        .toggle-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }
        .toggle-row:last-child { border-bottom: none; }
    </style>
</head>
<body>

    <?php include('../includes/sidebar.php'); ?>

    <div class="main-area">
        <?php include('../includes/topbar.php'); ?>

        <div class="content-area">
            
            <div class="section-gap">
                <h2 class="panel-title fs-3">System Settings</h2>
                <p class="panel-subtitle">Configure salon preferences and account security</p>
            </div>

            <div class="row g-4">
                <div class="col-12 col-lg-3">
                    <div class="panel p-3">
                        <nav class="settings-nav">
                            <a href="#" class="settings-link active"><i class="bi bi-person"></i> Account Profile</a>
                            <a href="#" class="settings-link"><i class="bi bi-shop"></i> Salon Branding</a>
                            <a href="#" class="settings-link"><i class="bi bi-shield-lock"></i> Password & Security</a>
                            <a href="#" class="settings-link"><i class="bi bi-bell"></i> Notification Rules</a>
                            <a href="#" class="settings-link text-danger"><i class="bi bi-trash"></i> Data Management</a>
                        </nav>
                    </div>
                </div>

                <div class="col-12 col-lg-9">
                    <div class="panel p-4 mb-4">
                        <div class="panel-title fs-5 mb-4">Account Profile</div>
                        
                        <div class="admin-avatar-upload">
                            <i class="bi bi-camera"></i>
                            <span>Change Photo</span>
                        </div>

                        <form>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label-custom">Admin Name</label>
                                    <input type="text" class="form-input" value="Zain Ahmed">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label-custom">Email Address</label>
                                    <input type="email" class="form-input" value="zain.ahmed@elegance.com">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label-custom">Salon Name</label>
                                    <input type="text" class="form-input" value="Elegance Luxury Salon">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label-custom">Currency</label>
                                    <select class="form-input">
                                        <option>PKR (₨)</option>
                                        <option>USD ($)</option>
                                        <option>GBP (£)</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mt-4">
                                <button type="button" class="btn-gold px-4">Save Changes</button>
                            </div>
                        </form>
                    </div>

                    <div class="panel p-4">
                        <div class="panel-title fs-5 mb-3">System Preferences</div>
                        
                        <div class="toggle-row">
                            <div>
                                <div class="fw-bold small">SMS Notifications</div>
                                <div class="small text-muted">Send automated appointment reminders to clients</div>
                            </div>
                            <div class="toggle" id="sms-toggle"></div>
                        </div>

                        <div class="toggle-row">
                            <div>
                                <div class="fw-bold small">Inventory Alerts</div>
                                <div class="small text-muted">Notify me when stock levels fall below 15%</div>
                            </div>
                            <div class="toggle" id="stock-toggle"></div>
                        </div>

                        <div class="toggle-row">
                            <div>
                                <div class="fw-bold small">Public Booking Page</div>
                                <div class="small text-muted">Allow clients to book online via your public link</div>
                            </div>
                            <div class="toggle off" id="booking-toggle"></div>
                        </div>

                        <div class="toggle-row">
                            <div>
                                <div class="fw-bold small">Staff Commission Tracking</div>
                                <div class="small text-muted">Automatically calculate staff earnings based on services</div>
                            </div>
                            <div class="toggle" id="comm-toggle"></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/dashboard.js"></script>
    <script>
        // Update Topbar Title
        document.getElementById('page-title').textContent = "Settings & Administration";

        // Local settings interactivity
        document.querySelectorAll('.settings-link').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                document.querySelectorAll('.settings-link').forEach(l => l.classList.remove('active'));
                this.classList.add('active');
            });
        });
    </script>
</body>
</html> 