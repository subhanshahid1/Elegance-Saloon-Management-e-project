<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analytics | Elegance Salon</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/dashboard.css">

    <style>
        /* ===== REPORTS SPECIFIC STYLES ===== */
        .report-card {
            height: 100%;
        }
        
        /* --- Custom Bar Chart --- */
        .revenue-chart {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            height: 200px;
            padding-top: 20px;
            gap: 10px;
        }
        .revenue-bar-wrapper {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
        }
        .revenue-bar {
            width: 100%;
            max-width: 35px;
            background: var(--blush);
            border-radius: 6px 6px 0 0;
            transition: all 0.3s ease;
            position: relative;
            cursor: pointer;
        }
        .revenue-bar:hover {
            background: var(--gold-light);
        }
        .revenue-bar.active {
            background: var(--gold);
        }
        .bar-label {
            font-size: 10px;
            color: #999;
            text-transform: uppercase;
        }

        /* --- Circle Progress --- */
        .circle-chart {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: conic-gradient(var(--gold) 75%, var(--cream) 0);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 20px auto;
            position: relative;
        }
        .circle-chart::after {
            content: "75%";
            position: absolute;
            width: 90px;
            height: 90px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 18px;
        }

        @media (max-width: 576px) {
            .revenue-chart { height: 150px; gap: 4px; }
            .bar-label { font-size: 8px; }
        }
    </style>
</head>
<body>

    <?php include('../includes/sidebar.php'); ?>

    <div class="main-area">
        <?php include('../includes/topbar.php'); ?>

        <div class="content-area">
            
            <div class="row g-3 align-items-center section-gap">
                <div class="col-12 col-md-6">
                    <h2 class="panel-title fs-3">Business Analytics</h2>
                    <p class="panel-subtitle">Performance tracking and revenue insights</p>
                </div>
                <div class="col-12 col-md-6 d-flex justify-content-md-end gap-2">
                    <div class="tab-pills bg-white border p-1 rounded-pill">
                        <button class="tab-pill active" onclick="activateTab(this)">7D</button>
                        <button class="tab-pill" onclick="activateTab(this)">1M</button>
                        <button class="tab-pill" onclick="activateTab(this)">1Y</button>
                    </div>
                    <button class="btn-gold">
                        <i class="bi bi-printer"></i> Print Report
                    </button>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-12 col-xl-8">
                    <div class="panel report-card">
                        <div class="panel-header">
                            <div class="panel-title">Revenue Forecast</div>
                            <div class="small text-muted">Weekly Comparison</div>
                        </div>
                        <div class="panel-body">
                            <div class="revenue-chart">
                                <div class="revenue-bar-wrapper">
                                    <div class="revenue-bar" style="height: 40%;"></div>
                                    <span class="bar-label">Mon</span>
                                </div>
                                <div class="revenue-bar-wrapper">
                                    <div class="revenue-bar" style="height: 65%;"></div>
                                    <span class="bar-label">Tue</span>
                                </div>
                                <div class="revenue-bar-wrapper">
                                    <div class="revenue-bar" style="height: 50%;"></div>
                                    <span class="bar-label">Wed</span>
                                </div>
                                <div class="revenue-bar-wrapper">
                                    <div class="revenue-bar active" style="height: 90%;"></div>
                                    <span class="bar-label">Thu</span>
                                </div>
                                <div class="revenue-bar-wrapper">
                                    <div class="revenue-bar" style="height: 75%;"></div>
                                    <span class="bar-label">Fri</span>
                                </div>
                                <div class="revenue-bar-wrapper">
                                    <div class="revenue-bar" style="height: 85%;"></div>
                                    <span class="bar-label">Sat</span>
                                </div>
                                <div class="revenue-bar-wrapper">
                                    <div class="revenue-bar" style="height: 30%;"></div>
                                    <span class="bar-label">Sun</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-xl-4">
                    <div class="panel report-card">
                        <div class="panel-header">
                            <div class="panel-title">Capacity</div>
                        </div>
                        <div class="panel-body text-center">
                            <div class="circle-chart"></div>
                            <p class="small text-muted">Salon occupancy for the current week</p>
                            <hr>
                            <div class="text-start">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="small">Hair Services</span>
                                    <span class="small fw-bold">45%</span>
                                </div>
                                <div class="inv-bar mb-3"><div class="inv-fill ok" style="width: 45%;"></div></div>
                                
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="small">Skin Care</span>
                                    <span class="small fw-bold">30%</span>
                                </div>
                                <div class="inv-bar"><div class="inv-fill low" style="width: 30%;"></div></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="panel">
                        <div class="panel-header">
                            <div class="panel-title">Top Specialists This Month</div>
                        </div>
                        <div class="table-responsive">
                            <table class="data-table">
                                <thead>
                                    <tr>
                                        <th>Staff Member</th>
                                        <th>Services Done</th>
                                        <th>Total Generated</th>
                                        <th>Avg. Rating</th>
                                        <th>Trend</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><strong>Sara Khan</strong></td>
                                        <td>84</td>
                                        <td>₨245,000</td>
                                        <td><i class="bi bi-star-fill text-warning"></i> 4.9</td>
                                        <td class="text-success"><i class="bi bi-graph-up-arrow"></i> +12%</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Maria Jameel</strong></td>
                                        <td>62</td>
                                        <td>₨180,500</td>
                                        <td><i class="bi bi-star-fill text-warning"></i> 4.7</td>
                                        <td class="text-success"><i class="bi bi-graph-up-arrow"></i> +5%</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/dashboard.js"></script>
    <script>
        // ===== PAGE NAVIGATION =====
        document.getElementById('page-title').textContent = "Analytics & Reports";
    </script>
</body>
</html>