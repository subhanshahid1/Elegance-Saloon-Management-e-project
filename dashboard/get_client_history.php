<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';

if (!isset($_GET['id']) || (int)$_GET['id'] == 0) {
    echo '<p class="text-center text-muted">No history available for new clients.</p>';
    exit();
}

$client_id = (int)$_GET['id'];

$sql = "SELECT a.*, s.name as service_name, st.name as stylist_name 
        FROM appointments a 
        JOIN services s ON a.service_id = s.id 
        LEFT JOIN users st ON a.stylist_id = st.id 
        WHERE a.client_id = $client_id 
        ORDER BY a.apt_date DESC, a.apt_time DESC";

$res = $conn->query($sql);

if ($res && $res->num_rows > 0) {
    echo '<div class="table-responsive"><table class="table table-sm custom-table small">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Service</th>
                    <th>Stylist</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>';
    while ($row = $res->fetch_assoc()) {
        $badge = 'bg-secondary';
        if ($row['status'] == 'completed') $badge = 'bg-success';
        if ($row['status'] == 'confirmed') $badge = 'bg-primary';

        echo "<tr>
                <td>" . date('d M, Y', strtotime($row['apt_date'])) . "</td>
                <td class='fw-bold'>{$row['service_name']}</td>
                <td>" . ($row['stylist_name'] ?: 'Any') . "</td>
                <td><span class='badge $badge'>" . ucfirst($row['status']) . "</span></td>
              </tr>";
    }
    echo '</tbody></table></div>';
} else {
    echo '<div class="text-center py-4 text-muted">No past appointments found.</div>';
}
