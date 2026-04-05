<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elegance Saloon | Premium Grooming & Styling</title>

    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">

    <style>

        /* Global Mobile Fix */
        html, body {
            max-width: 100%;
            overflow-x: hidden;
            position: relative;
        }


        /* Banner */
        .banner {
            position: relative;
            width: 100%;
            height: 70vh;
            min-height: 450px;
            overflow: hidden;
            background: #000;
        }

        @media (min-width: 992px) {
            .banner { height: 85vh; }
        }

        .carousel-track {
            display: flex;
            width: 300%;
            height: 100%;
            transition: transform 0.8s cubic-bezier(0.4, 0, 0.2, 1);
            will-change: transform;
        }

        .slide {
            flex: 0 0 33.333%;
            width: 33.333%;
            height: 100%;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .overlay {
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 10;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 0 5%;
        }

        .overlay h1 {
            font-family: var(--font-primary);
            font-size: clamp(2.2rem, 10vw, 5.5rem);
            letter-spacing: clamp(5px, 2vw, 15px);
            margin-bottom: 15px;
            color: var(--primary-gold);
            text-transform: uppercase;
        }

        .overlay p {
            max-width: 650px;
            margin-bottom: 30px;
            font-size: clamp(0.85rem, 2.5vw, 1.2rem);
            color: var(--text-silver);
            line-height: 1.6;
        }

        .btn-book {
            padding: 15px 40px;
            background: var(--primary-gold);
            color: #000;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 2px;
            text-decoration: none;
            transition: 0.3s;
            display: inline-block;
        }

        .btn-book:hover {
            background: #fff;
            transform: translateY(-3px);
            color: #000;
        }

        .arrow {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            z-index: 20;
            background: rgba(0, 0, 0, 0.3);
            color: #fff;
            border: 1px solid rgba(212, 160, 23, 0.3);
            padding: 15px 20px;
            cursor: pointer;
            transition: 0.3s;
        }

        .arrow:hover { background: var(--primary-gold); color: #000; }
        .prev { left: 15px; }
        .next { right: 15px; }

        @media (max-width: 768px) {
            .arrow { display: none; }
        }


        /* Stats Bar */
        .stats-bar {
            background: #0d0d0d;
            border-bottom: 1px solid rgba(212, 160, 23, 0.15);
            padding: 25px 5%;
        }

        .stats-inner {
            max-width: var(--container-width);
            margin: 0 auto;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
            gap: 0;
        }

        .stat-item {
            text-align: center;
            padding: 10px 40px;
            border-right: 1px solid rgba(212, 160, 23, 0.2);
        }

        .stat-item:last-child {
            border-right: none;
        }

        .stat-number {
            font-family: var(--font-primary);
            font-size: clamp(1.6rem, 4vw, 2.2rem);
            color: var(--primary-gold);
            display: block;
            line-height: 1;
        }

        .stat-label {
            font-size: 11px;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--text-muted);
            margin-top: 6px;
            display: block;
        }

        @media (max-width: 576px) {
            .stat-item {
                width: 50%;
                border-right: none;
                border-bottom: 1px solid rgba(212, 160, 23, 0.1);
                padding: 15px 10px;
            }

            .stat-item:nth-child(odd) {
                border-right: 1px solid rgba(212, 160, 23, 0.1);
            }
        }


        /* Intro Section */
        .hero-section {
            display: flex;
            align-items: center;
            gap: 50px;
            flex-wrap: wrap;
            padding: clamp(50px, 10vh, 100px) 5%;
            max-width: var(--container-width);
            margin: 0 auto;
        }

        .content-box { flex: 1; min-width: 300px; }

        .content-box h1 {
            font-size: clamp(2rem, 5vw, 3.5rem);
            font-family: var(--font-primary);
            margin-bottom: 25px;
            line-height: 1.1;
        }

        .highlight { color: var(--primary-gold); }

        .content-box p {
            color: var(--text-silver);
            margin-bottom: 30px;
            line-height: 1.8;
        }

        .btn-outline {
            border: 1px solid var(--primary-gold);
            padding: 10px 25px;
            color: var(--primary-gold);
            text-transform: uppercase;
            font-weight: bold;
            text-decoration: none;
            display: inline-block;
            transition: 0.3s;
        }

        .btn-outline:hover {
            background: var(--primary-gold);
            color: #000;
        }

        .image-container {
            flex: 1.2;
            position: relative;
            height: 500px;
            min-width: 300px;
        }

        .img-wrapper {
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.5);
            position: absolute;
        }

        .img-main  { width: 75%; right: 0; top: 0; z-index: 2; height: 80%; }
        .img-left  { width: 45%; left: 0; bottom: 30px; z-index: 3; border: 4px solid #000; height: 50%; }
        .img-right { width: 30%; right: 5%; bottom: -10px; z-index: 1; opacity: 0.5; height: 40%; }

        .img-wrapper img { width: 100%; height: 100%; object-fit: cover; }


        /* For Everyone Services */
        .for-everyone {
            padding: 80px 0;
            text-align: center;
            background: #080808;
        }

        .for-everyone h2 {
            font-family: var(--font-primary);
            font-size: clamp(2rem, 5vw, 3rem);
            margin-bottom: 50px;
            text-transform: uppercase;
        }

        .services-layout {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: flex-start;
            gap: 30px;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .circle-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 180px;
        }

        .circle-frame {
            width: 160px;
            height: 160px;
            border-radius: 50%;
            overflow: hidden;
            border: 2px solid rgba(212, 160, 23, 0.2);
            margin-bottom: 15px;
            transition: 0.3s;
        }

        .circle-frame img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            filter: brightness(0.8);
        }

        .circle-item p {
            font-size: 12px;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--text-silver);
        }

        .circle-item:hover .circle-frame {
            border-color: var(--primary-gold);
            transform: translateY(-10px);
        }

        .services-view-all {
            margin-top: 40px;
        }


        /* Hot Deals */
        .deals-section {
            padding: 80px 5%;
            background: radial-gradient(circle at top, #111 0%, #000 100%);
        }

        .deals-header {
            text-align: center;
            margin-bottom: 50px;
        }

        .section-title {
            font-family: var(--font-primary);
            font-size: clamp(2rem, 5vw, 2.8rem);
            color: var(--primary-gold);
        }

        .subtitle-wrapper {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
            margin-top: 10px;
            color: var(--text-muted);
            font-size: 11px;
            letter-spacing: 2px;
        }

        .line {
            width: 40px;
            height: 1px;
            background: var(--primary-gold);
        }

        .deals-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .deal-card {
            background: #111;
            border-radius: 15px;
            overflow: hidden;
            border: 1px solid rgba(212, 160, 23, 0.1);
            transition: 0.3s;
            display: flex;
            flex-direction: column;
        }

        .deal-card:hover {
            transform: translateY(-10px);
            border-color: var(--primary-gold);
        }

        .deal-banner {
            background: rgba(212, 160, 23, 0.08);
            color: var(--primary-gold);
            padding: 10px;
            text-align: center;
            font-weight: bold;
            font-size: 14px;
            letter-spacing: 2px;
        }

        .deal-badge {
            display: inline-block;
            background: var(--primary-gold);
            color: #000;
            font-size: 10px;
            font-weight: bold;
            letter-spacing: 1px;
            padding: 2px 8px;
            margin-bottom: 12px;
            text-transform: uppercase;
        }

        .deal-content { padding: 25px 30px; flex-grow: 1; }

        .deal-content h4 {
            color: var(--primary-gold);
            font-weight: bold;
            margin-bottom: 15px;
            font-size: 15px;
            letter-spacing: 1px;
        }

        .deal-content ul li {
            list-style: none;
            color: var(--text-silver);
            font-size: 14px;
            margin-bottom: 10px;
            position: relative;
            padding-left: 20px;
        }

        .deal-content ul li::before {
            content: "✦";
            position: absolute;
            left: 0;
            color: var(--primary-gold);
        }

        .price-footer {
            margin-top: auto;
            border-top: 1px solid #222;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 25px;
        }

        .price { font-weight: bold; color: #fff; font-size: 1.2rem; }

        .book-btn {
            color: var(--primary-gold);
            font-weight: bold;
            font-size: 12px;
            text-transform: uppercase;
            text-decoration: none;
            letter-spacing: 1px;
            transition: 0.3s;
        }

        .book-btn:hover { color: #fff; }


        /* Why Choose Us */
        .why-us {
            padding: 80px 5%;
            background: #080808;
        }

        .why-us-header {
            text-align: center;
            margin-bottom: 50px;
        }

        .why-us-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 30px;
            max-width: 1100px;
            margin: 0 auto;
        }

        .why-card {
            background: var(--bg-card);
            padding: 40px 30px;
            text-align: center;
            border: 1px solid rgba(212, 160, 23, 0.08);
            border-top: 3px solid var(--primary-gold);
            transition: 0.3s;
        }

        .why-card:hover {
            transform: translateY(-8px);
            border-color: var(--primary-gold);
        }

        .why-icon {
            font-size: 2rem;
            margin-bottom: 20px;
            display: block;
        }

        .why-card h4 {
            font-family: var(--font-primary);
            color: var(--primary-gold);
            font-size: 1.1rem;
            margin-bottom: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .why-card p {
            color: var(--text-muted);
            font-size: 14px;
            line-height: 1.7;
            margin: 0;
        }


        /* Testimonials */
        .testimonials {
            padding: 80px 5%;
            text-align: center;
        }

        .testimonial-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            max-width: 1200px;
            margin: 50px auto 0;
        }

        .testi-card {
            background: #111;
            padding: 40px;
            border-radius: 10px;
            border-bottom: 4px solid var(--primary-gold);
            text-align: left;
        }

        .stars {
            color: var(--primary-gold);
            font-size: 14px;
            letter-spacing: 3px;
            margin-bottom: 18px;
            display: block;
        }

        .review-text {
            font-style: italic;
            color: var(--text-silver);
            margin-bottom: 20px;
            font-size: 15px;
            line-height: 1.7;
        }

        .client-name {
            color: var(--primary-gold);
            font-size: 14px;
            font-weight: bold;
            letter-spacing: 1px;
            text-transform: uppercase;
        }


        /* Final CTA */
        .cta-section {
            padding: 100px 5%;
            text-align: center;
            background: linear-gradient(to bottom, #111, #000);
            border-top: 1px solid rgba(212, 160, 23, 0.1);
        }

        .cta-section h2 {
            font-family: var(--font-primary);
            font-size: clamp(2rem, 5vw, 3.2rem);
            margin-bottom: 15px;
        }

        .cta-section p {
            color: var(--text-muted);
            font-size: 15px;
            margin-bottom: 40px;
            max-width: 500px;
            margin-left: auto;
            margin-right: auto;
        }


        /* Mobile */
        @media (max-width: 768px) {
            .hero-section { flex-direction: column-reverse; text-align: center; padding-top: 40px; }
            .image-container { width: 100%; height: 350px; }
            .img-left, .img-right { display: none; }
            .img-main { width: 100%; height: 100%; }
            .circle-item { width: 45%; }
        }

        @media (max-width: 480px) {
            .circle-item { width: 100%; }
            .overlay h1 { letter-spacing: 5px; }
        }

    </style>
</head>
<body>

    <?php include('includes/header.php'); ?>


    <!-- Banner -->
    <section class="banner">
        <button class="arrow prev">&#10094;</button>
        <button class="arrow next">&#10095;</button>

        <div class="overlay">
            <h1>ELEGANCE</h1>
            <p>Luxury hair styling and premium grooming for those who appreciate the finer things in life.</p>
            <a href="booking.php" class="btn-book">Book Appointment</a>
        </div>

        <div class="carousel-track" id="track">
            <div class="slide" style="background-image: url('https://images.unsplash.com/photo-1560066984-138dadb4c035?q=80&w=1600')"></div>
            <div class="slide" style="background-image: url('https://images.unsplash.com/photo-1521590832167-7bcbfaa6381f?q=80&w=1600')"></div>
            <div class="slide" style="background-image: url('https://images.unsplash.com/photo-1562322140-8baeececf3df?q=80&w=1600')"></div>
        </div>
    </section>


    <!-- Stats Bar -->
    <section class="stats-bar">
        <div class="stats-inner">
            <div class="stat-item">
                <span class="stat-number">500+</span>
                <span class="stat-label">Happy Clients</span>
            </div>
            <div class="stat-item">
                <span class="stat-number">12+</span>
                <span class="stat-label">Expert Stylists</span>
            </div>
            <div class="stat-item">
                <span class="stat-number">5 ★</span>
                <span class="stat-label">Google Rating</span>
            </div>
            <div class="stat-item">
                <span class="stat-number">Est. 2015</span>
                <span class="stat-label">Years of Excellence</span>
            </div>
        </div>
    </section>


    <!-- Intro Section -->
    <section class="hero-section">
        <div class="content-box">
            <h1>Welcome To <span class="highlight">Elegance</span> Salon</h1>
            <p>
                Experience the art of grooming. At Elegance, we combine traditional craftsmanship with modern styling
                to give you a look that is uniquely yours. Our expert team is dedicated to providing
                a high-end experience in a relaxing environment.
            </p>
            <a href="aboutus.php" class="btn-outline">Learn More</a>
        </div>

        <div class="image-container">
            <div class="img-wrapper img-main">
                <img src="https://images.unsplash.com/photo-1562322140-8baeececf3df?auto=format&fit=crop&w=800&q=80" alt="Main Salon">
            </div>
            <div class="img-wrapper img-left">
                <img src="https://images.unsplash.com/photo-1595476108010-b4d1f102b1b1?auto=format&fit=crop&w=600&q=80" alt="Styling">
            </div>
            <div class="img-wrapper img-right">
                <img src="https://images.unsplash.com/photo-1512290923902-8a9f81dc236c?auto=format&fit=crop&w=400&q=80" alt="Facial">
            </div>
        </div>
    </section>


    <!-- For Everyone Services -->
    <section class="for-everyone">
        <div class="container">
            <h2>For <span class="highlight">Everyone</span></h2>
            <div class="services-layout">

                <div class="circle-item">
                    <div class="circle-frame">
                        <img src="https://images.unsplash.com/photo-1562322140-8baeececf3df?q=80&w=400" alt="Hair Cut">
                    </div>
                    <p>Hair Cut</p>
                </div>

                <div class="circle-item">
                    <div class="circle-frame">
                        <img src="https://images.unsplash.com/photo-1604654894610-df49ff668781?q=80&w=400" alt="Nails">
                    </div>
                    <p>Nails</p>
                </div>

                <div class="circle-item">
                    <div class="circle-frame">
                        <img src="https://images.unsplash.com/photo-1544161515-4ab6ce6db874?q=80&w=400" alt="Massage">
                    </div>
                    <p>Massage</p>
                </div>

                <div class="circle-item">
                    <div class="circle-frame">
                        <img src="https://images.unsplash.com/photo-1512290923902-8a9f81dc236c?q=80&w=400" alt="Facial">
                    </div>
                    <p>Facials</p>
                </div>

            </div>

            <div class="services-view-all">
                <a href="services.php" class="btn-outline">View All Services</a>
            </div>
        </div>
    </section>


    <!-- Hot Deals -->
    <section class="deals-section">
        <div class="deals-header">
            <h2 class="section-title">Hot Deals</h2>
            <div class="subtitle-wrapper">
                <span class="line"></span>
                <span>LIMITED TIME OFFERS — BOOK VIA WHATSAPP</span>
                <span class="line"></span>
            </div>
        </div>

        <div class="deals-container">

            <div class="deal-card">
                <div class="deal-banner">DEAL — 01</div>
                <div class="deal-content">
                    <span class="deal-badge">Save 30%</span>
                    <h4>Refresh Package</h4>
                    <ul>
                        <li>Deep Cleansing Facial</li>
                        <li>Face Whitening Polish</li>
                        <li>Whitening Serum</li>
                    </ul>
                </div>
                <div class="price-footer">
                    <span class="price">Rs. 999</span>
                    <a href="booking.php" class="book-btn">Book Now</a>
                </div>
            </div>

            <div class="deal-card">
                <div class="deal-banner">DEAL — 02</div>
                <div class="deal-content">
                    <span class="deal-badge">Save 20%</span>
                    <h4>Luxury Care</h4>
                    <ul>
                        <li>Moroccan Manicure</li>
                        <li>Moroccan Pedicure</li>
                        <li>Hands & Feet Polish</li>
                    </ul>
                </div>
                <div class="price-footer">
                    <span class="price">Rs. 4999</span>
                    <a href="booking.php" class="book-btn">Book Now</a>
                </div>
            </div>

            <div class="deal-card">
                <div class="deal-banner">DEAL — 03</div>
                <div class="deal-content">
                    <span class="deal-badge">Best Value</span>
                    <h4>Style Combo</h4>
                    <ul>
                        <li>Haircut & Blow Dry</li>
                        <li>Keratin Treatment</li>
                        <li>Deep Conditioning</li>
                    </ul>
                </div>
                <div class="price-footer">
                    <span class="price">Rs. 2999</span>
                    <a href="booking.php" class="book-btn">Book Now</a>
                </div>
            </div>

        </div>
    </section>


    <!-- Why Choose Us -->
    <section class="why-us">
        <div class="why-us-header">
            <h2 class="section-title">Why <span style="color: #fff;">Choose</span> Us</h2>
            <div class="subtitle-wrapper" style="margin-top: 10px;">
                <span class="line"></span>
                <span>WHAT SETS US APART</span>
                <span class="line"></span>
            </div>
        </div>

        <div class="why-us-grid">

            <div class="why-card">
                <span class="why-icon">✂</span>
                <h4>Expert Stylists</h4>
                <p>Our team is trained in the latest techniques with years of hands-on experience.</p>
            </div>

            <div class="why-card">
                <span class="why-icon">✦</span>
                <h4>Premium Products</h4>
                <p>We use only top-tier, dermatologist-approved products for every treatment.</p>
            </div>

            <div class="why-card">
                <span class="why-icon">◆</span>
                <h4>Clean Environment</h4>
                <p>Our salon is maintained to the highest hygiene standards for your comfort.</p>
            </div>

            <div class="why-card">
                <span class="why-icon">◎</span>
                <h4>Affordable Pricing</h4>
                <p>Luxury doesn't have to break the bank. We offer premium service at fair prices.</p>
            </div>

        </div>
    </section>


    <!-- Testimonials -->
    <section class="testimonials">
        <h2 style="font-family: var(--font-primary); font-size: clamp(2rem, 5vw, 2.8rem);">
            What Our <span class="highlight">Clients</span> Say
        </h2>
        <p style="color: var(--text-muted); font-size: 13px; letter-spacing: 2px; text-transform: uppercase; margin-top: 10px;">
            Real reviews from real clients
        </p>

        <div class="testimonial-grid">

            <div class="testi-card">
                <span class="stars">★★★★★</span>
                <p class="review-text">"The best salon experience in the city. The attention to detail and professional service is unmatched."</p>
                <h4 class="client-name">Aiman Fahad</h4>
            </div>

            <div class="testi-card">
                <span class="stars">★★★★★</span>
                <p class="review-text">"Love their hair treatments. My hair has never looked this healthy and shiny before!"</p>
                <h4 class="client-name">Faiza Tahir</h4>
            </div>

            <div class="testi-card">
                <span class="stars">★★★★★</span>
                <p class="review-text">"Quick, professional, and excellent results. Highly recommended for facial treatments."</p>
                <h4 class="client-name">Ramsha Faizan</h4>
            </div>

        </div>
    </section>


    <!-- Final CTA -->
    <section class="cta-section">
        <h2>Ready for a <span class="highlight">New Look?</span></h2>
        <p>Book your appointment today and let our experts take care of the rest.</p>
        <a href="booking.php" class="btn-book">Book Appointment</a>
    </section>


    <?php include('includes/footer.php'); ?>


    <script>

        /* Carousel */
        let currentSlide = 0;
        const totalSlides = 3;
        const track = document.getElementById('track');

        function moveSlide(step) {
            currentSlide = (currentSlide + step + totalSlides) % totalSlides;
            track.style.transform = `translateX(-${currentSlide * 33.33333}%)`;
        }

        let slideTimer = setInterval(() => moveSlide(1), 5000);

        function manualMove(step) {
            clearInterval(slideTimer);
            moveSlide(step);
            slideTimer = setInterval(() => moveSlide(1), 5000);
        }

        document.querySelector('.prev').onclick = () => manualMove(-1);
        document.querySelector('.next').onclick = () => manualMove(1);

    </script>

    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/script.js"></script>

</body>
</html>