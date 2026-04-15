<?php
require_once 'includes/db.php';
if (!isset($_SESSION['user_id']) || !isset($_GET['id'])) { header("Location: appointment_history.php"); exit(); }

$apt_id = intval($_GET['id']);
$user_id = $_SESSION['user_id'];

// Get details of the existing appointment
$res = $conn->query("SELECT * FROM appointments WHERE id = $apt_id AND client_id = $user_id");
$apt = $res->fetch_assoc();
if(!$apt) exit("Appointment not found.");

$stylists = $conn->query("SELECT id, name FROM users WHERE role = 'stylist'");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reschedule Appointment | Elegance Salon</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        body { background: #000; color: #fff; }
        .res-container { max-width: 600px; margin: 100px auto; background: #111; padding: 40px; border: 1px solid #222; }
        .form-control, .form-select { background: #1a1a1a !important; color: #fff !important; border: 1px solid #333 !important; }
        .form-control:focus { border-color: var(--primary-gold) !important; box-shadow: none; }
        .btn-gold { background: var(--primary-gold); color: #000; font-weight: bold; width: 100%; padding: 12px; border: none; text-transform: uppercase; }
    </style>
</head>
<body>
    <div class="container">
        <div class="res-container">
            <h2 class="mb-4" style="font-family: var(--font-primary);">Reschedule <em>Appointment</em></h2>
            <form id="resForm">
                <input type="hidden" name="apt_id" value="<?= $apt_id ?>">
                
                <div class="mb-3">
                    <label class="form-label text-gold small text-uppercase fw-bold">Select Specialist</label>
                    <select name="stylist_id" id="stylist_id" class="form-select">
                        <option value="">Any Stylist</option>
                        <?php while($s = $stylists->fetch_assoc()): ?>
                            <option value="<?= $s['id'] ?>" <?= $apt['stylist_id'] == $s['id'] ? 'selected' : '' ?>><?= $s['name'] ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="row mb-4">
                    <div class="col-6">
                        <label class="form-label text-gold small text-uppercase fw-bold">New Date</label>
                        <input type="date" name="appt_date" id="appt_date" class="form-control" value="<?= $apt['apt_date'] ?>" required>
                    </div>
                    <div class="col-6">
                        <label class="form-label text-gold small text-uppercase fw-bold">New Time</label>
                        <select name="appt_time" id="appt_time" class="form-select" required>
                             <?php 
                                $slots = ["10:00:00","11:00:00","12:00:00","13:00:00","14:00:00","15:00:00","16:00:00","17:00:00"];
                                foreach($slots as $s) {
                                    $selected = ($apt['apt_time'] == $s) ? 'selected' : '';
                                    echo "<option value='$s' $selected>".date('h:i A', strtotime($s))."</option>";
                                }
                            ?>
                        </select>
                    </div>
                </div>

                <button type="submit" class="btn-gold">Update Schedule</button>
                <a href="appointment_history.php" class="d-block text-center mt-3 small text-decoration-none">Back to History</a>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('appt_date').setAttribute('min', new Date().toISOString().split('T')[0]);
        // Reuse availability AJAX (similar to booking.php)
        document.getElementById('appt_date').addEventListener('change', checkAvailability);
        document.getElementById('stylist_id').addEventListener('change', checkAvailability);

        function checkAvailability() {
            const date = document.getElementById('appt_date').value;
            const stylist = document.getElementById('stylist_id').value;
            fetch(`check_availability.php?date=${date}&stylist_id=${stylist}`)
            .then(res => res.json()).then(data => {
                Array.from(document.getElementById('appt_time').options).forEach(opt => {
                    if(data.booked.includes(opt.value)) { opt.disabled = true; opt.text += " (Taken)"; }
                    else { opt.disabled = false; opt.text = opt.text.replace(" (Taken)", ""); }
                });
            });
        }

        document.getElementById('resForm').addEventListener('submit', function(e) {
            e.preventDefault();
            fetch('reschedule_submit.php', { method: 'POST', body: new FormData(this) })
            .then(res => res.json()).then(data => {
                if(data.success) { alert("Appointment updated!"); window.location.href="appointment_history.php"; }
                else { alert(data.message); }
            });
        });
    </script>
</body>
</html>