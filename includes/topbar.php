<?php
/* Topbar logic to fetch real-time notifications */
require_once 'db.php';

$role = getUserRole();
$uid = getUserId();
$notif_count = 0;

// Admin and Receptionist see low stock alerts
if (in_array($role, ['admin', 'receptionist'])) {
    $stock_check = $conn->query("SELECT COUNT(*) as total FROM inventory WHERE quantity <= reorder_level");
    $notif_count = $stock_check->fetch_assoc()['total'];
}
?>

<header class="topbar">
    <button class="topbar-icon-btn d-lg-none me-2" id="sidebar-toggle" title="Toggle Menu">
        <i class="bi bi-list"></i>
    </button>

    <div class="topbar-title" id="page-title">Dashboard Overview</div>
    
    <div class="ms-auto d-flex align-items-center gap-2">
        <div class="dropdown">
            <button class="topbar-icon-btn position-relative" data-bs-toggle="dropdown">
                <i class="bi bi-bell"></i>
                <?php if($notif_count > 0): ?>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 10px;">
                        <?php echo $notif_count; ?>
                    </span>
                <?php endif; ?>
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow border-0 py-0" style="width: 280px;">
                <li class="p-3 border-bottom"><h6 class="mb-0 fw-bold">Alerts</h6></li>
                <div style="max-height: 250px; overflow-y: auto;">
                    <?php if($notif_count > 0): ?>
                        <li><a class="dropdown-item p-3 text-danger small" href="inventory.php">
                            <i class="bi bi-box-seam me-2"></i> Low stock items detected!
                        </a></li>
                    <?php else: ?>
                        <li class="p-4 text-center text-muted small">No new notifications</li>
                    <?php endif; ?>
                </div>
            </ul>
        </div>

        <button class="topbar-icon-btn" title="Quick Actions">
            <i class="bi bi-plus-lg"></i>
        </button>
    </div>
</header>