<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';
checkAccess(['admin']);

// 1. TOTAL STATS (Based on your saloon.sql)
$appt_stats_query = $conn->query("SELECT 
    (SELECT COUNT(*) FROM appointments) as total_appts,
    (SELECT COALESCE(SUM(amount), 0) FROM payments) as total_revenue,
    (SELECT COUNT(*) FROM appointments WHERE status = 'confirmed') as completed 
");
$appt_stats = $appt_stats_query->fetch_assoc();

// 2. POPULAR SERVICES
$popular_services = $conn->query("SELECT s.name, COUNT(a.id) as count 
    FROM services s
    LEFT JOIN appointments a ON s.id = a.service_id 
    GROUP BY s.id 
    ORDER BY count DESC LIMIT 5");

// 3. PEAK HOURS
$peak_hours = $conn->query("SELECT HOUR(apt_time) as hr, COUNT(*) as count 
    FROM appointments 
    GROUP BY hr ORDER BY count DESC LIMIT 4");

// 4. STAFF PERFORMANCE (Using stylist_id)
$staff_perf = $conn->query("SELECT u.name, COUNT(a.id) as jobs, COALESCE(SUM(p.amount), 0) as earnings 
    FROM users u
    LEFT JOIN appointments a ON u.id = a.stylist_id
    LEFT JOIN payments p ON a.id = p.appointment_id
    WHERE u.role = 'stylist'
    GROUP BY u.id ORDER BY earnings DESC");

// 5. INVENTORY ALERTS
$low_stock = $conn->query("SELECT name, quantity, reorder_level 
    FROM inventory 
    WHERE quantity <= reorder_level 
    LIMIT 8");

// Helper used in feedback page
function get_percent($val, $total)
{
    return ($total > 0) ? ($val / $total) * 100 : 0;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analytics | Elegance Salon</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <style>
        /* Custom Styles */
        :root {
            --gold: #c9a84c;
            --charcoal: #1a1a1a;
        }

        .stat-icon {
            width: 45px;
            height: 45px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .bg-gold-light {
            background: #fdfaf0;
            color: var(--gold);
        }

        .bg-green-light {
            background: #f0fff4;
            color: #28a745;
        }

        .bg-blue-light {
            background: #f0f7ff;
            color: #007bff;
        }

        /* Progress bars matching the feedback "Rating Breakdown" bars */
        .inv-bar {
            height: 6px;
            background: #eee;
            border-radius: 10px;
            margin: 4px 0;
        }

        .inv-fill {
            height: 100%;
            background: var(--gold);
            border-radius: 10px;
        }

        /* Panel style consistency */
        .panel {
            border: none;
            border-radius: 8px;
        }

        @media print {

            .sidebar,
            .topbar,
            .tab-pills-container,
            .btn-outline,
            .btn-gold {
                display: none !important;
            }

            .main-area {
                margin: 0;
                padding: 0;
                width: 100%;
            }

            .panel {
                box-shadow: none !important;
                border: 1px solid #ddd !important;
            }
        }
    </style>
</head>

<body>

    <?php include('../includes/sidebar.php'); ?>

    <div class="main-area">
        <?php include('../includes/topbar.php'); ?>

        <div class="content-area container-fluid px-3 px-md-4 py-4">

            <div class="row g-3 align-items-center mb-4">
                <div class="col-12 col-md-6">
                    <h2 class="panel-title fs-3 mb-1">Business Analytics</h2>
                    <p class="panel-subtitle">Salon Performance Overview</p>
                </div>
                <div class="col-12 col-md-6 d-flex justify-content-md-end gap-2">
                    <button onclick="window.print()" class="btn-gold btn-sm"><i class="bi bi-printer"></i> Print</button>
                </div>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="panel p-3 bg-white shadow-sm">
                        <div class="d-flex align-items-center gap-3">
                            <div class="stat-icon bg-gold-light"><i class="bi bi-calendar4-event"></i></div>
                            <div>
                                <small class="text-muted d-block">Total Bookings</small>
                                <span class="fs-4 fw-bold text-dark"><?php echo $appt_stats['total_appts']; ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="panel p-3 bg-white shadow-sm">
                        <div class="d-flex align-items-center gap-3">
                            <div class="stat-icon bg-green-light"><i class="bi bi-cash-stack"></i></div>
                            <div>
                                <small class="text-muted d-block">Total Sales</small>
                                <span class="fs-4 fw-bold text-dark">Rs. <?php echo number_format($appt_stats['total_revenue'], 2); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-md-4">
                    <div class="panel p-3 bg-white shadow-sm">
                        <div class="d-flex align-items-center gap-3">
                            <div class="stat-icon bg-blue-light"><i class="bi bi-check2-circle"></i></div>
                            <div>
                                <small class="text-muted d-block">Confirmed Jobs</small>
                                <span class="fs-4 fw-bold text-dark"><?php echo $appt_stats['completed']; ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-12 col-lg-7">
                    <div class="panel p-4 bg-white shadow-sm h-100">
                        <h6 class="fw-bold mb-4">Popular Services</h6>
                        <?php if ($popular_services->num_rows > 0): while ($s = $popular_services->fetch_assoc()):
                                $pct = get_percent($s['count'], $appt_stats['total_appts']); ?>
                                <div class="mb-4">
                                    <div class="d-flex justify-content-between small mb-1">
                                        <span class="fw-medium text-dark"><?php echo htmlspecialchars($s['name']); ?></span>
                                        <span class="text-muted"><?php echo $s['count']; ?> Bookings</span>
                                    </div>
                                    <div class="inv-bar">
                                        <div class="inv-fill" style="width:<?php echo $pct; ?>%"></div>
                                    </div>
                                </div>
                        <?php endwhile;
                        else: echo "No data available";
                        endif; ?>
                    </div>
                </div>

                <div class="col-12 col-lg-5">
                    <div class="panel p-4 bg-white shadow-sm h-100">
                        <h6 class="fw-bold mb-4">Peak Booking Hours</h6>
                        <div class="row g-2">
                            <?php if ($peak_hours->num_rows > 0): while ($h = $peak_hours->fetch_assoc()): ?>
                                    <div class="col-6">
                                        <div class="p-3 bg-light rounded text-center border">
                                            <div class="small text-muted mb-1"><?php echo date("g A", strtotime($h['hr'] . ":00")); ?></div>
                                            <div class="fw-bold fs-5 text-dark"><?php echo $h['count']; ?></div>
                                        </div>
                                    </div>
                            <?php endwhile;
                            else: echo "No trends found";
                            endif; ?>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="panel bg-white shadow-sm overflow-hidden">
                        <div class="p-3 border-bottom bg-light">
                            <h6 class="fw-bold mb-0">Stylist Performance Report</h6>
                        </div>
                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead class="table-light small text-uppercase">
                                    <tr>
                                        <th class="ps-4">Stylist Name</th>
                                        <th>Total Jobs</th>
                                        <th>Revenue Generated</th>
                                        <th class="pe-4">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($staff_perf->num_rows > 0): while ($st = $staff_perf->fetch_assoc()): ?>
                                            <tr>
                                                <td class="ps-4 fw-bold text-dark"><?php echo htmlspecialchars($st['name']); ?></td>
                                                <td><?php echo $st['jobs']; ?></td>
                                                <td class="text-success fw-bold">Rs. <?php echo number_format($st['earnings'], 2); ?></td>
                                                <td class="pe-4">
                                                    <span class="badge rounded-pill <?php echo ($st['jobs'] > 5) ? 'bg-success' : 'bg-warning'; ?>" style="font-size: 10px;">
                                                        <?php echo ($st['jobs'] > 5) ? 'Top Performer' : 'Active'; ?>
                                                    </span>
                                                </td>
                                            </tr>
                                        <?php endwhile;
                                    else: ?>
                                        <tr>
                                            <td colspan="4" class="p-4 text-center text-muted">No stylists recorded.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="panel p-4 bg-white shadow-sm border-start border-4 border-danger">
                        <h6 class="fw-bold text-danger mb-3"><i class="bi bi-exclamation-triangle me-2"></i>Inventory Reorder Alerts</h6>
                        <div class="row g-3">
                            <?php if ($low_stock->num_rows > 0): while ($i = $low_stock->fetch_assoc()): ?>
                                    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                        <div class="border rounded p-2 d-flex justify-content-between align-items-center">
                                            <span class="small fw-medium"><?php echo htmlspecialchars($i['name']); ?></span>
                                            <span class="badge bg-danger rounded-pill"><?php echo $i['quantity']; ?> left</span>
                                        </div>
                                    </div>
                                <?php endwhile;
                            else: ?>
                                <div class="col-12 text-muted small">All stock levels are sufficient.</div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script>
        if (document.getElementById('page-title')) document.getElementById('page-title').textContent = "Analytics";
    </script>
    <script src="../assets/js/dashboard.js"></script>
</body>

</html>