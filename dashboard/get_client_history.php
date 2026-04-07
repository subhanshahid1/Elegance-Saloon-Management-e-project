<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';

$client_id = (int)$_GET['id'];

$sql = "SELECT a.*, s.name as service_name, st.name as stylist_name 
        FROM appointments a 
        JOIN services s ON a.service_id = s.id 
        LEFT JOIN users st ON a.stylist_id = st.id 
        WHERE a.client_id = $client_id 
        ORDER BY a.apt_date DESC, a.apt_time DESC";

$res = $conn->query($sql);

if($res->num_rows > 0) {
    echo '<table class="table table-sm small">
            <thead><tr><th>Date</th><th>Service</th><th>Stylist</th><th>Status</th></tr></thead>
            <tbody>';
    while($row = $res->fetch_assoc()) {
        $status_color = ($row['status'] == 'confirmed') ? 'text-success' : 'text-muted';
        echo "<tr>
                <td>".date('d M, Y', strtotime($row['apt_date']))."</td>
                <td class='fw-bold'>{$row['service_name']}</td>
                <td>".($row['stylist_name'] ?: 'Any')."</td>
                <td class='$status_color'>".ucfirst($row['status'])."</td>
              </tr>";
    }
    echo '</tbody></table>';
} else {
    echo '<p class="text-center text-muted">No past appointments found for this client.</p>';
}