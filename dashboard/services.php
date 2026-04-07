<?php 
  $pageTitle = "Service Management";
  require_once '../includes/auth.php';
  require_once '../includes/db.php'; 
  checkAccess(['admin']); 

  // Fetch services from the database defined in your SQL file
  $query = "SELECT * FROM services ORDER BY name ASC";
  $result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elegance Salon | Services</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;600&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
</head>
<body>

    <?php include('../includes/sidebar.php'); ?>

    <div class="main-area">
        <?php include('../includes/topbar.php'); ?>

        <div class="content-area">
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
                <div>
                    <h2 class="panel-title" style="font-size: 24px;">Saloon Services</h2>
                    <p class="panel-subtitle">Manage your service menu and pricing</p>
                </div>
                <button class="btn-gold" onclick="openModal('addServiceModal')">
                    <i class="bi bi-plus-lg"></i> Add New Service
                </button>
            </div>

            <?php if(isset($_GET['msg'])): ?>
                <div class="alert alert-success d-flex align-items-center mb-4" style="font-size:13px; border-radius:10px;">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    Service successfully <?php echo $_GET['msg']; ?>!
                </div>
            <?php endif; ?>

            <div class="panel">
                <div class="panel-body p-0">
                    <div class="table-responsive">
                        <table class="data-table" style="min-width: 700px;">
                            <thead>
                                <tr>
                                    <th>Service Name</th>
                                    <th>Duration</th>
                                    <th>Price</th>
                                    <th>Status</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($result && $result->num_rows > 0): ?>
                                    <?php while($service = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td>
                                            <div class="fw-bold"><?php echo htmlspecialchars($service['name']); ?></div>
                                            <div class="text-muted small"><?php echo htmlspecialchars($service['description']); ?></div>
                                        </td>
                                        <td><?php echo $service['duration']; ?> Mins</td>
                                        <td class="fw-bold text-gold">₨<?php echo number_format($service['price']); ?></td>
                                        <td>
                                            <?php if($service['status'] == 'active'): ?>
                                                <span class="badge-confirmed">Active</span>
                                            <?php else: ?>
                                                <span class="badge-cancelled">Inactive</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-end">
                                            <button class="topbar-icon-btn d-inline-flex border-0 me-2" 
                                                    onclick='prepareEdit(<?php echo json_encode($service); ?>)'>
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <a href="service_proc.php?delete=<?php echo $service['id']; ?>" 
                                               class="topbar-icon-btn d-inline-flex border-0 text-danger" 
                                               onclick="return confirm('Delete this service?')">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr><td colspan="5" class="text-center py-5 text-muted">No services found.</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-overlay" id="addServiceModal">
        <div class="modal-box">
            <div class="panel-header">
                <div class="panel-title">Add New Service</div>
                <button class="btn-outline border-0 p-0" onclick="closeModal()"><i class="bi bi-x-lg"></i></button>
            </div>
            <form action="service_proc.php" method="POST">
                <div class="panel-body">
                    <div class="mb-3">
                        <label class="form-label-sm">Service Name</label>
                        <input type="text" name="name" class="form-input" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label-sm">Description</label>
                        <textarea name="description" class="form-input" rows="2"></textarea>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label-sm">Price (Rs)</label>
                            <input type="number" name="price" class="form-input" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label-sm">Duration (Mins)</label>
                            <input type="number" name="duration" class="form-input" required>
                        </div>
                    </div>
                </div>
                <div class="panel-header border-top justify-content-end gap-2">
                    <button type="button" class="btn-outline" onclick="closeModal()">Cancel</button>
                    <button type="submit" name="add_service" class="btn-gold">Save Service</button>
                </div>
            </form>
        </div>
    </div>

    <div class="modal-overlay" id="editServiceModal">
        <div class="modal-box">
            <div class="panel-header">
                <div class="panel-title">Edit Service</div>
                <button class="btn-outline border-0 p-0" onclick="closeModal()"><i class="bi bi-x-lg"></i></button>
            </div>
            <form action="service_proc.php" method="POST">
                <input type="hidden" name="service_id" id="edit_id">
                <div class="panel-body">
                    <div class="mb-3">
                        <label class="form-label-sm">Service Name</label>
                        <input type="text" name="name" id="edit_name" class="form-input" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label-sm">Description</label>
                        <textarea name="description" id="edit_description" class="form-input" rows="2"></textarea>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label-sm">Price (Rs)</label>
                            <input type="number" name="price" id="edit_price" class="form-input" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label-sm">Duration (Mins)</label>
                            <input type="number" name="duration" id="edit_duration" class="form-input" required>
                        </div>
                    </div>
                    <div class="mb-2">
                        <label class="form-label-sm">Availability Status</label>
                        <select name="status" id="edit_status" class="form-input">
                            <option value="active">Active (Visible to Clients)</option>
                            <option value="inactive">Inactive (Hidden)</option>
                        </select>
                    </div>
                </div>
                <div class="panel-header border-top justify-content-end gap-2">
                    <button type="button" class="btn-outline" onclick="closeModal()">Cancel</button>
                    <button type="submit" name="update_service" class="btn-gold">Update Service</button>
                </div>
            </form>
        </div>
    </div>

    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/dashboard.js"></script>
    <script>
        // This function handles the data injection into the Edit Modal
        function prepareEdit(data) {
            document.getElementById('edit_id').value = data.id;
            document.getElementById('edit_name').value = data.name;
            document.getElementById('edit_description').value = data.description;
            document.getElementById('edit_price').value = data.price;
            document.getElementById('edit_duration').value = data.duration;
            document.getElementById('edit_status').value = data.status;
            
            // Calls your existing openModal function from dashboard.js
            openModal('editServiceModal');
        }
    </script>
</body>
</html>