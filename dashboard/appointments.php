<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';

checkAccess(['admin', 'receptionist', 'stylist']);

$current_user_id = getUserId();
$current_role = getUserRole();

// Fetch summary counts based on role
$stats_query = "SELECT 
    COUNT(*) as total,
    SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending,
    SUM(CASE WHEN status = 'completed' THEN 1 ELSE 0 END) as completed
    FROM appointments";

if ($current_role === 'stylist') {
    $stats_query .= " WHERE stylist_id = $current_user_id";
}
$stats = $conn->query($stats_query)->fetch_assoc();

// Fetch appointment list
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

// Fetch stylists for the assignment dropdown
$stylist_list = [];
if ($current_role !== 'stylist') {
    $s_res = $conn->query("SELECT id, name FROM users WHERE role = 'stylist'");
    while ($s_row = $s_res->fetch_assoc()) {
        $stylist_list[] = $s_row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointments | Elegance Salon</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <style>
        .tab-pill {
            border: 1px solid rgba(0, 0, 0, 0.1);
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

        .badge-completed {
            background: rgba(25, 135, 84, 0.1);
            color: #198754;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 11px;
        }

        .badge-confirmed {
            background: rgba(13, 110, 253, 0.1);
            color: #0d6efd;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 11px;
        }

        .badge-pending {
            background: rgba(255, 193, 7, 0.1);
            color: #856404;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 11px;
        }

        .badge-cancelled {
            background: rgba(220, 53, 69, 0.1);
            color: #dc3545;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 11px;
        }
    </style>
</head>

<body>
    <?php include('../includes/sidebar.php'); ?>
    <div class="main-area">
        <?php include('../includes/topbar.php'); ?>
        <div class="content-area container-fluid px-4">
            <div class="mb-4">
                <h2 class="panel-title fs-3">Appointments</h2>
                <p class="panel-subtitle">Manage scheduling and role-based assignments</p>
            </div>

            <div class="row mb-4 g-3">
                <div class="col-md-4">
                    <div class="panel p-3 d-flex align-items-center gap-3" style="border-left: 4px solid var(--gold);">
                        <div class="fs-2 text-gold"><i class="bi bi-journal-bookmark"></i></div>
                        <div>
                            <h4 class="m-0 fw-bold"><?php echo $stats['total'] ?? 0; ?></h4>
                            <small class="text-muted text-uppercase fw-bold">Total (<?php echo ucfirst($current_role); ?>)</small>
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
                            <small class="text-muted text-uppercase fw-bold">Completed</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel p-4">
                <div class="row align-items-center mb-4">
                    <div class="col-md-12">
                        <div class="d-flex overflow-auto pb-2">
                            <button class="tab-pill active" onclick="filterByStatus('all', this)">All</button>
                            <button class="tab-pill" onclick="filterByStatus('pending', this)">Pending</button>
                            <button class="tab-pill" onclick="filterByStatus('confirmed', this)">Confirmed</button>
                            <button class="tab-pill" onclick="filterByStatus('completed', this)">Completed</button>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table custom-table">
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
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr class="apt-row-item" data-status="<?php echo strtolower($row['status']); ?>">
                                    <td>
                                        <div class="fw-bold"><?php echo date('d M, Y', strtotime($row['apt_date'])); ?></div>
                                        <small class="text-gold"><?php echo date('h:i A', strtotime($row['apt_time'])); ?></small>
                                    </td>
                                    <td>
                                        <div class="fw-bold"><?php echo htmlspecialchars($row['client_name']); ?></div>
                                        <small class="text-muted"><?php echo $row['client_phone']; ?></small>
                                    </td>
                                    <td><?php echo $row['service_name']; ?></td>
                                    <td>
                                        <?php if ($current_role !== 'stylist'): ?>
                                            <select class="form-select form-select-sm" onchange="assignStylist(<?php echo $row['id']; ?>, this.value)">
                                                <option value="">Choose Stylist</option>
                                                <?php foreach ($stylist_list as $st): ?>
                                                    <option value="<?php echo $st['id']; ?>" <?php echo ($row['stylist_id'] == $st['id']) ? 'selected' : ''; ?>>
                                                        <?php echo $st['name']; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        <?php else: ?>
                                            <span class="badge bg-light text-dark border">Me</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><span class="badge-<?php echo strtolower($row['status']); ?>"><?php echo ucfirst($row['status']); ?></span></td>
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
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>
        function filterByStatus(status, btn) {
            document.querySelectorAll('.tab-pill').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            document.querySelectorAll('.apt-row-item').forEach(row => {
                const rowStatus = row.getAttribute('data-status');
                row.style.display = (status === 'all' || rowStatus === status) ? "" : "none";
            });
        }

        function assignStylist(aptId, stylistId) {
            fetch('assign_stylist.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `apt_id=${aptId}&stylist_id=${stylistId}`
            }).then(res => res.json()).then(data => {
                if (!data.success) alert(data.message);
                location.reload();
            });
        }

        function updateAptStatus(id, newStatus) {
            fetch('update_apt_status.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `id=${id}&status=${newStatus}`
            }).then(res => res.json()).then(data => {
                if (data.success) location.reload();
                else alert(data.message);
            });
        }
    </script>
</body>

</html>