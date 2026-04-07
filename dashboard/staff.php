<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';

checkAccess(['admin', 'receptionist']);

$countResult = $conn->query("SELECT COUNT(*) as total FROM users WHERE role IN ('admin', 'receptionist', 'stylist')");
$totalStaff = $countResult->fetch_assoc()['total'];

$query = "SELECT * FROM users WHERE role IN ('admin', 'receptionist', 'stylist') ORDER BY role, name ASC";
$result = $conn->query($query);
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
</head>
<body>
    <?php include('../includes/sidebar.php'); ?>

    <div class="main-area">
        <?php include('../includes/topbar.php'); ?>

        <div class="content-area">
            <?php if(isset($_GET['msg'])): ?>
                <?php if($_GET['msg'] == 'email_exists'): ?>
                    <div class="alert alert-danger d-flex align-items-center"><i class="bi bi-exclamation-triangle-fill me-2"></i> Error: This email is already registered.</div>
                <?php elseif($_GET['msg'] == 'added'): ?>
                    <div class="alert alert-success">Staff member added successfully!</div>
                <?php elseif($_GET['msg'] == 'updated'): ?>
                    <div class="alert alert-info">Staff details updated successfully!</div>
                <?php elseif($_GET['msg'] == 'deleted'): ?>
                    <div class="alert alert-warning">Staff record removed.</div>
                <?php endif; ?>
            <?php endif; ?>

            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="panel p-3 d-flex align-items-center gap-3" style="border-left: 4px solid var(--gold);">
                        <div class="fs-1 text-gold"><i class="bi bi-person-workspace"></i></div>
                        <div>
                            <h4 class="m-0 fw-bold"><?php echo $totalStaff; ?></h4>
                            <small class="text-muted text-uppercase">Team Members</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row align-items-center mb-4">
                <div class="col-12 d-md-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="panel-title fs-3">Staff Directory</h2>
                        <p class="panel-subtitle">Manage shifts, roles, and commission rates</p>
                    </div>
                    <button class="btn-gold mt-3 mt-md-0" onclick="openModal('addStaffModal')">
                        <i class="bi bi-person-plus-fill"></i> Add Staff Member
                    </button>
                </div>
            </div>

            <div class="panel">
                <div class="table-responsive">
                    <table class="table custom-table">
                        <thead>
                            <tr>
                                <th>Name & Role</th>
                                <th>Contact info</th>
                                <th>Commission (%)</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($row = $result->fetch_assoc()): 
                                $staffData = htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8');
                            ?>
                            <tr>
                                <td>
                                    <div class="fw-bold"><?php echo htmlspecialchars($row['name']); ?></div>
                                    <span class="badge bg-light text-dark border small text-uppercase"><?php echo $row['role']; ?></span>
                                </td>
                                <td>
                                    <small class="d-block"><i class="bi bi-envelope"></i> <?php echo htmlspecialchars($row['email']); ?></small>
                                    <small class="d-block"><i class="bi bi-telephone"></i> <?php echo htmlspecialchars($row['phone'] ?? 'N/A'); ?></small>
                                </td>
                                <td class="fw-bold">
                                    <?php echo (isset($row['commission_rate']) && $row['commission_rate'] > 0) ? $row['commission_rate'].'%' : '0%'; ?>
                                </td>
                                <td>
                                    <span class="badge <?php echo ($row['status'] == 'active') ? 'bg-success' : 'bg-danger'; ?>">
                                        <?php echo strtoupper($row['status']); ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <button class="btn btn-sm btn-outline-secondary edit-staff-btn" data-item='<?php echo $staffData; ?>'><i class="bi bi-pencil"></i></button>
                                        <a href="staff_proc.php?delete_id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Remove staff member?')"><i class="bi bi-trash"></i></a>
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

    <div class="modal-overlay" id="addStaffModal">
        <div class="modal-box" style="max-width: 600px;">
            <div class="panel-header">
                <div class="panel-title">Register New Staff</div>
                <button class="border-0 bg-transparent" onclick="closeModal()"><i class="bi bi-x-lg"></i></button>
            </div>
            <form action="staff_proc.php" method="POST">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-6 mb-3"><label class="form-label small fw-bold">Full Name</label><input type="text" name="name" class="form-input" required></div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold">Role</label>
                            <select name="role" class="form-input" required>
                                <option value="stylist">Stylist</option>
                                <option value="receptionist">Receptionist</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3"><label class="form-label small fw-bold">Email Address</label><input type="email" name="email" class="form-input" required></div>
                        <div class="col-md-6 mb-3"><label class="form-label small fw-bold">Phone Number</label><input type="text" name="phone" class="form-input"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3"><label class="form-label small fw-bold">Commission Rate (%)</label><input type="number" step="0.01" name="commission_rate" class="form-input" value="0.00"></div>
                        <div class="col-md-6 mb-3"><label class="form-label small fw-bold">Password</label><input type="password" name="password" class="form-input" required></div>
                    </div>
                    <div class="mb-3"><label class="form-label small fw-bold">Work Schedule</label><textarea name="work_schedule" class="form-input" rows="2" placeholder="e.g. Mon-Fri, 9AM-6PM"></textarea></div>
                </div>
                <div class="panel-header border-top justify-content-end gap-2">
                    <button type="button" class="btn-outline" onclick="closeModal()">Cancel</button>
                    <button type="submit" name="add_staff" class="btn-gold">Add Staff</button>
                </div>
            </form>
        </div>
    </div>

    <div class="modal-overlay" id="editStaffModal">
        <div class="modal-box" style="max-width: 600px;">
            <div class="panel-header">
                <div class="panel-title">Edit Staff Member</div>
                <button class="border-0 bg-transparent" onclick="closeModal()"><i class="bi bi-x-lg"></i></button>
            </div>
            <form action="staff_proc.php" method="POST">
                <input type="hidden" name="staff_id" id="edit_staff_id">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-6 mb-3"><label class="form-label small fw-bold">Full Name</label><input type="text" name="name" id="edit_staff_name" class="form-input" required></div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold">Status</label>
                            <select name="status" id="edit_staff_status" class="form-input">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3"><label class="form-label small fw-bold">Email</label><input type="email" name="email" id="edit_staff_email" class="form-input" required></div>
                        <div class="col-md-6 mb-3"><label class="form-label small fw-bold">Phone</label><input type="text" name="phone" id="edit_staff_phone" class="form-input"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3"><label class="form-label small fw-bold">Commission Rate (%)</label><input type="number" step="0.01" name="commission_rate" id="edit_staff_commission" class="form-input"></div>
                        <div class="col-md-6 mb-3"><label class="form-label small fw-bold">New Password (Optional)</label><input type="password" name="password" class="form-input" placeholder="Leave blank to keep current"></div>
                    </div>
                    <div class="mb-3"><label class="form-label small fw-bold">Work Schedule</label><textarea name="work_schedule" id="edit_staff_schedule" class="form-input" rows="2"></textarea></div>
                </div>
                <div class="panel-header border-top justify-content-end gap-2">
                    <button type="button" class="btn-outline" onclick="closeModal()">Cancel</button>
                    <button type="submit" name="update_staff" class="btn-gold">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.edit-staff-btn').forEach(btn => {
            btn.onclick = function() {
                const staff = JSON.parse(this.getAttribute('data-item'));
                document.getElementById('edit_staff_id').value = staff.id;
                document.getElementById('edit_staff_name').value = staff.name;
                document.getElementById('edit_staff_email').value = staff.email;
                document.getElementById('edit_staff_phone').value = staff.phone || '';
                document.getElementById('edit_staff_status').value = staff.status;
                document.getElementById('edit_staff_commission').value = staff.commission_rate;
                document.getElementById('edit_staff_schedule').value = staff.work_schedule || '';
                openModal('editStaffModal');
            };
        });
    });
    function openModal(id) { document.getElementById(id).style.display = 'flex'; }
    function closeModal() { document.querySelectorAll('.modal-overlay').forEach(m => m.style.display = 'none'); }
    </script>
</body>
</html>