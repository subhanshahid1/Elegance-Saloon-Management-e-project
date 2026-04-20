<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';
checkAccess(['admin']);

// 1. ADMIN NOTIFICATION LOGIC
// This will automatically notify admin if there are new critical feedbacks (1-2 stars) 
// that haven't been "read" yet.
$critical_check = $conn->query("SELECT id, name, rating FROM feedbacks WHERE rating <= 2 AND created_at >= NOW() - INTERVAL 1 DAY");
if ($critical_check->num_rows > 0) {
    while ($crit = $critical_check->fetch_assoc()) {
        $notif_title = "Critical Feedback";
        $notif_msg = "New " . $crit['rating'] . "-star review from " . $crit['name'];
        $notif_link = "feedback.php";
        $uid = $_SESSION['user_id'];

        // Check if this specific notification was already sent to avoid duplicates
        $check_dup = $conn->prepare("SELECT id FROM notifications WHERE message = ? AND user_id = ?");
        $check_dup->bind_param("si", $notif_msg, $uid);
        $check_dup->execute();
        if ($check_dup->get_result()->num_rows == 0) {
            $ins = $conn->prepare("INSERT INTO notifications (user_id, title, message, link, type, is_read) VALUES (?, ?, ?, ?, 'feedback', 0)");
            $ins->bind_param("isss", $uid, $notif_title, $notif_msg, $notif_link);
            $ins->execute();
        }
    }
}

// 2. Get Summary Stats
$stats_query = "SELECT 
    COUNT(*) as total_reviews, 
    AVG(rating) as avg_rating,
    SUM(CASE WHEN rating = 5 THEN 1 ELSE 0 END) as star5,
    SUM(CASE WHEN rating = 4 THEN 1 ELSE 0 END) as star4,
    SUM(CASE WHEN rating = 3 THEN 1 ELSE 0 END) as star3,
    SUM(CASE WHEN rating = 2 THEN 1 ELSE 0 END) as star2,
    SUM(CASE WHEN rating = 1 THEN 1 ELSE 0 END) as star1
FROM feedbacks";

$stats_res = $conn->query($stats_query);
$stats = $stats_res->fetch_assoc();

$total = $stats['total_reviews'] ?: 1;
$average = round($stats['avg_rating'], 1) ?: 0;

// 3. Filter Logic
$filter = $_GET['filter'] ?? 'newest';
$order_by = ($filter === 'critical') ? "rating ASC, created_at DESC" : "created_at DESC";

// 4. Fetch List
$feedbacks = $conn->query("SELECT * FROM feedbacks WHERE status != 'archived' ORDER BY $order_by LIMIT 50");

// Helpers
function get_percent($val, $total)
{
    return ($val / $total) * 100;
}

function time_elapsed_string($datetime)
{
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);
    $w = floor($diff->d / 7);
    $d = $diff->d - ($w * 7);
    $items = ['y' => 'yr', 'm' => 'mo', 'w' => $w, 'd' => $d, 'h' => $diff->h, 'i' => 'min'];
    $labels = ['y' => 'year', 'm' => 'month', 'w' => 'week', 'd' => 'day', 'h' => 'hour', 'i' => 'minute'];
    foreach ($items as $k => $v) {
        if ($v > 0) return $v . ' ' . $labels[$k] . ($v > 1 ? 's' : '') . ' ago';
    }
    return 'Just now';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback | Elegance Salon</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <style>
        :root {
            --gold: #c9a84c;
            --charcoal: #1a1a1a;
        }

        .feedback-item {
            padding: 20px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .star-rating {
            color: var(--gold);
            font-size: 12px;
        }

        .tab-pills-container {
            background: #f8f9fa;
            padding: 5px;
            border-radius: 30px;
            display: inline-flex;
            border: 1px solid #eee;
        }

        .tab-pill {
            padding: 6px 20px;
            font-size: 13px;
            border-radius: 20px;
            color: #666 !important;
            text-decoration: none !important;
            transition: 0.3s;
        }

        .tab-pill.active {
            background: var(--gold) !important;
            color: white !important;
        }

        .sentiment-badge {
            font-size: 9px;
            padding: 2px 8px;
            border-radius: 4px;
            text-transform: uppercase;
            font-weight: 700;
        }

        .sentiment-positive {
            background: #E8F5E9;
            color: #2E7D32;
        }

        .sentiment-neutral {
            background: #FFF3E0;
            color: #EF6C00;
        }

        .sentiment-critical {
            background: #FFEBEE;
            color: #C62828;
        }

        .inv-bar {
            height: 6px;
            background: #eee;
            border-radius: 10px;
            margin: 4px 0;
        }

        .inv-fill {
            height: 100%;
            background: var(--gold);
            border-radius: 10px;
        }

        @media (max-width: 768px) {
            .rating-huge {
                font-size: 36px;
            }
        }

        @media print {

            .sidebar,
            .topbar,
            .tab-pills-container,
            .btn-outline,
            .btn-gold {
                display: none !important;
            }

            .main-area {
                margin: 0;
                padding: 0;
                width: 100%;
            }

            .panel {
                box-shadow: none !important;
                border: 1px solid #ddd !important;
            }
        }
    </style>
</head>

<body>
    <?php include('../includes/sidebar.php'); ?>
    <div class="main-area">
        <?php include('../includes/topbar.php'); ?>
        <div class="content-area container-fluid px-3 px-md-4 py-4">
            <div class="row g-3 align-items-center mb-4">
                <div class="col-12 col-md-6">
                    <h2 class="panel-title fs-3 mb-1">Customer Feedback</h2>
                    <p class="panel-subtitle">Salon Satisfaction Overview</p>
                </div>
                <div class="col-12 col-md-6 d-flex justify-content-md-end gap-2">
                    <a href="../feedback.php" class="btn-outline btn-sm text-decoration-none"><i class="bi bi-eye"></i> Form</a>
                    <button onclick="window.print()" class="btn-gold btn-sm"><i class="bi bi-printer"></i> Print</button>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-12 col-lg-4">
                    <div class="panel p-4 text-center mb-4 bg-white shadow-sm">
                        <div class="small text-muted text-uppercase fw-bold mb-2">Avg Rating</div>
                        <div class="display-5 fw-bold text-dark"><?php echo $average; ?></div>
                        <div class="star-rating fs-5 mb-2">
                            <?php for ($i = 1; $i <= 5; $i++) echo ($i <= $average) ? '<i class="bi bi-star-fill"></i>' : '<i class="bi bi-star"></i>'; ?>
                        </div>
                        <div class="small text-muted">From <?php echo number_format($total); ?> reviews</div>
                    </div>

                    <div class="panel p-4 bg-white shadow-sm">
                        <h6 class="fw-bold mb-3">Rating Breakdown</h6>
                        <?php for ($s = 5; $s >= 1; $s--):
                            $count = $stats['star' . $s] ?? 0;
                            $pct = get_percent($count, $total); ?>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between small mb-1">
                                    <span><?php echo $s; ?> Stars</span>
                                    <span class="text-muted"><?php echo round($pct); ?>%</span>
                                </div>
                                <div class="inv-bar">
                                    <div class="inv-fill" style="width:<?php echo $pct; ?>%"></div>
                                </div>
                            </div>
                        <?php endfor; ?>
                    </div>
                </div>

                <div class="col-12 col-lg-8">
                    <div class="panel bg-white shadow-sm overflow-hidden">
                        <div class="p-3 border-bottom bg-light d-flex justify-content-center justify-content-md-start">
                            <div class="tab-pills-container">
                                <a href="?filter=newest" class="tab-pill <?php echo $filter == 'newest' ? 'active' : ''; ?>">Newest</a>
                                <a href="?filter=critical" class="tab-pill <?php echo $filter == 'critical' ? 'active' : ''; ?>">Critical</a>
                            </div>
                        </div>

                        <div class="feedback-list">
                            <?php if ($feedbacks->num_rows > 0): while ($row = $feedbacks->fetch_assoc()):
                                    $sent = ($row['rating'] >= 4) ? 'positive' : (($row['rating'] == 3) ? 'neutral' : 'critical'); ?>
                                    <div class="feedback-item">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <div>
                                                <div class="fw-bold text-dark"><?php echo htmlspecialchars($row['name']); ?></div>
                                                <div class="small text-muted mb-2" style="font-size: 11px;">
                                                    <i class="bi bi-clock"></i> <?php echo time_elapsed_string($row['created_at']); ?> • <?php echo htmlspecialchars($row['email']); ?>
                                                </div>
                                                <div class="star-rating mb-2">
                                                    <?php for ($i = 1; $i <= 5; $i++) echo ($i <= $row['rating']) ? '<i class="bi bi-star-fill"></i>' : '<i class="bi bi-star"></i>'; ?>
                                                </div>
                                                <p class="small text-secondary mb-0">"<?php echo htmlspecialchars($row['message']); ?>"</p>
                                            </div>
                                            <span class="sentiment-badge sentiment-<?php echo $sent; ?>"><?php echo $sent; ?></span>
                                        </div>
                                    </div>
                                <?php endwhile;
                            else: ?>
                                <div class="p-5 text-center text-muted">No reviews found.</div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/dashboard.js"></script>
</body>

</html>