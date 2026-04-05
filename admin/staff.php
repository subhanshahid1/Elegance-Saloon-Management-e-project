<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Management | Elegance Salon</title>
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
                    <h2 class="mb-1 text-charcoal font-display">Staff & Team</h2>
                    <p class="text-muted small">Manage stylist schedules and performance</p>
                </div>
                <button class="btn btn-elegance shadow-sm" data-bs-toggle="modal" data-bs-target="#addStaffModal">
                    <i class="bi bi-person-plus me-2"></i> Add Staff Member
                </button>
            </div>

            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="elegance-card d-flex align-items-center">
                        <div class="rounded-circle bg-success-subtle p-3 me-3">
                            <i class="bi bi-person-check text-success fs-4"></i>
                        </div>
                        <div>
                            <h6 class="text-muted small mb-0">Currently On-Duty</h6>
                            <h4 class="fw-bold mb-0">8 Stylists</h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="elegance-card d-flex align-items-center">
                        <div class="rounded-circle bg-gold-light p-3 me-3">
                            <i class="bi bi-star text-gold fs-4"></i>
                        </div>
                        <div>
                            <h6 class="text-muted small mb-0">Top Performer</h6>
                            <h4 class="fw-bold mb-0">Sarah M.</h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="elegance-card d-flex align-items-center">
                        <div class="rounded-circle bg-light p-3 me-3">
                            <i class="bi bi-cash-stack text-charcoal fs-4"></i>
                        </div>
                        <div>
                            <h6 class="text-muted small mb-0">Avg. Commission</h6>
                            <h4 class="fw-bold mb-0">15%</h4>
                        </div>
                    </div>
                </div>
            </div>

            <div class="elegance-card p-0 overflow-hidden">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4">Stylist Name</th>
                                <th>Specialization</th>
                                <th>Schedule</th>
                                <th>Commission</th>
                                <th>Status</th>
                                <th class="pe-4 text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <img src="https://ui-avatars.com/api/?name=Sarah+Mitchell&background=C9A84C&color=fff" class="rounded-circle me-3" width="40">
                                        <div>
                                            <div class="fw-bold text-charcoal">Sarah Mitchell</div>
                                            <small class="text-muted">sarah.m@elegance.com</small>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="badge border text-dark fw-normal">Senior Stylist</span></td>
                                <td>
                                    <div class="small">Mon, Wed, Fri</div>
                                    <small class="text-gold">09:00 AM - 05:00 PM</small>
                                </td>
                                <td>20%</td>
                                <td><span class="badge bg-success-subtle text-success">Active</span></td>
                                <td class="pe-4 text-end">
                                    <button class="btn btn-sm btn-light border"><i class="bi bi-calendar-range"></i></button>
                                    <button class="btn btn-sm btn-light border"><i class="bi bi-pencil"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <img src="https://ui-avatars.com/api/?name=Elena+Rodriguez&background=1C1C1E&color=fff" class="rounded-circle me-3" width="40">
                                        <div>
                                            <div class="fw-bold text-charcoal">Elena Rodriguez</div>
                                            <small class="text-muted">elena.r@elegance.com</small>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="badge border text-dark fw-normal">Nail Artist</span></td>
                                <td>
                                    <div class="small">Tue, Thu, Sat</div>
                                    <small class="text-gold">11:00 AM - 07:00 PM</small>
                                </td>
                                <td>15%</td>
                                <td><span class="badge bg-success-subtle text-success">Active</span></td>
                                <td class="pe-4 text-end">
                                    <button class="btn btn-sm btn-light border"><i class="bi bi-calendar-range"></i></button>
                                    <button class="btn btn-sm btn-light border"><i class="bi bi-pencil"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addStaffModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-charcoal text-white">
                <h5 class="modal-title font-display">New Staff Member</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">First Name</label>
                            <input type="text" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Last Name</label>
                            <input type="text" class="form-control" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Specialization</label>
                        <select class="form-select">
                            <option>Hair Styling</option>
                            <option>Makeup Artist</option>
                            <option>Nail Technician</option>
                            <option>Skin Specialist</option>
                        </select>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Commission %</label>
                            <input type="number" class="form-control" placeholder="15">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Base Salary</label>
                            <input type="number" class="form-control" placeholder="0.00">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-elegance w-100 mt-2">Create Profile</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>