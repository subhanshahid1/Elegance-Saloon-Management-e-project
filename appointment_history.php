<?php 
require_once 'includes/db.php'; 
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit(); }

$client_id = $_SESSION['user_id'];

// Handling Cancellation request
if(isset($_GET['cancel_id'])) {
    $c_id = intval($_GET['cancel_id']);
    $conn->query("UPDATE appointments SET status = 'cancelled' WHERE id = $c_id AND client_id = $client_id");
    header("Location: appointment_history.php?msg=cancelled");
    exit();
}

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
        /* Keeping your original styles exactly */
        html, body { max-width: 100%; overflow-x: hidden; }
        .page-hero { background: linear-gradient(rgba(0,0,0,0.65), rgba(0,0,0,0.65)), url('https://images.unsplash.com/photo-1560066984-138dadb4c035?q=80&w=1600') center/cover no-repeat; padding: 90px 0 70px; text-align: center; }
        .page-hero h1 { font-family: var(--font-primary); font-size: clamp(2.2rem, 6vw, 3.8rem); color: var(--primary-gold); text-transform: uppercase; letter-spacing: 6px; }
        .history-section { padding: 80px 0; background: var(--bg-black); min-height: 80vh; }
        .table-custom { color: #fff; width: 100%; font-size: 14px; border-collapse: separate; border-spacing: 0 10px; }
        .table-custom td { padding: 20px 15px; background: var(--bg-card); border-top: 1px solid #333; border-bottom: 1px solid #333; vertical-align: middle; }
        .status-badge { font-size: 10px; text-transform: uppercase; padding: 4px 10px; border-radius: 3px; border: 1px solid; font-weight: bold; }
        .status-pending { color: #ffc107; border-color: #ffc107; }
        .status-confirmed { color: #28a745; border-color: #28a745; }
        .status-cancelled { color: #dc3545; border-color: #dc3545; }
        .btn-gold-sm { background: var(--primary-gold); color: #000; font-size: 11px; font-weight: bold; text-transform: uppercase; padding: 10px 20px; text-decoration: none; border-radius: 4px; display: inline-block; transition: 0.3s; }
        .btn-gold-sm:hover { background: #fff; transform: translateY(-2px); }
        .text-cancel { color: #dc3545; font-size: 11px; text-transform: uppercase; text-decoration: none; font-weight: bold; }
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
                <?php if(isset($_GET['msg'])) echo "<p class='text-success small'>Action processed successfully.</p>"; ?>
                
                <div class="table-responsive-custom">
                    <table class="table-custom">
                        <thead>
                            <tr style="color:var(--primary-gold); font-size:11px; text-transform:uppercase;">
                                <th class="pb-3">Schedule</th>
                                <th class="pb-3">Treatment</th>
                                <th class="pb-3">Status</th>
                                <th class="pb-3 text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(mysqli_num_rows($res) > 0): ?>
                                <?php while($row = mysqli_fetch_assoc($res)): ?>
                                <tr>
                                    <td>
                                        <div style="font-weight: 600; color: #fff;"><?php echo date('D, M d', strtotime($row['apt_date'])); ?></div>
                                        <small class=""><?php echo date('h:i A', strtotime($row['apt_time'])); ?></small>
                                    </td>
                                    <td><?php echo $row['service_name']; ?></td>
                                    <td>
                                        <span class="status-badge status-<?php echo $row['status']; ?>"><?php echo $row['status']; ?></span>
                                    </td>
                                    <td class="text-end">
                                        <?php if($row['status'] != 'cancelled'): ?>
                                            <a href="reschedule.php?id=<?php echo $row['id']; ?>" class="btn-gold-sm me-2">Reschedule</a>
                                            <a href="appointment_history.php?cancel_id=<?php echo $row['id']; ?>" class="text-cancel" onclick="return confirm('Cancel this appointment?')">Cancel</a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr><td colspan="4" class="text-center py-5 text-muted">No appointments found.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="col-12 col-md-4 ps-md-5 info-col divider-col">
                <h2 class="col-heading">Dashboard <em>Info</em></h2>
                <div class="info-block mt-4">
                    <div class="info-block-title">Status Guide</div>
                    <p><i class="fa-solid fa-clock info-icon" style="color:#ffc107;"></i> <strong>Pending:</strong> Staff is reviewing your request.</p>
                    <p><i class="fa-solid fa-check-circle info-icon" style="color:#28a745;"></i> <strong>Confirmed:</strong> Your slot is locked in!</p>
                </div>
                <div class="info-block">
                    <div class="info-block-title">Profile</div>
                    <p>User: <strong><?php echo $_SESSION['user_name']; ?></strong></p>
                    <a href="logout.php" style="color:var(--primary-gold); font-size:12px; text-decoration:none;">LOGOUT</a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include('includes/footer.php'); ?>
</body>
</html>