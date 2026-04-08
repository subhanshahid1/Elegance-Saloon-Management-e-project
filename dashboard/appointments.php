<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';

// Only Admin and Receptionist can manage all appointments
checkAccess(['admin', 'receptionist']);

// 1. Fetch Stats for the Top Row
$totalApts = $conn->query("SELECT COUNT(*) as total FROM appointments")->fetch_assoc()['total'] ?? 0;
$pendingApts = $conn->query("SELECT COUNT(*) as total FROM appointments WHERE status = 'pending'")->fetch_assoc()['total'] ?? 0;
$confirmedApts = $conn->query("SELECT COUNT(*) as total FROM appointments WHERE status = 'confirmed'")->fetch_assoc()['total'] ?? 0;

// 2. Fetch Appointments with Joins
$query = "SELECT a.*, c.name as client_name, s.name as service_name, u.name as stylist_name 
          FROM appointments a 
          JOIN users c ON a.client_id = c.id 
          JOIN services s ON a.service_id = s.id 
          LEFT JOIN users u ON a.stylist_id = u.id 
          ORDER BY a.apt_date DESC, a.apt_time DESC";
$result = $conn->query($query);

// 3. Fetch Stylists for the Assignment Dropdown
$stylists = $conn->query("SELECT id, name FROM users WHERE role = 'stylist' AND status = 'active'");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Appointment Manager | Elegance Salon</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
</head>
<body>
    <?php include('../includes/sidebar.php'); ?>

    <div class="main-area">
        <?php include('../includes/topbar.php'); ?>

        <div class="content-area container-fluid">
            <div class="row align-items-center mb-4">
                <div class="col-12 d-md-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="panel-title fs-3">Appointments</h2>
                        <p class="panel-subtitle">Manage bookings and stylist assignments</p>
                    </div>
                </div>
            </div>

            <div class="row mb-4 g-3">
                <div class="col-12 col-sm-4">
                    <div class="stat-card gold">
                        <div class="stat-icon gold"><i class="bi bi-calendar-event"></i></div>
                        <div class="stat-label">Total Bookings</div>
                        <div class="stat-value"><?php echo $totalApts; ?></div>
                    </div>
                </div>
                <div class="col-12 col-sm-4">
                    <div class="stat-card rose">
                        <div class="stat-icon rose"><i class="bi bi-clock-history"></i></div>
                        <div class="stat-label">Pending Review</div>
                        <div class="stat-value"><?php echo $pendingApts; ?></div>
                    </div>
                </div>
                <div class="col-12 col-sm-4">
                    <div class="stat-card green">
                        <div class="stat-icon green"><i class="bi bi-check2-circle"></i></div>
                        <div class="stat-label">Confirmed</div>
                        <div class="stat-value"><?php echo $confirmedApts; ?></div>
                    </div>
                </div>
            </div>

            <div class="panel">
                <div class="table-responsive">
                    <table class="table custom-table mb-0">
                        <thead>
                            <tr>
                                <th>Client</th>
                                <th>Service</th>
                                <th>Schedule</th>
                                <th>Stylist</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><div class="fw-bold"><?php echo htmlspecialchars($row['client_name']); ?></div></td>
                                <td><span class="badge-gold"><?php echo htmlspecialchars($row['service_name']); ?></span></td>
                                <td>
                                    <div class="small fw-bold"><?php echo date('D, M d', strtotime($row['apt_date'])); ?></div>
                                    <div class="small text-muted"><?php echo date('h:i A', strtotime($row['apt_time'])); ?></div>
                                </td>
                                <td>
                                    <span class="text-charcoal"><?php echo $row['stylist_name'] ?: '<em class="text-muted">Unassigned</em>'; ?></span>
                                </td>
                                <td>
                                    <span class="badge-<?php echo ($row['status'] == 'confirmed') ? 'confirmed' : (($row['status'] == 'pending') ? 'pending' : 'cancelled'); ?>">
                                        <?php echo strtoupper($row['status']); ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <button class="btn btn-sm btn-outline" onclick='openEdit(<?php echo json_encode($row); ?>)'>
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-overlay" id="editAptModal">
        <div class="modal-box">
            <div class="panel-header">
                <div class="panel-title">Manage Appointment</div>
                <button class="border-0 bg-transparent" onclick="closeModal()"><i class="bi bi-x-lg"></i></button>
            </div>
            <form action="appointment_proc.php" method="POST">
                <input type="hidden" name="apt_id" id="field_apt_id">
                <div class="panel-body">
                    <div class="mb-3">
                        <label class="form-label-sm">Assign Stylist</label>
                        <select name="stylist_id" id="field_stylist_id" class="form-input">
                            <option value="">-- Select Specialist --</option>
                            <?php 
                            $stylists->data_seek(0);
                            while($s = $stylists->fetch_assoc()): ?>
                                <option value="<?php echo $s['id']; ?>"><?php echo $s['name']; ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label-sm">Update Status</label>
                        <select name="status" id="field_status" class="form-input">
                            <option value="pending">Pending</option>
                            <option value="confirmed">Confirmed</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label-sm">Admin Notes</label>
                        <textarea name="notes" id="field_notes" class="form-input" rows="3"></textarea>
                    </div>
                </div>
                <div class="panel-footer p-3 text-end border-top">
                    <button type="submit" name="btn_update_apt" class="btn-gold px-4">Update Appointment</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openEdit(data) {
            document.getElementById('field_apt_id').value = data.id;
            document.getElementById('field_stylist_id').value = data.stylist_id || '';
            document.getElementById('field_status').value = data.status;
            document.getElementById('field_notes').value = data.notes || '';
            openModal('editAptModal');
        }
    </script>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/dashboard.js"></script>
</body>
</html>