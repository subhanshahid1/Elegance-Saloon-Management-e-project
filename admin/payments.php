<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payments & Invoices | Elegance Salon</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/admin-style.css">
</head>
<body>

<div class="main-wrapper">
    <?php include('includes/sidebar.php'); ?>

    <div id="content-area" class="p-0">
        <?php include('includes/topbar.php'); ?>

        <div class="p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="mb-1 text-charcoal font-display">Payments & Billing</h2>
                    <p class="text-muted small">Manage invoices, receipts, and daily revenue</p>
                </div>
                <button class="btn btn-elegance shadow-sm" data-bs-toggle="modal" data-bs-target="#newPaymentModal">
                    <i class="bi bi-receipt me-2"></i> Process New Payment
                </button>
            </div>

            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="elegance-card border-0 shadow-sm">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="text-muted small text-uppercase">Today's Revenue</h6>
                                <h3 class="fw-bold mb-0">$1,240.50</h3>
                            </div>
                            <div class="bg-success-subtle p-3 rounded">
                                <i class="bi bi-cash-stack text-success fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="elegance-card border-0 shadow-sm">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="text-muted small text-uppercase">Pending Invoices</h6>
                                <h3 class="fw-bold mb-0">14</h3>
                            </div>
                            <div class="bg-warning-subtle p-3 rounded">
                                <i class="bi bi-clock-history text-warning fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="elegance-card border-0 shadow-sm">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="text-muted small text-uppercase">Monthly Target</h6>
                                <h3 class="fw-bold mb-0">78%</h3>
                            </div>
                            <div class="bg-gold-light p-3 rounded">
                                <i class="bi bi-graph-up-arrow text-gold fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="elegance-card p-0 overflow-hidden shadow-sm">
                <div class="p-4 border-bottom bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">Recent Transactions</h5>
                    <div class="d-flex gap-2">
                        <input type="text" class="form-control form-control-sm" placeholder="Invoice #">
                        <button class="btn btn-sm btn-light border">Filter</button>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4">Invoice #</th>
                                <th>Client</th>
                                <th>Date</th>
                                <th>Method</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th class="pe-4 text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="ps-4 fw-bold">#INV-8821</td>
                                <td>Jane Doe</td>
                                <td>Oct 24, 2023</td>
                                <td><i class="bi bi-credit-card me-2"></i>Card</td>
                                <td class="fw-bold">$125.00</td>
                                <td><span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2">Paid</span></td>
                                <td class="pe-4 text-end">
                                    <button class="btn btn-sm btn-light border" title="Download PDF"><i class="bi bi-download"></i></button>
                                    <button class="btn btn-sm btn-light border" title="Print Receipt"><i class="bi bi-printer"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td class="ps-4 fw-bold">#INV-8820</td>
                                <td>Mark Wilson</td>
                                <td>Oct 23, 2023</td>
                                <td><i class="bi bi-cash me-2"></i>Cash</td>
                                <td class="fw-bold">$45.00</td>
                                <td><span class="badge bg-warning-subtle text-warning border border-warning-subtle px-3 py-2">Unpaid</span></td>
                                <td class="pe-4 text-end">
                                    <button class="btn btn-sm btn-light border"><i class="bi bi-download"></i></button>
                                    <button class="btn btn-sm btn-gold text-white"><i class="bi bi-check2-circle"></i> Mark Paid</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="newPaymentModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-charcoal text-white">
                <h5 class="modal-title font-display">Record Service Payment</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Select Appointment / Client</label>
                        <select class="form-select">
                            <option>Jane Doe - Hair Styling (Oct 24)</option>
                            <option>New Walk-in Client</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Total Amount Due</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" class="form-control" placeholder="0.00">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Payment Method</label>
                        <div class="d-flex gap-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payMethod" id="cash">
                                <label class="form-check-label" for="cash">Cash</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payMethod" id="card" checked>
                                <label class="form-check-label" for="card">Credit Card</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payMethod" id="online">
                                <label class="form-check-label" for="online">Online</label>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-3">
                        <span>Subtotal:</span>
                        <span class="fw-bold">$120.00</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span>Tax (5%):</span>
                        <span class="fw-bold">$5.00</span>
                    </div>
                    <button type="submit" class="btn btn-elegance w-100 py-2">Generate Receipt & Close</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>