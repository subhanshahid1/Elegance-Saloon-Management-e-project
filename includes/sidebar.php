<aside class="sidebar">
    <div class="sidebar-logo">
        <div class="brand-icon">
            <i class="bi bi-scissors text-white"></i>
        </div>
        <div class="brand-name">Elegance</div>
        <div class="brand-sub">Luxury Salon & Spa</div>
    </div>

    <!-- ===== MAIN MENU — ALL ROLES SEE THESE ===== -->
    <div class="nav-section-label">Main Menu</div>

    <a href="index.php" class="nav-link-custom active">
        <i class="bi bi-grid-1x2"></i>
        <span>Dashboard</span>
    </a>

    <a href="calendar.php" class="nav-link-custom">
        <i class="bi bi-calendar3"></i>
        <span>Schedule</span>
    </a>

    <a href="appointments.php" class="nav-link-custom">
        <i class="bi bi-journal-text"></i>
        <span>Appointments</span>
        <span class="nav-badge">4</span>
    </a>

    <!-- --- Clients: Admin and Receptionist only --- -->
    <?php if (in_array(getUserRole(), ['admin', 'receptionist'])): ?>
        <a href="clients.php" class="nav-link-custom">
            <i class="bi bi-people"></i>
            <span>Clients</span>
        </a>
    <?php endif; ?>

    <!-- ===== MANAGEMENT SECTION ===== -->
    <!-- Only show this label if user can see at least one item below -->
    <?php if (in_array(getUserRole(), ['admin', 'receptionist'])): ?>
        <div class="nav-section-label">Management</div>
    <?php endif; ?>

    <!-- --- Services: Admin only --- -->
    <?php if (getUserRole() === 'admin'): ?>
        <a href="services.php" class="nav-link-custom">
            <i class="bi bi-scissors"></i>
            <span>Service Menu</span>
        </a>
    <?php endif; ?>

    <!-- --- Staff: Admin only --- -->
    <?php if (getUserRole() === 'admin'): ?>
        <a href="staff.php" class="nav-link-custom">
            <i class="bi bi-person-badge"></i>
            <span>Staff Team</span>
        </a>
    <?php endif; ?>

    <!-- --- Inventory: Admin and Receptionist --- -->
    <?php if (in_array(getUserRole(), ['admin', 'receptionist'])): ?>
        <a href="inventory.php" class="nav-link-custom">
            <i class="bi bi-box-seam"></i>
            <span>Inventory</span>
        </a>
    <?php endif; ?>

    <!-- --- Payments: Admin and Receptionist --- -->
    <?php if (in_array(getUserRole(), ['admin', 'receptionist'])): ?>
        <a href="payments.php" class="nav-link-custom">
            <i class="bi bi-credit-card"></i>
            <span>Payments</span>
        </a>
    <?php endif; ?>

    <!-- --- Analytics: Admin only --- -->
    <?php if (getUserRole() === 'admin'): ?>
        <a href="reports.php" class="nav-link-custom">
            <i class="bi bi-bar-chart-line"></i>
            <span>Analytics</span>
        </a>
    <?php endif; ?>

    <!-- ===== SYSTEM SECTION — Admin only ===== -->
    <?php if (getUserRole() === 'admin'): ?>
        <div class="nav-section-label">System</div>

        <a href="feedback.php" class="nav-link-custom">
            <i class="bi bi-chat-heart"></i>
            <span>Feedback</span>
        </a>

        <a href="admin.php" class="nav-link-custom">
            <i class="bi bi-gear"></i>
            <span>Settings</span>
        </a>
    <?php endif; ?>

    <!-- ===== SIDEBAR BOTTOM — USER INFO ===== -->
    <div class="sidebar-bottom">
        <div class="sidebar-user">
            <!-- --- Show first 2 letters of their name dynamically --- -->
            <div class="user-avatar">
                <?php echo strtoupper(substr(getUserName(), 0, 2)); ?>
            </div>
            <div class="user-info">
                <!-- --- Show actual logged in user name and role --- -->
                <div class="user-name"><?php echo getUserName(); ?></div>
                <div class="user-role"><?php echo ucfirst(getUserRole()); ?></div>
            </div>
            <a href="<?php echo SITE_URL; ?>/logout.php" class="logout-btn" title="Logout">
                <i class="bi bi-box-arrow-right"></i>
            </a>
        </div>
    </div>

</aside>