<?php require_once 'config/config.php'; ?>

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
                            <li><a class="dropdown-item" href="services.php#hair">Haircut &amp; Styling</a></li>
                            <li><a class="dropdown-item" href="services.php#facial">Facial Care</a></li>
                            <li><a class="dropdown-item" href="services.php#nails">Nail Care</a></li>
                            <li><a class="dropdown-item" href="services.php#massage">Head Massage</a></li>
                            <li><a class="dropdown-item" href="services.php#spa">Spa Treatments</a></li>
                            <li><a class="dropdown-item" href="services.php#bridal">Bridal Packages</a></li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="contact.php">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="feedback.php">Feedback</a>
                    </li>

                    <!-- ===== DYNAMIC BUTTONS BASED ON LOGIN STATUS ===== -->
                    <?php if (isset($_SESSION['user_id'])): ?>

                        <?php if (in_array($_SESSION['role'], ['admin', 'receptionist', 'stylist'])): ?>
                            <!-- Staff — show Dashboard button -->
                            <li class="nav-item ms-lg-3 mt-3 mt-lg-0">
                                <a class="nav-login-btn" href="dashboard/index.php">Dashboard</a>
                            </li>

                        <?php else: ?>
                            <!-- Client — show Book Appointment button -->
                            <li class="nav-item ms-lg-3 mt-3 mt-lg-0">
                                <a class="nav-login-btn" href="booking.php">Book Now</a>
                            </li>

                        <?php endif; ?>

                        <!-- Everyone logged in sees Logout -->
                        <li class="nav-item ms-lg-2 mt-3 mt-lg-0">
                            <a class="nav-link" href="logout.php">Logout</a>
                        </li>

                    <?php else: ?>

                        <!-- Not logged in — show Login button -->
                        <li class="nav-item ms-lg-3 mt-3 mt-lg-0">
                            <a class="nav-login-btn" href="login.php">Login</a>
                        </li>

                    <?php endif; ?>
                    <!-- ===== END DYNAMIC BUTTONS ===== -->

                </ul>
            </div>
        </div>
    </nav>
</header>