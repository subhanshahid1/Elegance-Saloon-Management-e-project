<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Appointments | Elegance Salon</title>
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
                    <h2 class="mb-1">Appointments</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="index.php" class="text-gold text-decoration-none">Dashboard</a></li>
                            <li class="breadcrumb-item active">Appointments</li>
                        </ol>
                    </nav>
                </div>
                <button class="btn btn-elegance shadow-sm" data-bs-toggle="modal" data-bs-target="#addAppointmentModal">
                    <i class="bi bi-plus-lg me-2"></i> Book Appointment
                </button>
            </div>

            <div class="elegance-card mb-4 p-2">
                <ul class="nav nav-pills nav-fill">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Upcoming</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-muted" href="#">Today</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-muted" href="#">Completed</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-muted" href="#">Cancelled</a>
                    </li>
                </ul>
            </div>

            <div class="elegance-card p-0 overflow-hidden">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4">Date & Time</th>
                                <th>Client Name</th>
                                <th>Service</th>
                                <th>Stylist</th>
                                <th>Status</th>
                                <th class="pe-4 text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="ps-4">
                                    <div class="fw-bold text-charcoal">Oct 24, 2023</div>
                                    <small class="text-muted">10:30 AM - 11:30 AM</small>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-gold-light rounded-circle me-2 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; font-size: 0.8rem; color: var(--gold-dark); font-weight: bold;">AS</div>
                                        <span>Alice Smith</span>
                                    </div>
                                </td>
                                <td><span class="badge border text-charcoal fw-normal">Bridal Makeup</span></td>
                                <td>Sarah Mitchell</td>
                                <td><span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2">Confirmed</span></td>
                                <td class="pe-4 text-end">
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-light border" data-bs-toggle="dropdown">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                                            <li><a class="dropdown-item" href="#"><i class="bi bi-pencil me-2"></i> Edit</a></li>
                                            <li><a class="dropdown-item" href="#"><i class="bi bi-check2-circle me-2"></i> Complete</a></li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-x-circle me-2"></i> Cancel</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="ps-4">
                                    <div class="fw-bold text-charcoal">Oct 24, 2023</div>
                                    <small class="text-muted">01:00 PM - 01:45 PM</small>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-gold-light rounded-circle me-2 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; font-size: 0.8rem; color: var(--gold-dark); font-weight: bold;">RB</div>
                                        <span>Robert Brown</span>
                                    </div>
                                </td>
                                <td><span class="badge border text-charcoal fw-normal">Men's Haircut</span></td>
                                <td>David Wilson</td>
                                <td><span class="badge bg-warning-subtle text-warning border border-warning-subtle px-3 py-2">Arrived</span></td>
                                <td class="pe-4 text-end">
                                    <button class="btn btn-sm btn-light border"><i class="bi bi-three-dots-vertical"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>