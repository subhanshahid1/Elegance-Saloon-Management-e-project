<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Appointment - Elegance Saloon</title>

    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">

    <style>

        /* Global Fix */
        html, body {
            max-width: 100%;
            overflow-x: hidden;
        }


        /* Page Hero Banner */
        .page-hero {
            background: linear-gradient(rgba(0,0,0,0.65), rgba(0,0,0,0.65)),
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
            margin-bottom: 12px;
        }

        .breadcrumb-row {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            font-size: 12px;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--text-muted);
        }

        .breadcrumb-row a {
            color: var(--text-muted);
            text-decoration: none;
            transition: 0.3s;
        }

        .breadcrumb-row a:hover { color: var(--primary-gold); }
        .breadcrumb-row span    { color: var(--primary-gold); }


        /* Booking Page Wrapper */
        .booking-page {
            background: var(--bg-black);
            padding: 80px 0;
        }


        /* Left Column: Form */
        .booking-form-col {
            padding-right: 50px;
        }

        .booking-title {
            font-family: var(--font-primary);
            font-size: clamp(1.8rem, 4vw, 2.5rem);
            color: var(--text-white);
            margin-bottom: 8px;
        }

        .booking-title em {
            color: var(--primary-gold);
            font-style: normal;
        }

        .booking-subtitle {
            font-size: 13px;
            color: var(--text-muted);
            margin-bottom: 40px;
            line-height: 1.6;
        }


        /* Step Headings inside the form */
        .step-heading {
            font-size: 10px;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: var(--primary-gold);
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
            margin-top: 35px;
        }

        .step-heading:first-of-type {
            margin-top: 0;
        }

        .step-num {
            width: 26px;
            height: 26px;
            border: 1px solid var(--primary-gold);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            color: var(--primary-gold);
            flex-shrink: 0;
        }

        .step-line {
            flex: 1;
            height: 1px;
            background: rgba(212, 160, 23, 0.15);
        }


        /* Form Inputs */
        .form-label {
            font-size: 11px;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--primary-gold);
            margin-bottom: 0.5rem;
            font-weight: 600;
            display: block;
        }

        .form-control,
        .form-select {
            background-color: var(--bg-card);
            border: 1px solid #333;
            color: var(--text-white);
            font-size: 14px;
            border-radius: 4px;
            padding: 0.8rem 1rem;
            transition: var(--trans-std);
            width: 100%;
        }

        .form-control::placeholder { color: var(--text-muted); }

        .form-control:focus,
        .form-select:focus {
            background-color: #222;
            border-color: var(--primary-gold);
            color: var(--text-white);
            box-shadow: 0 0 10px rgba(212, 160, 23, 0.1);
            outline: none;
        }

        .form-select {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6'%3E%3Cpath d='M0 0l5 6 5-6z' fill='%23d4a017'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 1rem center;
        }

        .form-select option {
            background: var(--bg-card);
            color: var(--text-white);
        }

        /* Date and time inputs need extra override for dark bg */
        input[type="date"],
        input[type="time"] {
            color-scheme: dark;
        }


        /* Submit Button */
        .btn-book-submit {
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
            transition: var(--trans-std);
            margin-top: 10px;
        }

        .btn-book-submit:hover {
            background: var(--text-white);
            border-color: var(--text-white);
            transform: translateY(-3px);
        }


        /* Right Column: Info Panel */
        .booking-info-col {
            border-left: 1px solid #222;
            padding-left: 50px;
        }

        .info-panel-title {
            font-family: var(--font-primary);
            font-size: 1.4rem;
            color: var(--text-white);
            margin-bottom: 25px;
        }

        .info-panel-title em {
            color: var(--primary-gold);
            font-style: normal;
        }


        /* Info Item in right panel */
        .info-item {
            display: flex;
            gap: 15px;
            margin-bottom: 28px;
            align-items: flex-start;
        }

        .info-item-icon {
            width: 38px;
            height: 38px;
            border: 1px solid rgba(212, 160, 23, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-gold);
            font-size: 14px;
            flex-shrink: 0;
        }

        .info-item-text h5 {
            font-size: 13px;
            font-weight: bold;
            color: var(--text-white);
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 4px;
        }

        .info-item-text p {
            font-size: 13px;
            color: var(--text-muted);
            margin: 0;
            line-height: 1.6;
        }


        /* Hours Table in right panel */
        .hours-list {
            margin-top: 30px;
            border-top: 1px solid #1a1a1a;
            padding-top: 25px;
        }

        .hours-list h5 {
            font-size: 11px;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--primary-gold);
            margin-bottom: 15px;
            font-weight: bold;
        }

        .hours-row {
            display: flex;
            justify-content: space-between;
            font-size: 13px;
            color: var(--text-muted);
            padding: 8px 0;
            border-bottom: 1px solid #111;
        }

        .hours-row:last-child { border-bottom: none; }
        .hours-row .day { color: var(--text-silver); }


        /* Confirmation Message */
        .confirm-overlay {
            display: none;
            text-align: center;
            padding: 40px 20px;
            animation: fadeIn 0.8s ease forwards;
        }

        .confirm-icon {
            width: 70px;
            height: 70px;
            border: 2px solid var(--primary-gold);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 25px;
            font-size: 1.8rem;
            color: var(--primary-gold);
        }

        .confirm-overlay h2 {
            font-family: var(--font-primary);
            font-size: 2.2rem;
            color: var(--text-white);
            margin-bottom: 10px;
        }

        .confirm-overlay h2 em {
            color: var(--primary-gold);
            font-style: normal;
        }

        .confirm-overlay p {
            font-size: 14px;
            color: var(--text-silver);
            line-height: 1.8;
            max-width: 400px;
            margin: 0 auto 30px;
        }

        .btn-outline-gold {
            border: 1px solid var(--primary-gold);
            color: var(--primary-gold);
            padding: 12px 35px;
            font-size: 11px;
            letter-spacing: 2px;
            text-transform: uppercase;
            text-decoration: none;
            display: inline-block;
            transition: 0.3s;
        }

        .btn-outline-gold:hover {
            background: var(--primary-gold);
            color: #000;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to   { opacity: 1; transform: translateY(0); }
        }


        /* Mobile */
        @media (max-width: 991px) {
            .booking-form-col  { padding-right: 15px; }
            .booking-info-col  { border-left: none; border-top: 1px solid #222; padding-left: 15px; padding-top: 50px; margin-top: 50px; }
        }

    </style>
</head>
<body>

<?php include('includes/header.php'); ?>


<!-- Page Hero Banner -->
<section class="page-hero">
    <h1>Book Appointment</h1>
    <div class="breadcrumb-row">
        <a href="index.php">Home</a>
        <span>&#8250;</span>
        <span>Book Appointment</span>
    </div>
</section>


<!-- Booking Section -->
<section class="booking-page">
    <div class="container">
        <div class="row">


            <!-- Left Column: Booking Form -->
            <div class="col-lg-7 booking-form-col">

                <!-- Form is shown by default, confirm message shown after submit -->
                <div id="bookingFormContainer">

                    <h2 class="booking-title">Reserve Your <em>Session</em></h2>
                    <p class="booking-subtitle">
                        Fill in the details below and we will confirm your appointment within 24 hours.
                    </p>

                    <!--
                        NOTE: action points to booking_submit.php (build this file later with PHP + MySQL)
                        JS currently intercepts submit to show confirmation message
                        When backend is ready: remove e.preventDefault() and let the form POST normally
                    -->
                    <form id="bookingForm" action="booking_submit.php" method="POST" autocomplete="off">


                        <!-- Step 1: Personal Info -->
                        <div class="step-heading">
                            <div class="step-num">1</div>
                            Personal Information
                            <div class="step-line"></div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-sm-6">
                                <label class="form-label" for="first_name">First Name</label>
                                <input type="text" id="first_name" name="first_name" class="form-control" placeholder="First Name" required>
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label" for="last_name">Last Name</label>
                                <input type="text" id="last_name" name="last_name" class="form-control" placeholder="Last Name" required>
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-sm-6">
                                <label class="form-label" for="phone">Phone Number</label>
                                <input type="tel" id="phone" name="phone" class="form-control" placeholder="+92 300 000 0000" required>
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label" for="email">Email Address</label>
                                <input type="email" id="email" name="email" class="form-control" placeholder="you@email.com">
                            </div>
                        </div>


                        <!-- Step 2: Service Selection -->
                        <div class="step-heading">
                            <div class="step-num">2</div>
                            Choose Your Service
                            <div class="step-line"></div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="service">Service</label>
                            <select id="service" name="service" class="form-select" required>
                                <option value="" disabled selected>Select a service</option>
                                <optgroup label="Hair">
                                    <option value="basic_haircut">Basic Haircut</option>
                                    <option value="haircut_blowdry">Haircut &amp; Blow Dry</option>
                                    <option value="keratin">Keratin Treatment</option>
                                    <option value="hair_color">Hair Coloring</option>
                                </optgroup>
                                <optgroup label="Facial Care">
                                    <option value="deep_cleansing">Deep Cleansing Facial</option>
                                    <option value="whitening_facial">Whitening Facial</option>
                                    <option value="anti_aging">Anti-Aging Treatment</option>
                                    <option value="gold_facial">Gold Facial</option>
                                </optgroup>
                                <optgroup label="Nail Care">
                                    <option value="classic_mani">Classic Manicure</option>
                                    <option value="moroccan_mani">Moroccan Manicure</option>
                                    <option value="classic_pedi">Classic Pedicure</option>
                                    <option value="gel_extensions">Gel Nail Extensions</option>
                                </optgroup>
                                <optgroup label="Head Massage">
                                    <option value="classic_massage">Classic Head Massage</option>
                                    <option value="deep_tissue">Deep Tissue Scalp</option>
                                    <option value="moroccan_oil">Moroccan Oil Treatment</option>
                                    <option value="head_neck">Head &amp; Neck Combo</option>
                                </optgroup>
                                <optgroup label="Spa">
                                    <option value="body_scrub">Full Body Scrub</option>
                                    <option value="aromatherapy">Aromatherapy Wrap</option>
                                    <option value="swedish">Swedish Massage</option>
                                    <option value="luxury_spa">Luxury Spa Package</option>
                                </optgroup>
                                <optgroup label="Bridal">
                                    <option value="bridal_makeup">Bridal Makeup</option>
                                    <option value="bridal_hair">Bridal Hair Styling</option>
                                    <option value="party_glam">Party Glam Package</option>
                                    <option value="full_bridal">Full Bridal Package</option>
                                </optgroup>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label" for="stylist">Stylist Preference</label>
                            <select id="stylist" name="stylist" class="form-select">
                                <option value="" selected>No preference</option>
                                <option value="ahmed">Ahmed Khan — Senior Barber</option>
                                <option value="sara">Sara Ali — Lead Stylist</option>
                                <option value="zain">Zain Malik — Junior Barber</option>
                            </select>
                        </div>


                        <!-- Step 3: Date and Time -->
                        <div class="step-heading">
                            <div class="step-num">3</div>
                            Pick a Date &amp; Time
                            <div class="step-line"></div>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-sm-6">
                                <label class="form-label" for="appt_date">Preferred Date</label>
                                <input type="date" id="appt_date" name="appt_date" class="form-control" required>
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label" for="appt_time">Preferred Time</label>
                                <input type="time" id="appt_time" name="appt_time" class="form-control" required>
                            </div>
                        </div>


                        <!-- Step 4: Notes -->
                        <div class="step-heading">
                            <div class="step-num">4</div>
                            Additional Notes
                            <div class="step-line"></div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label" for="notes">Special Requests (Optional)</label>
                            <textarea id="notes" name="notes" class="form-control" rows="4" placeholder="Any allergies, special requests, or details we should know..."></textarea>
                        </div>


                        <button type="submit" class="btn-book-submit">Confirm Appointment</button>

                    </form>
                </div>


                <!-- Confirmation shown after form submit -->
                <div class="confirm-overlay" id="confirmMsg">
                    <div class="confirm-icon">✓</div>
                    <h2>Appointment <em>Requested</em></h2>
                    <p>
                        Thank you! Your appointment request has been received.<br>
                        We will confirm via phone or email within 24 hours.
                    </p>
                    <a href="index.php" class="btn-outline-gold">Back to Home</a>
                </div>

            </div>


            <!-- Right Column: Info Panel -->
            <div class="col-lg-5 booking-info-col">

                <h3 class="info-panel-title">Good to <em>Know</em></h3>

                <div class="info-item">
                    <div class="info-item-icon">◎</div>
                    <div class="info-item-text">
                        <h5>Confirmation</h5>
                        <p>We confirm appointments within 24 hours via phone or email.</p>
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-item-icon">◆</div>
                    <div class="info-item-text">
                        <h5>Cancellation Policy</h5>
                        <p>Please cancel at least 6 hours before your appointment to avoid charges.</p>
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-item-icon">✦</div>
                    <div class="info-item-text">
                        <h5>Arrive Early</h5>
                        <p>We recommend arriving 10 minutes early so we can prepare for your session.</p>
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-item-icon">✂</div>
                    <div class="info-item-text">
                        <h5>Walk-ins Welcome</h5>
                        <p>No appointment? Walk-ins are accepted based on stylist availability.</p>
                    </div>
                </div>

                <div class="hours-list">
                    <h5>Opening Hours</h5>
                    <div class="hours-row">
                        <span class="day">Mon – Thu</span>
                        <span>10:00 AM – 6:00 PM</span>
                    </div>
                    <div class="hours-row">
                        <span class="day">Fri – Sat</span>
                        <span>10:00 AM – 8:00 PM</span>
                    </div>
                    <div class="hours-row">
                        <span class="day">Sunday</span>
                        <span>12:00 PM – 6:00 PM</span>
                    </div>
                </div>

            </div>


        </div>
    </div>
</section>


<?php include('includes/footer.php'); ?>


<script>

    /* Set minimum date to today so past dates cant be selected */
    const dateInput = document.getElementById('appt_date');
    const today = new Date().toISOString().split('T')[0];
    dateInput.setAttribute('min', today);

    /* Booking Form Submit Handler */
    document.getElementById('bookingForm').addEventListener('submit', function(e) {
        e.preventDefault();
        document.getElementById('bookingFormContainer').style.display = 'none';
        document.getElementById('confirmMsg').style.display = 'block';
    });

</script>


<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/script.js"></script>

</body>
</html>