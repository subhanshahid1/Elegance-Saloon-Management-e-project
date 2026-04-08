<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';

checkAccess(['admin', 'receptionist', 'stylist', 'staff']);
$current_user_id = getUserId();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schedule & Calendar | Elegance Salon</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/dashboard.css">    
    <style>
        :root { --gold: #c9a84c; --dark: #1a1a1a; }
        
        /* Responsive Calendar Container */
        #calendar { 
            background: #fff; 
            padding: 15px; 
            border-radius: 12px; 
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            min-height: 500px;
        }

        /* Mobile Adjustments for Calendar Header */
        @media (max-width: 768px) {
            .fc-toolbar {
                flex-direction: column;
                gap: 10px;
            }
            .fc-toolbar-title { font-size: 1.2rem !important; }
            #calendar { padding: 5px; }
        }

        .fc-event { cursor: pointer; border: none !important; padding: 2px 5px; font-size: 0.85em; }
        .fc-button-primary { 
            background-color: var(--gold) !important; 
            border-color: var(--gold) !important; 
            text-transform: capitalize;
        }
        .fc-button-primary:hover { opacity: 0.9; }
        .fc-day-today { background-color: rgba(201, 168, 76, 0.05) !important; }

        /* Sync Section Styling */
        .sync-card {
            background: #fff;
            border-radius: 10px;
            border-left: 5px solid var(--gold);
            padding: 20px;
            margin-bottom: 25px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.03);
        }
        .copy-input {
            background: #f8f9fa;
            border: 1px dashed #ccc;
            font-family: monospace;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <?php include('../includes/sidebar.php'); ?>

    <div class="main-area">
        <?php include('../includes/topbar.php'); ?>

        <div class="content-area container-fluid px-3 px-md-4 py-4">
            <div class="row align-items-center mb-4 g-3">
                <div class="col-12 col-md-6">
                    <h2 class="panel-title fs-3 mb-1">Salon Schedule</h2>
                    <p class="panel-subtitle text-muted">Manage appointments and shifts</p>
                </div>
                <div class="col-12 col-md-6 text-md-end">
                    <button class="btn btn-outline-dark btn-sm" onclick="location.reload()">
                        <i class="bi bi-arrow-clockwise"></i> Refresh
                    </button>
                </div>
            </div>

            <div class="sync-card">
                <div class="row align-items-center g-3">
                    <div class="col-lg-4">
                        <h6 class="mb-1 fw-bold"><i class="bi bi-google-calendar me-2"></i>Calendar Sync</h6>
                        <p class="small text-muted mb-0">Connect this schedule to your phone (Google/iCal).</p>
                    </div>
                    <div class="col-lg-8">
                        <div class="input-group">
                            <input type="text" id="syncLink" class="form-control copy-input" readonly 
                                   value="https://<?php echo $_SERVER['HTTP_HOST']; ?>/dashboard/export_ical.php?token=<?php echo md5($current_user_id . 'salon_salt'); ?>">
                            <button class="btn btn-gold px-3" onclick="copySyncUrl()">
                                <i class="bi bi-clipboard"></i> <span class="d-none d-sm-inline">Copy</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                // Adaptive view based on screen width
                initialView: window.innerWidth < 768 ? 'listMonth' : 'dayGridMonth',
                
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: window.innerWidth < 768 ? 'listMonth,timeGridDay' : 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                
                themeSystem: 'bootstrap5',
                height: 'auto',
                aspectRatio: 1.35,
                events: 'fetch_calendar_events.php',
                
                // Clicking an event opens a Bootstrap modal or alert
                eventClick: function(info) {
                    alert('Appointment: ' + info.event.title + '\nType: ' + info.event.extendedProps.type);
                },

                // Event Colors
                eventDidMount: function(info) {
                    if (info.event.extendedProps.type === 'shift') {
                        info.el.style.backgroundColor = '#6c757d'; 
                    } else if (info.event.extendedProps.status === 'pending') {
                        info.el.style.backgroundColor = '#ffc107'; 
                        info.el.style.color = '#000';
                    } else {
                        info.el.style.backgroundColor = '#c9a84c'; 
                    }
                }
            });

            calendar.render();

            // Handle window resize to switch views dynamically
            window.addEventListener('resize', function() {
                if (window.innerWidth < 768) {
                    calendar.changeView('listMonth');
                } else {
                    calendar.changeView('dayGridMonth');
                }
            });
        });

        function copySyncUrl() {
            const copyText = document.getElementById("syncLink");
            copyText.select();
            copyText.setSelectionRange(0, 99999);
            navigator.clipboard.writeText(copyText.value);
            
            // Visual feedback
            const btn = document.querySelector('.btn-gold');
            const originalHtml = btn.innerHTML;
            btn.innerHTML = '<i class="bi bi-check-lg"></i> Copied!';
            setTimeout(() => { btn.innerHTML = originalHtml; }, 2000);
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/dashboard.js"></script>
</body>
</html>