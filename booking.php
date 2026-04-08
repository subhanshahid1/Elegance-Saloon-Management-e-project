<?php
require_once 'includes/db.php';

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
        /* Exact Styles from contact.php */
        html,
        body {
            max-width: 100%;
            overflow-x: hidden;
        }

        .page-hero {
            background: linear-gradient(rgba(0, 0, 0, 0.65), rgba(0, 0, 0, 0.65)),
                url('https://images.unsplash.com/photo-1560066984-138dadb4c035?q=80&w=1600') center/cover no-repeat;
            padding: 90px 0 70px;
            text-align: center;
        }

        .page-hero h1 {
            font-family: var(--font-primary);
            font-size: clamp(2.2rem, 6vw, 3.8rem);
            color: var(--primary-gold);
            text-transform: uppercase;
            letter-spacing: 6px;
        }

        .breadcrumb-row {
            display: flex;
            justify-content: center;
            gap: 10px;
            font-size: 12px;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--text-muted);
        }

        .breadcrumb-row a {
            color: var(--text-muted);
            text-decoration: none;
        }

        .breadcrumb-row span {
            color: var(--primary-gold);
        }

        .contact-section {
            padding: 80px 0;
            background: var(--bg-black);
        }

        .col-heading {
            font-family: var(--font-primary);
            font-size: 1.8rem;
            color: var(--text-white);
            margin-bottom: 10px;
        }

        .col-heading em {
            color: var(--primary-gold);
            font-style: normal;
        }

        .col-subtext {
            font-size: 13px;
            color: var(--text-muted);
            margin-bottom: 2rem;
            line-height: 1.6;
        }

        .divider-col {
            border-left: 1px solid #222;
        }

        /* Form & Input Styles from contact.php */
        .form-label {
            font-size: 11px;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--primary-gold);
            margin-bottom: 0.5rem;
            font-weight: 600;
            display: block;
        }

        /* FIX: Force text color to white for all inputs including date, time, and textarea */
        .form-control,
        .form-select {
            background-color: var(--bg-card);
            border: 1px solid #333;
            color: #ffffff !important;
            /* Explicit white text */
            font-size: 14px;
            border-radius: 4px;
            padding: 0.8rem 1rem;
            width: 100%;
        }

        /* FIX: Ensure the text inside Date and Time inputs is white in all browsers */
        input[type="date"],
        input[type="time"],
        textarea.form-control {
            color: #ffffff !important;
        }

        /* FIX: Placeholder color */
        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.5) !important;
        }

        .form-control:focus,
        .form-select:focus {
            background-color: #222;
            border-color: var(--primary-gold);
            color: #ffffff !important;
            outline: none;
            box-shadow: 0 0 10px rgba(212, 160, 23, 0.1);
        }

        /* Fix for date/time icons in dark theme */
        input[type="date"]::-webkit-calendar-picker-indicator,
        input[type="time"]::-webkit-calendar-picker-indicator {
            filter: invert(1) sepia(100%) saturate(5000%) hue-rotate(10deg);
            cursor: pointer;
        }

        /* Specific fix for iOS/Safari white text on date inputs */
        input[type="date"]::-webkit-datetime-edit-text,
        input[type="date"]::-webkit-datetime-edit-month-field,
        input[type="date"]::-webkit-datetime-edit-day-field,
        input[type="date"]::-webkit-datetime-edit-year-field,
        input[type="time"]::-webkit-datetime-edit-hour-field,
        input[type="time"]::-webkit-datetime-edit-minute-field,
        input[type="time"]::-webkit-datetime-edit-ampm-field {
            color: #ffffff !important;
        }

        .btn-gold {
            width: 100%;
            background: var(--primary-gold);
            border: 1px solid var(--primary-gold);
            color: #000;
            font-size: 12px;
            font-weight: bold;
            letter-spacing: 3px;
            text-transform: uppercase;
            padding: 1rem;
            border-radius: 4px;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn-gold:hover {
            background: var(--text-white);
            border-color: var(--text-white);
            transform: translateY(-3px);
        }

        /* Info Block Styles */
        .info-block {
            margin-bottom: 2.2rem;
        }

        .info-block-title {
            font-size: 11px;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--primary-gold);
            margin-bottom: 0.8rem;
            font-weight: bold;
        }

        .info-block p {
            font-size: 14px;
            color: var(--text-silver);
            line-height: 1.8;
        }

        .info-icon {
            color: var(--primary-gold);
            margin-right: 8px;
        }

        #successMsg {
            display: none;
            text-align: center;
            padding: 40px 0;
        }

        @media (max-width: 991px) {
            .divider-col {
                border-left: none;
                border-top: 1px solid #222;
                padding-top: 3rem;
                margin-top: 2rem;
            }
        }
    </style>
</head>

<body>

    <?php include('includes/header.php'); ?>

    <section class="page-hero">
        <h1>Reservations</h1>
        <div class="breadcrumb-row">
            <a href="index.php">Home</a> <span>›</span> <span>Booking</span>
        </div>
    </section>

    <section class="contact-section">
        <div class="container">
            <div class="row g-0">
                <div class="col-12 col-md-6 pe-md-5 pb-5 pb-md-0">
                    <div id="bookingFormWrap">
                        <h2 class="col-heading">Book <em>Experience</em></h2>
                        <p class="col-subtext">Select your preferred treatment and specialist below.</p>

                        <form id="bookingForm">
                            <div class="mb-3">
                                <label class="form-label">Service</label>
                                <select name="service_id" class="form-select" required>
                                    <option value="" disabled selected>Select Service</option>
                                    <?php while ($s = mysqli_fetch_assoc($services_res)): ?>
                                        <option value="<?php echo $s['id']; ?>"><?php echo $s['name']; ?> — Rs. <?php echo number_format($s['price']); ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Specialist</label>
                                <select name="stylist_id" class="form-select">
                                    <option value="">No Preference / Any Stylist</option>
                                    <?php while ($st = mysqli_fetch_assoc($stylists_res)): ?>
                                        <option value="<?php echo $st['id']; ?>"><?php echo $st['name']; ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>

                            <div class="row g-3 mb-3">
                                <div class="col-12 col-sm-6">
                                    <label class="form-label">Date</label>
                                    <input type="date" name="appt_date" id="appt_date" class="form-control" required>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <label class="form-label">Time</label>
                                    <input type="time" name="appt_time" class="form-control" required>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Notes</label>
                                <textarea name="notes" class="form-control" placeholder="Any special requests or details..." rows="4"></textarea>
                            </div>

                            <button type="submit" class="btn-gold">Confirm Booking</button>
                        </form>
                    </div>

                    <div id="successMsg">
                        <h2 class="col-heading">Booking <em>Received</em></h2>
                        <p class="col-subtext">Your request is currently pending. You can track its status in your dashboard.</p>
                        <a href="appointment_history.php" class="btn-gold" style="text-decoration:none; display:inline-block; width:auto; padding: 1rem 3rem;">View My Appointments</a>
                    </div>
                </div>

                <div class="col-12 col-md-6 ps-md-5 info-col divider-col">
                    <h2 class="col-heading">Helpful <em>Info</em></h2>
                    <p class="col-subtext">Important details regarding your salon visit.</p>

                    <div class="info-block">
                        <div class="info-block-title">Policy</div>
                        <p><i class="fa-solid fa-circle-info info-icon"></i> Appointments are held for 15 minutes past the scheduled time.</p>
                        <p><i class="fa-solid fa-circle-info info-icon"></i> Please cancel at least 4 hours in advance.</p>
                    </div>

                    <div class="info-block">
                        <div class="info-block-title">Tracking</div>
                        <p><i class="fa-solid fa-calendar-check info-icon"></i> Check your history to see if your status has changed from <strong>Pending</strong> to <strong>Confirmed</strong>.</p>
                    </div>

                    <div class="info-block">
                        <div class="info-block-title">Support</div>
                        <p><i class="fa-solid fa-phone info-icon"></i> Call us at <a href="tel:+922134530829" style="color:var(--primary-gold);">+92 21 345 308 29</a> for urgent changes.</p>
                    </div>

                    <div class="info-block">
                        <div class="info-block-title">Manage Bookings</div>
                        <p>Already have a reservation?</p>
                        <a href="appointment_history.php" style="color:var(--primary-gold); text-transform:uppercase; font-size:12px; font-weight:bold; text-decoration:none;">
                            <i class="fa-solid fa-magnifying-glass me-1"></i> Track My Appointments
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <?php include('includes/footer.php'); ?>

    <script>
        document.getElementById('appt_date').setAttribute('min', new Date().toISOString().split('T')[0]);

        document.getElementById('bookingForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const btn = this.querySelector('button');
            btn.innerHTML = "Processing...";

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
                        btn.innerHTML = "Confirm Booking";
                    }
                });
        });
    </script>
</body>

</html>