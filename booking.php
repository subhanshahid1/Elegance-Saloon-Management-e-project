<?php 
require_once 'config/config.php'; 
require_once 'includes/db.php'; // Handle form submission logic here

// Fetch Dynamic Data from Database
$services_res = mysqli_query($conn, "SELECT id, name, price FROM services WHERE status = 'active' ORDER BY category ASC");
$stylists_res = mysqli_query($conn, "SELECT id, name FROM users WHERE role = 'stylist' AND status = 'active'");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Appointment | Elegance Saloon</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        /* YOUR THEME STYLES */
        html, body { max-width: 100%; overflow-x: hidden; }
        .page-hero { background: linear-gradient(rgba(0,0,0,0.65), rgba(0,0,0,0.65)), url('https://images.unsplash.com/photo-1560066984-138dadb4c035?q=80&w=1600') center/cover no-repeat; padding: 90px 0 70px; text-align: center; }
        .page-hero h1 { font-family: var(--font-primary); font-size: clamp(2.2rem, 6vw, 3.8rem); color: var(--primary-gold); text-transform: uppercase; letter-spacing: 6px; margin-bottom: 12px; }
        
        .booking-page { background: var(--bg-black); padding: 80px 0; }
        .booking-form-col { padding-right: 50px; }
        .booking-title { font-family: var(--font-primary); font-size: clamp(1.8rem, 4vw, 2.5rem); color: var(--text-white); margin-bottom: 8px; }
        .booking-title em { color: var(--primary-gold); font-style: normal; }
        
        .step-heading { font-size: 10px; letter-spacing: 3px; text-transform: uppercase; color: var(--primary-gold); font-weight: bold; display: flex; align-items: center; gap: 12px; margin-bottom: 20px; margin-top: 35px; }
        .step-num { width: 26px; height: 26px; border: 1px solid var(--primary-gold); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 11px; color: var(--primary-gold); flex-shrink: 0; }
        .step-line { flex: 1; height: 1px; background: rgba(212, 160, 23, 0.15); }
        
        .form-label { font-size: 11px; letter-spacing: 2px; text-transform: uppercase; color: var(--primary-gold); margin-bottom: 0.5rem; font-weight: 600; display: block; }
        .form-control, .form-select { background-color: var(--bg-card); border: 1px solid #333; color: var(--text-white); font-size: 14px; border-radius: 4px; padding: 0.8rem 1rem; width: 100%; }
        
        .btn-book-submit { width: 100%; background: var(--primary-gold); border: 1px solid var(--primary-gold); color: #000; font-size: 12px; font-weight: bold; letter-spacing: 3px; text-transform: uppercase; padding: 1rem; cursor: pointer; transition: 0.3s; margin-top: 20px; }
        .btn-book-submit:hover { background: var(--text-white); border-color: var(--text-white); transform: translateY(-3px); }

        /* RIGHT SECTION STYLES */
        .booking-info-col { border-left: 1px solid #222; padding-left: 50px; }
        .info-panel-title { font-family: var(--font-primary); font-size: 1.4rem; color: var(--text-white); margin-bottom: 25px; }
        .info-panel-title em { color: var(--primary-gold); font-style: normal; }
        .info-item { display: flex; gap: 15px; margin-bottom: 28px; }
        .info-item-icon { width: 38px; height: 38px; border: 1px solid rgba(212, 160, 23, 0.3); display: flex; align-items: center; justify-content: center; color: var(--primary-gold); flex-shrink: 0; }
        .info-item-text h5 { font-size: 13px; font-weight: bold; color: var(--text-white); text-transform: uppercase; margin-bottom: 4px; }
        .info-item-text p { font-size: 13px; color: var(--text-muted); margin: 0; line-height: 1.6; }
        
        .hours-list { margin-top: 30px; border-top: 1px solid #1a1a1a; padding-top: 25px; }
        .hours-row { display: flex; justify-content: space-between; font-size: 13px; color: var(--text-muted); padding: 8px 0; border-bottom: 1px solid #111; }
        .hours-row .day { color: var(--text-silver); }

        /* SUCCESS ANIMATION */
        .confirm-overlay { display: none; text-align: center; padding: 60px 20px; animation: fadeIn 0.8s ease forwards; }
        .confirm-icon { width: 70px; height: 70px; border: 2px solid var(--primary-gold); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 25px; font-size: 1.8rem; color: var(--primary-gold); }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(15px); } to { opacity: 1; transform: translateY(0); } }

        @media (max-width: 991px) { .booking-form-col { padding-right: 15px; } .booking-info-col { border-left: none; border-top: 1px solid #222; padding-left: 15px; margin-top: 50px; padding-top: 50px; } }
    </style>
</head>
<body>

<?php include('includes/header.php'); ?>

<section class="page-hero">
    <h1>Book Appointment</h1>
</section>

<section class="booking-page">
    <div class="container">
        <div class="row">
            <div class="col-lg-7 booking-form-col">
                <div id="bookingFormContainer">
                    <h2 class="booking-title">Reserve Your <em>Session</em></h2>
                    <form id="bookingForm">
                        <div class="step-heading"><div class="step-num">1</div> Personal Info <div class="step-line"></div></div>
                        <div class="row g-3 mb-3">
                            <div class="col-sm-6"><label class="form-label">First Name</label><input type="text" name="first_name" class="form-control" required></div>
                            <div class="col-sm-6"><label class="form-label">Last Name</label><input type="text" name="last_name" class="form-control" required></div>
                            <div class="col-sm-6"><label class="form-label">Phone</label><input type="tel" name="phone" class="form-control" required></div>
                            <div class="col-sm-6"><label class="form-label">Email</label><input type="email" name="email" class="form-control" required></div>
                        </div>

                        <div class="step-heading"><div class="step-num">2</div> Service & Stylist <div class="step-line"></div></div>
                        <div class="mb-3">
                            <label class="form-label">Service</label>
                            <select name="service_id" class="form-select" required>
                                <option value="" disabled selected>Select Service</option>
                                <?php while($s = mysqli_fetch_assoc($services_res)) echo "<option value='{$s['id']}'>{$s['name']} — Rs. {$s['price']}</option>"; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Stylist Preference</label>
                            <select name="stylist_id" class="form-select">
                                <option value="">No Preference</option>
                                <?php while($st = mysqli_fetch_assoc($stylists_res)) echo "<option value='{$st['id']}'>{$st['name']}</option>"; ?>
                            </select>
                        </div>

                        <div class="step-heading"><div class="step-num">3</div> Date & Time <div class="step-line"></div></div>
                        <div class="row g-3">
                            <div class="col-6"><input type="date" name="appt_date" id="appt_date" class="form-control" required></div>
                            <div class="col-6"><input type="time" name="appt_time" class="form-control" required></div>
                        </div>

                        <button type="submit" class="btn-book-submit">Confirm Appointment</button>
                    </form>
                </div>

                <div id="confirmMsg" class="confirm-overlay">
                    <div class="confirm-icon">✓</div>
                    <h2 class="booking-title">Booking <em>Requested</em></h2>
                    <p style="color: #888;">We will contact you shortly to confirm your slot.</p>
                    <a href="index.php" class="btn-book-submit" style="display:inline-block; width:auto; padding: 10px 40px; text-decoration:none;">Home</a>
                </div>
            </div>

            <div class="col-lg-5 booking-info-col">
                <h3 class="info-panel-title">Good to <em>Know</em></h3>
                <div class="info-item">
                    <div class="info-item-icon">◎</div>
                    <div class="info-item-text">
                        <h5>Confirmation</h5>
                        <p>We confirm all appointments within 24 hours via phone call.</p>
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-item-icon">◎</div>
                    <div class="info-item-text">
                        <h5>Cancellation</h5>
                        <p>Please cancel at least 4 hours before your scheduled time.</p>
                    </div>
                </div>

                <div class="hours-list">
                    <h5 class="form-label" style="margin-bottom:15px;">Opening Hours</h5>
                    <div class="hours-row"><span class="day">Mon – Thu</span><span>10:00 AM – 6:00 PM</span></div>
                    <div class="hours-row"><span class="day">Fri – Sat</span><span>10:00 AM – 8:00 PM</span></div>
                    <div class="hours-row"><span class="day">Sunday</span><span>12:00 PM – 6:00 PM</span></div>
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
        btn.disabled = true;

        fetch('booking_submit.php', {
            method: 'POST',
            body: new FormData(this)
        })
        .then(res => res.text())
        .then(text => {
            try {
                const data = JSON.parse(text);
                if(data.success) {
                    document.getElementById('bookingFormContainer').style.display = 'none';
                    document.getElementById('confirmMsg').style.display = 'block';
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                } else {
                    alert("Error: " + data.message);
                    btn.innerHTML = "Confirm Appointment";
                    btn.disabled = false;
                }
            } catch(e) {
                console.error("Server error:", text);
                alert("Database Error. Please ensure booking_submit.php is in the root folder.");
                btn.innerHTML = "Confirm Appointment";
                btn.disabled = false;
            }
        });
    });
</script>
</body>
</html>