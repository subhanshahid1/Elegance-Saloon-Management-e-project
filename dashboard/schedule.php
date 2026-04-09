<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';

checkAccess(['admin', 'receptionist', 'stylist']);
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
        :root {
            --gold: #c9a84c;
            --dark: #1a1a1a;
        }

        /* Calendar Container Responsiveness */
        #calendar {
            background: #fff;
            padding: 15px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            min-height: 500px;
        }

        /* Adjustments for small screens */
        @media (max-width: 768px) {
            .fc-toolbar {
                flex-direction: column;
                gap: 10px;
            }

            .fc-toolbar-title {
                font-size: 1.1rem !important;
            }

            #calendar {
                padding: 8px;
            }

            .sync-card {
                padding: 15px;
            }
        }

        .fc-event {
            cursor: pointer;
            border: none !important;
            padding: 2px 4px;
        }

        .fc-button-primary {
            background-color: var(--gold) !important;
            border-color: var(--gold) !important;
        }

        .sync-card {
            background: #fff;
            border-radius: 10px;
            border-left: 5px solid var(--gold);
            padding: 20px;
            margin-bottom: 25px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
        }

        .copy-input {
            background: #f8f9fa;
            font-family: monospace;
            font-size: 0.85rem;
            border: 1px dashed #ccc;
        }

        .btn-gold {
            background: var(--gold);
            color: white;
            border: none;
        }

        .btn-gold:hover {
            background: #b08d3a;
            color: white;
        }
    </style>
</head>

<body>
    <?php include('../includes/sidebar.php'); ?>

    <div class="main-area">
        <?php include('../includes/topbar.php'); ?>

        <div class="content-area container-fluid px-3 px-md-4 py-4">
            <div class="row align-items-center mb-4">
                <div class="col-12">
                    <h2 class="fw-bold mb-1">Salon Schedule</h2>
                    <p class="text-muted">Manage appointments and staff shifts</p>
                </div>
            </div>

            <div class="sync-card">
                <div class="row align-items-center g-3">
                    <div class="col-12 col-xl-5">
                        <h6 class="mb-1 fw-bold"><i class="bi bi-phone-vibrate me-2"></i>Sync to Mobile</h6>
                        <p class="small text-muted mb-0">Use this link to add the salon calendar to your Google or Apple calendar.</p>
                    </div>
                    <div class="col-12 col-xl-7">
                        <div class="input-group">
                            <input type="text" id="syncLink" class="form-control copy-input" readonly
                                value="http://<?php echo $_SERVER['HTTP_HOST']; ?>/dashboard/export_ical.php?token=<?php echo md5($current_user_id . 'salon_salt'); ?>&uid=<?php echo $current_user_id; ?>">
                            <button class="btn btn-gold" onclick="copySyncUrl()">
                                <i class="bi bi-clipboard"></i> <span class="d-none d-sm-inline">Copy Link</span>
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

    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/dashboard.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                // Switches to List view on mobile automatically
                initialView: window.innerWidth < 768 ? 'listMonth' : 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: window.innerWidth < 768 ? 'listMonth,timeGridDay' : 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                height: 'auto',
                events: 'fetch_calendar_events.php',
                eventClick: function(info) {
                    alert('Details: ' + info.event.title + '\nStatus: ' + (info.event.extendedProps.status || 'N/A'));
                },
                eventDidMount: function(info) {
                    // Color coding based on your DB enum
                    if (info.event.extendedProps.type === 'shift') {
                        info.el.style.backgroundColor = '#495057'; // Dark for shifts
                    } else {
                        const status = info.event.extendedProps.status;
                        if (status === 'pending') {
                            info.el.style.backgroundColor = '#f1c40f'; // Yellow
                            info.el.style.color = '#000';
                        } else if (status === 'cancelled') {
                            info.el.style.backgroundColor = '#e74c3c'; // Red
                        } else {
                            info.el.style.backgroundColor = '#c9a84c'; // Gold (Confirmed)
                        }
                    }
                }
            });
            calendar.render();

            // Handle browser resize
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
            navigator.clipboard.writeText(copyText.value);

            const btn = document.querySelector('.btn-gold');
            const originalText = btn.innerHTML;
            btn.innerHTML = '<i class="bi bi-check-lg"></i> Copied!';
            setTimeout(() => {
                btn.innerHTML = originalText;
            }, 2000);
        }
    </script>
</body>

</html>