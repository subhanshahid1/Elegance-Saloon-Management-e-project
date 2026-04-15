<?php 
require_once 'includes/db.php'; 

/* To Fetch active service categories for the dropdown */
$category_query = "SELECT DISTINCT category FROM services WHERE status = 'active' ORDER BY category ASC";
$categories_result = mysqli_query($conn, $category_query);
?>

<header class="main-nav-container">
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand logo" href="index.php">
                ELEGANCE
                <span>✦ SALOON ✦</span>
            </a>

            <button class="navbar-toggler custom-hamburger" type="button" data-bs-toggle="collapse" data-bs-target="#navContent" aria-controls="navContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </button>

            <div class="collapse navbar-collapse" id="navContent">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="aboutus.php">About</a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="services.php" id="servicesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Our Services
                        </a>
                        <ul class="dropdown-menu custom-drop-menu" aria-labelledby="servicesDropdown">
                            <?php if ($categories_result && mysqli_num_rows($categories_result) > 0): ?>
                                <?php while($row = mysqli_fetch_assoc($categories_result)): 
                                    $cat_name = $row['category'];
                                    // Create a slug for the URL anchor (e.g., "Skin Care" becomes "skin-care")
                                    $cat_slug = strtolower(str_replace(' ', '-', $cat_name));
                                ?>
                                    <li><a class="dropdown-item" href="services.php#<?php echo $cat_slug; ?>"><?php echo htmlspecialchars($cat_name); ?></a></li>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <li><a class="dropdown-item" href="services.php">All Services</a></li>
                            <?php endif; ?>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="contact.php">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="feedback.php">Feedback</a>
                    </li>

                    <?php if (isset($_SESSION['user_id'])): ?>
                        <?php if (in_array($_SESSION['role'], ['admin', 'receptionist', 'stylist'])): ?>
                            <li class="nav-item ms-lg-3 mt-3 mt-lg-0">
                                <a class="nav-login-btn" href="dashboard/index.php">Dashboard</a>
                            </li>
                        <?php else: ?>
                            <li class="nav-item ms-lg-3 mt-3 mt-lg-0">
                                <a class="nav-login-btn" href="booking.php">Book Now</a>
                            </li>
                        <?php endif; ?>

                        <li class="nav-item ms-lg-2 mt-3 mt-lg-0">
                            <a class="nav-link" href="logout.php">Logout</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item ms-lg-3 mt-3 mt-lg-0">
                            <a class="nav-login-btn" href="login.php">Login</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
</header>