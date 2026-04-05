<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management | Elegance Salon</title>
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
                    <h2 class="mb-1 text-charcoal">Inventory & Supplies</h2>
                    <p class="text-muted small">Track stock levels and manage salon supplies</p>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-elegance" data-bs-toggle="modal" data-bs-target="#orderModal">
                        <i class="bi bi-cart-plus me-2"></i> Purchase Order
                    </button>
                    <button class="btn btn-elegance shadow-sm" data-bs-toggle="modal" data-bs-target="#addItemModal">
                        <i class="bi bi-plus-lg me-2"></i> Add New Item
                    </button>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="elegance-card text-center border-bottom border-gold border-3">
                        <h6 class="text-muted small text-uppercase">Total Items</h6>
                        <h3 class="fw-bold">142</h3>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="elegance-card text-center border-bottom border-danger border-3">
                        <h6 class="text-muted small text-uppercase">Low Stock</h6>
                        <h3 class="fw-bold text-danger">5</h3>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="elegance-card text-center border-bottom border-primary border-3">
                        <h6 class="text-muted small text-uppercase">Out of Stock</h6>
                        <h3 class="fw-bold text-dark">2</h3>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="elegance-card text-center border-bottom border-success border-3">
                        <h6 class="text-muted small text-uppercase">Inventory Value</h6>
                        <h3 class="fw-bold">$12,450</h3>
                    </div>
                </div>
            </div>

            <div class="elegance-card p-0 overflow-hidden">
                <div class="p-4 border-bottom bg-white">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h5 class="mb-0">Current Stock</h5>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <div class="input-group input-group-sm d-inline-flex w-auto">
                                <input type="text" class="form-control" placeholder="Search product...">
                                <button class="btn btn-outline-secondary"><i class="bi bi-search"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4">Item Details</th>
                                <th>Category</th>
                                <th>Unit Price</th>
                                <th>Stock Level</th>
                                <th>Supplier</th>
                                <th class="pe-4 text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="ps-4">
                                    <div class="fw-bold">L'Oréal Revitalift</div>
                                    <small class="text-muted">SKU: EL-SC-001</small>
                                </td>
                                <td><span class="badge border text-dark fw-normal">Skincare</span></td>
                                <td>$45.00</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <span class="fw-bold text-danger me-2">3</span>
                                        <div class="progress flex-grow-1" style="height: 6px; width: 60px;">
                                            <div class="progress-bar bg-danger" style="width: 20%"></div>
                                        </div>
                                    </div>
                                    <small class="text-danger" style="font-size: 0.7rem;">Low Stock (Min: 10)</small>
                                </td>
                                <td>Luxury Beauty Corp</td>
                                <td class="pe-4 text-end">
                                    <button class="btn btn-sm btn-light border" title="Update Stock"><i class="bi bi-arrow-repeat"></i></button>
                                    <button class="btn btn-sm btn-light border" title="Edit Item"><i class="bi bi-pencil"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td class="ps-4">
                                    <div class="fw-bold">Premium Argan Oil</div>
                                    <small class="text-muted">SKU: EL-HC-042</small>
                                </td>
                                <td><span class="badge border text-dark fw-normal">Hair Care</span></td>
                                <td>$28.50</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <span class="fw-bold text-dark me-2">48</span>
                                        <div class="progress flex-grow-1" style="height: 6px; width: 60px;">
                                            <div class="progress-bar bg-success" style="width: 80%"></div>
                                        </div>
                                    </div>
                                    <small class="text-muted" style="font-size: 0.7rem;">Healthy Level</small>
                                </td>
                                <td>Global Salon Supplies</td>
                                <td class="pe-4 text-end">
                                    <button class="btn btn-sm btn-light border"><i class="bi bi-arrow-repeat"></i></button>
                                    <button class="btn btn-sm btn-light border"><i class="bi bi-pencil"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addItemModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-charcoal text-white">
                <h5 class="modal-title">Add New Inventory Item</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Item Name</label>
                        <input type="text" class="form-control" placeholder="e.g. Shampoo 500ml">
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label class="form-label small fw-bold">Category</label>
                            <select class="form-select">
                                <option>Hair Care</option>
                                <option>Skincare</option>
                                <option>Tools</option>
                            </select>
                        </div>
                        <div class="col">
                            <label class="form-label small fw-bold">Initial Quantity</label>
                            <input type="number" class="form-control" placeholder="0">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-danger">Low Stock Alert Level</label>
                        <input type="number" class="form-control border-danger" placeholder="Min. level to trigger alert">
                    </div>
                    <button type="submit" class="btn btn-elegance w-100">Add to Stock</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>