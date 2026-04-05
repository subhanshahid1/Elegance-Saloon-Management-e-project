<div id="sidebar-overlay" onclick="toggleSidebar()" style="display:none;"></div>

<nav id="sidebar">
    <div class="p-4 text-center">
        <h3 class="text-gold mb-0 fw-bold">ELEGANCE</h3>
        <small class="text-white-50">SALON ADMIN</small>
    </div>

    <div class="mt-4">
        <?php
        $current = basename($_SERVER['PHP_SELF']);
        $menu = [
            'index.php' => ['Dashboard', 'speedometer2'],
            'appointments.php' => ['Appointments', 'calendar3'],
            'clients.php' => ['Clients', 'people'],
            'inventory.php' => ['Inventory', 'box-seam'],
            'staff.php' => ['Staff', 'person-badge'],
            'payments.php' => ['Payments', 'wallet2'],
            'reports.php' => ['Reports', 'bar-chart-line'],
            'feedback.php' => ['Feedback', 'chat-left-heart'],
            'settings.php' => ['Settings', 'sliders']
        ];

        foreach ($menu as $url => $info) {
            $active = ($current == $url) ? 'active' : '';
            echo "<a href='$url' class='nav-link $active'>
                    <i class='bi bi-{$info[1]} me-3'></i> <span>{$info[0]}</span>
                  </a>";
        }
        ?>
    </div>
</nav>