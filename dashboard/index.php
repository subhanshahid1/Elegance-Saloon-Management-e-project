<?php 
  // index.php
  $pageTitle = "Dashboard Overview";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elegance Salon — Dashboard</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
</head>
<body>

    <?php include('../includes/sidebar.php'); ?>

    <div class="main-area">
        <?php include('../includes/topbar.php'); ?>

        <div class="content-area">
            <div class="row g-3 section-gap">
                <div class="col-6 col-xl-3">
                    <div class="stat-card gold">
                        <div class="stat-icon gold"><i class="bi bi-calendar-check-fill"></i></div>
                        <div class="stat-label">Today's Appointments</div>
                        <div class="stat-value">14</div>
                        <div class="stat-change up"><i class="bi bi-arrow-up-short"></i> 3 more than yesterday</div>
                    </div>
                </div>
                <div class="col-6 col-xl-3">
                    <div class="stat-card green">
                        <div class="stat-icon green"><i class="bi bi-cash-stack"></i></div>
                        <div class="stat-label">Revenue Today</div>
                        <div class="stat-value">₨82,400</div>
                        <div class="stat-change up"><i class="bi bi-arrow-up-short"></i> 12% vs last week</div>
                    </div>
                </div>
                <div class="col-6 col-xl-3">
                    <div class="stat-card rose">
                        <div class="stat-icon rose"><i class="bi bi-people-fill"></i></div>
                        <div class="stat-label">Total Clients</div>
                        <div class="stat-value">1,248</div>
                        <div class="stat-change up"><i class="bi bi-arrow-up-short"></i> 8 new this week</div>
                    </div>
                </div>
                <div class="col-6 col-xl-3">
                    <div class="stat-card blue">
                        <div class="stat-icon blue"><i class="bi bi-box-seam-fill"></i></div>
                        <div class="stat-label">Low Stock Alerts</div>
                        <div class="stat-value">2</div>
                        <div class="stat-change warn"><i class="bi bi-exclamation-circle-fill"></i> Needs attention</div>
                    </div>
                </div>
            </div>

            <div class="row g-3 section-gap">
                <div class="col-12 col-lg-7">
                    <div class="panel" style="height:100%;">
                        <div class="panel-header">
                            <div>
                                <div class="panel-title">Today's Appointments</div>
                                <div class="panel-subtitle">Friday, April 4 · 14 booked</div>
                            </div>
                            <a href="appointments.php" class="panel-action">View all →</a>
                        </div>

                        <div class="apt-row">
                            <div class="apt-avatar" style="background:rgba(201,168,76,0.14);color:var(--gold-dark);">AN</div>
                            <div class="flex-grow-1">
                                <div class="apt-name">Ayesha Noor</div>
                                <div class="apt-service">Balayage Hair Color</div>
                            </div>
                            <div class="apt-time me-2">9:00 AM</div>
                            <span class="badge-confirmed">Confirmed</span>
                        </div>
                        <div class="apt-row">
                            <div class="apt-avatar" style="background:rgba(196,139,139,0.14);color:var(--rose);">FK</div>
                            <div class="flex-grow-1">
                                <div class="apt-name">Fatima Khan</div>
                                <div class="apt-service">Deep Cleanse Facial</div>
                            </div>
                            <div class="apt-time me-2">10:30 AM</div>
                            <span class="badge-confirmed">Confirmed</span>
                        </div>
                        <div class="apt-row">
                            <div class="apt-avatar" style="background:rgba(91,164,207,0.14);color:#2E86C1;">MA</div>
                            <div class="flex-grow-1">
                                <div class="apt-name">Maria Ahmed</div>
                                <div class="apt-service">Manicure + Pedicure</div>
                            </div>
                            <div class="apt-time me-2">12:00 PM</div>
                            <span class="badge-pending">Pending</span>
                        </div>
                        <div class="apt-row">
                            <div class="apt-avatar" style="background:rgba(82,190,128,0.14);color:#27AE60;">ZR</div>
                            <div class="flex-grow-1">
                                <div class="apt-name">Zara Raza</div>
                                <div class="apt-service">Hair Cut & Blow Dry</div>
                            </div>
                            <div class="apt-time me-2">2:00 PM</div>
                            <span class="badge-confirmed">Confirmed</span>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-5 d-flex flex-column gap-3">
                    <div class="panel">
                        <div class="panel-header">
                            <div class="panel-title">Stock Watch</div>
                            <a href="inventory.php" class="panel-action">Inventory →</a>
                        </div>
                        <div class="panel-body">
                            <div class="inv-row">
                                <div class="inv-label">
                                    <span class="inv-name">Shampoo Refill (5L)</span>
                                    <span class="inv-qty">12% left</span>
                                </div>
                                <div class="inv-bar"><div class="inv-fill critical" style="width: 12%;"></div></div>
                            </div>
                            <div class="inv-row">
                                <div class="inv-label">
                                    <span class="inv-name">Hair Color (Golden Brown)</span>
                                    <span class="inv-qty">28% left</span>
                                </div>
                                <div class="inv-bar"><div class="inv-fill low" style="width: 28%;"></div></div>
                            </div>
                        </div>
                    </div>

                    <div class="panel">
                        <div class="panel-header">
                            <div class="panel-title">Weekly Revenue</div>
                        </div>
                        <div class="panel-body">
                            <div class="mini-chart">
                                <div class="chart-col"><div class="chart-bar" style="height:38%;"></div><div class="chart-lbl">Mo</div></div>
                                <div class="chart-col"><div class="chart-bar" style="height:62%;"></div><div class="chart-lbl">Tu</div></div>
                                <div class="chart-col"><div class="chart-bar" style="height:48%;"></div><div class="chart-lbl">We</div></div>
                                <div class="chart-col"><div class="chart-bar active" style="height:85%;"></div><div class="chart-lbl">Th</div></div>
                                <div class="chart-col"><div class="chart-bar" style="height:55%;"></div><div class="chart-lbl">Fr</div></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/dashboard.js"></script>
</body>
</html>