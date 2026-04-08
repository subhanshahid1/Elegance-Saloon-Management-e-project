<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';

checkAccess(['admin', 'receptionist', 'stylist', 'staff']);
$current_user_id = getUserId();
$current_role = getUserRole();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Schedule & Calendar | Elegance Salon</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>
    <style>
        #calendar { background: #fff; padding: 20px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        .fc-event { cursor: pointer; border: none !important; padding: 2px 5px; }
        .fc-toolbar-title { font-size: 1.5rem !important; font-weight: bold; color: var(--dark); }
        .fc-button-primary { background-color: var(--gold) !important; border-color: var(--gold) !important; }
        .sync-section { background: #f8f9fa; border-radius: 10px; padding: 15px; margin-bottom: 20px; border-left: 4px solid var(--gold); }
    </style>
</head>
<body>
    <?php include('../includes/sidebar.php'); ?>

    <div class="main-area">
        <?php include('../includes/topbar.php'); ?>

        <div class="content-area container-fluid px-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="panel-title fs-3">Salon Schedule</h2>
                    <p class="panel-subtitle">Manage appointments and staff shifts</p>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-dark" onclick="window.location.href='export_ical.php'">
                        <i class="bi bi-calendar-range"></i> Sync to Phone
                    </button>
                </div>
            </div>

            <div class="sync-section">
                <small class="text-uppercase fw-bold text-muted">Calendar Sync URL</small>
                <div class="input-group mt-1">
                    <input type="text" class="form-control form-control-sm" readonly 
                           value="https://<?php echo $_SERVER['HTTP_HOST']; ?>/dashboard/export_ical.php?token=<?php echo md5($current_user_id . 'salon_salt'); ?>">
                    <button class="btn btn-sm btn-gold" onclick="copySyncUrl()">Copy Link</button>
                </div>
                <p class="small text-muted mt-2 mb-0">Paste this link into Google Calendar "Add by URL" to see your salon schedule on your phone.</p>
            </div>

            <div id="calendar"></div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                events: 'fetch_calendar_events.php', // Feed URL
                eventClick: function(info) {
                    alert('Event: ' + info.event.title + '\nDescription: ' + info.event.extendedProps.description);
                },
                eventDidMount: function(info) {
                    if (info.event.extendedProps.type === 'shift') {
                        info.el.style.backgroundColor = '#6c757d'; // Grey for shifts
                    } else if (info.event.extendedProps.status === 'pending') {
                        info.el.style.backgroundColor = '#ffc107'; // Yellow for pending
                        info.el.style.color = '#000';
                    } else {
                        info.el.style.backgroundColor = '#c9a84c'; // Gold for confirmed
                    }
                }
            });
            calendar.render();
        });

        function copySyncUrl() {
            const input = document.querySelector('.sync-section input');
            input.select();
            document.execCommand('copy');
            alert('Sync URL copied to clipboard!');
        }
    </script>
</body>
</html>