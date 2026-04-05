<?php
require_once '../includes/auth.php';
checkAccess(['admin', 'receptionist', 'stylist']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schedule | Elegance Salon</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/dashboard.css">

    <style>
        /* ===== CALENDAR SPECIFIC STYLES ===== */
        .calendar-container {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 1px;
            background: rgba(0,0,0,0.05);
            border: 1px solid rgba(0,0,0,0.05);
            border-radius: var(--panel-radius);
            overflow: hidden;
        }

        .calendar-day-head {
            background: white;
            padding: 15px;
            text-align: center;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: #999;
            font-weight: 600;
        }

        .calendar-cell {
            background: white;
            min-height: 120px;
            padding: 10px;
            transition: background 0.2s;
        }

        .calendar-cell:hover {
            background: var(--cream);
        }

        .calendar-cell.inactive {
            background: #fafafa;
        }

        .day-number {
            font-family: var(--font-display);
            font-size: 16px;
            color: var(--charcoal);
            margin-bottom: 8px;
            display: block;
        }

        .calendar-cell.today .day-number {
            color: var(--gold);
            font-weight: 700;
        }

        /* --- Appointment Mini Cards --- */
        .cal-apt {
            font-size: 10px;
            padding: 4px 8px;
            border-radius: 6px;
            margin-bottom: 4px;
            border-left: 3px solid var(--gold);
            background: rgba(201,168,76,0.08);
            color: var(--gold-dark);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            cursor: pointer;
        }

        .cal-apt.rose {
            border-left-color: var(--rose);
            background: rgba(196,139,139,0.08);
            color: #7B3535;
        }

        /* --- Responsive Adjustments --- */
        @media (max-width: 992px) {
            .calendar-cell { min-height: 80px; }
            .cal-apt { font-size: 9px; padding: 2px 5px; }
        }

        @media (max-width: 576px) {
            .calendar-day-head { padding: 8px 2px; font-size: 9px; }
            .calendar-cell { min-height: 60px; padding: 5px; }
            .day-number { font-size: 13px; }
            .cal-apt { display: none; } /* Hide text on very small screens, show dots or dots-only */
        }
    </style>
</head>
<body>

    <?php include('../includes/sidebar.php'); ?>

    <div class="main-area">
        <?php include('../includes/topbar.php'); ?>

        <div class="content-area">
            
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="panel-title fs-3">April 2024</h2>
                    <p class="panel-subtitle">Manage your salon's daily bookings</p>
                </div>
                <div class="d-flex gap-2">
                    <div class="tab-pills bg-white p-1 rounded-pill border">
                        <button class="tab-pill active" onclick="activateTab(this)">Month</button>
                        <button class="tab-pill" onclick="activateTab(this)">Week</button>
                        <button class="tab-pill" onclick="activateTab(this)">Day</button>
                    </div>
                    <button class="btn-gold">
                        <i class="bi bi-plus-lg"></i> New Booking
                    </button>
                </div>
            </div>

            <div class="calendar-container">
                <div class="calendar-day-head">Mon</div>
                <div class="calendar-day-head">Tue</div>
                <div class="calendar-day-head">Wed</div>
                <div class="calendar-day-head">Thu</div>
                <div class="calendar-day-head">Fri</div>
                <div class="calendar-day-head">Sat</div>
                <div class="calendar-day-head">Sun</div>

                <div class="calendar-cell inactive"><span class="day-number text-muted">27</span></div>
                <div class="calendar-cell inactive"><span class="day-number text-muted">28</span></div>
                <div class="calendar-cell inactive"><span class="day-number text-muted">29</span></div>
                <div class="calendar-cell inactive"><span class="day-number text-muted">30</span></div>
                <div class="calendar-cell inactive"><span class="day-number text-muted">31</span></div>
                <div class="calendar-cell"><span class="day-number">1</span></div>
                <div class="calendar-cell"><span class="day-number">2</span></div>

                <div class="calendar-cell"><span class="day-number">3</span></div>
                <div class="calendar-cell today">
                    <span class="day-number">4</span>
                    <div class="cal-apt">09:00 - Ayesha N.</div>
                    <div class="cal-apt rose">10:30 - Fatima K.</div>
                    <div class="cal-apt">12:00 - Maria A.</div>
                </div>
                <div class="calendar-cell"><span class="day-number">5</span></div>
                <div class="calendar-cell"><span class="day-number">6</span></div>
                <div class="calendar-cell"><span class="day-number">7</span></div>
                <div class="calendar-cell"><span class="day-number">8</span></div>
                <div class="calendar-cell"><span class="day-number">9</span></div>

                <div class="calendar-cell">
                    <span class="day-number">10</span>
                    <div class="cal-apt rose">11:00 - Sana W.</div>
                </div>
                <div class="calendar-cell"><span class="day-number">11</span></div>
                <div class="calendar-cell"><span class="day-number">12</span></div>
                <div class="calendar-cell"><span class="day-number">13</span></div>
                <div class="calendar-cell"><span class="day-number">14</span></div>
                <div class="calendar-cell"><span class="day-number">15</span></div>
                <div class="calendar-cell"><span class="day-number">16</span></div>
            </div>

        </div>
    </div>

    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/dashboard.js"></script>
    <script>
        // ===== PAGE NAVIGATION =====
        // Set active link in sidebar
        document.querySelectorAll('.nav-link-custom').forEach(link => {
            link.classList.remove('active');
            if(link.getAttribute('href').includes('calendar.php')) {
                link.classList.add('active');
            }
        });

        // Update Topbar Title
        document.getElementById('page-title').textContent = "Service Schedule";
    </script>
</body>
</html>