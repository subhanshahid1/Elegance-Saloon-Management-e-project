<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Services - Elegance Saloon</title>

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">

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


        /* Services Filter Nav */
        .services-nav {
            background: var(--bg-nav);
            border-bottom: 1px solid rgba(212, 160, 23, 0.15);
            padding: 0;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .services-nav-inner {
            max-width: var(--container-width);
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 0;
        }

        .nav-filter-btn {
            background: transparent;
            border: none;
            color: var(--text-muted);
            font-size: 11px;
            letter-spacing: 2px;
            text-transform: uppercase;
            padding: 18px 22px;
            cursor: pointer;
            transition: 0.3s;
            text-decoration: none;
            display: inline-block;
            border-bottom: 2px solid transparent;
        }

        .nav-filter-btn:hover {
            color: var(--primary-gold);
            border-bottom-color: var(--primary-gold);
        }

        .nav-filter-btn.active {
            color: var(--primary-gold);
            border-bottom-color: var(--primary-gold);
        }

        @media (max-width: 576px) {
            .nav-filter-btn {
                padding: 14px 12px;
                font-size: 10px;
            }
        }


        /* Section Header */
        .section-label {
            font-size: 11px;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: var(--primary-gold);
            font-weight: bold;
            display: block;
            margin-bottom: 10px;
        }

        .section-title {
            font-family: var(--font-primary);
            font-size: clamp(1.8rem, 4vw, 2.8rem);
            color: var(--text-white);
            margin-bottom: 15px;
            line-height: 1.2;
        }

        .section-title em {
            color: var(--primary-gold);
            font-style: normal;
        }

        .section-desc {
            font-size: 14px;
            color: var(--text-silver);
            line-height: 1.8;
            max-width: 480px;
            margin-bottom: 35px;
        }

        .gold-line {
            width: 40px;
            height: 2px;
            background: var(--primary-gold);
            margin-bottom: 20px;
        }


        /* Service Card */
        .service-card {
            background: var(--bg-card);
            border: 1px solid rgba(212, 160, 23, 0.08);
            padding: 25px;
            transition: 0.3s;
            height: 100%;
        }

        .service-card:hover {
            border-color: var(--primary-gold);
            transform: translateY(-5px);
        }

        .service-card-name {
            font-family: var(--font-primary);
            font-size: 1.1rem;
            color: var(--text-white);
            margin-bottom: 8px;
        }

        .service-card-detail {
            font-size: 13px;
            color: var(--text-muted);
            line-height: 1.6;
            margin-bottom: 18px;
        }

        .service-card-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top: 1px solid #222;
            padding-top: 15px;
            margin-top: auto;
        }

        .service-price {
            font-size: 1rem;
            font-weight: bold;
            color: var(--primary-gold);
        }

        .service-duration {
            font-size: 11px;
            letter-spacing: 1px;
            color: var(--text-muted);
            text-transform: uppercase;
        }


        /* Section Image */
        .service-section-img {
            width: 100%;
            height: 100%;
            min-height: 380px;
            object-fit: cover;
            filter: brightness(0.85);
        }

        .img-frame {
            border: 1px solid rgba(212, 160, 23, 0.2);
            overflow: hidden;
            height: 100%;
        }


        /* Individual Service Sections */
        .service-section {
            padding: 90px 0;
        }

        .service-section.alt-bg {
            background: #080808;
        }


        /* CTA Section */
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

        .btn-book {
            padding: 15px 40px;
            background: var(--primary-gold);
            color: #000;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 2px;
            text-decoration: none;
            display: inline-block;
            transition: 0.3s;
        }

        .btn-book:hover {
            background: #fff;
            color: #000;
            transform: translateY(-3px);
        }


        /* Mobile */
        @media (max-width: 991px) {
            .service-section-img { min-height: 280px; }
            .section-desc { max-width: 100%; }
        }

        @media (max-width: 768px) {
            .service-section { padding: 60px 0; }
            .img-frame { margin-bottom: 40px; }
        }

    </style>
</head>
<body>

<?php include('includes/header.php'); ?>


<!-- Page Hero Banner -->
<section class="page-hero">
    <h1>Our Services</h1>
    <div class="breadcrumb-row">
        <a href="index.php">Home</a>
        <span>&#8250;</span>
        <span>Services</span>
    </div>
</section>


<!-- Services Filter Nav -->
<nav class="services-nav">
    <div class="services-nav-inner">
        <a href="#hair"     class="nav-filter-btn active">Hair</a>
        <a href="#facial"   class="nav-filter-btn">Facial</a>
        <a href="#nails"    class="nav-filter-btn">Nails</a>
        <a href="#massage"  class="nav-filter-btn">Massage</a>
        <a href="#spa"      class="nav-filter-btn">Spa</a>
        <a href="#bridal"   class="nav-filter-btn">Bridal</a>
    </div>
</nav>


<!-- Hair Styling and Cutting -->
<section class="service-section" id="hair">
    <div class="container">
        <div class="row align-items-center g-5">

            <div class="col-lg-5 order-2 order-lg-1">
                <div class="img-frame">
                    <img src="https://images.unsplash.com/photo-1562322140-8baeececf3df?q=80&w=800" alt="Hair Styling" class="service-section-img">
                </div>
            </div>

            <div class="col-lg-7 order-1 order-lg-2">
                <span class="section-label">✦ Service 01</span>
                <h2 class="section-title">Hair Styling <em>&amp; Cutting</em></h2>
                <div class="gold-line"></div>
                <p class="section-desc">
                    From classic cuts to bold transformations, our expert stylists craft the perfect look tailored to your face shape and personal style. We use premium products for lasting results.
                </p>

                <div class="row g-3">
                    <div class="col-sm-6">
                        <div class="service-card">
                            <div class="service-card-name">Basic Haircut</div>
                            <div class="service-card-detail">Clean cut with wash and dry finish.</div>
                            <div class="service-card-footer">
                                <span class="service-price">Rs. 500</span>
                                <span class="service-duration">30 min</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="service-card">
                            <div class="service-card-name">Haircut &amp; Blow Dry</div>
                            <div class="service-card-detail">Precision cut with professional blow dry styling.</div>
                            <div class="service-card-footer">
                                <span class="service-price">Rs. 1200</span>
                                <span class="service-duration">45 min</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="service-card">
                            <div class="service-card-name">Keratin Treatment</div>
                            <div class="service-card-detail">Smoothing treatment for frizz-free, shiny hair.</div>
                            <div class="service-card-footer">
                                <span class="service-price">Rs. 3500</span>
                                <span class="service-duration">90 min</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="service-card">
                            <div class="service-card-name">Hair Coloring</div>
                            <div class="service-card-detail">Full color, highlights, or ombre using premium dye.</div>
                            <div class="service-card-footer">
                                <span class="service-price">Rs. 4000</span>
                                <span class="service-duration">2 hrs</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>


<!-- Facial Care -->
<section class="service-section alt-bg" id="facial">
    <div class="container">
        <div class="row align-items-center g-5">

            <div class="col-lg-7">
                <span class="section-label">✦ Service 02</span>
                <h2 class="section-title">Facial <em>Care</em></h2>
                <div class="gold-line"></div>
                <p class="section-desc">
                    Revitalize your skin with our signature facial treatments. From deep cleansing to anti-aging therapies, every treatment is customized to your skin type for visible, lasting results.
                </p>

                <div class="row g-3">
                    <div class="col-sm-6">
                        <div class="service-card">
                            <div class="service-card-name">Deep Cleansing Facial</div>
                            <div class="service-card-detail">Removes impurities and unclogs pores thoroughly.</div>
                            <div class="service-card-footer">
                                <span class="service-price">Rs. 1500</span>
                                <span class="service-duration">45 min</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="service-card">
                            <div class="service-card-name">Whitening Facial</div>
                            <div class="service-card-detail">Brightens skin tone with whitening serum and polish.</div>
                            <div class="service-card-footer">
                                <span class="service-price">Rs. 2000</span>
                                <span class="service-duration">60 min</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="service-card">
                            <div class="service-card-name">Anti-Aging Treatment</div>
                            <div class="service-card-detail">Reduces fine lines and firms skin with collagen mask.</div>
                            <div class="service-card-footer">
                                <span class="service-price">Rs. 3000</span>
                                <span class="service-duration">75 min</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="service-card">
                            <div class="service-card-name">Gold Facial</div>
                            <div class="service-card-detail">Luxury 24K gold mask for radiant, glowing skin.</div>
                            <div class="service-card-footer">
                                <span class="service-price">Rs. 4500</span>
                                <span class="service-duration">90 min</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="img-frame">
                    <img src="https://images.unsplash.com/photo-1512290923902-8a9f81dc236c?q=80&w=800" alt="Facial Care" class="service-section-img">
                </div>
            </div>

        </div>
    </div>
</section>


<!-- Nail Care -->
<section class="service-section" id="nails">
    <div class="container">
        <div class="row align-items-center g-5">

            <div class="col-lg-5 order-2 order-lg-1">
                <div class="img-frame">
                    <img src="https://images.unsplash.com/photo-1604654894610-df49ff668781?q=80&w=800" alt="Nail Care" class="service-section-img">
                </div>
            </div>

            <div class="col-lg-7 order-1 order-lg-2">
                <span class="section-label">✦ Service 03</span>
                <h2 class="section-title">Nail <em>Care</em></h2>
                <div class="gold-line"></div>
                <p class="section-desc">
                    Treat your hands and feet to a premium nail care experience. From classic manicures to detailed nail art, our nail technicians deliver precision and style in every session.
                </p>

                <div class="row g-3">
                    <div class="col-sm-6">
                        <div class="service-card">
                            <div class="service-card-name">Classic Manicure</div>
                            <div class="service-card-detail">Shaping, cuticle care, and polish application.</div>
                            <div class="service-card-footer">
                                <span class="service-price">Rs. 800</span>
                                <span class="service-duration">30 min</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="service-card">
                            <div class="service-card-name">Moroccan Manicure</div>
                            <div class="service-card-detail">Deep nourishing treatment with Moroccan argan oil.</div>
                            <div class="service-card-footer">
                                <span class="service-price">Rs. 1800</span>
                                <span class="service-duration">45 min</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="service-card">
                            <div class="service-card-name">Classic Pedicure</div>
                            <div class="service-card-detail">Foot soak, exfoliation, nail shaping, and polish.</div>
                            <div class="service-card-footer">
                                <span class="service-price">Rs. 1200</span>
                                <span class="service-duration">45 min</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="service-card">
                            <div class="service-card-name">Gel Nail Extensions</div>
                            <div class="service-card-detail">Long-lasting gel extensions with custom shape and color.</div>
                            <div class="service-card-footer">
                                <span class="service-price">Rs. 3000</span>
                                <span class="service-duration">75 min</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>


<!-- Head Massage -->
<section class="service-section alt-bg" id="massage">
    <div class="container">
        <div class="row align-items-center g-5">

            <div class="col-lg-7">
                <span class="section-label">✦ Service 04</span>
                <h2 class="section-title">Head <em>Massage</em></h2>
                <div class="gold-line"></div>
                <p class="section-desc">
                    Melt away stress with our therapeutic head and scalp massage treatments. Expertly designed to improve circulation, stimulate hair growth, and leave you deeply relaxed.
                </p>

                <div class="row g-3">
                    <div class="col-sm-6">
                        <div class="service-card">
                            <div class="service-card-name">Classic Head Massage</div>
                            <div class="service-card-detail">Relaxing scalp massage with warm oil.</div>
                            <div class="service-card-footer">
                                <span class="service-price">Rs. 700</span>
                                <span class="service-duration">20 min</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="service-card">
                            <div class="service-card-name">Deep Tissue Scalp</div>
                            <div class="service-card-detail">Intensive massage targeting tension and scalp health.</div>
                            <div class="service-card-footer">
                                <span class="service-price">Rs. 1200</span>
                                <span class="service-duration">35 min</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="service-card">
                            <div class="service-card-name">Moroccan Oil Treatment</div>
                            <div class="service-card-detail">Scalp massage with nourishing Moroccan argan oil.</div>
                            <div class="service-card-footer">
                                <span class="service-price">Rs. 1500</span>
                                <span class="service-duration">40 min</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="service-card">
                            <div class="service-card-name">Head &amp; Neck Combo</div>
                            <div class="service-card-detail">Extended session covering head, neck, and shoulders.</div>
                            <div class="service-card-footer">
                                <span class="service-price">Rs. 2000</span>
                                <span class="service-duration">55 min</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="img-frame">
                    <img src="https://images.unsplash.com/photo-1544161515-4ab6ce6db874?q=80&w=800" alt="Head Massage" class="service-section-img">
                </div>
            </div>

        </div>
    </div>
</section>


<!-- Spa Treatments -->
<section class="service-section" id="spa">
    <div class="container">
        <div class="row align-items-center g-5">

            <div class="col-lg-5 order-2 order-lg-1">
                <div class="img-frame">
                    <img src="https://images.unsplash.com/photo-1540555700478-4be289fbecef?q=80&w=800" alt="Spa Treatments" class="service-section-img">
                </div>
            </div>

            <div class="col-lg-7 order-1 order-lg-2">
                <span class="section-label">✦ Service 05</span>
                <h2 class="section-title">Spa <em>Treatments</em></h2>
                <div class="gold-line"></div>
                <p class="section-desc">
                    Step into a world of relaxation. Our spa menu is crafted to restore your body and mind using natural ingredients, therapeutic techniques, and a serene atmosphere.
                </p>

                <div class="row g-3">
                    <div class="col-sm-6">
                        <div class="service-card">
                            <div class="service-card-name">Full Body Scrub</div>
                            <div class="service-card-detail">Exfoliates and revitalizes skin from head to toe.</div>
                            <div class="service-card-footer">
                                <span class="service-price">Rs. 3500</span>
                                <span class="service-duration">60 min</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="service-card">
                            <div class="service-card-name">Aromatherapy Wrap</div>
                            <div class="service-card-detail">Hydrating body wrap with essential oil infusion.</div>
                            <div class="service-card-footer">
                                <span class="service-price">Rs. 4000</span>
                                <span class="service-duration">75 min</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="service-card">
                            <div class="service-card-name">Swedish Massage</div>
                            <div class="service-card-detail">Full body relaxation massage with long, gentle strokes.</div>
                            <div class="service-card-footer">
                                <span class="service-price">Rs. 4500</span>
                                <span class="service-duration">90 min</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="service-card">
                            <div class="service-card-name">Luxury Spa Package</div>
                            <div class="service-card-detail">Scrub, wrap, massage, and facial all in one session.</div>
                            <div class="service-card-footer">
                                <span class="service-price">Rs. 9999</span>
                                <span class="service-duration">3 hrs</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>


<!-- Bridal and Special Occasion -->
<section class="service-section alt-bg" id="bridal">
    <div class="container">
        <div class="row align-items-center g-5">

            <div class="col-lg-7">
                <span class="section-label">✦ Service 06</span>
                <h2 class="section-title">Bridal <em>&amp; Special Occasions</em></h2>
                <div class="gold-line"></div>
                <p class="section-desc">
                    Look and feel extraordinary on your most important days. Our bridal team specializes in complete makeovers tailored to your vision, ensuring you shine from every angle.
                </p>

                <div class="row g-3">
                    <div class="col-sm-6">
                        <div class="service-card">
                            <div class="service-card-name">Bridal Makeup</div>
                            <div class="service-card-detail">Full bridal look with trial session included.</div>
                            <div class="service-card-footer">
                                <span class="service-price">Rs. 12000</span>
                                <span class="service-duration">3 hrs</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="service-card">
                            <div class="service-card-name">Bridal Hair Styling</div>
                            <div class="service-card-detail">Updo, curls, or any style with accessories.</div>
                            <div class="service-card-footer">
                                <span class="service-price">Rs. 6000</span>
                                <span class="service-duration">2 hrs</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="service-card">
                            <div class="service-card-name">Party Glam Package</div>
                            <div class="service-card-detail">Hair, makeup, and nails for events and parties.</div>
                            <div class="service-card-footer">
                                <span class="service-price">Rs. 8000</span>
                                <span class="service-duration">2.5 hrs</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="service-card">
                            <div class="service-card-name">Full Bridal Package</div>
                            <div class="service-card-detail">Complete head to toe bridal treatment for the big day.</div>
                            <div class="service-card-footer">
                                <span class="service-price">Rs. 25000</span>
                                <span class="service-duration">Full Day</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="img-frame">
                    <img src="https://images.unsplash.com/photo-1595476108010-b4d1f102b1b1?q=80&w=800" alt="Bridal Services" class="service-section-img">
                </div>
            </div>

        </div>
    </div>
</section>


<!-- Final CTA -->
<section class="cta-section">
    <h2>Ready for a <span style="color: var(--primary-gold);">New Look?</span></h2>
    <p>Book your appointment today and let our experts take care of the rest.</p>
    <a href="booking.php" class="btn-book">Book Appointment</a>
</section>


<?php include('includes/footer.php'); ?>


<script>
    /* Services Nav Active State on Scroll */
    const sections = document.querySelectorAll('.service-section');
    const navBtns  = document.querySelectorAll('.nav-filter-btn');

    window.addEventListener('scroll', function() {
        let current = '';

        sections.forEach(function(section) {
            const sectionTop = section.offsetTop - 120;
            if (window.scrollY >= sectionTop) {
                current = section.getAttribute('id');
            }
        });

        navBtns.forEach(function(btn) {
            btn.classList.remove('active');
            if (btn.getAttribute('href') === '#' + current) {
                btn.classList.add('active');
            }
        });
    });
</script>

<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/script.js"></script>

</body>
</html>