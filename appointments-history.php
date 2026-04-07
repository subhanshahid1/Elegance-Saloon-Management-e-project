<?php 
require_once 'config/config.php'; 
session_start();

$client_id = $_SESSION['user_id'] ?? 2; // Example ID

// Fetching history with service and stylist names
$query = "SELECT a.*, s.name as service_name, u.name as stylist_name 
          FROM appointments a 
          JOIN services s ON a.service_id = s.id 
          LEFT JOIN users u ON a.stylist_id = u.id 
          WHERE a.client_id = '$client_id' 
          ORDER BY a.apt_date DESC";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Appointments | Elegance Saloon</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        body { background: var(--bg-black); color: white; }
        .history-table { background: var(--bg-card); border: 1px solid #222; border-radius: 8px; margin-top: 50px; }
        .table { color: var(--text-silver); margin-bottom: 0; }
        .table thead th { border-bottom: 1px solid #333; color: var(--primary-gold); text-transform: uppercase; font-size: 11px; letter-spacing: 1px; }
        .table td { border-top: 1px solid #222; padding: 15px; font-size: 13px; }
        .status-badge { padding: 4px 10px; border-radius: 4px; font-size: 10px; text-transform: uppercase; font-weight: bold; }
        .pending { background: #d4a01722; color: var(--primary-gold); }
        .confirmed { background: #28a74522; color: #28a745; }
        .cancelled { background: #dc354522; color: #dc3545; }
    </style>
</head>
<body>
<?php include('includes/header.php'); ?>

<section class="page-hero"><h1>Appointment <em>History</em></h1></section>

<div class="container my-5">
    <div class="history-table table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Date & Time</th>
                    <th>Service</th>
                    <th>Stylist</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo date('M d, Y', strtotime($row['apt_date'])); ?> @ <?php echo date('h:i A', strtotime($row['apt_time'])); ?></td>
                    <td><?php echo htmlspecialchars($row['service_name']); ?></td>
                    <td><?php echo $row['stylist_name'] ?? 'Any available'; ?></td>
                    <td><span class="status-badge <?php echo $row['status']; ?>"><?php echo $row['status']; ?></span></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include('includes/footer.php'); ?>
</body>
</html>