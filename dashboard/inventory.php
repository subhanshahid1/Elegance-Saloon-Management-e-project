<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory | Elegance Salon</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/dashboard.css">

    <style>
        /* ===== INVENTORY SPECIFIC STYLES ===== */
        .inv-item-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .inv-img-placeholder {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            background: var(--cream);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--gold);
            border: 1px solid rgba(0,0,0,0.05);
            flex-shrink: 0;
        }
        .inv-label {
            display: flex;
            justify-content: space-between;
            margin-bottom: 6px;
            font-size: 12px;
        }
        .inv-name-main {
            font-weight: 500;
            display: block;
        }
        .inv-category {
            font-size: 11px;
            color: #999;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .stock-count {
            font-family: var(--font-display);
            font-weight: 600;
            font-size: 16px;
        }
        
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
                    <h2 class="panel-title fs-3">Inventory & Supplies</h2>
                    <p class="panel-subtitle">Track stock levels and manage product orders</p>
                </div>
                <div class="col-12 col-md-6 d-flex justify-content-md-end gap-2">
                    <button class="btn-outline">
                        <i class="bi bi-cart-plus"></i> Order Supplies
                    </button>
                    <button class="btn-gold">
                        <i class="bi bi-plus-lg"></i> Add New Product
                    </button>
                </div>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-6 col-md-3">
                    <div class="panel p-3 text-center">
                        <div class="panel-subtitle">Total Items</div>
                        <div class="stock-count">142</div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="panel p-3 text-center">
                        <div class="panel-subtitle">Low Stock</div>
                        <div class="stock-count text-warning">8</div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="panel p-3 text-center">
                        <div class="panel-subtitle">Out of Stock</div>
                        <div class="stock-count text-danger">2</div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="panel p-3 text-center">
                        <div class="panel-subtitle">Inventory Value</div>
                        <div class="stock-count">₨185k</div>
                    </div>
                </div>
            </div>

            <div class="panel">
                <div class="panel-header">
                    <div class="tab-pills">
                        <button class="tab-pill active" onclick="activateTab(this)">All Products</button>
                        <button class="tab-pill" onclick="activateTab(this)">Hair Care</button>
                        <button class="tab-pill" onclick="activateTab(this)">Skin Care</button>
                        <button class="tab-pill" onclick="activateTab(this)">Tools</button>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Product Details</th>
                                <th>Category</th>
                                <th style="width: 250px;">Stock Level</th>
                                <th class="hide-mobile">Price</th>
                                <th>Status</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="inv-item-info">
                                        <div class="inv-img-placeholder"><i class="bi bi-droplet-fill"></i></div>
                                        <div>
                                            <span class="inv-name-main">Shampoo Refill (5L)</span>
                                            <span class="small text-muted">L'Oreal Professional</span>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="inv-category">Hair Care</span></td>
                                <td>
                                    <div class="inv-label">
                                        <span>Current: 12%</span>
                                        <span>Goal: 100%</span>
                                    </div>
                                    <div class="inv-bar"><div class="inv-fill critical" style="width: 12%;"></div></div>
                                </td>
                                <td class="hide-mobile">₨4,500</td>
                                <td><span class="badge-critical">Critical</span></td>
                                <td class="text-end">
                                    <button class="logout-btn text-dark me-2"><i class="bi bi-plus-circle"></i></button>
                                    <button class="logout-btn"><i class="bi bi-pencil"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="inv-item-info">
                                        <div class="inv-img-placeholder"><i class="bi bi-magic"></i></div>
                                        <div>
                                            <span class="inv-name-main">Golden Brown Tint</span>
                                            <span class="small text-muted">Wella Koleston</span>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="inv-category">Color</span></td>
                                <td>
                                    <div class="inv-label">
                                        <span>Current: 28%</span>
                                        <span>Goal: 100%</span>
                                    </div>
                                    <div class="inv-bar"><div class="inv-fill low" style="width: 28%;"></div></div>
                                </td>
                                <td class="hide-mobile">₨1,200</td>
                                <td><span class="badge-low">Low Stock</span></td>
                                <td class="text-end">
                                    <button class="logout-btn text-dark me-2"><i class="bi bi-plus-circle"></i></button>
                                    <button class="logout-btn"><i class="bi bi-pencil"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="inv-item-info">
                                        <div class="inv-img-placeholder"><i class="bi bi-wind"></i></div>
                                        <div>
                                            <span class="inv-name-main">Argan Oil Serum</span>
                                            <span class="small text-muted">Moroccanoil</span>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="inv-category">Styling</span></td>
                                <td>
                                    <div class="inv-label">
                                        <span>Current: 85%</span>
                                        <span>Goal: 100%</span>
                                    </div>
                                    <div class="inv-bar"><div class="inv-fill ok" style="width: 85%;"></div></div>
                                </td>
                                <td class="hide-mobile">₨3,800</td>
                                <td><span class="badge-ok">In Stock</span></td>
                                <td class="text-end">
                                    <button class="logout-btn text-dark me-2"><i class="bi bi-plus-circle"></i></button>
                                    <button class="logout-btn"><i class="bi bi-pencil"></i></button>
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
        document.getElementById('page-title').textContent = "Inventory Management";
    </script>
</body>
</html>