<header class="topbar d-flex align-items-center px-3 shadow-sm bg-white" style="height: 70px;">
    <button class="topbar-icon-btn d-lg-none border-0 bg-transparent me-2" id="sidebar-toggle">
        <i class="bi bi-list fs-4"></i>
    </button>

    <div class="topbar-title fw-bold" id="page-title">Dashboard</div>
    
    <div class="ms-auto d-flex align-items-center gap-3">
        <div class="dropdown">
            <button class="topbar-icon-btn border-0 bg-transparent position-relative" data-bs-toggle="dropdown">
                <i class="bi bi-bell fs-5"></i>
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem;">
                    <?php 
                    // Counts low stock items as notifications
                    $notif_count = $conn->query("SELECT COUNT(*) FROM inventory WHERE quantity <= reorder_level")->fetch_row()[0];
                    echo $notif_count;
                    ?>
                </span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow border-0" style="min-width: 250px;">
                <li class="p-2 border-bottom fw-bold small">Inventory Alerts</li>
                <?php 
                $low_stock = $conn->query("SELECT name, quantity FROM inventory WHERE quantity <= reorder_level LIMIT 3");
                while($item = $low_stock->fetch_assoc()): ?>
                    <li><a class="dropdown-item small py-2" href="inventory.php">
                        <i class="bi bi-exclamation-circle text-danger me-2"></i>
                        <?php echo $item['name']; ?> is low (<?php echo $item['quantity']; ?> left)
                    </a></li>
                <?php endwhile; ?>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item text-center small text-gold" href="inventory.php">Manage Stock</a></li>
            </ul>
        </div>

        <a href="appointments.php" class="topbar-icon-btn border-0 bg-transparent text-dark" title="Quick Appointment">
            <i class="bi bi-plus-circle fs-5"></i>
        </a>
    </div>
</header>