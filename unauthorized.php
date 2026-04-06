<?php
require_once 'config/config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Access Denied | <?php echo SITE_NAME; ?></title>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;600&family=DM+Sans:opsz,wght@9..40,400;9..40,500&display=swap" rel="stylesheet">
    <style>
        :root {
            --gold:         #C9A84C;
            --gold-dark:    #8B6914;
            --cream:        #FAF7F2;
            --rose:         #C48B8B;
            --charcoal:     #1C1C1E;
            --font-display: 'Cormorant Garamond', serif;
            --font-body:    'DM Sans', sans-serif;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: var(--font-body);
            background: var(--cream);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 20px;
        }
        .icon {
            font-size: 64px;
            color: var(--rose);
            margin-bottom: 20px;
        }
        .title {
            font-family: var(--font-display);
            font-size: 36px;
            color: var(--charcoal);
            margin-bottom: 10px;
        }
        .message {
            font-size: 14px;
            color: #aaa;
            margin-bottom: 30px;
            line-height: 1.7;
        }
        .btn-gold {
            padding: 11px 28px;
            background: var(--gold);
            border: none;
            border-radius: 9px;
            color: white;
            font-size: 13px;
            font-weight: 500;
            font-family: var(--font-body);
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: background 0.15s;
        }
        .btn-gold:hover { background: var(--gold-dark); color: white; }
    </style>
</head>
<body>
    <div>
        <div class="icon"><i class="bi bi-shield-x"></i></div>
        <div class="title">Access Denied</div>
        <div class="message">
            You do not have permission to view this page.<br>
            Please contact your administrator if you think this is a mistake.
        </div>
        <a href="<?php echo SITE_URL; ?>/index.php" class="btn-gold">
            <i class="bi bi-arrow-left"></i> Back to Homepage
        </a>
    </div>
</body>
</html>