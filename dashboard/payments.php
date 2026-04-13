<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';

checkAccess(['admin', 'receptionist']);

// 1. Calculate Daily Revenue (Today)
$dailyQuery = "SELECT SUM(amount) as total FROM payments WHERE status = 'paid' AND DATE(created_at) = CURDATE()";
$dailyRes = $conn->query($dailyQuery);
$dailyRevenue = $dailyRes->fetch_assoc()['total'] ?? 0;

// 2. Calculate Monthly Revenue (Current Month)
$monthlyQuery = "SELECT SUM(amount) as total FROM payments WHERE status = 'paid' AND MONTH(created_at) = MONTH(CURDATE()) AND YEAR(created_at) = YEAR(CURDATE())";
$monthlyRes = $conn->query($monthlyQuery);
$monthlyRevenue = $monthlyRes->fetch_assoc()['total'] ?? 0;

// 3. Calculate Total Revenue (All Time)
$totalQuery = "SELECT SUM(amount) as total FROM payments WHERE status = 'paid'";
$totalRes = $conn->query($totalQuery);
$totalRevenue = $totalRes->fetch_assoc()['total'] ?? 0;

// 4. Fetch Transaction List
$query = "SELECT p.*, u.name as client_name 
          FROM payments p 
          JOIN users u ON p.client_id = u.id 
          ORDER BY p.created_at DESC";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payments | Elegance Salon</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
</head>
<body>
    <?php include('../includes/sidebar.php'); ?>

    <div class="main-area">
        <?php include('../includes/topbar.php'); ?>

        <div class="content-area">
            
            <div class="row align-items-center mb-4">
                <div class="col-12 d-md-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="panel-title fs-3">Transaction History</h2>
                        <p class="panel-subtitle">Manage billing and track salon revenue</p>
                    </div>
                    <a href="new_payment.php" class="btn-gold mt-3 mt-md-0 text-decoration-none">
                        <i class="bi bi-plus-circle"></i> Create New Payment
                    </a>
                </div>
            </div>

            <div class="row mb-5 g-3">
                <div class="col-md-4">
                    <div class="panel p-3 d-flex align-items-center gap-3" style="border-left: 4px solid #0dcaf0;">
                        <div class="fs-2 text-info"><i class="bi bi-calendar-check"></i></div>
                        <div>
                            <h4 class="m-0 fw-bold">Rs. <?php echo number_format($dailyRevenue); ?></h4>
                            <small class="text-muted text-uppercase fw-bold" style="font-size: 0.75rem;">Today's Sales</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="panel p-3 d-flex align-items-center gap-3" style="border-left: 4px solid var(--gold);">
                        <div class="fs-2 text-gold"><i class="bi bi-graph-up-arrow"></i></div>
                        <div>
                            <h4 class="m-0 fw-bold">Rs. <?php echo number_format($monthlyRevenue); ?></h4>
                            <small class="text-muted text-uppercase fw-bold" style="font-size: 0.75rem;">Monthly Revenue</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="panel p-3 d-flex align-items-center gap-3" style="border-left: 4px solid #198754;">
                        <div class="fs-2 text-success"><i class="bi bi-wallet2"></i></div>
                        <div>
                            <h4 class="m-0 fw-bold">Rs. <?php echo number_format($totalRevenue); ?></h4>
                            <small class="text-muted text-uppercase fw-bold" style="font-size: 0.75rem;">Total (All Time)</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel">
                <div class="table-responsive">
                    <table class="table custom-table">
                        <thead>
                            <tr>
                                <th>Date & Time</th>
                                <th>Client</th>
                                <th>Amount</th>
                                <th>Method</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($result->num_rows > 0): ?>
                                <?php while($row = $result->fetch_assoc()): 
                                    $paymentData = htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8');
                                ?>
                                <tr>
                                    <td><?php echo date('d M Y, h:i A', strtotime($row['created_at'])); ?></td>
                                    <td class="fw-bold"><?php echo htmlspecialchars($row['client_name']); ?></td>
                                    <td class="text-success fw-bold">Rs. <?php echo number_format($row['amount']); ?></td>
                                    <td class="text-uppercase small text-muted"><?php echo $row['method']; ?></td>
                                    <td>
                                        <span class="badge <?php echo ($row['status'] == 'paid') ? 'bg-success' : 'bg-warning'; ?>">
                                            <?php echo strtoupper($row['status']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <button class="btn btn-sm btn-outline-secondary edit-payment-btn" data-item='<?php echo $paymentData; ?>'>
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <a href="payment_proc.php?delete_id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this transaction?')">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr><td colspan="6" class="text-center py-5 text-muted">No transactions found.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-overlay" id="editPaymentModal">
        <div class="modal-box" style="max-width: 450px;">
            <div class="panel-header">
                <div class="panel-title">Update Transaction</div>
                <button class="border-0 bg-transparent" onclick="closeModal()"><i class="bi bi-x-lg"></i></button>
            </div>
            <form action="payment_proc.php" method="POST">
                <input type="hidden" name="payment_id" id="edit_payment_id">
                <div class="panel-body">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Amount (Rs.)</label>
                        <input type="number" name="amount" id="edit_payment_amount" class="form-input" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Payment Method</label>
                        <select name="method" id="edit_payment_method" class="form-input">
                            <option value="cash">Cash</option>
                            <option value="card">Card</option>
                            <option value="online">Online Transfer</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Status</label>
                        <select name="status" id="edit_payment_status" class="form-input">
                            <option value="paid">Paid</option>
                            <option value="pending">Pending</option>
                            <option value="refunded">Refunded</option>
                        </select>
                    </div>
                </div>
                <div class="panel-header border-top justify-content-end gap-2">
                    <button type="button" class="btn-outline" onclick="closeModal()">Cancel</button>
                    <button type="submit" name="update_payment" class="btn-gold">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/dashboard.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const editButtons = document.querySelectorAll('.edit-payment-btn');
        editButtons.forEach(btn => {
            btn.onclick = function() {
                const data = JSON.parse(this.getAttribute('data-item'));
                document.getElementById('edit_payment_id').value = data.id;
                document.getElementById('edit_payment_amount').value = data.amount;
                document.getElementById('edit_payment_method').value = data.method;
                document.getElementById('edit_payment_status').value = data.status;
                openModal('editPaymentModal');
            };
        });
    });
    function openModal(id) { document.getElementById(id).style.display = 'flex'; }
    function closeModal() { document.querySelectorAll('.modal-overlay').forEach(m => m.style.display = 'none'); }
    </script>
</body>
</html> 