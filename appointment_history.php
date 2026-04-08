<?php 
require_once 'includes/db.php'; 
// Guard: Ensure user is logged in
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit(); }

$client_id = $_SESSION['user_id'];

// Fetching appointments with joined service and stylist names
$query = "SELECT a.*, s.name as service_name, s.price, u.name as stylist_name 
          FROM appointments a 
          JOIN services s ON a.service_id = s.id 
          LEFT JOIN users u ON a.stylist_id = u.id 
          WHERE a.client_id = '$client_id' 
          ORDER BY a.apt_date DESC, a.apt_time DESC";
$res = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Appointments | Elegance Salon</title>
    
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <style>
        /* Shared Contact.php Theme */
        html, body { max-width: 100%; overflow-x: hidden; }
        .page-hero {
            background: linear-gradient(rgba(0,0,0,0.65), rgba(0,0,0,0.65)),
                        url('https://images.unsplash.com/photo-1560066984-138dadb4c035?q=80&w=1600') center/cover no-repeat;
            padding: 90px 0 70px; text-align: center;
        }
        .page-hero h1 {
            font-family: var(--font-primary); font-size: clamp(2.2rem, 6vw, 3.8rem);
            color: var(--primary-gold); text-transform: uppercase; letter-spacing: 6px;
        }
        .breadcrumb-row { display: flex; justify-content: center; gap: 10px; font-size: 12px; letter-spacing: 2px; text-transform: uppercase; color: var(--text-muted); }
        .breadcrumb-row a { color: var(--text-muted); text-decoration: none; }
        .breadcrumb-row span { color: var(--primary-gold); }

        .history-section { padding: 80px 0; background: var(--bg-black); min-height: 80vh; }
        .col-heading { font-family: var(--font-primary); font-size: 1.8rem; color: #fff; margin-bottom: 10px; }
        .col-heading em { color: var(--primary-gold); font-style: normal; }
        .col-subtext { font-size: 13px; color: var(--text-muted); margin-bottom: 2rem; line-height: 1.6; }
        .divider-col { border-left: 1px solid #222; }

        /* Table Design */
        .table-responsive-custom { width: 100%; }
        .table-custom { color: #fff; width: 100%; font-size: 14px; border-collapse: separate; border-spacing: 0 10px; }
        .table-custom th { 
            color: var(--primary-gold); font-size: 11px; text-transform: uppercase; 
            letter-spacing: 1px; padding: 10px; border-bottom: 1px solid #333; 
        }
        .table-custom td { 
            padding: 20px 15px; background: var(--bg-card); 
            border-top: 1px solid #333; border-bottom: 1px solid #333; 
            vertical-align: middle;
        }

        /* Status Badges */
        .status-badge { 
            font-size: 10px; text-transform: uppercase; padding: 4px 10px; 
            border-radius: 3px; border: 1px solid; font-weight: bold;
        }
        .status-pending { color: #ffc107; border-color: #ffc107; background: rgba(255, 193, 7, 0.05); }
        .status-confirmed { color: #28a745; border-color: #28a745; background: rgba(40, 167, 69, 0.05); }
        .status-cancelled { color: #dc3545; border-color: #dc3545; background: rgba(220, 53, 69, 0.05); }

        /* Buttons */
        .btn-gold-sm { 
            background: var(--primary-gold); color: #000; font-size: 11px; 
            font-weight: bold; text-transform: uppercase; padding: 12px 25px; 
            text-decoration: none; border-radius: 4px; display: inline-block; 
            transition: 0.3s; border: 1px solid var(--primary-gold);
        }
        .btn-gold-sm:hover { background: #fff; border-color: #fff; color: #000; transform: translateY(-2px); }

        .info-block p.small {
            color: var(--text-silver) !important; /* Forces the luxury silver/white color */
            opacity: 0.8; /* Maintains the hierarchy without being "black" */
            line-height: 1.6;
        }

        /* MOBILE RESPONSIVENESS HACK */
        @media (max-width: 768px) {
            .table-custom thead { display: none; } /* Hide headers on mobile */
            .table-custom, .table-custom tbody, .table-custom tr, .table-custom td { display: block; width: 100%; }
            .table-custom tr { margin-bottom: 20px; border: 1px solid #333; background: var(--bg-card); padding: 10px; }
            .table-custom td { 
                border: none; text-align: right; padding: 10px 15px; 
                position: relative; background: transparent; 
            }
            .table-custom td::before {
                content: attr(data-label); /* Uses the data-label attribute to show header */
                position: absolute; left: 15px; font-weight: bold; 
                text-transform: uppercase; font-size: 10px; color: var(--primary-gold);
            }
        }

        @media (max-width: 991px) {
            .divider-col { border-left: none; border-top: 1px solid #222; padding-top: 3rem; margin-top: 2rem; }
        }
    </style>
</head>
<body>

<?php include('includes/header.php'); ?>

<section class="page-hero">
    <h1>Account</h1>
    <div class="breadcrumb-row">
        <a href="index.php">Home</a> <span>›</span> <span>Appointments</span>
    </div>
</section>

<section class="history-section">
    <div class="container">
        <div class="row g-0">
            <div class="col-12 col-md-8 pe-md-5">
                <h2 class="col-heading">Appointment <em>History</em></h2>
                <p class="col-subtext">Track the status of your upcoming and past salon visits.</p>
                
                <div class="table-responsive-custom">
                    <table class="table-custom">
                        <thead>
                            <tr>
                                <th>Schedule</th>
                                <th>Treatment</th>
                                <th>Specialist</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(mysqli_num_rows($res) > 0): ?>
                                <?php while($row = mysqli_fetch_assoc($res)): ?>
                                <tr>
                                    <td data-label="Schedule">
                                        <div style="font-weight: 600; color: #fff;">
                                            <?php echo date('D, M d, Y', strtotime($row['apt_date'])); ?>
                                        </div>
                                        <small class="text-muted"><?php echo date('h:i A', strtotime($row['apt_time'])); ?></small>
                                    </td>
                                    <td data-label="Treatment">
                                        <?php echo $row['service_name']; ?>
                                    </td>
                                    <td data-label="Specialist">
                                        <?php echo $row['stylist_name'] ? $row['stylist_name'] : '<span class="text-muted">Any Specialist</span>'; ?>
                                    </td>
                                    <td data-label="Status">
                                        <span class="status-badge status-<?php echo $row['status']; ?>">
                                            <?php echo $row['status']; ?>
                                        </span>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center py-5">
                                        <p class="text-muted">You haven't booked any appointments yet.</p>
                                        <a href="booking.php" class="btn-gold-sm">Book Now</a>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="col-12 col-md-4 ps-md-5 info-col divider-col">
    <h2 class="col-heading">Dashboard <em>Info</em></h2>
    
    <div class="info-block mt-4">
        <div class="info-block-title">Next Visit</div>
        <p class="small">Ready for another session? Secure your slot today to avoid the weekend rush.</p>
        <a href="booking.php" class="btn-gold-sm">New Reservation</a>
    </div>

    <div class="info-block">
        <div class="info-block-title">Status Guide</div>
        <p><i class="fa-solid fa-clock info-icon" style="color:#ffc107;"></i> <strong>Pending:</strong> Staff is reviewing your request.</p>
        <p><i class="fa-solid fa-check-circle info-icon" style="color:#28a745;"></i> <strong>Confirmed:</strong> Your slot is locked in!</p>
    </div>

    <div class="info-block">
        <div class="info-block-title">Profile</div>
        <p>User: <strong><?php echo $_SESSION['user_name']; ?></strong></p>
        <a href="logout.php" style="color:var(--primary-gold); font-size:12px; text-transform:uppercase; letter-spacing:1px; text-decoration:none;">
            <i class="fa-solid fa-arrow-right-from-bracket"></i> Logout
        </a>
    </div>
</div>
        </div>
    </div>
</section>

<?php include('includes/footer.php'); ?>

<script src="assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>