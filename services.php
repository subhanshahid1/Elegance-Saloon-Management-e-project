<?php
require_once 'includes/db.php';

// Fetch unique categories that have ACTIVE services
$cat_query = "SELECT DISTINCT category FROM services WHERE status = 'active' ORDER BY category ASC";
$cat_result = mysqli_query($conn, $cat_query);

$categories = [];
if ($cat_result) {
    while ($row = mysqli_fetch_assoc($cat_result)) {
        $categories[] = $row['category'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Services | Elegance Saloon</title>

    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">

    <style>
        :root {
            --gold-gradient: linear-gradient(135deg, #d4a017 0%, #f9e27d 50%, #d4a017 100%);
        }

        /* Global Fix */
        html,
        body {
            max-width: 100%;
            overflow-x: hidden;
            scroll-behavior: smooth;
            background-color: #050505;
            color: #fff;
        }

        /* Page Hero Banner (Matched with About Us) */
        .page-hero {
            background: linear-gradient(rgba(0, 0, 0, 0.65), rgba(0, 0, 0, 0.65)),
                url('assets/images/carousel1.png') center/cover no-repeat;
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

        .breadcrumb-row a:hover {
            color: var(--primary-gold);
        }

        .breadcrumb-row span {
            color: var(--primary-gold);
        }

        .book-btn {
            color: var(--primary-gold);
            font-weight: bold;
            font-size: 12px;
            text-transform: uppercase;
            text-decoration: none;
            letter-spacing: 1px;
            transition: 0.3s;
            border: 1px solid var(--primary-gold);
            padding: 8px 15px;
            border-radius: 4px;
        }

        .book-btn:hover {
            color: #000;
            background-color: var(--primary-gold);
        }

        /* Sticky Filter Bar */
        .services-nav {
            background: rgba(10, 10, 10, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(212, 160, 23, 0.2);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .nav-filter-btn {
            color: #888;
            font-size: 11px;
            letter-spacing: 2px;
            text-transform: uppercase;
            padding: 20px 25px;
            text-decoration: none;
            transition: 0.3s;
            display: inline-block;
            border-bottom: 3px solid transparent;
        }

        .nav-filter-btn.active {
            color: var(--primary-gold) !important;
            border-bottom-color: var(--primary-gold) !important;
        }


        /* Section Layout */
        .service-section {
            padding: 80px 0;
        }

        .service-section.alt-bg {
            background: #0a0a0a;
        }

        .section-header {
            margin-bottom: 50px;
            text-align: center;
        }

        .section-title {
            font-family: var(--font-primary);
            font-size: clamp(2rem, 5vw, 3rem);
            color: var(--primary-gold);
            text-transform: uppercase;
            letter-spacing: 3px;
        }

        /* Services Grid */
        .services-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

        .service-wrapper {
            flex: 1 1 350px;
            max-width: 500px;
        }

        .service-card {
            background: #111;
            border: 1px solid #222;
            padding: 35px 30px;
            height: 100%;
            transition: 0.4s;
            display: flex;
            flex-direction: column;
            border-radius: 4px;
        }

        .service-card:hover {
            border-color: var(--primary-gold);
            transform: translateY(-5px);
            background: #161616;
        }

        .service-card-name {
            font-size: 1.4rem;
            color: #fff;
            margin-bottom: 12px;
            font-family: var(--font-primary);
        }

        .service-card-detail {
            font-size: 14px;
            color: var(--text-muted);
            line-height: 1.7;
            margin-bottom: 25px;
            flex-grow: 1;
        }

        .service-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 18px;
            border-top: 1px solid #222;
        }

        .service-price {
            color: var(--primary-gold);
            font-weight: bold;
            font-size: 1.2rem;
        }

        .service-duration {
            font-size: 11px;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        @media (max-width: 768px) {
            .nav-filter-btn {
                padding: 15px 12px;
                font-size: 10px;
            }
        }
    </style>
</head>

<body>

    <?php include('includes/header.php'); ?>

    <section class="page-hero">
        <h1>Our Services</h1>
        <div class="breadcrumb-row">
            <a href="index.php">Home</a>
            <span>&#8250;</span>
            <span>Services</span>
        </div>
    </section>

    <nav class="services-nav">
        <div class="container d-flex justify-content-center flex-wrap">
            <?php foreach ($categories as $catName): ?>
                <a href="#<?php echo strtolower(str_replace(' ', '-', $catName)); ?>"
                    class="nav-filter-btn">
                    <?php echo htmlspecialchars($catName); ?>
                </a>
            <?php endforeach; ?>
        </div>
    </nav>

    <?php
    $counter = 1;
    foreach ($categories as $catName):
        $is_alt = ($counter % 2 == 0);
        $section_id = strtolower(str_replace(' ', '-', $catName));

        $safe_cat = mysqli_real_escape_string($conn, $catName);
        // Modified query to only fetch ACTIVE services
        $s_query = "SELECT * FROM services WHERE category = '$safe_cat' AND status = 'active' ORDER BY name ASC";
        $s_result = mysqli_query($conn, $s_query);
    ?>
        <section class="service-section <?php echo $is_alt ? 'alt-bg' : ''; ?>" id="<?php echo $section_id; ?>">
            <div class="container">
                <div class="section-header">
                    <h2 class="section-title"><?php echo htmlspecialchars($catName); ?></h2>
                    <div style="width: 50px; height: 2px; background: var(--primary-gold); margin: 15px auto;"></div>
                </div>

                <div class="services-container">
                    <?php while ($service = mysqli_fetch_assoc($s_result)): ?>
                        <div class="service-wrapper">
                            <div class="service-card">
                                <div class="service-card-name"><?php echo htmlspecialchars($service['name']); ?></div>
                                <p class="service-card-detail"><?php echo htmlspecialchars($service['description']); ?></p>
                                <div class="service-footer">
                                    <div class="d-flex flex-column">
                                        <span class="service-price">Rs. <?php echo number_format($service['price']); ?></span>
                                        <span class="service-duration"><?php echo $service['duration']; ?> MINS</span>
                                    </div>
                                    <a href="booking.php?service_id=<?php echo $service['id']; ?>" class="book-btn">Book Now</a>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </section>
    <?php
        $counter++;
    endforeach;
    ?>

    <?php include('includes/footer.php'); ?>

    <script src="assets/js/bootstrap.bundle.min.js"></script>

    <script>
        const sections = document.querySelectorAll('.service-section');
        const navLinks = document.querySelectorAll('.nav-filter-btn');

        window.addEventListener('scroll', () => {
            let current = "";

            sections.forEach(section => {
                const sectionTop = section.offsetTop;
                if (pageYOffset >= (sectionTop - 200)) {
                    current = section.getAttribute('id');
                }
            });

            navLinks.forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('href').includes(current) && current !== "") {
                    link.classList.add('active');
                }
            });
        });
    </script>

</body>

</html>