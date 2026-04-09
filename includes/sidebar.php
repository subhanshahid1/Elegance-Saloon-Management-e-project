<aside class="sidebar">
    <div class="sidebar-logo">
        <div class="brand-icon">
            <i class="bi bi-scissors text-white"></i>
        </div>
        <div class="brand-name">Elegance</div>
        <div class="brand-sub">Luxury Salon & Spa</div>
    </div>

    <div class="nav-section-label">Main Menu</div>

    <a href="index.php" class="nav-link-custom <?php echo (basename($_SERVER['PHP_SELF']) == 'index.php') ? 'active' : ''; ?>">
        <i class="bi bi-grid-1x2"></i>
        <span>Dashboard</span>
    </a>

    <a href="schedule.php" class="nav-link-custom <?php echo (basename($_SERVER['PHP_SELF']) == 'schedule.php') ? 'active' : ''; ?>">
        <i class="bi bi-calendar3"></i>
        <span>Schedule</span>
    </a>

    <a href="appointments.php" class="nav-link-custom <?php echo (basename($_SERVER['PHP_SELF']) == 'appointments.php') ? 'active' : ''; ?>">
        <i class="bi bi-journal-text"></i>
        <span>Appointments</span>
        <span class="nav-badge">4</span>
    </a>

    <a href="staff.php" class="nav-link-custom <?php echo (basename($_SERVER['PHP_SELF']) == 'staff.php') ? 'active' : ''; ?>">
        <i class="bi bi-person-badge"></i>
        <span><?php echo (getUserRole() === 'admin') ? 'Staff Team' : 'My Profile'; ?></span>
    </a>

    <?php if (in_array(getUserRole(), ['admin', 'receptionist'])): ?>
        <a href="clients.php" class="nav-link-custom <?php echo (basename($_SERVER['PHP_SELF']) == 'clients.php') ? 'active' : ''; ?>">
            <i class="bi bi-people"></i>
            <span>Clients</span>
        </a>
    <?php endif; ?>

    <?php if (in_array(getUserRole(), ['admin', 'receptionist'])): ?>
        <div class="nav-section-label">Management</div>

        <?php if (getUserRole() === 'admin'): ?>
            <a href="services.php" class="nav-link-custom <?php echo (basename($_SERVER['PHP_SELF']) == 'services.php') ? 'active' : ''; ?>">
                <i class="bi bi-scissors"></i>
                <span>Service Menu</span>
            </a>
        <?php endif; ?>

        <a href="inventory.php" class="nav-link-custom <?php echo (basename($_SERVER['PHP_SELF']) == 'inventory.php') ? 'active' : ''; ?>">
            <i class="bi bi-box-seam"></i>
            <span>Inventory</span>
        </a>

        <a href="payments.php" class="nav-link-custom <?php echo (basename($_SERVER['PHP_SELF']) == 'payments.php') ? 'active' : ''; ?>">
            <i class="bi bi-credit-card"></i>
            <span>Payments</span>
        </a>
    <?php endif; ?>

    <?php if (getUserRole() === 'admin'): ?>
        <div class="nav-section-label">System</div>

        <a href="analytics.php" class="nav-link-custom <?php echo (basename($_SERVER['PHP_SELF']) == 'analytics.php') ? 'active' : ''; ?>">
            <i class="bi bi-bar-chart-line"></i>
            <span>Analytics</span>
        </a>

        <a href="feedback.php" class="nav-link-custom <?php echo (basename($_SERVER['PHP_SELF']) == 'feedback.php') ? 'active' : ''; ?>">
            <i class="bi bi-chat-heart"></i>
            <span>Feedback</span>
        </a>

        <a href="settings.php" class="nav-link-custom <?php echo (basename($_SERVER['PHP_SELF']) == 'settings.php') ? 'active' : ''; ?>">
            <i class="bi bi-gear"></i>
            <span>Settings</span>
        </a>
    <?php endif; ?>

    <div class="sidebar-bottom">
        <div class="sidebar-user">
            <div class="user-avatar">
                <?php echo strtoupper(substr(getUserName(), 0, 2)); ?>
            </div>
            <div class="user-info">
                <div class="user-name"><?php echo htmlspecialchars(getUserName()); ?></div>
                <div class="user-role"><?php echo ucfirst(getUserRole()); ?></div>
            </div>
            <a href="../logout.php" class="logout-btn" title="Logout">
                <i class="bi bi-box-arrow-right"></i>
            </a>
        </div>
    </div>
</aside>