<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';

// Updated to include 'stylist'
checkAccess(['admin', 'receptionist', 'stylist']); 

$user_id = $_SESSION['user_id'];
$user_role = getUserRole();

// Fetch Current User Data
$stmt = $conn->prepare("SELECT name, email, phone FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user_data = $stmt->get_result()->fetch_assoc();

// Fetch Salon Settings for Admin
$salon_settings = [];
if($user_role === 'admin') {
    $res = $conn->query("SELECT * FROM salon_settings");
    if($res) {
        while($row = $res->fetch_assoc()) {
            $salon_settings[$row['setting_key']] = $row['setting_value'];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings | Elegance Salon</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <style>
        .settings-nav .nav-link { color: #1a1a1a; padding: 12px; border-radius: 8px; margin-bottom: 5px; cursor: pointer; border: none; background: none; width: 100%; text-align: left; transition: 0.3s; }
        .settings-nav .nav-link.active { background: #c9a84c; color: white; }
        .settings-nav .nav-link:hover:not(.active) { background: #f8f9fa; }
        .tab-content { display: none; }
        .tab-content.active { display: block; animation: fadeIn 0.4s; }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    </style>
</head>
<body>
    <?php include('../includes/sidebar.php'); ?>
    <div class="main-area">
        <?php include('../includes/topbar.php'); ?>
        <div class="content-area container-fluid px-4 py-4">
            <div class="mb-4">
                <h2 class="fw-bold mb-0">Settings & Profile</h2>
                <p class="text-muted">Manage your account and salon configurations.</p>
                <?php if(isset($_GET['success'])): ?>
                    <div class="alert alert-success border-0 shadow-sm py-2 small"><i class="bi bi-check-circle me-2"></i><?php echo $_GET['success']; ?></div>
                <?php endif; ?>
                <?php if(isset($_GET['error'])): ?>
                    <div class="alert alert-danger border-0 shadow-sm py-2 small"><i class="bi bi-exclamation-triangle me-2"></i><?php echo $_GET['error']; ?></div>
                <?php endif; ?>
            </div>

            <div class="row g-4">
                <div class="col-12 col-lg-3">
                    <div class="panel p-3 bg-white shadow-sm border-0">
                        <nav class="settings-nav nav flex-column">
                            <button class="nav-link active" data-target="profile"><i class="bi bi-person me-2"></i> My Profile</button>
                            <button class="nav-link" data-target="security"><i class="bi bi-shield-lock me-2"></i> Security</button>
                            <?php if($user_role === 'admin'): ?>
                                <hr>
                                <button class="nav-link text-primary fw-bold" data-target="admin-panel"><i class="bi bi-gear-wide-connected me-2"></i> Salon Admin</button>
                                <button class="nav-link" data-target="notifications"><i class="bi bi-bell me-2"></i> Notification Rules</button>
                            <?php endif; ?>
                        </nav>
                    </div>
                </div>

                <div class="col-12 col-lg-9">
                    <div id="profile" class="tab-content active panel p-4 bg-white shadow-sm border-0">
                        <h5 class="fw-bold mb-4">Profile Information</h5>
                        <form action="settings_action.php" method="POST">
                            <input type="hidden" name="action" value="update_profile">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="small text-muted mb-1">Full Name</label>
                                    <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($user_data['name']); ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="small text-muted mb-1">Email Address</label>
                                    <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($user_data['email']); ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="small text-muted mb-1">Phone Number</label>
                                    <input type="text" name="phone" class="form-control" value="<?php echo htmlspecialchars($user_data['phone']); ?>">
                                </div>
                                <div class="col-12 mt-4">
                                    <button type="submit" class="btn btn-dark px-4">Save Changes</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div id="security" class="tab-content panel p-4 bg-white shadow-sm border-0">
                        <h5 class="fw-bold mb-4">Update Password</h5>
                        <form action="settings_action.php" method="POST">
                            <input type="hidden" name="action" value="update_password">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="small text-muted">New Password</label>
                                    <input type="password" name="new_pass" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="small text-muted">Confirm Password</label>
                                    <input type="password" name="confirm_pass" class="form-control" required>
                                </div>
                                <div class="col-12 mt-4">
                                    <button type="submit" class="btn btn-dark">Change Password</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <?php if($user_role === 'admin'): ?>
                    <div id="admin-panel" class="tab-content panel p-4 bg-white shadow-sm border-0">
                        <h5 class="fw-bold mb-4">Salon Branding & Contact</h5>
                        <form action="settings_action.php" method="POST">
                            <input type="hidden" name="action" value="update_salon">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="small text-muted">Salon Name</label>
                                    <input type="text" name="salon_name" class="form-control" value="<?php echo htmlspecialchars($salon_settings['salon_name'] ?? ''); ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="small text-muted">Contact Phone</label>
                                    <input type="text" name="contact_phone" class="form-control" value="<?php echo htmlspecialchars($salon_settings['contact_phone'] ?? ''); ?>">
                                </div>
                                <div class="col-md-12">
                                    <label class="small text-muted">Business Address</label>
                                    <input type="text" name="address" class="form-control" value="<?php echo htmlspecialchars($salon_settings['address'] ?? ''); ?>">
                                </div>
                                <div class="col-12 mt-4">
                                    <button type="submit" class="btn btn-gold text-white" style="background:#c9a84c;">Save Global Configuration</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelectorAll('.nav-link').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.nav-link').forEach(b => b.classList.remove('active'));
                document.querySelectorAll('.tab-content').forEach(t => t.classList.remove('active'));
                this.classList.add('active');
                document.getElementById(this.dataset.target).classList.add('active');
            });
        });
        if(document.getElementById('page-title')) document.getElementById('page-title').textContent = "Settings";
    </script>
</body>
</html>