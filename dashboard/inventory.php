<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';

checkAccess(['admin', 'receptionist']);

// 1. Fetch Stats
$totalItems = $conn->query("SELECT COUNT(*) as total FROM inventory")->fetch_assoc()['total'] ?? 0;
$lowStockCount = $conn->query("SELECT COUNT(*) as total FROM inventory WHERE quantity <= reorder_level")->fetch_assoc()['total'] ?? 0;
$totalValue = $conn->query("SELECT SUM(quantity * cost_per_unit) as val FROM inventory")->fetch_assoc()['val'] ?? 0;

// 2. Fetch Inventory
$inventory = $conn->query("SELECT i.*, s.supplier_name FROM inventory i LEFT JOIN suppliers s ON i.supplier_id = s.id ORDER BY i.name ASC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management | Elegance Salon</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <style>
        /* Responsive adjustments for the Stat Cards */
        @media (max-width: 768px) {
            .panel-title { font-size: 1.5rem; }
            .fs-2 { font-size: 1.5rem !important; }
            .btn-responsive { width: 100%; margin-bottom: 10px; }
            .d-flex-mobile { flex-direction: column; align-items: stretch !important; }
        }
        
        /* Ensure table doesn't break layout */
        .table-responsive {
            border-radius: 8px;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        /* Modal responsiveness */
        .modal-box {
            width: 95%;
            max-width: 500px;
            margin: 20px;
        }
    </style>
</head>
<body>
    <?php include('../includes/sidebar.php'); ?>

    <div class="main-area">
        <?php include('../includes/topbar.php'); ?>

        <div class="content-area container-fluid px-3 px-md-4">
            <div class="row align-items-center mb-4">
                <div class="col-12 d-lg-flex justify-content-between align-items-center">
                    <div class="mb-3 mb-lg-0">
                        <h2 class="panel-title">Inventory & Supplies</h2>
                        <p class="panel-subtitle">Manage salon products and stock levels</p>
                    </div>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="generate_po.php" class="btn btn-outline-secondary flex-fill flex-md-grow-0">
                            <i class="bi bi-file-earmark-text"></i> PO
                        </a>
                        <a href="suppliers.php" class="btn btn-outline-secondary flex-fill flex-md-grow-0">
                            <i class="bi bi-truck"></i> Suppliers
                        </a>
                        <button class="btn-gold flex-fill flex-md-grow-0" onclick="openModal('addModal')">
                            <i class="bi bi-plus-lg"></i> Add New
                        </button>
                    </div>
                </div>
            </div>

            <div class="row mb-4 g-3">
                <div class="col-12 col-sm-6 col-lg-4">
                    <div class="panel p-3 d-flex align-items-center gap-3" style="border-left: 4px solid var(--gold);">
                        <div class="fs-2 text-gold"><i class="bi bi-box-seam"></i></div>
                        <div>
                            <h4 class="m-0 fw-bold"><?php echo $totalItems; ?></h4>
                            <small class="text-muted text-uppercase fw-bold" style="font-size: 0.75rem;">Total Products</small>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-4">
                    <div class="panel p-3 d-flex align-items-center gap-3" style="border-left: 4px solid #dc3545;">
                        <div class="fs-2 text-danger"><i class="bi bi-exclamation-triangle-fill"></i></div>
                        <div>
                            <h4 class="m-0 fw-bold"><?php echo $lowStockCount; ?></h4>
                            <small class="text-muted text-uppercase fw-bold" style="font-size: 0.75rem;">Low Stock</small>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-4">
                    <div class="panel p-3 d-flex align-items-center gap-3" style="border-left: 4px solid #198754;">
                        <div class="fs-2 text-success"><i class="bi bi-currency-dollar"></i></div>
                        <div>
                            <h4 class="m-0 fw-bold">Rs. <?php echo number_format($totalValue/1000, 1); ?>k</h4>
                            <small class="text-muted text-uppercase fw-bold" style="font-size: 0.75rem;">Stock Value</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel">
                <div class="table-responsive">
                    <table class="table custom-table">
                        <thead>
                            <tr>
                                <th>Item Name</th>
                                <th>Category</th>
                                <th>Quantity</th>
                                <th class="d-none d-md-table-cell">Reorder Level</th>
                                <th class="d-none d-sm-table-cell">Cost/Unit</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($row = $inventory->fetch_assoc()): 
                                $isLow = ($row['quantity'] <= $row['reorder_level']);
                            ?>
                            <tr>
                                <td class="fw-bold"><?php echo htmlspecialchars($row['name']); ?></td>
                                <td><span class="badge bg-light text-dark border"><?php echo htmlspecialchars($row['category']); ?></span></td>
                                <td><span class="fw-bold <?php echo $isLow ? 'text-danger' : 'text-success'; ?>"><?php echo $row['quantity']; ?></span></td>
                                <td class="d-none d-md-table-cell"><?php echo $row['reorder_level']; ?></td>
                                <td class="fw-bold d-none d-sm-table-cell">Rs. <?php echo number_format($row['cost_per_unit']); ?></td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <button class="btn btn-sm btn-outline-secondary" onclick='fillEdit(<?php echo json_encode($row); ?>)'>
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <a href="inventory_proc.php?del_id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete item?')">
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

    <div class="modal-overlay" id="editModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:1050; justify-content:center; align-items:center;">
        <div class="modal-box bg-white rounded shadow">
            <div class="panel-header d-flex justify-content-between align-items-center p-3 border-bottom">
                <h5 class="m-0">Edit Inventory Item</h5>
                <button class="btn-close" onclick="closeModal()"></button>
            </div>
            <form action="inventory_proc.php" method="POST">
                <input type="hidden" name="upd_id" id="field_id">
                <div class="panel-body p-3">
                    <div class="mb-3"><label class="form-label fw-bold small text-uppercase">Item Name</label><input type="text" name="upd_name" id="field_name" class="form-control" required></div>
                    <div class="row g-2">
                        <div class="col-6 mb-3"><label class="form-label fw-bold small text-uppercase">Stock</label><input type="number" name="upd_qty" id="field_qty" class="form-control" required></div>
                        <div class="col-6 mb-3"><label class="form-label fw-bold small text-uppercase">Cost (Rs)</label><input type="number" step="0.01" name="upd_cost" id="field_cost" class="form-control" required></div>
                    </div>
                    <div class="mb-3"><label class="form-label fw-bold small text-uppercase">Reorder Level</label><input type="number" name="upd_reorder" id="field_reorder" class="form-control"></div>
                </div>
                <div class="panel-footer p-3 text-end border-top bg-light rounded-bottom">
                    <button type="button" class="btn btn-secondary btn-sm" onclick="closeModal()">Cancel</button>
                    <button type="submit" name="btn_update" class="btn-gold btn-sm px-4">Save</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function fillEdit(data) {
            document.getElementById('field_id').value = data.id;
            document.getElementById('field_name').value = data.name;
            document.getElementById('field_qty').value = data.quantity;
            document.getElementById('field_cost').value = data.cost_per_unit;
            document.getElementById('field_reorder').value = data.reorder_level;
            openModal('editModal');
        }
        function openModal(id) { document.getElementById(id).style.display = 'flex'; }
        function closeModal() { document.querySelectorAll('.modal-overlay').forEach(m => m.style.display = 'none'); }
        
        // Close modal if clicking outside box
        window.onclick = function(event) {
            if (event.target.className === 'modal-overlay') closeModal();
        }
    </script>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/dashboard.js"></script>
</body>
</html>