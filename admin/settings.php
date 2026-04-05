<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Settings | Elegance Salon</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/admin-style.css">
</head>
<body>

<div class="main-wrapper">
    <?php include('includes/sidebar.php'); ?>

    <div id="content-area" class="p-0">
        <?php include('includes/topbar.php'); ?>

        <div class="p-4">
            <h2 class="mb-4 text-charcoal font-display">System Settings</h2>

            <div class="row">
                <div class="col-md-3">
                    <div class="elegance-card p-0 overflow-hidden">
                        <div class="list-group list-group-flush" id="settings-tabs" role="tablist">
                            <a class="list-group-item list-group-item-action active p-3 border-0" id="salon-tab" data-bs-toggle="list" href="#salon-info">
                                <i class="bi bi-shop me-2 text-gold"></i> Salon Profile
                            </a>
                            <a class="list-group-item list-group-item-action p-3 border-0" id="user-tab" data-bs-toggle="list" href="#user-accounts">
                                <i class="bi bi-people me-2 text-gold"></i> User Accounts
                            </a>
                            <a class="list-group-item list-group-item-action p-3 border-0" id="service-tab" data-bs-toggle="list" href="#manage-services">
                                <i class="bi bi-scissors me-2 text-gold"></i> Service Catalog
                            </a>
                            <a class="list-group-item list-group-item-action p-3 border-0" id="security-tab" data-bs-toggle="list" href="#security">
                                <i class="bi bi-shield-lock me-2 text-gold"></i> Security & Login
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-9">
                    <div class="tab-content border-0">
                        
                        <div class="tab-pane fade show active" id="salon-info">
                            <div class="elegance-card shadow-sm">
                                <h5 class="mb-4 fw-bold">Salon Information</h5>
                                <form>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label small fw-bold">Salon Name</label>
                                            <input type="text" class="form-control" value="Elegance Salon">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label small fw-bold">Contact Email</label>
                                            <input type="email" class="form-control" value="contact@elegance.com">
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label small fw-bold">Address</label>
                                            <textarea class="form-control" rows="2">123 Beauty Lane, Luxury District, NY</textarea>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label small fw-bold">Currency</label>
                                            <select class="form-select">
                                                <option selected>USD ($)</option>
                                                <option>PKR (Rs.)</option>
                                            </select>
                                        </div>
                                    </div>
                                    <button class="btn btn-elegance mt-4">Save Changes</button>
                                </form>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="user-accounts">
                            <div class="elegance-card shadow-sm">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <h5 class="mb-0 fw-bold">System Users</h5>
                                    <button class="btn btn-sm btn-outline-elegance">+ Add User</button>
                                </div>
                                <table class="table align-middle small">
                                    <thead class="bg-light">
                                        <tr>
                                            <th>Username</th>
                                            <th>Role</th>
                                            <th>Last Login</th>
                                            <th class="text-end">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>admin_main</td>
                                            <td><span class="badge bg-dark">Admin</span></td>
                                            <td>Today, 10:45 AM</td>
                                            <td class="text-end"><i class="bi bi-pencil me-2"></i> <i class="bi bi-trash text-danger"></i></td>
                                        </tr>
                                        <tr>
                                            <td>recep_jane</td>
                                            <td><span class="badge bg-gold">Receptionist</span></td>
                                            <td>Yesterday</td>
                                            <td class="text-end"><i class="bi bi-pencil me-2"></i> <i class="bi bi-trash text-danger"></i></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="manage-services">
                             <div class="elegance-card shadow-sm">
                                <h5 class="mb-4 fw-bold">Manage Services & Pricing</h5>
                                <div class="list-group list-group-flush">
                                    <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                        <div>
                                            <div class="fw-bold">Haircut & Styling</div>
                                            <small class="text-muted">Duration: 45 min</small>
                                        </div>
                                        <div class="fw-bold text-gold">$50.00</div>
                                    </div>
                                    <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                        <div>
                                            <div class="fw-bold">Premium Facial</div>
                                            <small class="text-muted">Duration: 60 min</small>
                                        </div>
                                        <div class="fw-bold text-gold">$85.00</div>
                                    </div>
                                </div>
                                <button class="btn btn-sm btn-outline-elegance mt-3">Add New Service</button>
                             </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>