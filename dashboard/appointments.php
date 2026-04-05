<?php
require_once '../includes/auth.php';
checkAccess(['admin', 'receptionist', 'stylist']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointments | Elegance Salon</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/dashboard.css">

    <style>
        /* ===== APPOINTMENTS SPECIFIC STYLES ===== */
        .apt-customer-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .apt-avatar-sm {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: 600;
            flex-shrink: 0;
        }
        .customer-name {
            font-weight: 500;
            display: block;
            line-height: 1.2;
        }
        .customer-phone {
            font-size: 11px;
            color: #999;
        }
        .service-tag {
            font-size: 12px;
            color: var(--charcoal);
        }
        .staff-assigned {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
        }
        .staff-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: var(--gold);
        }
        
        /* --- Responsive Table --- */
        @media (max-width: 768px) {
            .hide-mobile { display: none; }
            .data-table { font-size: 12px; }
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
                    <h2 class="panel-title fs-3">Appointment Bookings</h2>
                    <p class="panel-subtitle">View and manage all scheduled services</p>
                </div>
                <div class="col-12 col-md-6 d-flex justify-content-md-end gap-2">
                    <button class="btn-outline">
                        <i class="bi bi-download"></i> Export
                    </button>
                    <button class="btn-gold" onclick="openModal('addAptModal')">
                        <i class="bi bi-plus-lg"></i> Book Appointment
                    </button>
                </div>
            </div>

            <div class="panel mb-4">
                <div class="panel-body d-flex flex-wrap justify-content-between align-items-center gap-3">
                    <div class="tab-pills">
                        <button class="tab-pill active" onclick="activateTab(this)">All</button>
                        <button class="tab-pill" onclick="activateTab(this)">Confirmed</button>
                        <button class="tab-pill" onclick="activateTab(this)">Pending</button>
                        <button class="tab-pill" onclick="activateTab(this)">Cancelled</button>
                    </div>
                    <div style="min-width: 200px;">
                        <input type="text" class="form-input" placeholder="Search customer or service...">
                    </div>
                </div>
            </div>

            <div class="panel">
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Customer</th>
                                <th>Service</th>
                                <th class="hide-mobile">Date & Time</th>
                                <th class="hide-mobile">Staff</th>
                                <th>Status</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="apt-customer-info">
                                        <div class="apt-avatar-sm" style="background: rgba(201,168,76,0.14); color: var(--gold-dark);">AN</div>
                                        <div>
                                            <span class="customer-name">Ayesha Noor</span>
                                            <span class="customer-phone">+92 300 1234567</span>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="service-tag">Balayage Hair Color</span></td>
                                <td class="hide-mobile">April 4, 09:00 AM</td>
                                <td class="hide-mobile">
                                    <div class="staff-assigned"><span class="staff-dot"></span> Sara K.</div>
                                </td>
                                <td><span class="badge-confirmed">Confirmed</span></td>
                                <td class="text-end">
                                    <button class="logout-btn text-dark me-2"><i class="bi bi-pencil-square"></i></button>
                                    <button class="logout-btn"><i class="bi bi-three-dots-vertical"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="apt-customer-info">
                                        <div class="apt-avatar-sm" style="background: rgba(196,139,139,0.14); color: var(--rose);">FK</div>
                                        <div>
                                            <span class="customer-name">Fatima Khan</span>
                                            <span class="customer-phone">+92 321 7654321</span>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="service-tag">Deep Cleanse Facial</span></td>
                                <td class="hide-mobile">April 4, 10:30 AM</td>
                                <td class="hide-mobile">
                                    <div class="staff-assigned"><span class="staff-dot"></span> Maria J.</div>
                                </td>
                                <td><span class="badge-confirmed">Confirmed</span></td>
                                <td class="text-end">
                                    <button class="logout-btn text-dark me-2"><i class="bi bi-pencil-square"></i></button>
                                    <button class="logout-btn"><i class="bi bi-three-dots-vertical"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="apt-customer-info">
                                        <div class="apt-avatar-sm" style="background: rgba(91,164,207,0.14); color: #2E86C1;">MA</div>
                                        <div>
                                            <span class="customer-name">Maria Ahmed</span>
                                            <span class="customer-phone">+92 333 9876543</span>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="service-tag">Manicure + Pedicure</span></td>
                                <td class="hide-mobile">April 4, 12:00 PM</td>
                                <td class="hide-mobile">
                                    <div class="staff-assigned"><span class="staff-dot"></span> Sana W.</div>
                                </td>
                                <td><span class="badge-pending">Pending</span></td>
                                <td class="text-end">
                                    <button class="logout-btn text-dark me-2"><i class="bi bi-pencil-square"></i></button>
                                    <button class="logout-btn"><i class="bi bi-three-dots-vertical"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/dashboard.js"></script>
    <script>
        // ===== PAGE NAVIGATION =====
        document.getElementById('page-title').textContent = "Manage Appointments";
        
        // Specific page JS logic can go here
    </script>
</body>
</html>