<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Feedback | Elegance Salon</title>
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
            <h2 class="mb-4 font-display">Client Feedback</h2>
            
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="elegance-card text-center">
                        <h6 class="text-muted small uppercase">Average Rating</h6>
                        <h1 class="display-4 fw-bold text-gold">4.8</h1>
                        <div class="text-gold">
                            <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-half"></i>
                        </div>
                        <p class="small text-muted mt-2">Based on 124 reviews</p>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="elegance-card p-0 overflow-hidden">
                        <div class="list-group list-group-flush">
                            <div class="list-group-item p-4">
                                <div class="d-flex justify-content-between">
                                    <h6 class="fw-bold mb-1">Jane Doe</h6>
                                    <small class="text-muted">2 hours ago</small>
                                </div>
                                <div class="text-gold mb-2 small"><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i></div>
                                <p class="mb-0 small text-secondary">"The hair coloring service was exceptional! Sarah really knows her craft. The salon atmosphere is so relaxing."</p>
                            </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>