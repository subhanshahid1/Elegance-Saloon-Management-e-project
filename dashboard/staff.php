<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';

checkAccess(['admin', 'receptionist', 'stylist']);

$current_user_id = getUserId();
$current_role = getUserRole();

if ($current_role === 'stylist') {
    $query = "SELECT * FROM users WHERE id = $current_user_id";
} else {
    $query = "SELECT * FROM users WHERE role IN ('admin', 'receptionist', 'stylist') ORDER BY role, name ASC";
}
$result = $conn->query($query);

$countRes = $conn->query("SELECT COUNT(*) as total FROM users WHERE role IN ('admin', 'receptionist', 'stylist')");
$totalStaff = $countRes->fetch_assoc()['total'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Management | Elegance Salon</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <style>
        .comm-card { background: #fcf9f0; border: 1px solid #e9dfc4; border-radius: 10px; }
        .schedule-box { font-size: 0.85rem; color: #555; background: #f8f9fa; padding: 10px; border-radius: 5px; }
        input[readonly], textarea[readonly] { background-color: #e9ecef !important; cursor: not-allowed; }
    </style>
</head>
<body>
    <?php include('../includes/sidebar.php'); ?>

    <div class="main-area">
        <?php include('../includes/topbar.php'); ?>

        <div class="content-area container-fluid px-4 py-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold m-0">Staff Management</h2>
                    <p class="text-muted">Role: <span class="text-gold fw-bold text-uppercase"><?php echo $current_role; ?></span></p>
                </div>
                <?php if($current_role === 'admin'): ?>
                    <button class="btn-gold" onclick="openModal('addStaffModal')">
                        <i class="bi bi-person-plus-fill me-2"></i>Register New Staff
                    </button>
                <?php endif; ?>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <div class="panel p-3 d-flex align-items-center gap-3" style="border-left: 4px solid var(--gold);">
                        <div class="fs-1 text-gold"><i class="bi bi-people"></i></div>
                        <div>
                            <h4 class="m-0 fw-bold"><?php echo ($current_role === 'stylist') ? '1' : $totalStaff; ?></h4>
                            <small class="text-muted">Profiles Visible</small>
                        </div>
                    </div>
                </div>
                
                <?php if($current_role === 'stylist' || $current_role === 'admin'): ?>
                <div class="col-md-8">
                    <div class="panel p-3 comm-card">
                        <h6 class="fw-bold mb-2"><i class="bi bi-graph-up-arrow me-2"></i>Commission Overview</h6>
                        <div class="small text-muted">
                            <?php echo ($current_role === 'stylist') ? "Your earning rate is set by Admin." : "Admins can modify percentage rates for all stylists."; ?>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>

            <div class="panel p-4">
                <div class="table-responsive">
                    <table class="table custom-table align-middle">
                        <thead>
                            <tr class="text-muted small">
                                <th>MEMBER</th>
                                <th>CONTACT</th>
                                <th>WORK SCHEDULE</th>
                                <th>COMMISSION (%)</th>
                                <?php if($current_role !== 'stylist'): ?><th>ACTIONS</th><?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td>
                                    <div class="fw-bold"><?php echo htmlspecialchars($row['name']); ?></div>
                                    <span class="badge bg-light text-dark border small text-uppercase"><?php echo $row['role']; ?></span>
                                </td>
                                <td>
                                    <div class="small"><i class="bi bi-envelope me-1"></i><?php echo $row['email']; ?></div>
                                    <div class="small"><i class="bi bi-telephone me-1"></i><?php echo $row['phone'] ?? 'N/A'; ?></div>
                                </td>
                                <td>
                                    <div class="schedule-box">
                                        <i class="bi bi-calendar3 me-1"></i> <?php echo !empty($row['work_schedule']) ? htmlspecialchars($row['work_schedule']) : 'No schedule set'; ?>
                                    </div>
                                </td>
                                <td>
                                    <span class="fs-5 fw-bold text-gold"><?php echo number_format($row['commission_rate'], 1); ?>%</span>
                                </td>
                                <?php if($current_role !== 'stylist'): ?>
                                <td>
                                    <div class="d-flex gap-2">
                                        <button class="btn btn-sm btn-outline-dark" onclick='editStaff(<?php echo json_encode($row); ?>)'>
                                            <i class="bi bi-pencil-square"></i> <?php echo ($current_role === 'receptionist') ? 'Manage Shift' : 'Edit'; ?>
                                        </button>
                                        <?php if($current_role === 'admin'): ?>
                                            <a href="staff_proc.php?delete_id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Remove this staff member?')">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <?php endif; ?>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-overlay" id="editStaffModal">
        <div class="modal-box" style="max-width: 600px;">
            <div class="panel-header">
                <h5 class="m-0 fw-bold"><?php echo ($current_role === 'receptionist') ? 'Manage Work Schedule' : 'Update Staff Profile'; ?></h5>
                <button class="border-0 bg-transparent" onclick="closeModal()"><i class="bi bi-x-lg"></i></button>
            </div>
            <form action="staff_proc.php" method="POST">
                <input type="hidden" name="staff_id" id="edit_id">
                <div class="panel-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="small fw-bold mb-1">Full Name</label>
                            <input type="text" name="name" id="edit_name" class="form-input" required <?php echo ($current_role === 'receptionist') ? 'readonly' : ''; ?>>
                        </div>
                        <div class="col-md-6">
                            <label class="small fw-bold mb-1">Email</label>
                            <input type="email" name="email" id="edit_email" class="form-input" required <?php echo ($current_role === 'receptionist') ? 'readonly' : ''; ?>>
                        </div>
                        <div class="col-md-12">
                            <label class="small fw-bold mb-1">Work Schedule (Assign Shifts)</label>
                            <textarea name="work_schedule" id="edit_schedule" class="form-input" rows="2"></textarea>
                        </div>
                        <?php if($current_role === 'admin'): ?>
                        <div class="col-md-6">
                            <label class="small fw-bold mb-1">Commission Rate (%)</label>
                            <input type="number" step="0.01" name="commission_rate" id="edit_commission" class="form-input">
                        </div>
                        <div class="col-md-6">
                            <label class="small fw-bold mb-1">New Password (Optional)</label>
                            <input type="password" name="password" class="form-input">
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="panel-header border-top justify-content-end gap-2">
                    <button type="button" class="btn-outline" onclick="closeModal()">Cancel</button>
                    <button type="submit" name="update_staff" class="btn-gold">Update Details</button>
                </div>
            </form>
        </div>
    </div>

    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script>
        function openModal(id) { 
            const modal = document.getElementById(id);
            if(modal) modal.style.display = 'flex'; 
        }
        function closeModal() { 
            document.querySelectorAll('.modal-overlay').forEach(m => m.style.display = 'none'); 
        }
        function editStaff(data) {
            document.getElementById('edit_id').value = data.id;
            document.getElementById('edit_name').value = data.name;
            document.getElementById('edit_email').value = data.email;
            document.getElementById('edit_schedule').value = data.work_schedule || '';
            const commField = document.getElementById('edit_commission');
            if(commField) commField.value = data.commission_rate;
            openModal('editStaffModal');
        }
    </script>
    <script src="../assets/js/dashboard.js"></script>
</body>
</html>