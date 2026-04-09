<?php
require_once '../includes/auth.php';
require_once '../includes/db.php'; 
checkAccess(['admin', 'receptionist' , 'stylist']);

// --- 1. KEY METRICS ---
// Get Today's Appointments
$today = date('Y-m-d');
$today_appt_query = $conn->query("SELECT COUNT(*) as count FROM appointments WHERE apt_date = '$today'");
$today_count = $today_appt_query->fetch_assoc()['count'];

// Get Pending Feedbacks
$pending_feedback = $conn->query("SELECT COUNT(*) as count FROM feedbacks WHERE status = 'new'");
$feedback_count = $pending_feedback->fetch_assoc()['count'];

// Get Total Revenue (Sum of payments)
$revenue_query = $conn->query("SELECT SUM(amount) as total FROM payments WHERE status = 'paid'");
$total_revenue = $revenue_query->fetch_assoc()['total'] ?? 0;

// --- 2. RECENT ACTIVITY ---
// Fetch last 5 appointments with client and service names
$recent_appts = $conn->query("
    SELECT a.apt_time, u.name as client_name, s.name as service_name, a.status 
    FROM appointments a
    JOIN users u ON a.client_id = u.id
    JOIN services s ON a.service_id = s.id
    ORDER BY a.created_at DESC LIMIT 5
");

// --- 3. INVENTORY STATUS ---
// Count items below reorder level
$low_stock_query = $conn->query("SELECT COUNT(*) as count FROM inventory WHERE quantity <= reorder_level");
$low_stock_count = $low_stock_query->fetch_assoc()['count'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Elegance Salon</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <style>
        :root { --gold: #c9a84c; --charcoal: #1a1a1a; }
        body { background-color: #f4f7f6; }
        
        .stat-card {
            border: none;
            border-radius: 12px;
            transition: transform 0.3s ease;
            background: #fff;
        }
        .stat-card:hover { transform: translateY(-5px); }
        
        .icon-box {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }
        
        .bg-gold-light { background: #fdfaf0; color: var(--gold); }
        .bg-charcoal { background: var(--charcoal); color: #fff; }
        
        .btn-gold { 
            background: var(--gold); 
            color: white; 
            border: none; 
            border-radius: 8px;
            padding: 10px 20px;
            transition: 0.3s;
        }
        .btn-gold:hover { background: #b08d3a; color: white; }

        .table-custom thead { background: #f8f9fa; text-transform: uppercase; font-size: 12px; letter-spacing: 1px; }
        
        .status-badge { font-size: 11px; padding: 5px 10px; border-radius: 20px; }
    </style>
</head>
<body>

    <?php include('../includes/sidebar.php'); ?>

    <div class="main-area">
        <?php include('../includes/topbar.php'); ?>

        <div class="content-area container-fluid px-4 py-4">
            
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold mb-0">Welcome, <?php echo $_SESSION['user_name']; ?></h2>
                    <p class="text-muted">Here's what's happening at Elegance Salon today.</p>
                </div>
                <div class="d-none d-md-block">
                    <a href="appointments.php" class="btn-gold"><i class="bi bi-plus-lg me-2"></i>New Appointment</a>
                </div>
            </div>

            <div class="row g-4 mb-4">
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="stat-card p-4 shadow-sm">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-1">Today's Bookings</h6>
                                <h3 class="fw-bold mb-0"><?php echo $today_count; ?></h3>
                            </div>
                            <div class="icon-box bg-gold-light"><i class="bi bi-calendar-check"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="stat-card p-4 shadow-sm">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-1">Total Revenue</h6>
                                <h3 class="fw-bold mb-0">Rs. <?php echo number_format($total_revenue); ?></h3>
                            </div>
                            <div class="icon-box bg-green-light" style="background:#e8f5e9; color:#2e7d32;"><i class="bi bi-currency-dollar"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="stat-card p-4 shadow-sm">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-1">New Feedback</h6>
                                <h3 class="fw-bold mb-0"><?php echo $feedback_count; ?></h3>
                            </div>
                            <div class="icon-box bg-blue-light" style="background:#e3f2fd; color:#1976d2;"><i class="bi bi-chat-left-text"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="stat-card p-4 shadow-sm">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-1">Low Stock Items</h6>
                                <h3 class="fw-bold mb-0 <?php echo $low_stock_count > 0 ? 'text-danger' : ''; ?>"><?php echo $low_stock_count; ?></h3>
                            </div>
                            <div class="icon-box bg-danger-light" style="background:#ffebee; color:#c62828;"><i class="bi bi-box-seam"></i></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-12 col-lg-8">
                    <div class="card stat-card shadow-sm h-100">
                        <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                            <h5 class="fw-bold mb-0">Recent Appointments</h5>
                            <a href="appointments.php" class="text-gold text-decoration-none small fw-bold">View All</a>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-custom align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th class="ps-4">Time</th>
                                        <th>Client</th>
                                        <th>Service</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if($recent_appts->num_rows > 0): while($row = $recent_appts->fetch_assoc()): ?>
                                    <tr>
                                        <td class="ps-4 fw-medium"><?php echo date('h:i A', strtotime($row['apt_time'])); ?></td>
                                        <td><?php echo htmlspecialchars($row['client_name']); ?></td>
                                        <td><?php echo htmlspecialchars($row['service_name']); ?></td>
                                        <td>
                                            <?php 
                                            $status_class = match($row['status']) {
                                                'confirmed' => 'bg-success text-white',
                                                'pending' => 'bg-warning text-dark',
                                                'cancelled' => 'bg-danger text-white',
                                                default => 'bg-secondary text-white'
                                            };
                                            ?>
                                            <span class="status-badge <?php echo $status_class; ?>">
                                                <?php echo ucfirst($row['status']); ?>
                                            </span>
                                        </td>
                                    </tr>
                                    <?php endwhile; else: ?>
                                        <tr><td colspan="4" class="text-center py-4">No recent appointments found.</td></tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-4">
                    <div class="card stat-card shadow-sm mb-4">
                        <div class="card-body p-4 text-center">
                            <div class="icon-box bg-charcoal mx-auto mb-3" style="width: 70px; height: 70px; font-size: 32px;">
                                <i class="bi bi-scissors"></i>
                            </div>
                            <h5 class="fw-bold">Elegance Salon</h5>
                            <p class="text-muted small">Manage your business settings and preferences.</p>
                            <div class="d-grid gap-2">
                                <a href="inventory.php" class="btn btn-outline-dark btn-sm rounded-pill">Manage Inventory</a>
                                <a href="staff.php" class="btn btn-outline-dark btn-sm rounded-pill">Staff Management</a>
                                <a href="settings.php" class="btn btn-outline-dark btn-sm rounded-pill">Salon Settings</a>
                            </div>
                        </div>
                    </div>

                    <div class="card stat-card shadow-sm bg-charcoal text-white">
                        <div class="card-body p-4">
                            <h6 class="text-uppercase small mb-3" style="letter-spacing: 1px; color: var(--gold);">Daily Goal</h6>
                            <div class="d-flex justify-content-between align-items-end mb-2">
                                <h2 class="fw-bold mb-0">75%</h2>
                                <small class="text-white-50">15 / 20 Bookings</small>
                            </div>
                            <div class="progress" style="height: 6px; background: rgba(255,255,255,0.1);">
                                <div class="progress-bar" style="width: 75%; background: var(--gold);"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/dashboard.js"></script>
</body>
</html>