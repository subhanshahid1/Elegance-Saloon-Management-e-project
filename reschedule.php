<?php
require_once 'includes/db.php';

// Session and ID Guard
if (!isset($_SESSION['user_id']) || !isset($_GET['id'])) { 
    header("Location: appointment_history.php"); 
    exit(); 
}

$apt_id = intval($_GET['id']);
$user_id = $_SESSION['user_id'];

// Get details of the existing appointment to pre-fill the form
$stmt = $conn->prepare("SELECT * FROM appointments WHERE id = ? AND client_id = ?");
$stmt->bind_param("ii", $apt_id, $user_id);
$stmt->execute();
$res = $stmt->get_result();
$apt = $res->fetch_assoc();

if(!$apt) {
    exit("Appointment not found or access denied.");
}

// Fetch active stylists for the dropdown
$stylists = $conn->query("SELECT id, name FROM users WHERE role = 'stylist' AND status = 'active'");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reschedule Appointment | Elegance Salon</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background: #000; color: #fff; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .res-container { max-width: 600px; margin: 80px auto; background: #111; padding: 40px; border: 1px solid #222; border-radius: 8px; }
        .form-label { color: var(--primary-gold); font-size: 11px; letter-spacing: 1.5px; text-transform: uppercase; font-weight: 700; }
        .form-control, .form-select { 
            background: #1a1a1a !important; 
            color: #fff !important; 
            border: 1px solid #333 !important; 
            padding: 12px;
            border-radius: 4px;
        }
        .form-control:focus, .form-select:focus { 
            border-color: var(--primary-gold) !important; 
            box-shadow: 0 0 10px rgba(212, 160, 23, 0.2); 
            outline: none; 
        }
        .btn-gold { 
            background: var(--primary-gold); 
            color: #000; 
            font-weight: 800; 
            width: 100%; 
            padding: 15px; 
            border: none; 
            text-transform: uppercase; 
            letter-spacing: 2px;
            transition: 0.3s;
            margin-top: 20px;
        }
        .btn-gold:hover { background: #fff; transform: translateY(-3px); }
        .text-gold { color: var(--primary-gold); }
        input[type="date"]::-webkit-calendar-picker-indicator { filter: invert(1); opacity: 0.6; }
    </style>
</head>
<body>

    <div class="container">
        <div class="res-container">
            <h2 class="mb-2" style="font-family: var(--font-primary); color: var(--primary-gold);">RESCHEDULE <em>EXPERIENCE</em></h2>
            <p class="text-muted small mb-4">Update your preferred specialist, date, or time below.</p>
            
            <form id="resForm">
                <input type="hidden" name="apt_id" value="<?= $apt_id ?>">
                
                <div class="mb-4">
                    <label class="form-label">Preferred Specialist</label>
                    <select name="stylist_id" id="stylist_id" class="form-select">
                        <option value="">Any Specialist / No Preference</option>
                        <?php while($s = $stylists->fetch_assoc()): ?>
                            <option value="<?= $s['id'] ?>" <?= ($apt['stylist_id'] == $s['id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($s['name']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <label class="form-label">New Date</label>
                        <input type="date" name="appt_date" id="appt_date" class="form-control" value="<?= $apt['apt_date'] ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">New Time Slot</label>
                        <select name="appt_time" id="appt_time" class="form-select" required>
                             <?php 
                                $slots = ["10:00:00","11:00:00","12:00:00","13:00:00","14:00:00","15:00:00","16:00:00","17:00:00"];
                                foreach($slots as $s) {
                                    $selected = ($apt['apt_time'] == $s) ? 'selected' : '';
                                    // Uniform 12-hour display: 01:00 PM
                                    $displayTime = date('h:i A', strtotime($s));
                                    echo "<option value='$s' $selected>$displayTime</option>";
                                }
                            ?>
                        </select>
                    </div>
                </div>

                <button type="submit" id="submitBtn" class="btn-gold">Update Appointment</button>
                <a href="appointment_history.php" class="d-block text-center mt-4 small text-decoration-none text-muted">
                    <i class="fa-solid fa-arrow-left me-1"></i> Cancel & Go Back
                </a>
            </form>
        </div>
    </div>

    <script>
        // Set min date to today
        document.getElementById('appt_date').setAttribute('min', new Date().toISOString().split('T')[0]);

        function checkAvailability() {
            const date = document.getElementById('appt_date').value;
            const stylist = document.getElementById('stylist_id').value;
            const apt_id = document.querySelector('input[name="apt_id"]').value;

            if (!date) return;

            // Notice we pass exclude_id so your current slot doesn't show as "Taken" to you
            fetch(`check_availability.php?date=${date}&stylist_id=${stylist}&exclude_id=${apt_id}`)
            .then(res => res.json())
            .then(data => {
                const timeSelect = document.getElementById('appt_time');
                Array.from(timeSelect.options).forEach(opt => {
                    // Strip previous "(Taken)" text if it exists
                    const baseTime = opt.text.replace(" (Taken)", "");
                    
                    if(data.booked.includes(opt.value)) { 
                        opt.disabled = true; 
                        opt.text = baseTime + " (Taken)";
                        opt.style.color = "#555";
                    } else { 
                        opt.disabled = false; 
                        opt.text = baseTime;
                        opt.style.color = "#fff";
                    }
                });
            });
        }

        // Listen for changes to trigger availability check
        document.getElementById('appt_date').addEventListener('change', checkAvailability);
        document.getElementById('stylist_id').addEventListener('change', checkAvailability);

        // Run once on load to initialize correct availability for the pre-filled date
        window.addEventListener('DOMContentLoaded', checkAvailability);

        // Form Submission via AJAX
        document.getElementById('resForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const btn = document.getElementById('submitBtn');
            btn.disabled = true;
            btn.innerText = "Processing...";

            fetch('reschedule_submit.php', { 
                method: 'POST', 
                body: new FormData(this) 
            })
            .then(res => res.json())
            .then(data => {
                if(data.success) { 
                    alert("Your appointment has been successfully updated."); 
                    window.location.href="appointment_history.php"; 
                } else { 
                    alert(data.message); 
                    btn.disabled = false;
                    btn.innerText = "Update Appointment";
                }
            })
            .catch(err => {
                alert("An error occurred. Please check your connection.");
                btn.disabled = false;
                btn.innerText = "Update Appointment";
            });
        });
    </script>
</body>
</html>