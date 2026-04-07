<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';

checkAccess(['admin', 'receptionist']);

// 1. Fetch Stats
$totalServices = $conn->query("SELECT COUNT(*) as total FROM services")->fetch_assoc()['total'] ?? 0;
$activeServices = $conn->query("SELECT COUNT(*) as total FROM services WHERE status = 'active'")->fetch_assoc()['total'] ?? 0;
$inactiveServices = $conn->query("SELECT COUNT(*) as total FROM services WHERE status = 'inactive'")->fetch_assoc()['total'] ?? 0;

// 2. Fetch Services
$result = $conn->query("SELECT * FROM services ORDER BY category ASC, name ASC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service Management | Elegance Salon</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <style>
        /* Responsive Fixes */
        .content-area { padding: 1.5rem; }
        
        @media (max-width: 768px) {
            .content-area { padding: 1rem; }
            .panel-title { font-size: 1.5rem; }
            .btn-gold { width: 100%; justify-content: center; }
        }

        .modal-overlay {
            display: none;
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(0,0,0,0.6);
            z-index: 9999;
            justify-content: center;
            align-items: center;
            padding: 15px;
        }

        .modal-box {
            background: white;
            width: 100%;
            max-width: 500px;
            border-radius: 8px;
            overflow: hidden;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .table-responsive {
            border-radius: 8px;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
    </style>
</head>
<body>
    <?php include('../includes/sidebar.php'); ?>

    <div class="main-area">
        <?php include('../includes/topbar.php'); ?>

        <div class="content-area container-fluid">
            <div class="row align-items-center mb-4">
                <div class="col-12 d-md-flex justify-content-between align-items-center">
                    <div class="mb-3 mb-md-0">
                        <h2 class="panel-title fs-3">Service Menu</h2>
                        <p class="panel-subtitle">Manage salon offerings and categories</p>
                    </div>
                    <button class="btn-gold" onclick="openModal('addModal')">
                        <i class="bi bi-plus-lg"></i> Add New Service
                    </button>
                </div>
            </div>

            <div class="row mb-4 g-3">
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="panel p-3 d-flex align-items-center gap-3" style="border-left: 4px solid var(--gold);">
                        <div class="fs-2 text-gold"><i class="bi bi-scissors"></i></div>
                        <div>
                            <h4 class="m-0 fw-bold"><?php echo $totalServices; ?></h4>
                            <small class="text-muted text-uppercase fw-bold" style="font-size: 0.75rem;">Total Services</small>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="panel p-3 d-flex align-items-center gap-3" style="border-left: 4px solid #198754;">
                        <div class="fs-2 text-success"><i class="bi bi-check-circle-fill"></i></div>
                        <div>
                            <h4 class="m-0 fw-bold"><?php echo $activeServices; ?></h4>
                            <small class="text-muted text-uppercase fw-bold" style="font-size: 0.75rem;">Active Now</small>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="panel p-3 d-flex align-items-center gap-3" style="border-left: 4px solid #dc3545;">
                        <div class="fs-2 text-danger"><i class="bi bi-pause-circle-fill"></i></div>
                        <div>
                            <h4 class="m-0 fw-bold"><?php echo $inactiveServices; ?></h4>
                            <small class="text-muted text-uppercase fw-bold" style="font-size: 0.75rem;">Inactive</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel">
                <div class="table-responsive">
                    <table class="table custom-table mb-0">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Duration</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td class="fw-bold"><?php echo htmlspecialchars($row['name']); ?></td>
                                <td><span class="badge bg-light text-dark border"><?php echo htmlspecialchars($row['category'] ?: 'General'); ?></span></td>
                                <td class="text-success fw-bold">Rs. <?php echo number_format($row['price']); ?></td>
                                <td><?php echo $row['duration']; ?> mins</td>
                                <td><span class="badge <?php echo ($row['status'] == 'active') ? 'bg-success' : 'bg-danger'; ?>"><?php echo strtoupper($row['status']); ?></span></td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <button class="btn btn-sm btn-outline-secondary" onclick='fillEdit(<?php echo json_encode($row); ?>)'>
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <a href="service_proc.php?del_id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this service permanently?')">
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

    <div class="modal-overlay" id="addModal">
        <div class="modal-box">
            <div class="panel-header d-flex justify-content-between align-items-center p-3 border-bottom">
                <div class="panel-title m-0">Add New Service</div>
                <button class="border-0 bg-transparent" onclick="closeModal()"><i class="bi bi-x-lg"></i></button>
            </div>
            <form action="service_proc.php" method="POST">
                <div class="panel-body p-3">
                    <div class="mb-3"><label class="form-label fw-bold small">Service Name</label><input type="text" name="add_name" class="form-control" required></div>
                    <div class="row g-2">
                        <div class="col-6 mb-3"><label class="form-label fw-bold small">Category</label><input type="text" name="add_category" class="form-control" placeholder="e.g. Hair"></div>
                        <div class="col-6 mb-3"><label class="form-label fw-bold small">Price</label><input type="number" name="add_price" class="form-control" required></div>
                    </div>
                    <div class="mb-3"><label class="form-label fw-bold small">Duration (Mins)</label><input type="number" name="add_duration" class="form-control" value="30"></div>
                </div>
                <div class="panel-footer p-3 text-end border-top"><button type="submit" name="btn_add" class="btn-gold px-4">Save Service</button></div>
            </form>
        </div>
    </div>

    <div class="modal-overlay" id="editModal">
        <div class="modal-box">
            <div class="panel-header d-flex justify-content-between align-items-center p-3 border-bottom">
                <div class="panel-title m-0">Edit Service</div>
                <button class="border-0 bg-transparent" onclick="closeModal()"><i class="bi bi-x-lg"></i></button>
            </div>
            <form action="service_proc.php" method="POST">
                <input type="hidden" name="upd_id" id="field_id">
                <div class="panel-body p-3">
                    <div class="mb-3"><label class="form-label fw-bold small">Service Name</label><input type="text" name="upd_name" id="field_name" class="form-control" required></div>
                    <div class="row g-2">
                        <div class="col-6 mb-3"><label class="form-label fw-bold small">Category</label><input type="text" name="upd_category" id="field_category" class="form-control"></div>
                        <div class="col-6 mb-3"><label class="form-label fw-bold small">Price</label><input type="number" name="upd_price" id="field_price" class="form-control" required></div>
                    </div>
                    <div class="row g-2">
                        <div class="col-6 mb-3"><label class="form-label fw-bold small">Duration</label><input type="number" name="upd_duration" id="field_duration" class="form-control"></div>
                        <div class="col-6 mb-3"><label class="form-label fw-bold small">Status</label>
                            <select name="upd_status" id="field_status" class="form-select">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="panel-footer p-3 text-end border-top"><button type="submit" name="btn_update" class="btn-gold px-4">Update Changes</button></div>
            </form>
        </div>
    </div>

    <script>
        function fillEdit(data) {
            document.getElementById('field_id').value = data.id;
            document.getElementById('field_name').value = data.name;
            document.getElementById('field_category').value = data.category || '';
            document.getElementById('field_price').value = data.price;
            document.getElementById('field_duration').value = data.duration;
            document.getElementById('field_status').value = data.status;
            openModal('editModal');
        }
        function openModal(id) { document.getElementById(id).style.display = 'flex'; }
        function closeModal() { document.querySelectorAll('.modal-overlay').forEach(m => m.style.display = 'none'); }
        
        // Close modal when clicking outside box
        window.onclick = function(event) {
            if (event.target.classList.contains('modal-overlay')) {
                closeModal();
            }
        }
    </script>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/dashboard.js"></script>
</body>
</html>