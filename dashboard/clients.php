<?php
require_once '../includes/auth.php';
checkAccess(['admin', 'receptionist']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clients | Elegance Salon</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/dashboard.css">

    <style>
        /* ===== CLIENTS SPECIFIC STYLES ===== */
        .client-profile {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .client-avatar {
            width: 38px;
            height: 38px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: var(--font-display);
            font-weight: 600;
            font-size: 14px;
        }
        .last-visit {
            font-size: 11px;
            color: #999;
        }
        .spend-amount {
            font-weight: 600;
            color: var(--charcoal);
        }
        
        /* --- Responsive Adjustments --- */
        @media (max-width: 992px) {
            .hide-tablet { display: none; }
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
                    <h2 class="panel-title fs-3">Client Directory</h2>
                    <p class="panel-subtitle">Manage customer profiles and history</p>
                </div>
                <div class="col-12 col-md-6 d-flex justify-content-md-end gap-2">
                    <button class="btn-outline">
                        <i class="bi bi-filter"></i> Filters
                    </button>
                    <button class="btn-gold">
                        <i class="bi bi-person-plus"></i> Add New Client
                    </button>
                </div>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-12 col-lg-8">
                    <div class="panel">
                        <div class="panel-body p-2">
                            <div class="input-group border-0">
                                <span class="input-group-text bg-transparent border-0"><i class="bi bi-search text-muted"></i></span>
                                <input type="text" class="form-control border-0 shadow-none" placeholder="Search by name, phone, or email...">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-4">
                    <div class="panel">
                        <div class="panel-body d-flex align-items-center justify-content-between py-2">
                            <div>
                                <div class="panel-subtitle">Active Clients</div>
                                <div class="fw-bold">1,248</div>
                            </div>
                            <div class="text-end">
                                <div class="panel-subtitle">New (This Month)</div>
                                <div class="fw-bold text-success">+24</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel">
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Client Name</th>
                                <th>Contact Information</th>
                                <th class="hide-tablet">Last Visit</th>
                                <th class="hide-tablet">Total Spend</th>
                                <th>Status</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="client-profile">
                                        <div class="client-avatar" style="background: var(--blush); color: var(--rose);">AN</div>
                                        <div>
                                            <div class="fw-bold">Ayesha Noor</div>
                                            <div class="last-visit d-lg-none">Last: 2 days ago</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="small">ayesha.n@email.com</div>
                                    <div class="customer-phone">+92 300 1234567</div>
                                </td>
                                <td class="hide-tablet">
                                    <div>April 4, 2024</div>
                                    <div class="last-visit">with Sara K.</div>
                                </td>
                                <td class="hide-tablet">
                                    <div class="spend-amount">₨45,200</div>
                                    <div class="last-visit">12 Appointments</div>
                                </td>
                                <td><span class="badge-gold">VIP</span></td>
                                <td class="text-end">
                                    <button class="logout-btn text-dark me-2" title="View History"><i class="bi bi-eye"></i></button>
                                    <button class="logout-btn"><i class="bi bi-three-dots-vertical"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="client-profile">
                                        <div class="client-avatar" style="background: #E8F4FD; color: #2E86C1;">FK</div>
                                        <div>
                                            <div class="fw-bold">Fatima Khan</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="small">f.khan88@email.com</div>
                                    <div class="customer-phone">+92 321 7654321</div>
                                </td>
                                <td class="hide-tablet">
                                    <div>March 28, 2024</div>
                                    <div class="last-visit">with Maria J.</div>
                                </td>
                                <td class="hide-tablet">
                                    <div class="spend-amount">₨12,500</div>
                                    <div class="last-visit">3 Appointments</div>
                                </td>
                                <td><span class="badge-blue">Regular</span></td>
                                <td class="text-end">
                                    <button class="logout-btn text-dark me-2"><i class="bi bi-eye"></i></button>
                                    <button class="logout-btn"><i class="bi bi-three-dots-vertical"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="client-profile">
                                        <div class="client-avatar" style="background: #F2F2F2; color: #666;">ZR</div>
                                        <div>
                                            <div class="fw-bold">Zara Raza</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="small">zara.raza@email.com</div>
                                    <div class="customer-phone">+92 333 4445556</div>
                                </td>
                                <td class="hide-tablet">
                                    <div>New Client</div>
                                    <div class="last-visit">No visits yet</div>
                                </td>
                                <td class="hide-tablet">
                                    <div class="spend-amount">₨0</div>
                                    <div class="last-visit">0 Appointments</div>
                                </td>
                                <td><span class="badge-rose">New</span></td>
                                <td class="text-end">
                                    <button class="logout-btn text-dark me-2"><i class="bi bi-eye"></i></button>
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
        document.getElementById('page-title').textContent = "Client Directory";
    </script>
</body>
</html>