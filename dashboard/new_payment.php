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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Checkout | Elegance Salon</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <style>
        /* Responsive tweaks */
        .content-area {
            padding: 20px;
        }

        @media (max-width: 576px) {
            .content-area {
                padding: 10px;
            }

            .panel-title {
                font-size: 1.1rem !important;
            }

            .btn-gold {
                width: 100%;
                justify-content: center;
            }

            .panel-footer {
                flex-direction: column-reverse;
            }

            .panel-footer a {
                width: 100%;
                text-align: center;
            }
        }

        /* Ensure form inputs look good on all screens */
        .form-input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <?php include('../includes/sidebar.php'); ?>

    <div class="main-area">
        <?php include('../includes/topbar.php'); ?>

        <div class="content-area container-fluid">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-8 col-xl-6">
                    <div class="panel shadow-sm">
                        <div class="panel-header border-bottom p-3">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-wallet2 text-gold fs-4 me-2"></i>
                                <h2 class="panel-title fs-4 m-0">Process Payment</h2>
                            </div>
                        </div>

                        <form action="payment_proc.php" method="POST">
                            <div class="panel-body p-3 p-md-4">
                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <label class="form-label small fw-bold">Select Client</label>
                                        <select name="client_id" class="form-select form-input" required>
                                            <option value="">-- Search Client --</option>
                                            <?php while ($c = $clients->fetch_assoc()): ?>
                                                <option value="<?php echo $c['id']; ?>"><?php echo $c['name']; ?></option>
                                            <?php endwhile; ?>
                                        </select>
                                    </div>

                                    <div class="col-12 mb-3">
                                        <label class="form-label small fw-bold">Service Performed</label>
                                        <select name="service_id" id="service_select" class="form-select form-input" required onchange="updatePrice()">
                                            <option value="" data-price="0">-- Select Service --</option>
                                            <?php while ($ser = $services->fetch_assoc()): ?>
                                                <option value="<?php echo $ser['id']; ?>" data-price="<?php echo $ser['price']; ?>">
                                                    <?php echo $ser['name']; ?> (Rs. <?php echo $ser['price']; ?>)
                                                </option>
                                            <?php endwhile; ?>
                                        </select>
                                    </div>

                                    <div class="col-12 mb-3">
                                        <label class="form-label small fw-bold">Assigned Stylist</label>
                                        <select name="stylist_id" class="form-select form-input" required>
                                            <option value="">-- Select Stylist --</option>
                                            <?php while ($s = $stylists->fetch_assoc()): ?>
                                                <option value="<?php echo $s['id']; ?>"><?php echo $s['name']; ?> (Comm: <?php echo $s['commission_rate']; ?>%)</option>
                                            <?php endwhile; ?>
                                        </select>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label small fw-bold">Amount to Pay (Rs.)</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">Rs.</span>
                                            <input type="number" name="amount" id="final_amount" class="form-control bg-light border-start-0" readonly required>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label small fw-bold">Payment Method</label>
                                        <select name="method" class="form-select form-input">
                                            <option value="cash">Cash</option>
                                            <option value="card">Debit/Credit Card</option>
                                            <option value="online">Online Transfer</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="panel-footer p-3 border-top d-flex flex-sm-row justify-content-end gap-2">
                                <a href="payments.php" class="btn btn-outline-secondary">Cancel</a>
                                <button type="submit" name="process_payment" class="btn-gold px-4">
                                    <i class="bi bi-check-circle me-1"></i> Complete Payment
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/dashboard.js"></script>
    <script>
        function updatePrice() {
            const select = document.getElementById('service_select');
            const price = select.options[select.selectedIndex].getAttribute('data-price');
            document.getElementById('final_amount').value = price;
        }
    </script>
</body>

</html>