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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supplier Management | Elegance Salon</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <style>
        @media (max-width: 768px) {
            .panel-title { font-size: 1.5rem; }
            .btn-responsive { width: 100%; }
        }
        
        .table-responsive {
            border-radius: 8px;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .modal-box {
            width: 95%;
            max-width: 500px;
            margin: 20px;
        }

        .address-col {
            max-width: 150px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .modal-overlay {
            display:none; 
            position:fixed; 
            top:0; left:0; 
            width:100%; height:100%; 
            background:rgba(0,0,0,0.5); 
            z-index:1050; 
            justify-content:center; 
            align-items:center;
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
                        <h2 class="panel-title fs-3">Suppliers & Vendors</h2>
                        <p class="panel-subtitle">Manage your supply chain and contact points</p>
                    </div>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="inventory.php" class="btn btn-outline-secondary flex-fill flex-md-grow-0">
                            <i class="bi bi-arrow-left"></i> Back
                        </a>
                        <button class="btn-gold flex-fill flex-md-grow-0" onclick="openModal('addSupplierModal')">
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
                                <th class="d-none d-md-table-cell">Contact Person</th>
                                <th>Phone</th>
                                <th class="d-none d-lg-table-cell">Email</th>
                                <th class="d-none d-xl-table-cell">Address</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($row = $result->fetch_assoc()): 
                                $supData = htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8');
                            ?>
                            <tr>
                                <td>
                                    <span class="fw-bold text-dark"><?php echo htmlspecialchars($row['supplier_name']); ?></span>
                                    <div class="d-md-none small text-muted">
                                        <?php echo htmlspecialchars($row['contact_person'] ?: 'No Contact'); ?>
                                    </div>
                                </td>
                                <td class="d-none d-md-table-cell"><?php echo htmlspecialchars($row['contact_person'] ?: 'N/A'); ?></td>
                                <td><a href="tel:<?php echo $row['phone']; ?>" class="text-decoration-none text-dark"><?php echo htmlspecialchars($row['phone'] ?: 'N/A'); ?></a></td>
                                <td class="d-none d-lg-table-cell"><?php echo htmlspecialchars($row['email'] ?: 'N/A'); ?></td>
                                <td class="d-none d-xl-table-cell address-col"><?php echo htmlspecialchars($row['address']); ?></td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <button class="btn btn-sm btn-outline-secondary" onclick='fillEdit(<?php echo $supData; ?>)'>
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <a href="supplier_proc.php?del_id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete supplier?')">
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
        <div class="modal-box bg-white rounded shadow">
            <div class="panel-header d-flex justify-content-between align-items-center p-3 border-bottom">
                <h5 class="m-0 fw-bold">Add New Supplier</h5>
                <button class="btn-close" onclick="closeModal()"></button>
            </div>
            <form action="supplier_proc.php" method="POST">
                <div class="panel-body p-3">
                    <div class="mb-3">
                        <label class="fw-bold small text-uppercase">Supplier Name</label>
                        <input type="text" name="s_name" class="form-control" required>
                    </div>
                    <div class="row g-2">
                        <div class="col-6 mb-3">
                            <label class="fw-bold small text-uppercase">Contact Person</label>
                            <input type="text" name="s_contact" class="form-control">
                        </div>
                        <div class="col-6 mb-3">
                            <label class="fw-bold small text-uppercase">Phone</label>
                            <input type="text" name="s_phone" class="form-control">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="fw-bold small text-uppercase">Email Address</label>
                        <input type="email" name="s_email" class="form-control">
                    </div>
                    <div class="mb-0">
                        <label class="fw-bold small text-uppercase">Address</label>
                        <textarea name="s_address" class="form-control" rows="2"></textarea>
                    </div>
                </div>
                <div class="panel-footer p-3 text-end border-top bg-light rounded-bottom">
                    <button type="button" class="btn btn-secondary btn-sm" onclick="closeModal()">Cancel</button>
                    <button type="submit" name="add_supplier" class="btn-gold btn-sm px-4">Save Supplier</button>
                </div>
            </form>
        </div>
    </div>

    <div class="modal-overlay" id="editSupplierModal">
        <div class="modal-box bg-white rounded shadow">
            <div class="panel-header d-flex justify-content-between align-items-center p-3 border-bottom">
                <h5 class="m-0 fw-bold">Edit Supplier</h5>
                <button class="btn-close" onclick="closeModal()"></button>
            </div>
            <form action="supplier_proc.php" method="POST">
                <input type="hidden" name="s_id" id="e_id">
                <div class="panel-body p-3">
                    <div class="mb-3">
                        <label class="fw-bold small text-uppercase">Supplier Name</label>
                        <input type="text" name="s_name" id="e_name" class="form-control" required>
                    </div>
                    <div class="row g-2">
                        <div class="col-6 mb-3">
                            <label class="fw-bold small text-uppercase">Contact Person</label>
                            <input type="text" name="s_contact" id="e_contact" class="form-control">
                        </div>
                        <div class="col-6 mb-3">
                            <label class="fw-bold small text-uppercase">Phone</label>
                            <input type="text" name="s_phone" id="e_phone" class="form-control">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="fw-bold small text-uppercase">Email Address</label>
                        <input type="email" name="s_email" id="e_email" class="form-control">
                    </div>
                    <div class="mb-0">
                        <label class="fw-bold small text-uppercase">Address</label>
                        <textarea name="s_address" id="e_address" class="form-control" rows="2"></textarea>
                    </div>
                </div>
                <div class="panel-footer p-3 text-end border-top bg-light rounded-bottom">
                    <button type="submit" name="update_supplier" class="btn-gold btn-sm px-4">Update Changes</button>
                </div>
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
        
        window.onclick = function(event) {
            if (event.target.classList.contains('modal-overlay')) closeModal();
        }
    </script>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/dashboard.js"></script>
</body>
</html> 