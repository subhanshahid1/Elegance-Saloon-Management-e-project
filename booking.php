<?php
require_once 'includes/db.php';

$preselected_service_id = isset($_GET['service_id']) ? intval($_GET['service_id']) : 0;

// Login Guard
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php?msg=Please login to book an appointment");
    exit();
}

$services_res = mysqli_query($conn, "SELECT id, name, price FROM services WHERE status = 'active' ORDER BY category ASC");
$stylists_res = mysqli_query($conn, "SELECT id, name FROM users WHERE role = 'stylist' AND status = 'active'");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Appointment | Elegance Salon</title>

    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <style>
        /* LUXURY DARK THEME CORE */
        html,
        body {
            max-width: 100%;
            overflow-x: hidden;
            background: #000;
            color: #fff;
        }

        .page-hero {
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)),
                url('https://images.unsplash.com/photo-1560066984-138dadb4c035?q=80&w=1600') center/cover no-repeat;
            padding: 100px 0 80px;
            text-align: center;
        }

        .page-hero h1 {
            font-family: var(--font-primary);
            font-size: clamp(2.5rem, 6vw, 4rem);
            color: var(--primary-gold);
            text-transform: uppercase;
            letter-spacing: 8px;
            margin: 0;
        }

        .contact-section {
            padding: 90px 0;
            background: #000;
        }

        .col-heading {
            font-family: var(--font-primary);
            font-size: 2rem;
            color: #fff;
            margin-bottom: 15px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .col-heading em {
            color: var(--primary-gold);
            font-style: normal;
        }

        .col-subtext {
            font-size: 14px;
            color: #888;
            margin-bottom: 2.5rem;
            line-height: 1.6;
            letter-spacing: 0.5px;
        }

        .divider-col {
            border-left: 1px solid #222;
        }

        /* FORM FIELD FIXES */
        .form-label {
            font-size: 11px;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--primary-gold);
            font-weight: 700;
            margin-bottom: 8px;
            display: block;
        }

        .form-control,
        .form-select {
            background-color: #111 !important;
            border: 1px solid #333 !important;
            color: #ffffff !important;
            font-size: 14px;
            padding: 14px 18px;
            border-radius: 2px;
            transition: all 0.3s ease;
        }

        /* Fix: Prevents white background on click/focus/autofill */
        .form-control:focus,
        .form-select:focus {
            background-color: #111 !important;
            color: #ffffff !important;
            border-color: var(--primary-gold) !important;
            box-shadow: 0 0 15px rgba(212, 160, 23, 0.15) !important;
            outline: none;
        }

        /* Fix: Notes Placeholder visibility */
        .form-control::placeholder {
            color: #555 !important;
            opacity: 1;
        }

        /* BUTTONS */
        .btn-gold {
            width: 100%;
            background: var(--primary-gold);
            border: 1px solid var(--primary-gold);
            color: #000;
            font-size: 13px;
            font-weight: 800;
            letter-spacing: 3px;
            text-transform: uppercase;
            padding: 16px;
            transition: 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            cursor: pointer;
        }

        .btn-gold:hover {
            background: #fff;
            border-color: #fff;
            transform: translateY(-4px);
        }

        .btn-outline-gold {
            display: inline-block;
            border: 1px solid var(--primary-gold);
            color: var(--primary-gold);
            padding: 12px 25px;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 2px;
            text-decoration: none;
            font-weight: bold;
            transition: 0.3s;
        }

        .btn-outline-gold:hover {
            background: var(--primary-gold);
            color: #000;
        }

        /* INFO BLOCKS */
        .info-block {
            margin-bottom: 2.5rem;
        }

        .info-block-title {
            font-size: 12px;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--primary-gold);
            margin-bottom: 12px;
            font-weight: 800;
        }

        .info-block p {
            font-size: 14px;
            color: #bbb;
            line-height: 1.8;
        }

        .text-gold {
            color: var(--primary-gold);
        }

        input[type="date"]::-webkit-calendar-picker-indicator {
            filter: invert(1);
            opacity: 0.5;
            cursor: pointer;
        }

        @media (max-width: 768px) {
            .divider-col {
                border-left: none;
                border-top: 1px solid #222;
                padding-top: 50px;
                margin-top: 20px;
            }
        }
    </style>
</head>

<body>

    <?php include('includes/header.php'); ?>

    <section class="page-hero">
        <h1>Reservations</h1>
        <div class="breadcrumb-row d-flex justify-content-center gap-2 text-uppercase" style="font-size:11px; letter-spacing: 1.5px;">
            <a href="index.php" class="text-decoration-none" style="color:#666;">Home</a>
            <span style="color:#444;">›</span>
            <span class="text-gold">Booking</span>
        </div>
    </section>

    <section class="contact-section">
        <div class="container">
            <div class="row g-0">

                <div class="col-12 col-md-6 pe-md-5 pb-5 pb-md-0">
                    <div id="bookingFormWrap">
                        <h2 class="col-heading">Book <em>Experience</em></h2>
                        <p class="col-subtext">Fill in the details below to request your salon appointment.</p>

                        <form id="bookingForm">
                            <div class="mb-4">
                                <label class="form-label">Service Required</label>
                                <select name="service_id" class="form-select" required>
                                    <option value="" disabled <?php echo ($preselected_service_id == 0) ? 'selected' : ''; ?>>Select a Service</option>

                                    <?php while ($s = mysqli_fetch_assoc($services_res)): ?>
                                        <option value="<?= $s['id']; ?>" <?php echo ($s['id'] == $preselected_service_id) ? 'selected' : ''; ?>>
                                            <?= $s['name']; ?> — Rs. <?= number_format($s['price']); ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Preferred Specialist</label>
                                <select name="stylist_id" id="stylist_id" class="form-select">
                                    <option value="">No Preference / Any Specialist</option>
                                    <?php while ($st = mysqli_fetch_assoc($stylists_res)): ?>
                                        <option value="<?= $st['id']; ?>"><?= $st['name']; ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>

                            <div class="row g-3 mb-4">
                                <div class="col-sm-6">
                                    <label class="form-label">Appointment Date</label>
                                    <input type="date" name="appt_date" id="appt_date" class="form-control" required>
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label">Available Time Slot</label>
                                    <select name="appt_time" id="appt_time" class="form-select" required>
                                        <option value="">Choose Date First</option>
                                        <?php
                                        $slots = ["10:00:00", "11:00:00", "12:00:00", "13:00:00", "14:00:00", "15:00:00", "16:00:00", "17:00:00"];
                                        foreach ($slots as $slot) echo "<option value='$slot'>" . date('h:i A', strtotime($slot)) . "</option>";
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-5">
                                <label class="form-label">Special Notes</label>
                                <textarea name="notes" class="form-control" placeholder="Any allergies, specific requests, or details we should know..." rows="4"></textarea>
                            </div>

                            <button type="submit" class="btn-gold">Confirm My Booking</button>
                        </form>
                    </div>

                    <div id="successMsg" style="display:none; text-align:center; padding: 40px 0;">
                        <i class="fa-solid fa-circle-check text-gold mb-4" style="font-size: 3rem;"></i>
                        <h2 class="col-heading">Booking <em>Received</em></h2>
                        <p class="col-subtext">Your request is being processed. You can track the status in your dashboard.</p>
                        <a href="appointment_history.php" class="btn-gold" style="display:inline-block; width:auto; padding:15px 40px; text-decoration:none;">Go to My Dashboard</a>
                    </div>
                </div>

                <div class="col-12 col-md-6 ps-md-5 info-col divider-col">
                    <h2 class="col-heading">Helpful <em>Info</em></h2>
                    <p class="col-subtext">Everything you need to know about our reservation process.</p>

                    <div class="info-block">
                        <div class="info-block-title">Tracking & Status</div>
                        <p>Already have a booking? Check your status, reschedule your timing, or cancel your appointment directly from your personal dashboard.</p>
                        <a href="appointment_history.php" class="btn-outline-gold">
                            <i class="fa-solid fa-clock-rotate-left me-2"></i> Track My Appointments
                        </a>
                    </div>

                    <div class="info-block">
                        <div class="info-block-title">Booking Policy</div>
                        <p><i class="fa-solid fa-check text-gold me-2 small"></i> Cancellations must be made 4 hours prior.</p>
                        <p><i class="fa-solid fa-check text-gold me-2 small"></i> Late arrivals (15+ mins) may need to reschedule.</p>
                        <p><i class="fa-solid fa-check text-gold me-2 small"></i> Walk-ins are subject to stylist availability.</p>
                    </div>

                    <div class="info-block">
                        <div class="info-block-title">Instant Support</div>
                        <p>Need immediate assistance with a booking?</p>
                        <p class="mb-0"><i class="fa-solid fa-phone-volume text-gold me-2"></i> <a href="tel:+922134530829" style="color:inherit; text-decoration:none;">+92 21 345 308 29</a></p>
                        <p><i class="fa-solid fa-envelope text-gold me-2"></i> concierge@elegance.com</p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <?php include('includes/footer.php'); ?>

    <script>
        // Set minimum booking date to Today
        document.getElementById('appt_date').setAttribute('min', new Date().toISOString().split('T')[0]);

        // REQ: Availability logic (Stylist + Date)
        function checkSlots() {
            const date = document.getElementById('appt_date').value;
            const stylist = document.getElementById('stylist_id').value;
            const timeSelect = document.getElementById('appt_time');

            if (!date) return;

            fetch(`check_availability.php?date=${date}&stylist_id=${stylist}`)
                .then(res => res.json())
                .then(data => {
                    Array.from(timeSelect.options).forEach(opt => {
                        if (opt.value === "") return;

                        // If slot is in the 'booked' array returned from server
                        if (data.booked.includes(opt.value)) {
                            opt.disabled = true;
                            opt.style.color = '#444';
                            opt.text = opt.value.substring(0, 5) + " (Unavailable)";
                        } else {
                            opt.disabled = false;
                            opt.style.color = '#fff';
                            opt.text = opt.value.substring(0, 5);
                        }
                    });
                });
        }

        document.getElementById('appt_date').addEventListener('change', checkSlots);
        document.getElementById('stylist_id').addEventListener('change', checkSlots);

        // Form Submit
        document.getElementById('bookingForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const btn = this.querySelector('button');
            const originalText = btn.innerText;

            btn.disabled = true;
            btn.innerText = "Processing...";

            fetch('booking_submit.php', {
                    method: 'POST',
                    body: new FormData(this)
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('bookingFormWrap').style.display = 'none';
                        document.getElementById('successMsg').style.display = 'block';
                        window.scrollTo({
                            top: 0,
                            behavior: 'smooth'
                        });
                    } else {
                        alert(data.message);
                        btn.disabled = false;
                        btn.innerText = originalText;
                    }
                })
                .catch(err => {
                    alert("An error occurred. Please try again.");
                    btn.disabled = false;
                    btn.innerText = originalText;
                });
        });
    </script>
</body>

</html>