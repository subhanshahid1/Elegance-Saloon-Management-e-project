<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';

// Check access: Only Admin and Receptionist
checkAccess(['admin', 'receptionist']);

$loggedInRole = getUserRole();

// Fetch inventory items - ordered by quantity to show low stock first
$query = "SELECT * FROM inventory ORDER BY quantity ASC";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory | Elegance Salon</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <style>
        .badge-low-stock { background-color: #ffebee; color: #c62828; border: 1px solid #ffcdd2; padding: 4px 8px; border-radius: 4px; }
        .badge-in-stock { background-color: #e8f5e9; color: #2e7d32; border: 1px solid #c8e6c9; padding: 4px 8px; border-radius: 4px; }
    </style>
</head>
<body>
    <?php include('../includes/sidebar.php'); ?>

    <div class="main-area">
        <?php include('../includes/topbar.php'); ?>

        <div class="content-area">
            <div class="row align-items-center mb-4">
                <div class="col-12 d-md-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="panel-title fs-3">Stock Inventory</h2>
                        <p class="panel-subtitle">Manage salon products and supplies</p>
                    </div>
                    <button class="btn-gold mt-3 mt-md-0" onclick="openModal('addItemModal')">
                        <i class="bi bi-plus-lg"></i> Add New Item
                    </button>
                </div>
            </div>

            <div class="panel">
                <div class="table-responsive">
                    <table class="table custom-table">
                        <thead>
                            <tr>
                                <th>Product Name</th>
                                <th>Category</th>
                                <th>Stock</th>
                                <th>Cost/Unit</th>
                                <th>Supplier</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($result->num_rows > 0): ?>
                                <?php while($item = $result->fetch_assoc()): 
                                    $isLow = ($item['quantity'] <= $item['reorder_level']);
                                    // Robust data encoding for JS
                                    $itemData = htmlspecialchars(json_encode($item), ENT_QUOTES, 'UTF-8');
                                ?>
                                <tr>
                                    <td class="fw-bold"><?php echo htmlspecialchars($item['name']); ?></td>
                                    <td><span class="badge bg-light text-dark"><?php echo htmlspecialchars($item['category']); ?></span></td>
                                    <td>
                                        <span class="<?php echo $isLow ? 'text-danger fw-bold' : ''; ?>">
                                            <?php echo $item['quantity']; ?> units
                                        </span>
                                    </td>
                                    <td>Rs. <?php echo number_format($item['cost_per_unit'], 2); ?></td>
                                    <td><?php echo htmlspecialchars($item['supplier']); ?></td>
                                    <td>
                                        <?php if($isLow): ?>
                                            <span class="badge-low-stock" style="font-size: 10px;">LOW STOCK</span>
                                        <?php else: ?>
                                            <span class="badge-in-stock" style="font-size: 10px;">IN STOCK</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <button class="btn btn-sm btn-outline-secondary edit-btn" 
                                                    data-item='<?php echo $itemData; ?>'>
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <a href="inventory_proc.php?delete_id=<?php echo $item['id']; ?>" 
                                               class="btn btn-sm btn-outline-danger" 
                                               onclick="return confirm('Delete this item permanently?')">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr><td colspan="7" class="text-center py-4 text-muted">No inventory items found.</td></tr>
                            <?php endif; ?>
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
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Product Name</label>
                        <input type="text" name="name" class="form-input" required>
                    </div>
                    <div class="row g-2">
                        <div class="col-6 mb-3">
                            <label class="form-label small fw-bold">Category</label>
                            <input type="text" name="category" class="form-input" placeholder="e.g. Hair Care">
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label small fw-bold">Supplier</label>
                            <input type="text" name="supplier" class="form-input">
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col-4 mb-3">
                            <label class="form-label small fw-bold">Quantity</label>
                            <input type="number" name="quantity" class="form-input" value="0" required>
                        </div>
                        <div class="col-4 mb-3">
                            <label class="form-label small fw-bold">Reorder Level</label>
                            <input type="number" name="reorder_level" class="form-input" value="10" required>
                        </div>
                        <div class="col-4 mb-3">
                            <label class="form-label small fw-bold">Cost/Unit</label>
                            <input type="number" step="0.01" name="cost" class="form-input" required>
                        </div>
                    </div>
                </div>
                <div class="panel-header border-top justify-content-end gap-2">
                    <button type="button" class="btn-outline" onclick="closeModal()">Cancel</button>
                    <button type="submit" name="add_item" class="btn-gold">Add to Stock</button>
                </div>
            </form>
        </div>
    </div>

    <div class="modal-overlay" id="editItemModal">
        <div class="modal-box">
            <div class="panel-header">
                <div class="panel-title">Edit Inventory Item</div>
                <button class="border-0 bg-transparent" onclick="closeModal()"><i class="bi bi-x-lg"></i></button>
            </div>
            <form action="inventory_proc.php" method="POST">
                <input type="hidden" name="item_id" id="edit_id">
                <div class="panel-body">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Product Name</label>
                        <input type="text" name="name" id="edit_name" class="form-input" required>
                    </div>
                    <div class="row g-2">
                        <div class="col-6 mb-3">
                            <label class="form-label small fw-bold">Category</label>
                            <input type="text" name="category" id="edit_category" class="form-input">
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label small fw-bold">Supplier</label>
                            <input type="text" name="supplier" id="edit_supplier" class="form-input">
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col-4 mb-3">
                            <label class="form-label small fw-bold">Quantity</label>
                            <input type="number" name="quantity" id="edit_quantity" class="form-input" required>
                        </div>
                        <div class="col-4 mb-3">
                            <label class="form-label small fw-bold">Reorder Level</label>
                            <input type="number" name="reorder_level" id="edit_reorder" class="form-input" required>
                        </div>
                        <div class="col-4 mb-3">
                            <label class="form-label small fw-bold">Cost/Unit</label>
                            <input type="number" step="0.01" name="cost" id="edit_cost" class="form-input" required>
                        </div>
                    </div>
                </div>
                <div class="panel-header border-top justify-content-end gap-2">
                    <button type="button" class="btn-outline" onclick="closeModal()">Cancel</button>
                    <button type="submit" name="update_item" class="btn-gold">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <script src="../assets/js/dashboard.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle Edit Button Clicks
        const editButtons = document.querySelectorAll('.edit-btn');
        editButtons.forEach(btn => {
            btn.onclick = function() {
                const item = JSON.parse(this.getAttribute('data-item'));
                
                // Fill modal fields
                document.getElementById('edit_id').value = item.id;
                document.getElementById('edit_name').value = item.name;
                document.getElementById('edit_category').value = item.category;
                document.getElementById('edit_supplier').value = item.supplier;
                document.getElementById('edit_quantity').value = item.quantity;
                document.getElementById('edit_reorder').value = item.reorder_level;
                document.getElementById('edit_cost').value = item.cost_per_unit;
                
                openModal('editItemModal');
            };
        });
    });

    // Helper functions in case they are missing from dashboard.js
    function openModal(id) { document.getElementById(id).style.display = 'flex'; }
    function closeModal() { document.querySelectorAll('.modal-overlay').forEach(m => m.style.display = 'none'); }
    </script>
</body>
</html>