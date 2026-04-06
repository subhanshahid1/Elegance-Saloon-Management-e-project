<?php
/* ===== INCLUDES ===== */
require_once 'config/config.php';
require_once 'includes/db.php';

/* ===== REDIRECT IF ALREADY LOGGED IN ===== */
if (isset($_SESSION['user_id'])) {
    header('Location: ' . SITE_URL . '/index.php');
    exit();
}

/* ===== GET TOKEN FROM URL ===== */
$token = isset($_GET['token']) ? trim($_GET['token']) : '';
$error   = '';
$success = '';

/* ===== VALIDATE TOKEN ===== */
if (empty($token)) {
    header('Location: ' . SITE_URL . '/login.php');
    exit();
}

/* --- Check token exists and not expired --- */
$token  = mysqli_real_escape_string($conn, $token);
$now    = date('Y-m-d H:i:s');
$result = mysqli_query($conn, "SELECT * FROM password_resets WHERE token = '$token' AND expires_at > '$now' LIMIT 1");

if (mysqli_num_rows($result) === 0) {
    $error = 'This reset link is invalid or has expired. Please request a new one.';
    $tokenValid = false;
} else {
    $reset      = mysqli_fetch_assoc($result);
    $tokenValid = true;
}

/* ===== RESET PASSWORD LOGIC ===== */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $tokenValid) {

    $password = trim($_POST['password']);
    $confirm  = trim($_POST['confirm_password']);

    if (empty($password) || empty($confirm)) {
        $error = 'Please fill in both fields.';

    } elseif (strlen($password) < 6) {
        $error = 'Password must be at least 6 characters.';

    } elseif ($password !== $confirm) {
        $error = 'Passwords do not match.';

    } else {

        /* --- HASH NEW PASSWORD --- */
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $email  = $reset['email'];

        /* --- UPDATE PASSWORD IN DATABASE --- */
        mysqli_query($conn, "UPDATE users SET password = '$hashed' WHERE email = '$email'");

        /* --- DELETE USED TOKEN --- */
        mysqli_query($conn, "DELETE FROM password_resets WHERE token = '$token'");

        $success    = 'Password updated successfully! Redirecting to login...';
        $tokenValid = false;
        header('Refresh: 2; URL=' . SITE_URL . '/login.php');
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password | <?php echo SITE_NAME; ?></title>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;600&family=DM+Sans:opsz,wght@9..40,400;9..40,500&display=swap" rel="stylesheet">
    <style>
        :root {
            --gold: #C9A84C; --gold-dark: #8B6914;
            --cream: #FAF7F2; --rose: #C48B8B;
            --charcoal: #1C1C1E;
            --font-display: 'Cormorant Garamond', serif;
            --font-body: 'DM Sans', sans-serif;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: var(--font-body); background: var(--cream);
            min-height: 100vh; display: flex;
            align-items: center; justify-content: center; padding: 30px 16px;
        }
        .wrapper { width: 100%; max-width: 420px; }
        .brand-header { text-align: center; margin-bottom: 32px; }
        .brand-name { font-family: var(--font-display); font-size: 38px; color: var(--charcoal); }
        .gold-line { width: 40px; height: 2px; background: var(--gold); margin: 10px auto; border-radius: 2px; }
        .brand-tagline { font-size: 12px; color: #bbb; letter-spacing: 0.1em; text-transform: uppercase; }
        .card-box {
            background: white; border-radius: 18px; padding: 36px 38px;
            border: 1px solid rgba(0,0,0,0.06); box-shadow: 0 4px 24px rgba(0,0,0,0.06);
        }
        .card-title { font-family: var(--font-display); font-size: 26px; color: var(--charcoal); margin-bottom: 6px; }
        .card-subtitle { font-size: 13px; color: #aaa; margin-bottom: 26px; }
        .form-label-sm {
            font-size: 11px; font-weight: 500; color: #999;
            text-transform: uppercase; letter-spacing: 0.08em;
            margin-bottom: 6px; display: block;
        }
        .form-input {
            width: 100%; padding: 10px 38px;
            border: 1px solid rgba(0,0,0,0.1); border-radius: 9px;
            font-size: 13px; font-family: var(--font-body);
            color: var(--charcoal); outline: none; transition: border-color 0.15s;
        }
        .form-input:focus { border-color: var(--gold); box-shadow: 0 0 0 3px rgba(201,168,76,0.08); }
        .input-wrap { position: relative; margin-bottom: 16px; }
        .input-icon { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #ccc; font-size: 15px; }
        .toggle-password {
            position: absolute; right: 12px; top: 50%; transform: translateY(-50%);
            color: #ccc; font-size: 15px; cursor: pointer;
            background: none; border: none; padding: 0; transition: color 0.15s;
        }
        .toggle-password:hover { color: var(--gold); }
        .btn-gold {
            width: 100%; padding: 12px; background: var(--gold);
            border: none; border-radius: 9px; color: white;
            font-size: 14px; font-weight: 500; font-family: var(--font-body);
            cursor: pointer; transition: background 0.15s;
            display: flex; align-items: center; justify-content: center; gap: 8px; margin-top: 6px;
        }
        .btn-gold:hover { background: var(--gold-dark); }
        .alert-custom { padding: 11px 14px; border-radius: 9px; font-size: 13px; margin-bottom: 18px; display: flex; align-items: center; gap: 9px; }
        .alert-error   { background: rgba(231,76,60,0.07); border: 1px solid rgba(231,76,60,0.2); color: #C0392B; }
        .alert-success { background: rgba(39,174,96,0.07); border: 1px solid rgba(39,174,96,0.2); color: #1E8449; }
        .bottom-link { text-align: center; margin-top: 20px; font-size: 13px; color: #aaa; }
        .bottom-link a { color: var(--gold); text-decoration: none; font-weight: 500; }
    </style>
</head>
<body>
    <div class="wrapper">

        <div class="brand-header">
            <div class="brand-name">Elegance</div>
            <div class="gold-line"></div>
            <div class="brand-tagline">Salon & Spa Management</div>
        </div>

        <div class="card-box">
            <div class="card-title">Reset Password</div>
            <div class="card-subtitle">Enter your new password below.</div>

            <?php if ($error): ?>
                <div class="alert-custom alert-error">
                    <i class="bi bi-exclamation-circle-fill"></i>
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="alert-custom alert-success">
                    <i class="bi bi-check-circle-fill"></i>
                    <?php echo $success; ?>
                </div>
            <?php endif; ?>

            <?php if ($tokenValid): ?>
                <form method="POST" action="">
                    <div class="input-wrap">
                        <label class="form-label-sm">New Password</label>
                        <div style="position:relative;">
                            <i class="bi bi-lock input-icon"></i>
                            <input type="password" name="password" id="pass1" class="form-input" placeholder="Minimum 6 characters" required>
                            <button type="button" class="toggle-password" onclick="togglePass('pass1', this)"><i class="bi bi-eye"></i></button>
                        </div>
                    </div>
                    <div class="input-wrap">
                        <label class="form-label-sm">Confirm New Password</label>
                        <div style="position:relative;">
                            <i class="bi bi-lock-fill input-icon"></i>
                            <input type="password" name="confirm_password" id="pass2" class="form-input" placeholder="Repeat new password" required>
                            <button type="button" class="toggle-password" onclick="togglePass('pass2', this)"><i class="bi bi-eye"></i></button>
                        </div>
                    </div>
                    <button type="submit" class="btn-gold">
                        <i class="bi bi-shield-lock-fill"></i>
                        Update Password
                    </button>
                </form>

            <?php elseif (!$success): ?>
                <div style="text-align:center;padding:10px 0;">
                    <a href="<?php echo SITE_URL; ?>/forgot_password.php" style="color:var(--gold);font-weight:500;text-decoration:none;">
                        Request a new reset link →
                    </a>
                </div>
            <?php endif; ?>
        </div>

        <div class="bottom-link">
            <a href="<?php echo SITE_URL; ?>/login.php">Back to Login</a>
        </div>

    </div>

    <script>
        // ===== TOGGLE PASSWORD =====
        function togglePass(fieldId, btn) {
            const field = document.getElementById(fieldId);
            const icon  = btn.querySelector('i');
            if (field.type === 'password') {
                field.type     = 'text';
                icon.className = 'bi bi-eye-slash';
            } else {
                field.type     = 'password';
                icon.className = 'bi bi-eye';
            }
        }
    </script>
</body>
</html>