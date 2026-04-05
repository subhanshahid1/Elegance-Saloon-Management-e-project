<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Database | Elegance Salon</title>
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
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="mb-1">Client Database</h2>
                    <p class="text-muted small">Manage your customer relations and history</p>
                </div>
                <button class="btn btn-elegance shadow-sm" data-bs-toggle="modal" data-bs-target="#addClientModal">
                    <i class="bi bi-person-plus me-2"></i> Add New Client
                </button>
            </div>

            <div class="elegance-card mb-4">
                <div class="row g-3">
                    <div class="col-md-8">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
                            <input type="text" class="form-control border-start-0" placeholder="Search by name, email, or phone...">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <select class="form-select">
                            <option selected>All Clients</option>
                            <option>VIP Clients</option>
                            <option>New this month</option>
                            <option>Inactive (6+ months)</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="elegance-card p-0 overflow-hidden">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4">Client Name</th>
                                <th>Contact Info</th>
                                <th>Total Visits</th>
                                <th>Last Service</th>
                                <th>Preferences</th>
                                <th class="pe-4 text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <img src="https://ui-avatars.com/api/?name=Jane+Doe&background=F2E8E4&color=C9A84C" class="rounded-circle me-3" width="40">
                                        <div>
                                            <div class="fw-bold text-charcoal">Jane Doe</div>
                                            <small class="badge bg-gold-light text-gold-dark" style="font-size: 0.65rem;">VIP</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="small"><i class="bi bi-envelope me-2 text-muted"></i>jane@example.com</div>
                                    <div class="small"><i class="bi bi-telephone me-2 text-muted"></i>+1 234 567 890</div>
                                </td>
                                <td>12</td>
                                <td>
                                    <div class="small fw-medium">Oct 15, 2023</div>
                                    <small class="text-muted">Balayage Hair Color</small>
                                </td>
                                <td>
                                    <span class="text-truncate d-inline-block" style="max-width: 150px;" title="Allergic to specific ammonia dyes">
                                        <i class="bi bi-info-circle me-1 text-gold"></i> Sensitive scalp...
                                    </span>
                                </td>
                                <td class="pe-4 text-end">
                                    <button class="btn btn-sm btn-light border" title="Edit Profile"><i class="bi bi-pencil"></i></button>
                                    <button class="btn btn-sm btn-light border text-primary" title="View History"><i class="bi bi-eye"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <img src="https://ui-avatars.com/api/?name=Mark+Wilson&background=F2E8E4&color=C9A84C" class="rounded-circle me-3" width="40">
                                        <div>
                                            <div class="fw-bold text-charcoal">Mark Wilson</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="small"><i class="bi bi-envelope me-2 text-muted"></i>mark.w@email.com</div>
                                    <div class="small"><i class="bi bi-telephone me-2 text-muted"></i>+1 987 654 321</div>
                                </td>
                                <td>3</td>
                                <td>
                                    <div class="small fw-medium">Sept 28, 2023</div>
                                    <small class="text-muted">Classic Manicure</small>
                                </td>
                                <td><span class="text-muted small">No specific notes</span></td>
                                <td class="pe-4 text-end">
                                    <button class="btn btn-sm btn-light border"><i class="bi bi-pencil"></i></button>
                                    <button class="btn btn-sm btn-light border text-primary"><i class="bi bi-eye"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addClientModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow">
      <div class="modal-header bg-charcoal text-white">
        <h5 class="modal-title font-display">New Client Profile</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body p-4">
        <form>
            <div class="row mb-3">
                <div class="col">
                    <label class="form-label small fw-bold text-muted">First Name</label>
                    <input type="text" class="form-control" placeholder="Jane">
                </div>
                <div class="col">
                    <label class="form-label small fw-bold text-muted">Last Name</label>
                    <input type="text" class="form-control" placeholder="Doe">
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label small fw-bold text-muted">Phone Number</label>
                <input type="tel" class="form-control" placeholder="+1 ...">
            </div>
            <div class="mb-3">
                <label class="form-label small fw-bold text-muted">Client Notes / Preferences</label>
                <textarea class="form-control" rows="3" placeholder="Stylist preference, allergies, etc."></textarea>
            </div>
            <button type="submit" class="btn btn-elegance w-100">Save Client</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>