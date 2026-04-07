<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';

checkAccess(['admin', 'receptionist']);

// 1. Fetch Low Stock Items for Alerts
$lowStockRes = $conn->query("SELECT * FROM inventory WHERE quantity <= min_stock_level");
$lowStockCount = $lowStockRes->num_rows;

// 2. Fetch All Inventory with Supplier Names
$query = "SELECT i.*, s.supplier_name 
          FROM inventory i 
          LEFT JOIN suppliers s ON i.supplier_id = s.id 
          ORDER BY i.item_name ASC";
$inventory = $conn->query($query);

// 3. Fetch Suppliers for the Dropdowns
$suppliers = $conn->query("SELECT id, supplier_name FROM suppliers ORDER BY supplier_name ASC");
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
            <?php if($lowStockCount > 0): ?>
                <div class="alert alert-warning border-0 shadow-sm d-flex align-items-center">
                    <i class="bi bi-exclamation-triangle-fill fs-4 me-3"></i>
                    <div>
                        <strong>Low Stock Alert!</strong> You have <?php echo $lowStockCount; ?> items running low. 
                        <button class="btn btn-sm btn-outline-dark ms-3" onclick="openModal('poModal')">Generate PO</button>
                    </div>
                </div>
            <?php endif; ?>

            <div class="row align-items-center mb-4">
                <div class="col-12 d-md-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="panel-title fs-3">Inventory & Supplies</h2>
                        <p class="panel-subtitle">Track stock levels and supplier costs</p>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="suppliers.php" class="btn btn-outline-secondary mt-3 mt-md-0">Manage Suppliers</a>
                        <button class="btn-gold mt-3 mt-md-0" onclick="openModal('addItemModal')">
                            <i class="bi bi-plus-lg"></i> Add New Item
                        </button>
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
                                <th>In Stock</th>
                                <th>Min. Level</th>
                                <th>Unit Cost</th>
                                <th>Supplier</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($row = $inventory->fetch_assoc()): 
                                $isLow = ($row['quantity'] <= $row['min_stock_level']);
                                $itemData = htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8');
                            ?>
                            <tr class="<?php echo $isLow ? 'table-light' : ''; ?>">
                                <td><span class="fw-bold"><?php echo htmlspecialchars($row['item_name']); ?></span></td>
                                <td><?php echo htmlspecialchars($row['category']); ?></td>
                                <td>
                                    <span class="badge <?php echo $isLow ? 'bg-danger' : 'bg-success'; ?>">
                                        <?php echo $row['quantity']; ?>
                                    </span>
                                </td>
                                <td><?php echo $row['min_stock_level']; ?></td>
                                <td class="text-success fw-bold">Rs. <?php echo number_format($row['cost_price'], 2); ?></td>
                                <td><?php echo htmlspecialchars($row['supplier_name'] ?? 'No Supplier'); ?></td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <button class="btn btn-sm btn-outline-secondary" onclick='fillEdit(<?php echo $itemData; ?>)'>
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <a href="inventory_proc.php?del_id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this item?')">
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

    <div class="modal-overlay" id="addItemModal">
        <div class="modal-box">
            <div class="panel-header">
                <div class="panel-title">Add Inventory Item</div>
                <button class="border-0 bg-transparent" onclick="closeModal()"><i class="bi bi-x-lg"></i></button>
            </div>
            <form action="inventory_proc.php" method="POST">
                <div class="panel-body">
                    <div class="mb-3"><label class="fw-bold small">Item Name</label><input type="text" name="item_name" class="form-input" required></div>
                    <div class="row">
                        <div class="col-6 mb-3"><label class="fw-bold small">Category</label><input type="text" name="category" class="form-input" placeholder="e.g. Hair Care"></div>
                        <div class="col-6 mb-3"><label class="fw-bold small">Initial Quantity</label><input type="number" name="quantity" class="form-input" value="0"></div>
                    </div>
                    <div class="row">
                        <div class="col-6 mb-3"><label class="fw-bold small">Cost Per Unit</label><input type="number" step="0.01" name="cost_price" class="form-input" required></div>
                        <div class="col-6 mb-3"><label class="fw-bold small">Min Stock Level</label><input type="number" name="min_level" class="form-input" value="5"></div>
                    </div>
                    <div class="mb-3">
                        <label class="fw-bold small">Supplier</label>
                        <select name="supplier_id" class="form-input">
                            <option value="">Select Supplier</option>
                            <?php 
                            $suppliers->data_seek(0);
                            while($s = $suppliers->fetch_assoc()) echo "<option value='{$s['id']}'>{$s['supplier_name']}</option>"; 
                            ?>
                        </select>
                    </div>
                </div>
                <div class="panel-footer p-3 text-end"><button type="submit" name="add_item" class="btn-gold">Add to Stock</button></div>
            </form>
        </div>
    </div>

    <div class="modal-overlay" id="editItemModal">
        <div class="modal-box">
            <div class="panel-header">
                <div class="panel-title">Update Stock Item</div>
                <button class="border-0 bg-transparent" onclick="closeModal()"><i class="bi bi-x-lg"></i></button>
            </div>
            <form action="inventory_proc.php" method="POST">
                <input type="hidden" name="item_id" id="e_id">
                <div class="panel-body">
                    <div class="mb-3"><label class="fw-bold small">Item Name</label><input type="text" name="item_name" id="e_name" class="form-input" required></div>
                    <div class="row">
                        <div class="col-6 mb-3"><label class="fw-bold small">Quantity in Stock</label><input type="number" name="quantity" id="e_qty" class="form-input"></div>
                        <div class="col-6 mb-3"><label class="fw-bold small">Cost Per Unit</label><input type="number" step="0.01" name="cost_price" id="e_cost" class="form-input"></div>
                    </div>
                    <div class="row">
                        <div class="col-6 mb-3"><label class="fw-bold small">Min Stock Alert Level</label><input type="number" name="min_level" id="e_min" class="form-input"></div>
                        <div class="col-6 mb-3">
                            <label class="fw-bold small">Supplier</label>
                            <select name="supplier_id" id="e_supplier" class="form-input">
                                <option value="">Select Supplier</option>
                                <?php 
                                $suppliers->data_seek(0);
                                while($s = $suppliers->fetch_assoc()) echo "<option value='{$s['id']}'>{$s['supplier_name']}</option>"; 
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="panel-footer p-3 text-end"><button type="submit" name="update_item" class="btn-gold">Update Item</button></div>
            </form>
        </div>
    </div>

    <script>
        function fillEdit(data) {
            document.getElementById('e_id').value = data.id;
            document.getElementById('e_name').value = data.item_name;
            document.getElementById('e_qty').value = data.quantity;
            document.getElementById('e_cost').value = data.cost_price;
            document.getElementById('e_min').value = data.min_stock_level;
            document.getElementById('e_supplier').value = data.supplier_id || '';
            openModal('editItemModal');
        }
        function openModal(id) { document.getElementById(id).style.display = 'flex'; }
        function closeModal() { document.querySelectorAll('.modal-overlay').forEach(m => m.style.display = 'none'); }
    </script>
</body>
</html>