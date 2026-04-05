<?php
require_once '../includes/auth.php';
checkAccess(['admin']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Team | Elegance Salon</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/dashboard.css">

    <style>
        /* ===== STAFF SPECIFIC STYLES ===== */
        .staff-card {
            text-align: center;
            padding: 30px 20px;
        }
        .staff-avatar-lg {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            margin: 0 auto 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: var(--font-display);
            font-size: 28px;
            font-weight: 600;
            border: 3px solid var(--cream);
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }
        .staff-name {
            font-family: var(--font-display);
            font-size: 20px;
            color: var(--charcoal);
            margin-bottom: 2px;
        }
        .staff-role {
            font-size: 12px;
            color: var(--gold-dark);
            text-transform: uppercase;
            letter-spacing: 0.1em;
            margin-bottom: 15px;
            display: block;
        }
        .staff-stats {
            display: flex;
            justify-content: center;
            gap: 20px;
            border-top: 1px solid rgba(0,0,0,0.05);
            padding-top: 15px;
            margin-top: 15px;
        }
        .stat-item {
            text-align: center;
        }
        .stat-num {
            display: block;
            font-weight: 600;
            font-size: 14px;
            color: var(--charcoal);
        }
        .stat-label {
            font-size: 10px;
            color: #999;
            text-transform: uppercase;
        }
        .status-indicator {
            position: absolute;
            top: 20px;
            right: 20px;
        }
    </style>
</head>
<body>

    <?php include('../includes/sidebar.php'); ?>

    <div class="main-area">
        <?php include('../includes/topbar.php'); ?>

        <div class="content-area">
            
            <div class="row g-3 align-items-center section-gap">
                <div class="col-12 col-md-6">
                    <h2 class="panel-title fs-3">Our Specialists</h2>
                    <p class="panel-subtitle">Manage staff schedules, roles, and performance</p>
                </div>
                <div class="col-12 col-md-6 d-flex justify-content-md-end gap-2">
                    <button class="btn-outline">
                        <i class="bi bi-calendar-event"></i> Rosters
                    </button>
                    <button class="btn-gold">
                        <i class="bi bi-person-plus"></i> Add Staff Member
                    </button>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-12 col-md-6 col-xl-4">
                    <div class="panel staff-card position-relative">
                        <div class="status-indicator">
                            <span class="badge-on-duty">On Duty</span>
                        </div>
                        <div class="staff-avatar-lg" style="background: var(--blush); color: var(--rose);">SK</div>
                        <h3 class="staff-name">Sara Khan</h3>
                        <span class="staff-role">Senior Hair Stylist</span>
                        <p class="small text-muted px-3">Expert in Balayage, Bridal updos, and precision cutting with 8 years experience.</p>
                        
                        <div class="staff-stats">
                            <div class="stat-item">
                                <span class="stat-num">124</span>
                                <span class="stat-label">Reviews</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-num">4.9</span>
                                <span class="stat-label">Rating</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-num">18</span>
                                <span class="stat-label">Bookings</span>
                            </div>
                        </div>
                        <div class="mt-4 d-flex gap-2 justify-content-center">
                            <button class="btn-outline w-50">Profile</button>
                            <button class="btn-gold w-50">Schedule</button>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-xl-4">
                    <div class="panel staff-card position-relative">
                        <div class="status-indicator">
                            <span class="badge-on-duty">On Duty</span>
                        </div>
                        <div class="staff-avatar-lg" style="background: #E8F4FD; color: #2E86C1;">MJ</div>
                        <h3 class="staff-name">Maria Jameel</h3>
                        <span class="staff-role">Skin Care Expert</span>
                        <p class="small text-muted px-3">Certified aesthetician specializing in organic facials and chemical peels.</p>
                        
                        <div class="staff-stats">
                            <div class="stat-item">
                                <span class="stat-num">98</span>
                                <span class="stat-label">Reviews</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-num">4.7</span>
                                <span class="stat-label">Rating</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-num">12</span>
                                <span class="stat-label">Bookings</span>
                            </div>
                        </div>
                        <div class="mt-4 d-flex gap-2 justify-content-center">
                            <button class="btn-outline w-50">Profile</button>
                            <button class="btn-gold w-50">Schedule</button>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-xl-4">
                    <div class="panel staff-card position-relative">
                        <div class="status-indicator">
                            <span class="badge-off">Off Duty</span>
                        </div>
                        <div class="staff-avatar-lg" style="background: var(--gold-light); color: var(--gold-dark);">SW</div>
                        <h3 class="staff-name">Sana Wahid</h3>
                        <span class="staff-role">Nail Technician</span>
                        <p class="small text-muted px-3">Master of nail art, gel extensions, and therapeutic spa pedicures.</p>
                        
                        <div class="staff-stats">
                            <div class="stat-item">
                                <span class="stat-num">210</span>
                                <span class="stat-label">Reviews</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-num">5.0</span>
                                <span class="stat-label">Rating</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-num">0</span>
                                <span class="stat-label">Bookings</span>
                            </div>
                        </div>
                        <div class="mt-4 d-flex gap-2 justify-content-center">
                            <button class="btn-outline w-50">Profile</button>
                            <button class="btn-gold w-50" disabled>Schedule</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/dashboard.js"></script>
    <script>
        // ===== PAGE NAVIGATION =====
        document.getElementById('page-title').textContent = "Staff Management";
    </script>
</body>
</html>