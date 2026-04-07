<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';

checkAccess(['admin', 'receptionist']);

// 1. Fetch Stats
$totalClients = $conn->query("SELECT COUNT(*) as total FROM users WHERE role = 'client'")->fetch_assoc()['total'] ?? 0;
$newClients = $conn->query("SELECT COUNT(*) as total FROM users WHERE role = 'client' AND month(created_at) = month(now())")->fetch_assoc()['total'] ?? 0;

// 2. Fetch Clients with Stylist Names and Last Visit Date
$sql = "SELECT c.*, s.name as stylist_name, 
        (SELECT MAX(apt_date) FROM appointments WHERE client_id = c.id) as last_visit
        FROM users c 
        LEFT JOIN users s ON c.preferred_stylist_id = s.id 
        WHERE c.role = 'client' 
        ORDER BY c.name ASC";
$result = $conn->query($sql);

// 3. Fetch Stylists for Dropdowns
$stylists = $conn->query("SELECT id, name FROM users WHERE role = 'stylist' AND status = 'active'");
$stylist_options = "";
while($s = $stylists->fetch_assoc()) {
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
            display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.6); z-index: 1050; justify-content: center; align-items: center; padding: 15px;
        }
        .modal-box { background: white; width: 100%; max-width: 600px; border-radius: 8px; overflow: hidden; }
        .search-container { position: relative; max-width: 400px; }
        .search-container i { position: absolute; left: 10px; top: 10px; color: #aaa; }
        .search-container input { padding-left: 35px; }
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
                        <h2 class="panel-title fs-3">Client Management</h2>
                        <p class="panel-subtitle">History, preferences, and contact records</p>
                    </div>
                    <button class="btn-gold" onclick="openModal('addClientModal')">
                        <i class="bi bi-person-plus"></i> Add New Client
                    </button>
                </div>
            </div>

            <div class="row mb-4 g-3">
                <div class="col-md-4">
                    <div class="panel p-3 d-flex align-items-center gap-3" style="border-left: 4px solid var(--gold);">
                        <div class="fs-2 text-gold"><i class="bi bi-people"></i></div>
                        <div>
                            <h4 class="m-0 fw-bold"><?php echo $totalClients; ?></h4>
                            <small class="text-muted text-uppercase fw-bold">Total Database</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="panel p-3 d-flex align-items-center gap-3" style="border-left: 4px solid #198754;">
                        <div class="fs-2 text-success"><i class="bi bi-graph-up-arrow"></i></div>
                        <div>
                            <h4 class="m-0 fw-bold"><?php echo $newClients; ?></h4>
                            <small class="text-muted text-uppercase fw-bold">New This Month</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel p-3">
                <div class="search-container mb-3">
                    <i class="bi bi-search"></i>
                    <input type="text" id="clientSearch" class="form-control" placeholder="Search by name, email or phone...">
                </div>
                
                <div class="table-responsive">
                    <table class="table custom-table" id="clientTable">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Contact</th>
                                <th>Last Visit</th>
                                <th class="d-none d-lg-table-cell">Preference</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($row = $result->fetch_assoc()): 
                                $clientData = htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8');
                            ?>
                            <tr>
                                <td><div class="fw-bold"><?php echo htmlspecialchars($row['name']); ?></div></td>
                                <td>
                                    <small><?php echo htmlspecialchars($row['phone']); ?></small><br>
                                    <small class="text-muted"><?php echo htmlspecialchars($row['email']); ?></small>
                                </td>
                                <td><?php echo $row['last_visit'] ? date('d M, Y', strtotime($row['last_visit'])) : '<span class="text-muted">No visits</span>'; ?></td>
                                <td class="d-none d-lg-table-cell">
                                    <span class="badge bg-light text-dark border"><?php echo htmlspecialchars($row['stylist_name'] ?: 'No Preference'); ?></span>
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <button class="btn btn-sm btn-outline-primary" title="History" onclick='viewHistory(<?php echo $row['id']; ?>, "<?php echo addslashes($row['name']); ?>")'>
                                            <i class="bi bi-clock-history"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-secondary" onclick='fillEdit(<?php echo $clientData; ?>)'>
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <a href="client_proc.php?del_id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete client?')">
                                            <i class="bi bi-trash"></i>
                                        </a>
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
        <div class="modal-box p-0">
            <div class="p-3 border-bottom d-flex justify-content-between align-items-center">
                <h5 class="m-0 fw-bold">Visit History: <span id="histName" class="text-gold"></span></h5>
                <button class="btn-close" onclick="closeModal()"></button>
            </div>
            <div id="historyContent" class="p-3" style="max-height: 400px; overflow-y: auto;">
                </div>
        </div>
    </div>

    <div class="modal-overlay" id="clientModal">
        <div class="modal-box">
            <div class="p-3 border-bottom d-flex justify-content-between">
                <h5 class="m-0 fw-bold" id="modalTitle">Add Client</h5>
                <button class="btn-close" onclick="closeModal()"></button>
            </div>
            <form action="client_proc.php" method="POST">
                <input type="hidden" name="c_id" id="f_id">
                <div class="p-3">
                    <div class="row g-3">
                        <div class="col-md-6"><label class="small fw-bold">NAME</label><input type="text" name="c_name" id="f_name" class="form-control" required></div>
                        <div class="col-md-6"><label class="small fw-bold">PHONE</label><input type="text" name="c_phone" id="f_phone" class="form-control" required></div>
                        <div class="col-12"><label class="small fw-bold">EMAIL</label><input type="email" name="c_email" id="f_email" class="form-control"></div>
                        <div class="col-md-6"><label class="small fw-bold">BIRTHDAY</label><input type="date" name="c_dob" id="f_dob" class="form-control"></div>
                        <div class="col-md-6"><label class="small fw-bold">PREF. STYLIST</label>
                            <select name="c_stylist" id="f_stylist" class="form-select">
                                <option value="">None</option><?php echo $stylist_options; ?>
                            </select>
                        </div>
                        <div class="col-12"><label class="small fw-bold">PREFERENCES / NOTES</label><textarea name="c_prefs" id="f_prefs" class="form-control" rows="2"></textarea></div>
                    </div>
                </div>
                <div class="p-3 bg-light border-top text-end">
                    <button type="submit" name="save_client" class="btn-gold px-4">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openModal(id) { document.getElementById(id).style.display = 'flex'; }
        function closeModal() { document.querySelectorAll('.modal-overlay').forEach(m => m.style.display = 'none'); }
        
        // Search Logic
        document.getElementById('clientSearch').addEventListener('keyup', function() {
            let filter = this.value.toLowerCase();
            let rows = document.querySelectorAll('#clientTable tbody tr');
            rows.forEach(row => {
                row.style.display = row.innerText.toLowerCase().includes(filter) ? '' : 'none';
            });
        });

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
            document.getElementById('historyContent').innerHTML = "Loading history...";
            openModal('historyModal');
            fetch(`get_client_history.php?id=${id}`)
                .then(r => r.text())
                .then(html => document.getElementById('historyContent').innerHTML = html);
        }
    </script>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/dashboard.js"></script>
</body>
</html>