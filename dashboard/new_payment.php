<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';

checkAccess(['admin', 'receptionist']);

$clients = $conn->query("SELECT id, name FROM users WHERE role = 'client' ORDER BY name ASC");
$services = $conn->query("SELECT id, name, price FROM services ORDER BY name ASC");
$stylists = $conn->query("SELECT id, name, commission_rate FROM users WHERE role = 'stylist' AND status = 'active'");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>New Checkout | Elegance Salon</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
</head>
<body>
    <?php include('../includes/sidebar.php'); ?>
    <div class="main-area">
        <?php include('../includes/topbar.php'); ?>
        <div class="content-area">
            <div class="panel mx-auto" style="max-width: 600px;">
                <div class="panel-header border-bottom">
                    <h2 class="panel-title fs-4">Process Payment</h2>
                </div>
                <form action="payment_proc.php" method="POST">
                    <div class="panel-body">
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Select Client</label>
                            <select name="client_id" class="form-input" required>
                                <option value="">-- Search Client --</option>
                                <?php while($c = $clients->fetch_assoc()): ?>
                                    <option value="<?php echo $c['id']; ?>"><?php echo $c['name']; ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold">Service Performed</label>
                            <select name="service_id" id="service_select" class="form-input" required onchange="updatePrice()">
                                <option value="" data-price="0">-- Select Service --</option>
                                <?php while($ser = $services->fetch_assoc()): ?>
                                    <option value="<?php echo $ser['id']; ?>" data-price="<?php echo $ser['price']; ?>">
                                        <?php echo $ser['name']; ?> (Rs. <?php echo $ser['price']; ?>)
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold">Assigned Stylist</label>
                            <select name="stylist_id" class="form-input" required>
                                <option value="">-- Select Stylist --</option>
                                <?php while($s = $stylists->fetch_assoc()): ?>
                                    <option value="<?php echo $s['id']; ?>"><?php echo $s['name']; ?> (Comm: <?php echo $s['commission_rate']; ?>%)</option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-bold">Amount to Pay</label>
                                <input type="number" name="amount" id="final_amount" class="form-input bg-light" readonly required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-bold">Payment Method</label>
                                <select name="method" class="form-input">
                                    <option value="cash">Cash</option>
                                    <option value="card">Debit/Credit Card</option>
                                    <option value="online">Online Transfer</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer p-3 border-top d-flex justify-content-end gap-2">
                        <a href="payments.php" class="btn btn-outline-secondary">Cancel</a>
                        <button type="submit" name="process_payment" class="btn-gold px-4">Complete Payment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        function updatePrice() {
            const select = document.getElementById('service_select');
            const price = select.options[select.selectedIndex].getAttribute('data-price');
            document.getElementById('final_amount').value = price;
        }
    </script>
</body>
</html>