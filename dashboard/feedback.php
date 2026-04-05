<?php
require_once '../includes/auth.php';
checkAccess(['admin']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback | Elegance Salon</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/dashboard.css">

    <style>
        /* ===== FEEDBACK SPECIFIC STYLES ===== */
        .feedback-item {
            padding: 20px;
            border-bottom: 1px solid rgba(0,0,0,0.05);
            transition: background 0.2s;
        }
        .feedback-item:last-child { border-bottom: none; }
        .feedback-item:hover { background: var(--cream); }

        .star-rating {
            color: var(--gold);
            font-size: 13px;
            margin-bottom: 5px;
        }
        .reviewer-info {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 12px;
        }
        .review-text {
            font-size: 14px;
            color: #555;
            font-style: italic;
            line-height: 1.6;
            margin-bottom: 15px;
            display: block;
        }
        .sentiment-badge {
            font-size: 10px;
            padding: 2px 8px;
            border-radius: 4px;
            text-transform: uppercase;
            font-weight: 600;
        }
        .sentiment-positive { background: #E8F5E9; color: #2E7D32; }
        .sentiment-neutral { background: #FFF3E0; color: #EF6C00; }

        /* --- Rating Summary Card --- */
        .rating-huge {
            font-family: var(--font-display);
            font-size: 48px;
            font-weight: 600;
            line-height: 1;
            color: var(--charcoal);
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
                    <h2 class="panel-title fs-3">Customer Feedback</h2>
                    <p class="panel-subtitle">Monitor reviews and service satisfaction</p>
                </div>
                <div class="col-12 col-md-6 d-flex justify-content-md-end gap-2">
                    <button class="btn-outline">
                        <i class="bi bi-share"></i> Public Page
                    </button>
                    <button class="btn-gold">
                        <i class="bi bi-envelope"></i> Request Feedback
                    </button>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-12 col-lg-4">
                    <div class="panel p-4 text-center mb-4">
                        <div class="panel-subtitle">Average Rating</div>
                        <div class="rating-huge my-2">4.8</div>
                        <div class="star-rating fs-5 mb-3">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-half"></i>
                        </div>
                        <div class="small text-muted">Based on 1,240 reviews</div>
                    </div>

                    <div class="panel p-4">
                        <div class="panel-title fs-6 mb-3">Rating Breakdown</div>
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <span class="small" style="width: 20px;">5</span>
                            <div class="inv-bar flex-grow-1"><div class="inv-fill ok" style="width: 85%;"></div></div>
                        </div>
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <span class="small" style="width: 20px;">4</span>
                            <div class="inv-bar flex-grow-1"><div class="inv-fill ok" style="width: 10%;"></div></div>
                        </div>
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <span class="small" style="width: 20px;">3</span>
                            <div class="inv-bar flex-grow-1"><div class="inv-fill low" style="width: 3%;"></div></div>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <span class="small" style="width: 20px;">2</span>
                            <div class="inv-bar flex-grow-1"><div class="inv-fill critical" style="width: 2%;"></div></div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-8">
                    <div class="panel">
                        <div class="panel-header">
                            <div class="tab-pills">
                                <button class="tab-pill active" onclick="activateTab(this)">Newest</button>
                                <button class="tab-pill" onclick="activateTab(this)">Critical</button>
                                <button class="tab-pill" onclick="activateTab(this)">Featured</button>
                            </div>
                        </div>
                        
                        <div class="feedback-item">
                            <div class="d-flex justify-content-between">
                                <div class="reviewer-info">
                                    <div class="apt-avatar-sm" style="background:var(--blush); color:var(--rose);">AN</div>
                                    <div>
                                        <div class="fw-bold small">Ayesha Noor</div>
                                        <div class="small text-muted" style="font-size: 10px;">2 hours ago · Service: Balayage</div>
                                    </div>
                                </div>
                                <span class="sentiment-badge sentiment-positive">Positive</span>
                            </div>
                            <div class="star-rating">
                                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                            </div>
                            <span class="review-text">"Absolutely loved the color! Sara is a magician with hair. The ambiance was so relaxing and the staff was very professional."</span>
                            <div class="d-flex gap-2">
                                <button class="btn-outline py-1 px-3" style="font-size: 11px;">Reply</button>
                                <button class="btn-outline py-1 px-3" style="font-size: 11px;">Feature</button>
                            </div>
                        </div>

                        <div class="feedback-item">
                            <div class="d-flex justify-content-between">
                                <div class="reviewer-info">
                                    <div class="apt-avatar-sm" style="background:#E8F4FD; color:#2E86C1;">MA</div>
                                    <div>
                                        <div class="fw-bold small">Maria Ahmed</div>
                                        <div class="small text-muted" style="font-size: 10px;">Yesterday · Service: Manicure</div>
                                    </div>
                                </div>
                                <span class="sentiment-badge sentiment-neutral">Neutral</span>
                            </div>
                            <div class="star-rating">
                                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star"></i>
                            </div>
                            <span class="review-text">"The service was good but I had to wait 15 minutes past my appointment time. Hope you guys can improve the scheduling."</span>
                            <div class="d-flex gap-2">
                                <button class="btn-outline py-1 px-3" style="font-size: 11px;">Reply</button>
                                <button class="btn-outline py-1 px-3" style="font-size: 11px;">Archive</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/dashboard.js"></script>
    <script>
        // ===== PAGE NAVIGATION =====
        document.getElementById('page-title').textContent = "Client Feedback";
    </script>
</body>
</html>