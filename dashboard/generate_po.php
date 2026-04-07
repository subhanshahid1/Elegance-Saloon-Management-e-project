<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';

// Requirement: Generate automatic PO for low inventory items
$sql = "SELECT i.*, s.supplier_name, s.phone, s.email, s.address 
        FROM inventory i 
        JOIN suppliers s ON i.supplier_id = s.id 
        WHERE i.quantity <= i.reorder_level 
        ORDER BY s.supplier_name ASC";
$result = $conn->query($sql);

$po_list = [];
while($row = $result->fetch_assoc()) {
    $po_list[$row['supplier_name']]['info'] = ['phone' => $row['phone'], 'email' => $row['email'], 'addr' => $row['address']];
    $po_list[$row['supplier_name']]['items'][] = $row;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Automatic Purchase Order | Elegance Salon</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <style>@media print { .no-print { display: none; } .main-area { margin: 0; width: 100%; } }</style>
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="d-flex justify-content-between no-print mb-4">
            <h2 class="fw-bold">Purchase Order Summary</h2>
            <div>
                <button onclick="window.print()" class="btn btn-dark"><i class="bi bi-printer"></i> Print POs</button>
                <a href="inventory.php" class="btn btn-outline-secondary">Back to Inventory</a>
            </div>
        </div>

        <?php if(empty($po_list)): ?>
            <div class="alert alert-success">All inventory levels are sufficient. No orders needed.</div>
        <?php else: ?>
            <?php foreach($po_list as $supplier => $data): ?>
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold"><?php echo htmlspecialchars($supplier); ?></h5>
                        <small class="text-muted"><?php echo $data['info']['phone']; ?> | <?php echo $data['info']['email']; ?></small>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Item Name</th>
                                    <th>Current Stock</th>
                                    <th>Suggested Order</th>
                                    <th>Estimated Cost</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $total = 0;
                                foreach($data['items'] as $item): 
                                    $orderQty = ($item['reorder_level'] * 2) - $item['quantity'];
                                    $subtotal = $orderQty * $item['cost_per_unit'];
                                    $total += $subtotal;
                                ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($item['name']); ?></td>
                                    <td class="text-danger"><?php echo $item['quantity']; ?></td>
                                    <td class="fw-bold"><?php echo $orderQty; ?> units</td>
                                    <td>Rs. <?php echo number_format($subtotal, 2); ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-end fw-bold">Supplier Total:</td>
                                    <td class="fw-bold text-success">Rs. <?php echo number_format($total, 2); ?></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</body>
</html>