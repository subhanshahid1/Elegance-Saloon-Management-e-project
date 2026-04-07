<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';

checkAccess(['admin', 'receptionist']);

// 1. Fetch Total Count
$countQuery = "SELECT COUNT(*) as total FROM users WHERE role = 'client'";
$countResult = $conn->query($countQuery);
$totalClients = $countResult->fetch_assoc()['total'];

// 2. Fetch all clients
$query = "SELECT * FROM users WHERE role = 'client' ORDER BY name ASC";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clients | Elegance Salon</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
</head>
<body>
    <?php include('../includes/sidebar.php'); ?>

    <div class="main-area">
        <?php include('../includes/topbar.php'); ?>

        <div class="content-area">
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="panel p-3 d-flex align-items-center gap-3" style="border-left: 4px solid var(--gold);">
                        <div class="fs-1 text-gold"><i class="bi bi-people"></i></div>
                        <div>
                            <h4 class="m-0 fw-bold"><?php echo $totalClients; ?></h4>
                            <small class="text-muted text-uppercase">Total Clients</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row align-items-center mb-4">
                <div class="col-12 d-md-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="panel-title fs-3">Client Directory</h2>
                        <p class="panel-subtitle">Manage customer profiles and accounts</p>
                    </div>
                    <button class="btn-gold mt-3 mt-md-0" onclick="openModal('addClientModal')">
                        <i class="bi bi-person-plus"></i> Add New Client
                    </button>
                </div>
            </div>

            <div class="panel">
                <div class="table-responsive">
                    <table class="table custom-table">
                        <thead>
                            <tr>
                                <th>Client Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Joined Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($result->num_rows > 0): ?>
                                <?php while($row = $result->fetch_assoc()): 
                                    $clientData = htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8');
                                ?>
                                <tr>
                                    <td class="fw-bold"><?php echo htmlspecialchars($row['name']); ?></td>
                                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                                    <td><?php echo htmlspecialchars($row['phone'] ?? 'N/A'); ?></td>
                                    <td><?php echo date('M d, Y', strtotime($row['created_at'])); ?></td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <button class="btn btn-sm btn-outline-secondary edit-client-btn" 
                                                    data-item='<?php echo $clientData; ?>'>
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <a href="client_proc.php?delete_id=<?php echo $row['id']; ?>" 
                                               class="btn btn-sm btn-outline-danger" 
                                               onclick="return confirm('Remove this client?')">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr><td colspan="5" class="text-center py-4 text-muted">No clients registered yet.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-overlay" id="addClientModal">
        <div class="modal-box">
            <div class="panel-header">
                <div class="panel-title">New Client Registration</div>
                <button class="border-0 bg-transparent" onclick="closeModal()"><i class="bi bi-x-lg"></i></button>
            </div>
            <form action="client_proc.php" method="POST">
                <div class="panel-body">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Full Name</label>
                        <input type="text" name="name" class="form-input" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold">Email Address</label>
                            <input type="email" name="email" class="form-input" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold">Phone Number</label>
                            <input type="text" name="phone" class="form-input" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Login Password</label>
                        <input type="password" name="password" class="form-input" required>
                    </div>
                </div>
                <div class="panel-header border-top justify-content-end gap-2">
                    <button type="button" class="btn-outline" onclick="closeModal()">Cancel</button>
                    <button type="submit" name="add_client" class="btn-gold">Register Client</button>
                </div>
            </form>
        </div>
    </div>

    <div class="modal-overlay" id="editClientModal">
        <div class="modal-box">
            <div class="panel-header">
                <div class="panel-title">Edit Client Details</div>
                <button class="border-0 bg-transparent" onclick="closeModal()"><i class="bi bi-x-lg"></i></button>
            </div>
            <form action="client_proc.php" method="POST">
                <input type="hidden" name="client_id" id="edit_client_id">
                <div class="panel-body">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Full Name</label>
                        <input type="text" name="name" id="edit_client_name" class="form-input" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold">Email Address</label>
                            <input type="email" name="email" id="edit_client_email" class="form-input" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold">Phone Number</label>
                            <input type="text" name="phone" id="edit_client_phone" class="form-input" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">New Password (Leave blank to keep current)</label>
                        <input type="password" name="password" class="form-input" placeholder="Enter new password only if changing">
                    </div>
                </div>
                <div class="panel-header border-top justify-content-end gap-2">
                    <button type="button" class="btn-outline" onclick="closeModal()">Cancel</button>
                    <button type="submit" name="update_client" class="btn-gold">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <script src="../assets/js/dashboard.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const editButtons = document.querySelectorAll('.edit-client-btn');
        editButtons.forEach(btn => {
            btn.onclick = function() {
                const client = JSON.parse(this.getAttribute('data-item'));
                document.getElementById('edit_client_id').value = client.id;
                document.getElementById('edit_client_name').value = client.name;
                document.getElementById('edit_client_email').value = client.email;
                document.getElementById('edit_client_phone').value = client.phone || '';
                openModal('editClientModal');
            };
        });
    });

    function openModal(id) { document.getElementById(id).style.display = 'flex'; }
    function closeModal() { document.querySelectorAll('.modal-overlay').forEach(m => m.style.display = 'none'); }
    </script>
</body>
</html>