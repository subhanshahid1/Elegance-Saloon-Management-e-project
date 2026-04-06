<?php require_once 'config/config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contact Us | Elegance Salon</title>

  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/style.css">

  <!-- Font Awesome for contact icons -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

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
    .breadcrumb-row span { color: var(--primary-gold); }


    /* Contact Section */
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

    .col-subtext a {
      color: var(--primary-gold);
      text-decoration: none;
    }

    .col-subtext a:hover {
      text-decoration: underline;
    }

    .divider-col {
      border-left: 1px solid #222;
    }


    /* Form Styles */
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
      transition: var(--trans-std);
      display: block;
    }

    .btn-gold:hover {
      background: var(--text-white);
      border-color: var(--text-white);
      transform: translateY(-3px);
    }


    /* Info Blocks */
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

    .info-block p,
    .info-block a {
      font-size: 14px;
      color: var(--text-silver);
      line-height: 1.8;
      text-decoration: none;
      transition: var(--trans-std);
      display: block;
    }

    .info-block a:hover {
      color: var(--primary-gold);
      padding-left: 5px;
    }

    .info-icon {
      color: var(--primary-gold);
      margin-right: 8px;
      font-size: 13px;
    }


    /* Hours Grid */
    .hours-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 8px 1.5rem;
      font-size: 14px;
    }

    .hours-grid .day  { color: var(--text-silver); }
    .hours-grid .time { color: var(--text-muted); text-align: right; }


    /* Social Chips */
    .social-chips {
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
      margin-top: 1rem;
    }

    .social-chip {
      font-size: 11px;
      letter-spacing: 1px;
      text-transform: lowercase;
      color: var(--text-muted);
      border: 1px solid #333;
      padding: 6px 16px;
      border-radius: 4px;
      text-decoration: none;
      transition: var(--trans-std);
    }

    .social-chip:hover {
      color: var(--primary-gold);
      border-color: var(--primary-gold);
      transform: translateY(-2px);
    }


    /* Map */
    .map-wrapper {
      margin-top: 2rem;
      border: 1px solid var(--dark-gold);
      border-radius: 4px;
      overflow: hidden;
    }

    .map-wrapper iframe {
      display: block;
      filter: grayscale(100%) invert(90%) contrast(90%);
    }


    /* Mobile */
    @media (max-width: 991px) {
      .divider-col { border-left: none; }
      .info-col {
        border-top: 1px solid #222;
        padding-top: 3rem;
        margin-top: 2rem;
      }
    }

  </style>
</head>
<body>

<?php include('includes/header.php'); ?>


<!-- Page Hero Banner -->
<section class="page-hero">
  <h1>Contact Us</h1>
  <div class="breadcrumb-row">
    <a href="index.php">Home</a>
    <span>&#8250;</span>
    <span>Contact Us</span>
  </div>
</section>


<!-- Contact Section -->
<section class="contact-section">
  <div class="container">
    <div class="row g-0">


      <!-- Left Column: Contact Form -->
      <div class="col-12 col-md-6 pe-md-5 pb-5 pb-md-0">

        <h2 class="col-heading">Send a <em>Message</em></h2>
        <p class="col-subtext">
          Have a question or want to get in touch? Fill the form below.<br>
          Looking to book an appointment? <a href="booking.php">Visit our booking page.</a>
        </p>

        <form action="contact_submit.php" method="POST">

          <div class="row g-3 mb-3">
            <div class="col-12 col-sm-6">
              <label class="form-label">First Name</label>
              <input type="text" name="first_name" class="form-control" placeholder="First Name" required>
            </div>
            <div class="col-12 col-sm-6">
              <label class="form-label">Last Name</label>
              <input type="text" name="last_name" class="form-control" placeholder="Last Name" required>
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label">Email Address</label>
            <input type="email" name="email" class="form-control" placeholder="you@email.com" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Phone Number</label>
            <input type="tel" name="phone" class="form-control" placeholder="+92 300 000 0000">
          </div>

          <div class="mb-3">
            <label class="form-label">Subject</label>
            <select name="subject" class="form-select" required>
              <option value="" disabled selected>Select a topic</option>
              <option value="inquiry">Service Inquiry</option>
              <option value="pricing">Pricing</option>
              <option value="feedback">Feedback</option>
              <option value="other">Other</option>
            </select>
          </div>

          <div class="mb-4">
            <label class="form-label">Your Message</label>
            <textarea name="message" class="form-control" placeholder="Write your message here..." rows="5" required></textarea>
          </div>

          <button type="submit" class="btn-gold">Send Message</button>

        </form>
      </div>


      <!-- Right Column: Info and Map -->
      <div class="col-12 col-md-6 ps-md-5 info-col divider-col">

        <h2 class="col-heading">Visit <em>Us</em></h2>
        <p class="col-subtext">We are open 7 days a week. Come visit us or reach out anytime.</p>

        <div class="info-block">
          <div class="info-block-title">Address</div>
          <p>
            <i class="fa-solid fa-location-dot info-icon"></i>
            C1 - Tariq Center Tariq Rd,<br>
            Block 2 P.E.C.H.S., Karachi, Pakistan
          </p>
        </div>

        <div class="info-block">
          <div class="info-block-title">Contact</div>
          <p>
            <i class="fa-solid fa-phone info-icon"></i>
            <a href="tel:+922134530829">+92 21 345 308 29</a>
          </p>
          <p>
            <i class="fa-solid fa-envelope info-icon"></i>
            <a href="mailto:hello@elegancesalon.pk">hello@elegancesalon.pk</a>
          </p>
        </div>

        <div class="info-block">
          <div class="info-block-title">Opening Hours</div>
          <div class="hours-grid">
            <span class="day">Mon – Thu</span>
            <span class="time">10:00 AM – 6:00 PM</span>
            <span class="day">Fri – Sat</span>
            <span class="time">10:00 AM – 8:00 PM</span>
            <span class="day">Sunday</span>
            <span class="time">12:00 PM – 6:00 PM</span>
          </div>
        </div>

        <div class="info-block">
          <div class="info-block-title">Follow Us</div>
          <div class="social-chips">
            <a href="#" class="social-chip">
              <i class="fa-brands fa-instagram me-1"></i> instagram
            </a>
            <a href="#" class="social-chip">
              <i class="fa-brands fa-facebook me-1"></i> facebook
            </a>
            <a href="#" class="social-chip">
              <i class="fa-brands fa-whatsapp me-1"></i> whatsapp
            </a>
          </div>
        </div>

        <div class="map-wrapper">
          <div class="ratio ratio-16x9">
            <iframe
              src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d14479.047326407388!2d67.04117059707642!3d24.87198274080208!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3eb33eeca8432bf5%3A0x81dece3730c9b1c5!2sAptech%20Computer%20Education%20Tariq%20Road!5e0!3m2!1sen!2sus!4v1775131076158!5m2!1sen!2sus"
              allowfullscreen=""
              loading="lazy"
              referrerpolicy="no-referrer-when-downgrade"
              title="Elegance Salon Location">
            </iframe>
          </div>
        </div>

      </div>


    </div>
  </div>
</section>


<?php include('includes/footer.php'); ?>

<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/script.js"></script>

</body>
</html>