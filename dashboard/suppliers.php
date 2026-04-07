<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';

checkAccess(['admin', 'receptionist']);

// Fetch all suppliers
$result = $conn->query("SELECT * FROM suppliers ORDER BY supplier_name ASC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Supplier Management | Elegance Salon</title>
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
                        <h2 class="panel-title fs-3">Suppliers & Vendors</h2>
                        <p class="panel-subtitle">Manage your supply chain and contact points</p>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="inventory.php" class="btn btn-outline-secondary mt-3 mt-md-0">Back to Inventory</a>
                        <button class="btn-gold mt-3 mt-md-0" onclick="openModal('addSupplierModal')">
                            <i class="bi bi-plus-lg"></i> Add New Supplier
                        </button>
                    </div>
                </div>
            </div>

            <div class="panel">
                <div class="table-responsive">
                    <table class="table custom-table">
                        <thead>
                            <tr>
                                <th>Supplier Name</th>
                                <th>Contact Person</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Address</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($row = $result->fetch_assoc()): 
                                $supData = htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8');
                            ?>
                            <tr>
                                <td><span class="fw-bold"><?php echo htmlspecialchars($row['supplier_name']); ?></span></td>
                                <td><?php echo htmlspecialchars($row['contact_person'] ?: 'N/A'); ?></td>
                                <td><?php echo htmlspecialchars($row['phone'] ?: 'N/A'); ?></td>
                                <td><?php echo htmlspecialchars($row['email'] ?: 'N/A'); ?></td>
                                <td style="max-width: 200px;" class="text-truncate"><?php echo htmlspecialchars($row['address']); ?></td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <button class="btn btn-sm btn-outline-secondary" onclick='fillEdit(<?php echo $supData; ?>)'>
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <a href="supplier_proc.php?del_id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete supplier? This may affect linked inventory items.')">
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

    <div class="modal-overlay" id="addSupplierModal">
        <div class="modal-box">
            <div class="panel-header">
                <div class="panel-title">Add New Supplier</div>
                <button class="border-0 bg-transparent" onclick="closeModal()"><i class="bi bi-x-lg"></i></button>
            </div>
            <form action="supplier_proc.php" method="POST">
                <div class="panel-body">
                    <div class="mb-3"><label class="fw-bold small">Supplier/Company Name</label><input type="text" name="s_name" class="form-input" required></div>
                    <div class="row">
                        <div class="col-6 mb-3"><label class="fw-bold small">Contact Person</label><input type="text" name="s_contact" class="form-input"></div>
                        <div class="col-6 mb-3"><label class="fw-bold small">Phone</label><input type="text" name="s_phone" class="form-input"></div>
                    </div>
                    <div class="mb-3"><label class="fw-bold small">Email Address</label><input type="email" name="s_email" class="form-input"></div>
                    <div class="mb-3"><label class="fw-bold small">Address</label><textarea name="s_address" class="form-input" rows="2"></textarea></div>
                </div>
                <div class="panel-footer p-3 text-end border-top"><button type="submit" name="add_supplier" class="btn-gold">Save Supplier</button></div>
            </form>
        </div>
    </div>

    <div class="modal-overlay" id="editSupplierModal">
        <div class="modal-box">
            <div class="panel-header">
                <div class="panel-title">Edit Supplier</div>
                <button class="border-0 bg-transparent" onclick="closeModal()"><i class="bi bi-x-lg"></i></button>
            </div>
            <form action="supplier_proc.php" method="POST">
                <input type="hidden" name="s_id" id="e_id">
                <div class="panel-body">
                    <div class="mb-3"><label class="fw-bold small">Supplier/Company Name</label><input type="text" name="s_name" id="e_name" class="form-input" required></div>
                    <div class="row">
                        <div class="col-6 mb-3"><label class="fw-bold small">Contact Person</label><input type="text" name="s_contact" id="e_contact" class="form-input"></div>
                        <div class="col-6 mb-3"><label class="fw-bold small">Phone</label><input type="text" name="s_phone" id="e_phone" class="form-input"></div>
                    </div>
                    <div class="mb-3"><label class="fw-bold small">Email Address</label><input type="email" name="s_email" id="e_email" class="form-input"></div>
                    <div class="mb-3"><label class="fw-bold small">Address</label><textarea name="s_address" id="e_address" class="form-input" rows="2"></textarea></div>
                </div>
                <div class="panel-footer p-3 text-end border-top"><button type="submit" name="update_supplier" class="btn-gold">Update Supplier</button></div>
            </form>
        </div>
    </div>

    <script>
        function fillEdit(data) {
            document.getElementById('e_id').value = data.id;
            document.getElementById('e_name').value = data.supplier_name;
            document.getElementById('e_contact').value = data.contact_person;
            document.getElementById('e_phone').value = data.phone;
            document.getElementById('e_email').value = data.email;
            document.getElementById('e_address').value = data.address;
            openModal('editSupplierModal');
        }
        function openModal(id) { document.getElementById(id).style.display = 'flex'; }
        function closeModal() { document.querySelectorAll('.modal-overlay').forEach(m => m.style.display = 'none'); }
    </script>
</body>
</html>