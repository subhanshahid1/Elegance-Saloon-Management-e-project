<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';

// Only Admin and Receptionist can access
checkAccess(['admin', 'receptionist']);

// Handle Deletion
if (isset($_GET['delete_id'])) {
    $id = (int)$_GET['delete_id'];
    $conn->query("DELETE FROM contact_messages WHERE id = $id");
    header("Location: messages.php?msg=deleted");
    exit();
}

// Fetch all messages (Note: we select first_name and last_name)
$result = $conn->query("SELECT * FROM contact_messages ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Messages | Elegance Salon</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
</head>

<body>
    <?php include('../includes/sidebar.php'); ?>

    <div class="main-area">
        <?php include('../includes/topbar.php'); ?>

        <div class="content-area container-fluid px-4 py-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold m-0">Client Messages</h2>
                    <p class="text-muted small">Manage inquiries and support requests</p>
                </div>
            </div>

            <?php if (isset($_GET['msg']) && $_GET['msg'] == 'deleted'): ?>
                <div class="alert alert-success border-0 shadow-sm">Message removed successfully.</div>
            <?php endif; ?>

            <div class="panel shadow-sm bg-white rounded">
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead class="bg-light">
                            <tr class="text-muted small">
                                <th class="ps-3">CLIENT INFO</th>
                                <th>SUBJECT</th>
                                <th>MESSAGE</th>
                                <th>DATE RECEIVED</th>
                                <th class="text-end pe-3">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($result && $result->num_rows > 0): ?>
                                <?php while ($row = $result->fetch_assoc()):
                                    // Combine names to fix the "Undefined index: name" error
                                    $fullName = htmlspecialchars($row['first_name'] . ' ' . $row['last_name']);
                                ?>
                                    <tr>
                                        <td class="ps-3">
                                            <div class="fw-bold"><?php echo $fullName; ?></div>
                                            <div class="small text-muted"><i class="bi bi-envelope me-1"></i><?php echo htmlspecialchars($row['email']); ?></div>
                                            <?php if (!empty($row['phone'])): ?>
                                                <div class="small text-muted"><i class="bi bi-telephone me-1"></i><?php echo htmlspecialchars($row['phone']); ?></div>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark border text-capitalize"><?php echo htmlspecialchars($row['subject']); ?></span>
                                        </td>
                                        <td>
                                            <div class="small text-wrap" style="max-width: 300px;">
                                                <?php echo nl2br(htmlspecialchars($row['message'])); ?>
                                            </div>
                                        </td>
                                        <td class="small text-muted">
                                            <?php echo date('M d, Y', strtotime($row['created_at'])); ?><br>
                                            <?php echo date('h:i A', strtotime($row['created_at'])); ?>
                                        </td>
                                        <td class="text-end pe-3">
                                            <div class="d-flex justify-content-end gap-2">
                                                <?php
                                                $replySubject = "Re: " . $row['subject'] . " - Elegance Salon";
                                                $replyBody = "Hello " . $row['first_name'] . ",\n\nThank you for contacting Elegance Salon.\n\nRegarding your message: \"" . $row['message'] . "\"\n\n";
                                                $gmail_link = "https://mail.google.com/mail/?view=cm&fs=1&to=" . $row['email'] . "&su=" . urlencode($replySubject) . "&body=" . urlencode($replyBody);
                                                ?>
                                                <a href="<?php echo $gmail_link; ?>" target="_blank" class="btn btn-sm btn-outline-primary" title="Reply via Gmail">
                                                    <i class="bi bi-reply-fill"></i> Reply
                                                </a>

                                                <a href="messages.php?delete_id=<?php echo $row['id']; ?>"
                                                    class="btn btn-sm btn-outline-danger"
                                                    onclick="return confirm('Are you sure you want to delete this message?')">
                                                    <i class="bi bi-trash"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">No messages found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/dashboard.js"></script>
</body>

</html>