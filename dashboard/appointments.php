<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';

// Access Control
checkAccess(['admin', 'receptionist', 'staff', 'stylist']);

$current_user_id = getUserId();
$current_role = getUserRole();

// 1. Fetch Stats (Dynamic based on Role)
$stats_query = "SELECT 
    COUNT(*) as total,
    SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending,
    SUM(CASE WHEN status = 'completed' THEN 1 ELSE 0 END) as completed
    FROM appointments";

if ($current_role === 'stylist') {
    $stats_query .= " WHERE stylist_id = $current_user_id";
}
$stats = $conn->query($stats_query)->fetch_assoc();

// 2. Fetch Appointments
$sql = "SELECT a.*, u.name as client_name, u.phone as client_phone, 
               s.name as service_name, st.name as stylist_name 
        FROM appointments a 
        JOIN users u ON a.client_id = u.id 
        JOIN services s ON a.service_id = s.id 
        LEFT JOIN users st ON a.stylist_id = st.id";

if ($current_role === 'stylist') {
    $sql .= " WHERE a.stylist_id = $current_user_id";
}
$sql .= " ORDER BY a.apt_date DESC, a.apt_time ASC";
$result = $conn->query($sql);

// 3. Fetch Stylists for Assignment
$stylist_list = $conn->query("SELECT id, name FROM users WHERE role = 'stylist'");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointments | <?php echo SITE_NAME; ?></title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <style>
        /* FIXED: Tab Active Colors */
        .tab-pill { 
            border: 1px solid rgba(0,0,0,0.1); 
            background: #fff; 
            padding: 8px 22px; 
            color: #666; 
            border-radius: 30px;
            transition: all 0.3s ease;
            margin-right: 8px;
            font-size: 13px;
            font-weight: 500;
        }
        .tab-pill.active { 
            background: var(--gold) !important; 
            color: #ffffff !important; 
            border-color: var(--gold) !important;
            box-shadow: 0 4px 12px rgba(201, 168, 76, 0.25);
        }
        
        /* Search Box styling */
        .search-container { position: relative; max-width: 400px; }
        .search-container i { position: absolute; left: 15px; top: 12px; color: #aaa; z-index: 5; }
        .search-container input { padding-left: 42px !important; border-radius: 10px; height: 42px; border: 1px solid rgba(0,0,0,0.1); }
        
        .badge-completed { background: rgba(25, 135, 84, 0.1); color: #198754; padding: 4px 12px; border-radius: 20px; font-size: 11px; }
        .badge-confirmed { background: rgba(13, 110, 253, 0.1); color: #0d6efd; padding: 4px 12px; border-radius: 20px; font-size: 11px; }
    </style>
</head>
<body>
    <?php include('../includes/sidebar.php'); ?>

    <div class="main-area">
        <?php include('../includes/topbar.php'); ?>

        <div class="content-area container-fluid px-4">
            <div class="mb-4">
                <h2 class="panel-title fs-3">Appointments</h2>
                <p class="panel-subtitle">View and manage salon bookings</p>
            </div>

            <div class="row mb-4 g-3">
                <div class="col-md-4">
                    <div class="panel p-3 d-flex align-items-center gap-3" style="border-left: 4px solid var(--gold);">
                        <div class="fs-2 text-gold"><i class="bi bi-journal-bookmark"></i></div>
                        <div>
                            <h4 class="m-0 fw-bold"><?php echo $stats['total'] ?? 0; ?></h4>
                            <small class="text-muted text-uppercase fw-bold">Total</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="panel p-3 d-flex align-items-center gap-3" style="border-left: 4px solid #ffc107;">
                        <div class="fs-2 text-warning"><i class="bi bi-hourglass-split"></i></div>
                        <div>
                            <h4 class="m-0 fw-bold"><?php echo $stats['pending'] ?? 0; ?></h4>
                            <small class="text-muted text-uppercase fw-bold">Pending</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="panel p-3 d-flex align-items-center gap-3" style="border-left: 4px solid #198754;">
                        <div class="fs-2 text-success"><i class="bi bi-check-circle"></i></div>
                        <div>
                            <h4 class="m-0 fw-bold"><?php echo $stats['completed'] ?? 0; ?></h4>
                            <small class="text-muted text-uppercase fw-bold">Done</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel p-4">
                <div class="row align-items-center mb-4">
                    <div class="col-md-7">
                        <div class="d-flex overflow-auto pb-2" id="statusFilters">
                            <button class="tab-pill active" onclick="filterByStatus('all', this)">All</button>
                            <button class="tab-pill" onclick="filterByStatus('pending', this)">Pending</button>
                            <button class="tab-pill" onclick="filterByStatus('confirmed', this)">Confirmed</button>
                            <button class="tab-pill" onclick="filterByStatus('completed', this)">Completed</button>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="search-container ms-md-auto mt-3 mt-md-0">
                            <i class="bi bi-search"></i>
                            <input type="text" id="aptSearchInput" class="form-control" placeholder="Search Client or Service...">
                        </div>
                    </div>
                </div>
                
                <div class="table-responsive">
                    <table class="table custom-table" id="aptMainTable">
                        <thead>
                            <tr class="text-uppercase small text-muted">
                                <th>Schedule</th>
                                <th>Client</th>
                                <th>Service</th>
                                <th>Stylist</th>
                                <th>Status</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($result->num_rows > 0): ?>
                                <?php while($row = $result->fetch_assoc()): ?>
                                <tr class="apt-row-item" data-status="<?php echo strtolower($row['status']); ?>">
                                    <td>
                                        <div class="fw-bold"><?php echo date('d M, Y', strtotime($row['apt_date'])); ?></div>
                                        <small class="text-gold"><?php echo date('h:i A', strtotime($row['apt_time'])); ?></small>
                                    </td>
                                    <td>
                                        <div class="fw-bold name-cell"><?php echo htmlspecialchars($row['client_name']); ?></div>
                                        <small class="text-muted phone-cell"><?php echo $row['client_phone']; ?></small>
                                    </td>
                                    <td class="service-cell"><?php echo $row['service_name']; ?></td>
                                    <td>
                                        <span class="badge bg-light text-dark border">
                                            <i class="bi bi-person me-1"></i><?php echo $row['stylist_name'] ?? 'Unassigned'; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge-<?php echo strtolower($row['status']); ?>">
                                            <?php echo ucfirst($row['status']); ?>
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <select class="form-select form-select-sm d-inline-block w-auto" onchange="updateAptStatus(<?php echo $row['id']; ?>, this.value)">
                                            <option value="" disabled selected>Update</option>
                                            <option value="pending">Pending</option>
                                            <option value="confirmed">Confirm</option>
                                            <option value="completed">Complete</option>
                                            <option value="cancelled">Cancel</option>
                                        </select>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr><td colspan="6" class="text-center py-5 text-muted">No appointments found.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/dashboard.js"></script>
    <script>
        // 1. Search Logic
        document.getElementById('aptSearchInput').addEventListener('keyup', function() {
            const term = this.value.toLowerCase();
            document.querySelectorAll('.apt-row-item').forEach(row => {
                const text = row.innerText.toLowerCase();
                row.style.display = text.includes(term) ? "" : "none";
            });
        });

        // 2. Tab Filter Logic
        function filterByStatus(status, btn) {
            document.querySelectorAll('.tab-pill').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');

            document.querySelectorAll('.apt-row-item').forEach(row => {
                const rowStatus = row.getAttribute('data-status');
                row.style.display = (status === 'all' || rowStatus === status) ? "" : "none";
            });
        }

        // 3. Status Update Logic (FIXED)
        function updateAptStatus(id, newStatus) {
            if(confirm("Change status to " + newStatus + "?")) {
                const formData = new URLSearchParams();
                formData.append('id', id);
                formData.append('status', newStatus);

                fetch('update_apt_status.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: formData.toString()
                })
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        location.reload(); // Reload to update badges and stats
                    } else {
                        alert("Error updating status: " + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert("A network error occurred.");
                });
            }
        }
    </script>
</body>
</html>