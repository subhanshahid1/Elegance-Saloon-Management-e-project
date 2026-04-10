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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Automatic Purchase Order | Elegance Salon</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <style>
        @media print { 
            .no-print { display: none !important; } 
            .main-area { margin: 0; width: 100%; }
            .card { border: 1px solid #dee2e6 !important; box-shadow: none !important; }
        }
        /* Ensures table content doesn't get squeezed too much on tiny screens */
        .table { min-width: 600px; }
        .table-responsive { border: none; }
    </style>
</head>
<body class="bg-light">
    <div class="container py-3 py-md-5">
        <div class="d-flex flex-column flex-md-row justify-content-between no-print mb-4 gap-3">
            <h2 class="fw-bold mb-0">Purchase Order Summary</h2>
            <div class="d-flex gap-2">
                <button onclick="window.print()" class="btn btn-dark flex-fill">
                    <i class="bi bi-printer"></i> <span class="d-none d-sm-inline">Print POs</span>
                </button>
                <a href="inventory.php" class="btn btn-outline-secondary flex-fill">Back to Inventory</a>
            </div>
        </div>

        <?php if(empty($po_list)): ?>
            <div class="alert alert-success">All inventory levels are sufficient. No orders needed.</div>
        <?php else: ?>
            <?php foreach($po_list as $supplier => $data): ?>
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold"><?php echo htmlspecialchars($supplier); ?></h5>
                        <small class="text-muted d-block mt-1">
                            <i class="bi bi-telephone"></i> <?php echo $data['info']['phone']; ?> | 
                            <i class="bi bi-envelope"></i> <?php echo $data['info']['email']; ?>
                        </small>
                    </div>
                    <div class="card-body p-0"> <div class="table-responsive">
                            <table class="table table-sm mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-3">Item Name</th>
                                        <th>Current Stock</th>
                                        <th>Suggested Order</th>
                                        <th class="pe-3">Estimated Cost</th>
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
                                        <td class="ps-3"><?php echo htmlspecialchars($item['name']); ?></td>
                                        <td class="text-danger"><?php echo $item['quantity']; ?></td>
                                        <td class="fw-bold"><?php echo $orderQty; ?> units</td>
                                        <td class="pe-3">Rs. <?php echo number_format($subtotal, 2); ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr class="table-light">
                                        <td colspan="3" class="text-end fw-bold ps-3">Supplier Total:</td>
                                        <td class="fw-bold text-success pe-3">Rs. <?php echo number_format($total, 2); ?></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</body>
</html> 