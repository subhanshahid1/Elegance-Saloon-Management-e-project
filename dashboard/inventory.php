<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';

checkAccess(['admin', 'receptionist']);

// 1. Fetch Stats (Matching the Services design you liked)
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
    <title>Inventory Management | Elegance Salon</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
</head>
<body>
    <?php include('../includes/sidebar.php'); ?>

    <div class="main-area">
        <?php include('../includes/topbar.php'); ?>

        <div class="content-area">
            <div class="row align-items-center mb-4">
                <div class="col-12 d-md-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="panel-title fs-3">Inventory & Supplies</h2>
                        <p class="panel-subtitle">Manage salon products and stock levels</p>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="generate_po.php" class="btn btn-outline-secondary mt-3 mt-md-0">
                            <i class="bi bi-file-earmark-text"></i> Generate PO
                        </a>
                        <a href="suppliers.php" class="btn btn-outline-secondary mt-3 mt-md-0">
                            <i class="bi bi-file-earmark-text"></i> Manage Suppliers
                        </a>
                        <button class="btn-gold mt-3 mt-md-0" onclick="openModal('addModal')">
                            <i class="bi bi-plus-lg"></i> Add New Item
                        </button>
                    </div>
                </div>
            </div>

            <div class="row mb-4 g-3">
                <div class="col-md-4">
                    <div class="panel p-3 d-flex align-items-center gap-3" style="border-left: 4px solid var(--gold);">
                        <div class="fs-2 text-gold"><i class="bi bi-box-seam"></i></div>
                        <div>
                            <h4 class="m-0 fw-bold"><?php echo $totalItems; ?></h4>
                            <small class="text-muted text-uppercase fw-bold" style="font-size: 0.75rem;">Total Products</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="panel p-3 d-flex align-items-center gap-3" style="border-left: 4px solid #dc3545;">
                        <div class="fs-2 text-danger"><i class="bi bi-exclamation-triangle-fill"></i></div>
                        <div>
                            <h4 class="m-0 fw-bold"><?php echo $lowStockCount; ?></h4>
                            <small class="text-muted text-uppercase fw-bold" style="font-size: 0.75rem;">Low Stock</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
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
                                <th>Reorder Level</th>
                                <th>Cost/Unit</th>
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
                                <td><?php echo $row['reorder_level']; ?></td>
                                <td class="fw-bold">Rs. <?php echo number_format($row['cost_per_unit']); ?></td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <button class="btn btn-sm btn-outline-secondary" onclick='fillEdit(<?php echo json_encode($row); ?>)'>
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <a href="inventory_proc.php?del_id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this item permanently?')">
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

    <div class="modal-overlay" id="editModal">
        <div class="modal-box">
            <div class="panel-header">
                <div class="panel-title">Edit Inventory Item</div>
                <button class="border-0 bg-transparent" onclick="closeModal()"><i class="bi bi-x-lg"></i></button>
            </div>
            <form action="inventory_proc.php" method="POST">
                <input type="hidden" name="upd_id" id="field_id">
                <div class="panel-body">
                    <div class="mb-3"><label class="form-label fw-bold small">Item Name</label><input type="text" name="upd_name" id="field_name" class="form-input" required></div>
                    <div class="row">
                        <div class="col-6 mb-3"><label class="form-label fw-bold small">Stock Quantity</label><input type="number" name="upd_qty" id="field_qty" class="form-input" required></div>
                        <div class="col-6 mb-3"><label class="form-label fw-bold small">Unit Cost (Rs)</label><input type="number" step="0.01" name="upd_cost" id="field_cost" class="form-input" required></div>
                    </div>
                    <div class="mb-3"><label class="form-label fw-bold small">Reorder Level</label><input type="number" name="upd_reorder" id="field_reorder" class="form-input"></div>
                </div>
                <div class="panel-footer p-3 text-end border-top">
                    <button type="submit" name="btn_update" class="btn-gold">Update Changes</button>
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
    </script>
</body>
</html>