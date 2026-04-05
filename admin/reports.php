<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports & Analytics | Elegance Salon</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/admin-style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<div class="main-wrapper">
    <?php include('includes/sidebar.php'); ?>

    <div id="content-area" class="p-0">
        <?php include('includes/topbar.php'); ?>

        <div class="p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="mb-1 text-charcoal font-display">Business Analytics</h2>
                    <p class="text-muted small">Track your salon's growth and performance metrics</p>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-secondary btn-sm"><i class="bi bi-download me-2"></i> Export PDF</button>
                    <select class="form-select form-select-sm" style="width: 150px;">
                        <option>Last 30 Days</option>
                        <option>Last 6 Months</option>
                        <option>This Year</option>
                    </select>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="elegance-card border-0 shadow-sm text-center">
                        <h6 class="text-muted small text-uppercase mb-2">Total Revenue</h6>
                        <h3 class="fw-bold text-gold">$12,840</h3>
                        <span class="text-success small"><i class="bi bi-arrow-up"></i> 8.2%</span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="elegance-card border-0 shadow-sm text-center">
                        <h6 class="text-muted small text-uppercase mb-2">Avg. Ticket</h6>
                        <h3 class="fw-bold text-charcoal">$85.00</h3>
                        <span class="text-muted small">per client</span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="elegance-card border-0 shadow-sm text-center">
                        <h6 class="text-muted small text-uppercase mb-2">Retention Rate</h6>
                        <h3 class="fw-bold text-charcoal">64%</h3>
                        <span class="text-success small"><i class="bi bi-arrow-up"></i> 2.1%</span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="elegance-card border-0 shadow-sm text-center">
                        <h6 class="text-muted small text-uppercase mb-2">Bookings</h6>
                        <h3 class="fw-bold text-charcoal">312</h3>
                        <span class="text-danger small"><i class="bi bi-arrow-down"></i> 3%</span>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-lg-8">
                    <div class="elegance-card shadow-sm">
                        <h5 class="mb-4 fw-bold">Revenue Trend</h5>
                        <canvas id="revenueChart" height="300"></canvas>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="elegance-card shadow-sm">
                        <h5 class="mb-4 fw-bold">Popular Services</h5>
                        <canvas id="serviceChart" height="300"></canvas>
                    </div>
                </div>
            </div>

            <div class="elegance-card shadow-sm">
                <h5 class="mb-4 fw-bold">Top Performing Stylists</h5>
                <div class="table-responsive">
                    <table class="table align-middle border-0">
                        <thead>
                            <tr class="text-muted small uppercase">
                                <th>Stylist</th>
                                <th>Services Done</th>
                                <th>Revenue Generated</th>
                                <th>Rating</th>
                                <th class="text-end">Growth</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="fw-bold">Sarah Mitchell</div>
                                    <small class="text-muted">Senior Stylist</small>
                                </td>
                                <td>84</td>
                                <td class="fw-bold">$4,200</td>
                                <td><i class="bi bi-star-fill text-gold"></i> 4.9</td>
                                <td class="text-end text-success">+12%</td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="fw-bold">Elena Rodriguez</div>
                                    <small class="text-muted">Nail Artist</small>
                                </td>
                                <td>112</td>
                                <td class="fw-bold">$3,150</td>
                                <td><i class="bi bi-star-fill text-gold"></i> 4.8</td>
                                <td class="text-end text-success">+5%</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Revenue Line Chart
    const ctxRevenue = document.getElementById('revenueChart').getContext('2d');
    new Chart(ctxRevenue, {
        type: 'line',
        data: {
            labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
            datasets: [{
                label: 'Monthly Revenue ($)',
                data: [2100, 3400, 2800, 4540],
                borderColor: '#C9A84C',
                backgroundColor: 'rgba(201, 168, 76, 0.1)',
                fill: true,
                tension: 0.4
            }]
        },
        options: { responsive: true, maintainAspectRatio: false }
    });

    // Service Pie Chart
    const ctxService = document.getElementById('serviceChart').getContext('2d');
    new Chart(ctxService, {
        type: 'doughnut',
        data: {
            labels: ['Hair', 'Nails', 'Facial', 'Other'],
            datasets: [{
                data: [45, 25, 20, 10],
                backgroundColor: ['#C9A84C', '#1C1C1E', '#E8D4A0', '#F2E8E4'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { position: 'bottom' } }
        }
    });
</script>

<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>