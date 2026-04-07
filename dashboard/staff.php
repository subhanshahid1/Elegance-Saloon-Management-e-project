<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';

// Security: Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$loggedInId = $_SESSION['user_id'];
$loggedInRole = getUserRole(); // Helper function from auth.php

// --- DATA FILTERING ---
if ($loggedInRole === 'admin') {
    // Admin sees all staff members
    $query = "SELECT * FROM users WHERE role IN ('stylist', 'receptionist') ORDER BY name ASC";
} else {
    // Staff ONLY see their own record
    $query = "SELECT * FROM users WHERE id = $loggedInId";
}

$result = $conn->query($query);

function getInitials($name) {
    $words = explode(" ", $name);
    $initials = "";
    foreach ($words as $w) { $initials .= (!empty($w)) ? $w[0] : ''; }
    return strtoupper(substr($initials, 0, 2));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo ($loggedInRole === 'admin') ? 'Staff Team' : 'My Profile'; ?> | Elegance</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <style>
        .staff-card { text-align: center; padding: 30px 20px; position: relative; border: 1px solid rgba(0,0,0,0.05); transition: 0.3s; }
        .staff-card:hover { border-color: var(--gold); }
        .staff-avatar-lg {
            width: 80px; height: 80px; border-radius: 50%; margin: 0 auto 15px;
            display: flex; align-items: center; justify-content: center;
            font-size: 28px; font-weight: 600; border: 3px solid #f8f9fa;
        }
        .status-badge { position: absolute; top: 15px; right: 15px; font-size: 10px; padding: 4px 8px; border-radius: 20px; font-weight: bold; }
    </style>
</head>
<body>
    <?php include('../includes/sidebar.php'); ?>

    <div class="main-area">
        <?php include('../includes/topbar.php'); ?>

        <div class="content-area">
            <div class="row g-3 align-items-center mb-4">
                <div class="col-md-6">
                    <h2 class="panel-title fs-3"><?php echo ($loggedInRole === 'admin') ? 'Staff Management' : 'My Professional Profile'; ?></h2>
                    <p class="panel-subtitle">Manage salon availability and performance</p>
                </div>
                
                <?php if ($loggedInRole === 'admin'): ?>
                <div class="col-md-6 text-md-end">
                    <button class="btn-gold" onclick="openModal('addStaffModal')">
                        <i class="bi bi-person-plus"></i> Add New Member
                    </button>
                </div>
                <?php endif; ?>
            </div>

            <div class="row g-4">
                <?php while($staff = $result->fetch_assoc()): 
                    $isOnDuty = ($staff['status'] === 'active');
                ?>
                <div class="col-12 col-md-6 col-xl-4">
                    <div class="panel staff-card">
                        <span class="status-badge <?php echo $isOnDuty ? 'badge-confirmed' : 'badge-cancelled'; ?>">
                            <?php echo $isOnDuty ? '● ON DUTY' : '○ OFF DUTY'; ?>
                        </span>

                        <div class="staff-avatar-lg" style="background: #fdf2f2; color: var(--gold-dark);">
                            <?php echo getInitials($staff['name']); ?>
                        </div>

                        <h3 class="staff-name fs-5 mb-1"><?php echo htmlspecialchars($staff['name']); ?></h3>
                        <span class="text-gold small text-uppercase fw-bold"><?php echo $staff['role']; ?></span>
                        
                        <div class="staff-stats d-flex justify-content-center gap-4 mt-3 border-top pt-3">
                            <div class="text-center"><span class="d-block fw-bold">0</span><small class="text-muted">Bookings</small></div>
                            <div class="text-center"><span class="d-block fw-bold">5.0</span><small class="text-muted">Rating</small></div>
                        </div>

                        <div class="mt-4">
                            <a href="staff_proc.php?toggle_id=<?php echo $staff['id']; ?>&status=<?php echo $staff['status']; ?>" 
                               class="btn <?php echo $isOnDuty ? 'btn-outline-secondary' : 'btn-gold'; ?> w-100 py-2">
                               Mark <?php echo $isOnDuty ? 'Off Duty' : 'On Duty'; ?>
                            </a>
                            
                            <?php if ($loggedInRole === 'admin' && $staff['id'] != $loggedInId): ?>
                                <a href="staff_proc.php?delete_id=<?php echo $staff['id']; ?>" 
                                   class="text-danger small d-block mt-3" onclick="return confirm('Remove this staff member permanently?')">
                                   <i class="bi bi-trash"></i> Remove Staff
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>

    <?php if ($loggedInRole === 'admin'): ?>
    <div class="modal-overlay" id="addStaffModal">
        <div class="modal-box">
            <div class="panel-header">
                <div class="panel-title">Create Staff Account</div>
                <button class="border-0 bg-transparent" onclick="closeModal()"><i class="bi bi-x-lg"></i></button>
            </div>
            <form action="staff_proc.php" method="POST">
                <div class="panel-body">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Full Name</label>
                        <input type="text" name="name" class="form-input" placeholder="e.g. Sara Khan" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Email Address</label>
                        <input type="email" name="email" class="form-input" required>
                    </div>
                    <div class="row g-2">
                        <div class="col-6 mb-3">
                            <label class="form-label small fw-bold">Role</label>
                            <select name="role" class="form-input">
                                <option value="stylist">Stylist</option>
                                <option value="receptionist">Receptionist</option>
                            </select>
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label small fw-bold">Temp Password</label>
                            <input type="password" name="password" class="form-input" required>
                        </div>
                    </div>
                </div>
                <div class="panel-header border-top justify-content-end gap-2">
                    <button type="button" class="btn-outline" onclick="closeModal()">Cancel</button>
                    <button type="submit" name="add_staff" class="btn-gold">Create Member</button>
                </div>
            </form>
        </div>
    </div>
    <?php endif; ?>

    <script src="../assets/js/dashboard.js"></script>
</body>
</html>