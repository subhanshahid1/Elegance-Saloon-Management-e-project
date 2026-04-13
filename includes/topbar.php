<?php
require_once 'db.php';

$role = getUserRole();
$uid = getUserId();
$notifications = [];

// --- 1. SYSTEM-GENERATED NOTIFICATIONS (From the Database) ---
// This fetches entries created by the notifyUser() function
$db_notif = $conn->prepare("SELECT title, message, link, type FROM notifications WHERE user_id = ? AND is_read = 0 ORDER BY created_at DESC LIMIT 5");
$db_notif->bind_param("i", $uid);
$db_notif->execute();
$db_res = $db_notif->get_result();

while($row = $db_res->fetch_assoc()) {
    $icon = 'bi-info-circle';
    $color = 'text-info';
    
    // Customize icon based on type
    if($row['type'] == 'appointment') { $icon = 'bi-calendar-check'; $color = 'text-primary'; }
    if($row['type'] == 'payment') { $icon = 'bi-cash-stack'; $color = 'text-success'; }

    $notifications[] = [
        'icon' => $icon,
        'title' => $row['title'],
        'msg' => $row['message'],
        'link' => $row['link'],
        'color' => $color
    ];
}

// --- 2. AUTOMATED LOGIC FOR STYLIST (New Assignments) ---
if ($role == 'stylist') {
    $sql = "SELECT id, apt_date FROM appointments 
            WHERE stylist_id = ? AND status = 'pending' 
            ORDER BY created_at DESC LIMIT 3";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $uid);
    $stmt->execute();
    $res = $stmt->get_result();
    while($row = $res->fetch_assoc()) {
        $notifications[] = [
            'icon' => 'bi-stars',
            'title' => 'Assigned Appt',
            'msg' => "New task for " . $row['apt_date'],
            'link' => 'appointments.php',
            'color' => 'text-primary'
        ];
    }
}

// --- 3. LOGIC FOR RECEPTIONIST & ADMIN (Stock & Bookings) ---
if (in_array($role, ['admin', 'receptionist'])) {
    // Corrected column name from stock_quantity to quantity
    $stock_check = $conn->query("SELECT name FROM inventory WHERE quantity <= 5");
    
    if ($stock_check) {
        while($item = $stock_check->fetch_assoc()) {
            $notifications[] = [
                'icon' => 'bi-exclamation-triangle',
                'title' => 'Low Stock',
                'msg' => $item['name'] . " needs refill!",
                'link' => 'inventory.php', 
                'color' => 'text-danger'
            ];
        }
    }

    // Pending Appointments check
    $appt_check = $conn->query("SELECT id FROM appointments WHERE status = 'pending' LIMIT 3");
    if ($appt_check) {
        while($appt = $appt_check->fetch_assoc()) {
            $notifications[] = [
                'icon' => 'bi-person-plus',
                'title' => 'Pending Approval',
                'msg' => "New customer booking waiting.",
                'link' => 'appointments.php',
                'color' => 'text-warning'
            ];
        }
    }
}

// --- 4. ADMIN ONLY (New Feedback) ---
if ($role == 'admin') {
    // Assuming you have a 'contact_messages' or 'feedback' table
    $fb_check = $conn->query("SELECT first_name FROM contact_messages ORDER BY created_at DESC LIMIT 1");
    if($fb_res = $fb_check->fetch_assoc()) {
        $notifications[] = [
            'icon' => 'bi-chat-left-dots',
            'title' => 'New Feedback',
            'msg' => "Message received from " . $fb_res['first_name'],
            'link' => 'feedback.php',
            'color' => 'text-info'
        ];
    }
}

$notif_count = count($notifications);
?>

<header class="topbar">
    <div class="topbar-title">Dashboard Overview</div>
    <div class="ms-auto d-flex align-items-center gap-2">
        <div class="dropdown">
            <button class="topbar-icon-btn position-relative" data-bs-toggle="dropdown">
                <i class="bi bi-bell"></i>
                <?php if($notif_count > 0): ?>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        <?php echo $notif_count; ?>
                    </span>
                <?php endif; ?>
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow border-0 py-0" style="width: 320px;">
                <li class="p-3 border-bottom d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-bold">Notifications</h6>
                    <?php if($notif_count > 0): ?>
                        <a href="mark_read.php" class="text-decoration-none small" style="font-size: 11px;">Mark all as read</a>
                    <?php endif; ?>
                </li>
                <div style="max-height: 350px; overflow-y: auto;">
                    <?php if($notif_count > 0): ?>
                        <?php foreach($notifications as $n): ?>
                            <li>
                                <a class="dropdown-item p-3 border-bottom d-flex align-items-center" href="mark_read.php?redirect=<?php echo $n['link']; ?>"></a>
                                    <div class="me-3 <?php echo $n['color']; ?>">
                                        <i class="bi <?php echo $n['icon']; ?> fs-4"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold small"><?php echo $n['title']; ?></div>
                                        <div class="text-muted" style="font-size: 11px;"><?php echo $n['msg']; ?></div>
                                    </div>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li class="p-4 text-center text-muted small">No new alerts!</li>
                    <?php endif; ?>
                </div>
                <li class="p-2 text-center bg-light">
                    <a href="index.php" class="text-decoration-none small text-dark">View Main Dashboard</a>
                </li>
            </ul>
        </div>
    </div>
</header>