<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';

checkAccess(['admin', 'receptionist']);

$current_role = getUserRole();

// 1. Fetch Stats
$totalClients = $conn->query("SELECT COUNT(*) as total FROM users WHERE role = 'client'")->fetch_assoc()['total'] ?? 0;
$newClients = $conn->query("SELECT COUNT(*) as total FROM users WHERE role = 'client' AND month(created_at) = month(now()) AND year(created_at) = year(now())")->fetch_assoc()['total'] ?? 0;

// 2. Fetch Clients 
$sql = "SELECT c.*, s.name as stylist_name, 
        (SELECT MAX(apt_date) FROM appointments WHERE client_id = c.id AND status = 'completed') as last_visit
        FROM users c 
        LEFT JOIN users s ON c.preferred_stylist_id = s.id 
        WHERE c.role = 'client' 
        ORDER BY c.name ASC";
$result = $conn->query($sql);

// 3. Fetch Stylists
$stylist_options = "";
$stylists = $conn->query("SELECT id, name FROM users WHERE role = 'stylist' AND status = 'active'");
while ($s = $stylists->fetch_assoc()) {
    $stylist_options .= "<option value='{$s['id']}'>{$s['name']}</option>";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Management | Elegance Salon</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <style>
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            z-index: 1050;
            justify-content: center;
            align-items: center;
            padding: 15px;
        }

        .modal-box {
            background: white;
            width: 100%;
            max-width: 650px;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .search-container {
            position: relative;
            max-width: 400px;
        }

        .search-container i {
            position: absolute;
            left: 12px;
            top: 10px;
            color: #aaa;
        }

        .search-container input {
            padding-left: 38px;
            border-radius: 20px;
        }

        .bg-gold-light {
            background-color: #fcf9f0;
            border: 1px solid #e9dfc4;
            color: #b8860b;
        }
    </style>
</head>

<body>
    <?php include('../includes/sidebar.php'); ?>

    <div class="main-area">
        <?php include('../includes/topbar.php'); ?>

        <div class="content-area container-fluid px-4">
            <div class="row align-items-center mb-4">
                <div class="col-12 d-md-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="panel-title fs-3">Client Database</h2>
                        <p class="panel-subtitle">Manage preferences, history, and records</p>
                    </div>
                    <?php if ($current_role === 'admin'): ?>
                        <button class="btn-gold" onclick="openAddModal()">
                            <i class="bi bi-person-plus-fill"></i> Add New Client
                        </button>
                    <?php endif; ?>
                </div>
            </div>

            <div class="row mb-4 g-3">
                <div class="col-md-6 col-lg-4">
                    <div class="panel p-3 d-flex align-items-center gap-3" style="border-left: 4px solid var(--gold);">
                        <div class="fs-2 text-gold"><i class="bi bi-person-badge"></i></div>
                        <div>
                            <h4 class="m-0 fw-bold"><?php echo $totalClients; ?></h4>
                            <small class="text-muted text-uppercase fw-bold">Total Clients</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="panel p-3 d-flex align-items-center gap-3" style="border-left: 4px solid #198754;">
                        <div class="fs-2 text-success"><i class="bi bi-calendar-check"></i></div>
                        <div>
                            <h4 class="m-0 fw-bold"><?php echo $newClients; ?></h4>
                            <small class="text-muted text-uppercase fw-bold">New This Month</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel p-3">
                <div class="search-container mb-4">
                    <i class="bi bi-search"></i>
                    <input type="text" id="clientSearch" class="form-control" placeholder="Search by name, phone or preference...">
                </div>

                <div class="table-responsive">
                    <table class="table custom-table" id="clientTable">
                        <thead>
                            <tr class="text-muted small text-uppercase">
                                <th>Client Info</th>
                                <th>Contact Details</th>
                                <th>Preferred Stylist</th>
                                <th>Last Visit</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $result->fetch_assoc()):
                                $clientJson = htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8');
                            ?>
                                <tr>
                                    <td>
                                        <div class="fw-bold"><?php echo htmlspecialchars($row['name']); ?></div>
                                    </td>
                                    <td>
                                        <div class="small"><i class="bi bi-telephone me-1"></i><?php echo htmlspecialchars($row['phone']); ?></div>
                                        <div class="small text-muted"><i class="bi bi-envelope me-1"></i><?php echo htmlspecialchars($row['email']); ?></div>
                                    </td>
                                    <td>
                                        <?php if (!empty($row['stylist_name'])): ?>
                                            <span class="badge bg-gold-light"><?php echo htmlspecialchars($row['stylist_name']); ?></span>
                                        <?php else: ?>
                                            <span class="text-muted small">No Preference</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo $row['last_visit'] ? date('d M, Y', strtotime($row['last_visit'])) : '<span class="text-muted small">No history</span>'; ?></td>
                                    <td class="text-end">
                                        <div class="btn-group">
                                            <button class="btn btn-sm btn-outline-primary" title="View History" onclick='viewHistory(<?php echo $row['id']; ?>, "<?php echo addslashes($row['name']); ?>")'>
                                                <i class="bi bi-clock-history"></i>
                                            </button>
                                            <?php if ($current_role === 'admin'): ?>
                                                <button class="btn btn-sm btn-outline-dark" onclick='fillEdit(<?php echo $clientJson; ?>)'>
                                                    <i class="bi bi-pencil-square"></i>
                                                </button>
                                                <a href="client_proc.php?del_id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this client?')">
                                                    <i class="bi bi-trash"></i>
                                                </a>
                                            <?php endif; ?>
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

    <div class="modal-overlay" id="historyModal">
        <div class="modal-box">
            <div class="p-3 border-bottom d-flex justify-content-between align-items-center bg-light">
                <h5 class="m-0 fw-bold">Appointment History: <span id="histName" class="text-gold"></span></h5>
                <button class="btn-close" onclick="closeModal()"></button>
            </div>
            <div id="historyContent" class="p-4" style="max-height: 450px; overflow-y: auto;"></div>
        </div>
    </div>

    <div class="modal-overlay" id="clientModal">
        <div class="modal-box">
            <div class="p-3 border-bottom d-flex justify-content-between align-items-center">
                <h5 class="m-0 fw-bold" id="modalTitle">Manage Client Profile</h5>
                <button class="btn-close" onclick="closeModal()"></button>
            </div>
            <form action="client_proc.php" method="POST">
                <input type="hidden" name="c_id" id="f_id">
                <div class="p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="small fw-bold text-muted">FULL NAME</label>
                            <input type="text" name="c_name" id="f_name" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="small fw-bold text-muted">PHONE NUMBER</label>
                            <input type="text" name="c_phone" id="f_phone" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <label class="small fw-bold text-muted">EMAIL ADDRESS</label>
                            <input type="email" name="c_email" id="f_email" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="small fw-bold text-muted">PREFERRED STYLIST</label>
                            <select name="c_stylist" id="f_stylist" class="form-select">
                                <option value="">No preference</option>
                                <?php echo $stylist_options; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="small fw-bold text-muted">DATE OF BIRTH</label>
                            <input type="date" name="c_dob" id="f_dob" class="form-control">
                        </div>
                        <div class="col-12">
                            <label class="small fw-bold text-muted">PREFERENCES / NOTES</label>
                            <textarea name="c_prefs" id="f_prefs" class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                </div>
                <div class="p-3 bg-light border-top text-end">
                    <button type="submit" name="save_client" class="btn-gold px-4">Save Profile</button>
                </div>
            </form>
        </div>
    </div>

    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script>
        function openModal(id) {
            document.getElementById(id).style.display = 'flex';
        }

        function closeModal() {
            document.querySelectorAll('.modal-overlay').forEach(m => m.style.display = 'none');
        }

        function openAddModal() {
            document.getElementById('f_id').value = "0";
            document.getElementById('modalTitle').innerText = "Add New Client";
            document.querySelector('#clientModal form').reset();
            openModal('clientModal');
        }

        function fillEdit(data) {
            document.getElementById('modalTitle').innerText = "Edit Client Profile";
            document.getElementById('f_id').value = data.id;
            document.getElementById('f_name').value = data.name;
            document.getElementById('f_phone').value = data.phone;
            document.getElementById('f_email').value = data.email;
            document.getElementById('f_dob').value = data.dob || "";
            document.getElementById('f_stylist').value = data.preferred_stylist_id || "";
            document.getElementById('f_prefs').value = data.preferences || "";
            openModal('clientModal');
        }

        function viewHistory(id, name) {
            document.getElementById('histName').innerText = name;
            document.getElementById('historyContent').innerHTML = 'Loading...';
            openModal('historyModal');
            fetch(`get_client_history.php?id=${id}`)
                .then(r => r.text())
                .then(html => document.getElementById('historyContent').innerHTML = html);
        }

        document.getElementById('clientSearch').addEventListener('keyup', function() {
            let filter = this.value.toLowerCase();
            let rows = document.querySelectorAll('#clientTable tbody tr');
            rows.forEach(row => {
                row.style.display = row.innerText.toLowerCase().includes(filter) ? '' : 'none';
            });
        });
    </script>
    <script src="../assets/js/dashboard.js"></script>
</body>

</html>