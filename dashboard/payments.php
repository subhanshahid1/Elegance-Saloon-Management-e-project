<?php
require_once '../includes/auth.php';
checkAccess(['admin', 'receptionist']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payments | Elegance Salon</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/dashboard.css">

    <style>
        /* ===== PAYMENTS SPECIFIC STYLES ===== */
        .transaction-id {
            font-family: monospace;
            font-size: 11px;
            color: #999;
        }
        .payment-method {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 12px;
        }
        .method-icon {
            width: 24px;
            height: 16px;
            background: #f0f0f0;
            border-radius: 3px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            color: #666;
        }
        .amount-positive {
            font-weight: 600;
            color: var(--charcoal);
        }
        
        /* --- Responsive Adjustments --- */
        @media (max-width: 768px) {
            .hide-mobile { display: none; }
        }
    </style>
</head>
<body>

    <?php include('../includes/sidebar.php'); ?>

    <div class="main-area">
        <?php include('../includes/topbar.php'); ?>

        <div class="content-area">
            
            <div class="row g-3 align-items-center section-gap">
                <div class="col-12 col-md-6">
                    <h2 class="panel-title fs-3">Transactions & Billing</h2>
                    <p class="panel-subtitle">Monitor revenue, invoices, and payment methods</p>
                </div>
                <div class="col-12 col-md-6 d-flex justify-content-md-end gap-2">
                    <button class="btn-outline">
                        <i class="bi bi-file-earmark-pdf"></i> Daily Report
                    </button>
                    <button class="btn-gold">
                        <i class="bi bi-plus-lg"></i> New Invoice
                    </button>
                </div>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-12 col-md-4">
                    <div class="stat-card gold">
                        <div class="stat-label">Daily Revenue</div>
                        <div class="stat-value">₨82,400</div>
                        <div class="stat-change up"><i class="bi bi-arrow-up-short"></i> 12% from yesterday</div>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="stat-card green">
                        <div class="stat-label">Monthly Total</div>
                        <div class="stat-value">₨1.2M</div>
                        <div class="stat-change up"><i class="bi bi-arrow-up-short"></i> Target: 1.5M</div>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="stat-card rose">
                        <div class="stat-label">Pending Payments</div>
                        <div class="stat-value">₨14,500</div>
                        <div class="stat-change warn"><i class="bi bi-clock-history"></i> 3 invoices open</div>
                    </div>
                </div>
            </div>

            <div class="panel">
                <div class="panel-header">
                    <div class="panel-title">Recent Transactions</div>
                    <div class="d-flex gap-2">
                        <select class="form-input py-1" style="width: auto;">
                            <option>All Methods</option>
                            <option>Cash</option>
                            <option>Card</option>
                            <option>Bank Transfer</option>
                        </select>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Invoice ID</th>
                                <th>Customer</th>
                                <th class="hide-mobile">Date</th>
                                <th>Method</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><span class="transaction-id">#INV-8821</span></td>
                                <td>
                                    <div class="fw-bold">Ayesha Noor</div>
                                    <div class="small text-muted hide-mobile">Balayage + Styling</div>
                                </td>
                                <td class="hide-mobile">Apr 4, 2024 · 10:45 AM</td>
                                <td>
                                    <div class="payment-method">
                                        <div class="method-icon"><i class="bi bi-credit-card"></i></div>
                                        <span>Visa ....4242</span>
                                    </div>
                                </td>
                                <td><span class="amount-positive">₨18,500</span></td>
                                <td><span class="badge-paid">Paid</span></td>
                                <td class="text-end">
                                    <button class="logout-btn text-dark" title="Download Receipt"><i class="bi bi-download"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td><span class="transaction-id">#INV-8820</span></td>
                                <td>
                                    <div class="fw-bold">Fatima Khan</div>
                                    <div class="small text-muted hide-mobile">Facial Treatment</div>
                                </td>
                                <td class="hide-mobile">Apr 4, 2024 · 09:15 AM</td>
                                <td>
                                    <div class="payment-method">
                                        <div class="method-icon"><i class="bi bi-cash-stack"></i></div>
                                        <span>Cash</span>
                                    </div>
                                </td>
                                <td><span class="amount-positive">₨6,000</span></td>
                                <td><span class="badge-paid">Paid</span></td>
                                <td class="text-end">
                                    <button class="logout-btn text-dark" title="Download Receipt"><i class="bi bi-download"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td><span class="transaction-id">#INV-8819</span></td>
                                <td>
                                    <div class="fw-bold">Maria Ahmed</div>
                                    <div class="small text-muted hide-mobile">Manicure</div>
                                </td>
                                <td class="hide-mobile">Apr 3, 2024 · 05:30 PM</td>
                                <td>
                                    <div class="payment-method">
                                        <div class="method-icon"><i class="bi bi-bank"></i></div>
                                        <span>Transfer</span>
                                    </div>
                                </td>
                                <td><span class="amount-positive">₨3,500</span></td>
                                <td><span class="badge-pending">Pending</span></td>
                                <td class="text-end">
                                    <button class="logout-btn text-dark" title="Remind"><i class="bi bi-bell"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/dashboard.js"></script>
    <script>
        // ===== PAGE NAVIGATION =====
        document.getElementById('page-title').textContent = "Payments & Revenue";
    </script>
</body>
</html>