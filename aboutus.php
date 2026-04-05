<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>About Us - Elegance Saloon</title>
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

    .breadcrumb-row span { color: var(--primary-gold); }


    /* About Section */
    .about {
      background: var(--bg-black);
      padding: 80px 0;
      font-family: var(--font-ui);
    }

    .about-left {
      display: flex;
      gap: 12px;
    }

    .img-col {
      display: flex;
      flex-direction: column;
      gap: 12px;
    }

    .img-box {
      width: 100%;
      max-width: 150px;
      height: 190px;
      background: var(--bg-card);
      border: 1px solid var(--dark-gold);
      border-radius: 4px;
      overflow: hidden;
    }

    .img-box img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: var(--trans-std);
    }

    .img-box:hover img { transform: scale(1.1); }
    .img-box.tall   { height: 290px; }
    .img-box.short  { height: 86px; }

    .tagline {
      font-size: 13px;
      color: var(--primary-gold);
      letter-spacing: 3px;
      text-transform: uppercase;
      margin-bottom: 6px;
      font-weight: bold;
    }

    .gold-line {
      width: 40px;
      height: 2px;
      background: var(--primary-gold);
      margin: 10px 0 18px;
    }

    .about-right h2 {
      font-size: 32px;
      color: var(--text-white);
      font-family: var(--font-primary);
      margin-bottom: 16px;
      line-height: 1.3;
    }

    .about-right p {
      font-size: 14px;
      color: var(--text-silver);
      line-height: 1.8;
      margin-bottom: 20px;
    }

    .gold-em { color: var(--primary-gold); font-style: normal; }

    .stats {
      display: flex;
      gap: 24px;
      margin-bottom: 28px;
    }

    .stat {
      text-align: center;
      border-left: 2px solid var(--primary-gold);
      padding-left: 14px;
    }

    .stat h3 {
      font-size: 26px;
      color: var(--primary-gold);
      font-family: var(--font-primary);
    }

    .stat p {
      font-size: 11px;
      color: var(--text-muted);
      letter-spacing: 1.5px;
      text-transform: uppercase;
      margin: 0;
    }

    .btn-custom {
      background: var(--primary-gold);
      color: #000;
      padding: 12px 30px;
      font-size: 12px;
      font-weight: bold;
      letter-spacing: 2px;
      text-transform: uppercase;
      border-radius: 4px;
      display: inline-block;
      text-decoration: none;
      transition: var(--trans-std);
    }

    .btn-custom:hover {
      background: var(--text-white);
      color: #000;
      transform: translateY(-3px);
    }


    /* History Section */
    .history {
      background: var(--bg-nav);
      border-top: 1px solid #222;
      border-bottom: 1px solid #222;
      padding: 80px 0;
      text-align: center;
    }

    .history-tag {
      font-size: 30px;
      color: var(--primary-gold);
      font-family: var(--font-primary);
      font-style: italic;
      margin-bottom: 10px;
    }

    .history h2 {
      font-size: clamp(2rem, 5vw, 45px);
      color: var(--text-white);
      font-family: var(--font-primary);
      letter-spacing: 4px;
      text-transform: uppercase;
      margin-bottom: 10px;
    }

    .history-line {
      width: 60px;
      height: 2px;
      background: var(--primary-gold);
      margin: 16px auto 28px;
    }

    .history p {
      font-size: 14px;
      color: var(--text-silver);
      line-height: 2;
    }


    /* Vision Section */
    .vision {
      background: var(--bg-black);
    }

    .vision-left {
      display: flex;
      flex-direction: column;
      justify-content: center;
      padding: 60px;
    }

    .vision-tag {
      font-size: 22px;
      color: var(--primary-gold);
      font-family: var(--font-primary);
      font-style: italic;
      margin-bottom: 14px;
    }

    .vision-left h2 {
      font-size: 34px;
      color: var(--text-white);
      font-family: var(--font-primary);
      margin-bottom: 24px;
      line-height: 1.3;
    }

    .vision-left p {
      font-size: 14px;
      color: var(--text-silver);
      line-height: 1.9;
      margin-bottom: 16px;
    }

    .vision-right {
      border-left: 2px solid var(--primary-gold);
      padding: 0;
    }

    .vision-right img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      display: block;
      min-height: 400px;
      filter: brightness(0.8);
    }


    /* Values Section */
    .values {
      background: #080808;
      padding: 80px 0;
      text-align: center;
    }

    .values h2 {
      font-family: var(--font-primary);
      font-size: clamp(2rem, 5vw, 2.6rem);
      color: var(--text-white);
      margin-bottom: 8px;
    }

    .values-sub {
      font-size: 11px;
      letter-spacing: 2px;
      text-transform: uppercase;
      color: var(--text-muted);
      margin-bottom: 50px;
    }

    .values-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
      gap: 25px;
      max-width: 1100px;
      margin: 0 auto;
    }

    .value-card {
      background: var(--bg-card);
      padding: 35px 25px;
      border: 1px solid rgba(212, 160, 23, 0.08);
      border-top: 3px solid var(--primary-gold);
      transition: 0.3s;
    }

    .value-card:hover {
      transform: translateY(-8px);
      border-color: var(--primary-gold);
    }

    .value-icon {
      font-size: 1.8rem;
      display: block;
      margin-bottom: 18px;
    }

    .value-card h4 {
      font-family: var(--font-primary);
      color: var(--primary-gold);
      font-size: 1.05rem;
      margin-bottom: 10px;
      text-transform: uppercase;
      letter-spacing: 1px;
    }

    .value-card p {
      font-size: 13px;
      color: var(--text-muted);
      line-height: 1.7;
      margin: 0;
    }


    /* Team Section */
    .team {
      background: var(--bg-black);
      padding: 80px 0;
      text-align: center;
    }

    .team-tag {
      font-size: 30px;
      color: var(--primary-gold);
      font-family: var(--font-primary);
      font-style: italic;
      margin-bottom: 8px;
    }

    .team h2 {
      font-size: 38px;
      color: var(--text-white);
      font-family: var(--font-primary);
      letter-spacing: 4px;
      text-transform: uppercase;
      margin-bottom: 45px;
    }

    .team-card {
      background: var(--bg-card);
      border: 1px solid #333;
      border-radius: 8px;
      overflow: hidden;
      transition: var(--trans-std);
      margin-bottom: 20px;
    }

    .team-card:hover {
      transform: translateY(-8px);
      border-color: var(--primary-gold);
    }

    .team-card-img {
      width: 100%;
      height: 250px;
      overflow: hidden;
      border-bottom: 2px solid var(--primary-gold);
    }

    .team-card-img img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .team-card-body { padding: 25px 20px; }

    .team-card-body h3 {
      font-size: 18px;
      color: var(--text-white);
      font-family: var(--font-primary);
      margin-bottom: 6px;
    }

    .card-role {
      font-size: 11px;
      color: var(--primary-gold);
      letter-spacing: 2px;
      text-transform: uppercase;
      margin-bottom: 12px;
      font-weight: bold;
    }

    .team-card-body p {
      font-size: 13px;
      color: var(--text-muted);
      line-height: 1.6;
      margin-bottom: 0;
    }


    /* Mobile */
    @media (max-width: 992px) {
      .vision-right { border-left: none; border-top: 2px solid var(--primary-gold); }
      .about-left { justify-content: center; margin-bottom: 40px; }
      .about-right { text-align: center; }
      .gold-line { margin: 10px auto 18px; }
      .stats { justify-content: center; }
      .vision-left { padding: 40px 20px; }
    }

  </style>
</head>
<body>

<?php include('includes/header.php'); ?>


<!-- Page Hero Banner -->
<section class="page-hero">
  <h1>About Us</h1>
  <div class="breadcrumb-row">
    <a href="index.php">Home</a>
    <span>&#8250;</span>
    <span>About Us</span>
  </div>
</section>


<!-- About Section -->
<section class="about">
  <div class="container">
    <div class="row align-items-center">

      <div class="col-lg-6">
        <div class="about-left">
          <div class="img-col">
            <div class="img-box tall">
              <img src="Eimages/about1.jpg" alt="Elegance Saloon Interior">
            </div>
            <div class="img-box short">
              <img src="Eimages/about3.jpg" alt="Styling">
            </div>
          </div>
          <div class="img-col" style="margin-top: 30px;">
            <div class="img-box short">
              <img src="Eimages/about4.jpg" alt="Grooming">
            </div>
            <div class="img-box tall">
              <img src="Eimages/about2.jpg" alt="Expert Team">
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-6">
        <div class="about-right">
          <div class="tagline">✦ The Journey</div>
          <h2>About <em class="gold-em">Elegance</em> Saloon</h2>
          <div class="gold-line"></div>
          <p>Over 14 years of excellence, Elegance Saloon has been crafting premium grooming experiences for every client. From sharp fades to luxurious treatments, we bring passion and precision to every chair.</p>
          <div class="stats">
            <div class="stat">
              <h3>14+</h3>
              <p>Years Experience</p>
            </div>
            <div class="stat">
              <h3>5K+</h3>
              <p>Happy Clients</p>
            </div>
            <div class="stat">
              <h3>10+</h3>
              <p>Expert Staff</p>
            </div>
          </div>
          <a href="booking.php" class="btn-custom">Book Appointment</a>
        </div>
      </div>

    </div>
  </div>
</section>


<!-- History Section -->
<section class="history">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-10">
        <div class="history-tag">Our History</div>
        <h2>14 Years of <em class="gold-em">Experience</em></h2>
        <div class="history-line"></div>
        <p>Established in 2010, Elegance Saloon was founded with a simple yet powerful vision — to bring premium grooming and styling to every client in Karachi. Starting as a small saloon, we have grown into one of the most trusted names in the grooming industry. Over 14 years of dedicated service, we have built a reputation for excellence, precision, and client satisfaction.</p>
      </div>
    </div>
  </div>
</section>


<!-- Vision Section -->
<section class="vision">
  <div class="container-fluid p-0">
    <div class="row g-0">

      <div class="col-lg-6 vision-left order-2 order-lg-1">
        <div class="vision-tag">Our Vision</div>
        <h2>Reflection of your <em class="gold-em">Elegance</em></h2>
        <div class="gold-line"></div>
        <p>Our vision is to inspire our clients and lead the grooming industry with pride, integrity and respect. We strive to deliver excellence in every service we offer.</p>
        <p>Our promise is to empower our clients with confidence and style — helping them look and feel their absolute best, every single visit.</p>
      </div>

      <div class="col-lg-6 vision-right order-1 order-lg-2">
        <img src="Eimages/about5.jpg" alt="Elegance Saloon">
      </div>

    </div>
  </div>
</section>


<!-- Values Section -->
<section class="values">
  <div class="container">
    <h2>Our <em class="gold-em">Values</em></h2>
    <p class="values-sub">What we stand for every single day</p>

    <div class="values-grid">

      <div class="value-card">
        <span class="value-icon">✂</span>
        <h4>Precision</h4>
        <p>Every cut, every treatment is executed with focus and skill — no shortcuts, ever.</p>
      </div>

      <div class="value-card">
        <span class="value-icon">◆</span>
        <h4>Hygiene</h4>
        <p>A clean environment is non-negotiable. We maintain the highest standards at all times.</p>
      </div>

      <div class="value-card">
        <span class="value-icon">✦</span>
        <h4>Respect</h4>
        <p>Every client deserves to feel valued and comfortable from the moment they walk in.</p>
      </div>

      <div class="value-card">
        <span class="value-icon">◎</span>
        <h4>Excellence</h4>
        <p>We never settle for average. Premium results is the only standard we know.</p>
      </div>

    </div>
  </div>
</section>


<!-- Team Section -->
<section class="team">
  <div class="container">
    <div class="row mb-5">
      <div class="col-12">
        <div class="team-tag">Our Team</div>
        <h2>Behind the <em class="gold-em">Magic</em></h2>
      </div>
    </div>

    <div class="row g-4 justify-content-center">

      <div class="col-md-4">
        <div class="team-card">
          <div class="team-card-img">
            <img src="Eimages/about6.jpg" alt="Ahmed Khan">
          </div>
          <div class="team-card-body">
            <h3>Ahmed Khan</h3>
            <div class="card-role">Senior Barber</div>
            <p>Ahmed has over 10 years of experience in precision cuts and classic shaving.</p>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="team-card">
          <div class="team-card-img">
            <img src="Eimages/about7.jpg" alt="Sara Ali">
          </div>
          <div class="team-card-body">
            <h3>Sara Ali</h3>
            <div class="card-role">Lead Stylist</div>
            <p>Sara is a certified hair stylist specialized in color and bridal styling.</p>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="team-card">
          <div class="team-card-img">
            <img src="Eimages/about8.jpg" alt="Zain Malik">
          </div>
          <div class="team-card-body">
            <h3>Zain Malik</h3>
            <div class="card-role">Junior Barber</div>
            <p>Zain brings creativity and precision to every modern haircut.</p>
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