<?php
/* ===== INCLUDE CONFIG & DB ===== */
require_once 'config/config.php';
require_once 'includes/db.php';

/* ===== REDIRECT IF ALREADY LOGGED IN ===== */
if (isset($_SESSION['user_id'])) {
    header('Location: ' . SITE_URL . '/dashboard/index.php');
    exit();
}

/* ===== LOGIN LOGIC ===== */
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    /* --- GET AND CLEAN FORM DATA --- */
    $email    = trim($_POST['email']);
    $password = trim($_POST['password']);

    /* --- BASIC VALIDATION --- */
    if (empty($email) || empty($password)) {
        $error = 'Please enter your email and password.';
    } else {

        /* --- FIND USER BY EMAIL --- */
        $email = mysqli_real_escape_string($conn, $email);
        $sql   = "SELECT * FROM users WHERE email = '$email' AND status = 'active' LIMIT 1";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) === 1) {

            $user = mysqli_fetch_assoc($result);

            /* --- VERIFY PASSWORD --- */
            if (password_verify($password, $user['password'])) {

                /* --- SET SESSION VARIABLES --- */
                $_SESSION['user_id']   = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['role']      = $user['role'];

                /* --- REDIRECT BASED ON ROLE --- */
                if ($user['role'] === 'client') {
                    header('Location: ' . SITE_URL . '/index.php');
                } else {
                    header('Location: ' . SITE_URL . '/dashboard/index.php');
                }
                exit();
            } else {
                $error = 'Incorrect password. Please try again.';
            }
        } else {
            $error = 'No account found with this email address.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <!-- ===== META & TITLE ===== -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | <?php echo SITE_NAME; ?></title>

    <!-- ===== BOOTSTRAP 5 ===== -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- ===== BOOTSTRAP ICONS ===== -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">

    <!-- ===== GOOGLE FONTS ===== -->
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;600&family=DM+Sans:opsz,wght@9..40,400;9..40,500&display=swap" rel="stylesheet">

    <style>
        /* ===== ROOT VARIABLES ===== */
        :root {
            --gold: #C9A84C;
            --gold-dark: #8B6914;
            --cream: #FAF7F2;
            --blush: #F2E8E4;
            --rose: #C48B8B;
            --charcoal: #1C1C1E;
            --font-display: 'Cormorant Garamond', serif;
            --font-body: 'DM Sans', sans-serif;
        }

        /* ===== BASE ===== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: var(--font-body);
            background: var(--cream);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px 16px;
        }

        /* ===== PAGE WRAPPER ===== */
        .login-wrapper {
            width: 100%;
            max-width: 420px;
        }

        /* ===== BRAND HEADER ===== */
        .brand-header {
            text-align: center;
            margin-bottom: 32px;
        }

        .brand-header .brand-name {
            font-family: var(--font-display);
            font-size: 40px;
            color: var(--charcoal);
            letter-spacing: 0.04em;
        }

        .brand-header .gold-line {
            width: 40px;
            height: 2px;
            background: var(--gold);
            margin: 10px auto;
            border-radius: 2px;
        }

        .brand-header .brand-tagline {
            font-size: 12px;
            color: #bbb;
            letter-spacing: 0.1em;
            text-transform: uppercase;
        }

        /* ===== LOGIN CARD ===== */
        .login-card {
            background: white;
            border-radius: 18px;
            padding: 36px 38px;
            border: 1px solid rgba(0, 0, 0, 0.06);
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06);
        }

        .card-title {
            font-family: var(--font-display);
            font-size: 26px;
            color: var(--charcoal);
            margin-bottom: 6px;
        }

        .card-subtitle {
            font-size: 13px;
            color: #aaa;
            margin-bottom: 26px;
        }

        /* ===== FORM LABELS ===== */
        .form-label-sm {
            font-size: 11px;
            font-weight: 500;
            color: #999;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-bottom: 6px;
            display: block;
        }

        /* ===== FORM INPUTS ===== */
        .form-input {
            width: 100%;
            padding: 10px 14px 10px 38px;
            border: 1px solid rgba(0, 0, 0, 0.1);
            border-radius: 9px;
            font-size: 13px;
            font-family: var(--font-body);
            background: white;
            color: var(--charcoal);
            outline: none;
            transition: border-color 0.15s;
        }

        .form-input:focus {
            border-color: var(--gold);
            box-shadow: 0 0 0 3px rgba(201, 168, 76, 0.08);
        }

        /* ===== INPUT GROUP ===== */
        .input-group-custom {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #ccc;
            font-size: 15px;
        }

        .toggle-password {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #ccc;
            font-size: 15px;
            cursor: pointer;
            background: none;
            border: none;
            padding: 0;
            transition: color 0.15s;
        }

        .toggle-password:hover {
            color: var(--gold);
        }

        /* ===== SUBMIT BUTTON ===== */
        .btn-gold {
            width: 100%;
            padding: 12px;
            background: var(--gold);
            border: none;
            border-radius: 9px;
            color: white;
            font-size: 14px;
            font-weight: 500;
            font-family: var(--font-body);
            cursor: pointer;
            transition: background 0.15s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 24px;
        }

        .btn-gold:hover {
            background: var(--gold-dark);
        }

        /* ===== FORM GAP ===== */
        .form-gap {
            margin-bottom: 16px;
        }

        /* ===== ALERT MESSAGES ===== */
        .alert-custom {
            padding: 11px 14px;
            border-radius: 9px;
            font-size: 13px;
            margin-bottom: 18px;
            display: flex;
            align-items: center;
            gap: 9px;
        }

        .alert-error {
            background: rgba(231, 76, 60, 0.07);
            border: 1px solid rgba(231, 76, 60, 0.2);
            color: #C0392B;
        }

        /* ===== BOTTOM LINKS ===== */
        .bottom-link {
            text-align: center;
            margin-top: 22px;
            font-size: 13px;
            color: #aaa;
        }

        .bottom-link a {
            color: var(--gold);
            text-decoration: none;
            font-weight: 500;
        }

        .bottom-link a:hover {
            color: var(--gold-dark);
        }

        .back-link {
            text-align: center;
            margin-top: 12px;
        }

        .back-link a {
            font-size: 12px;
            color: #bbb;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            transition: color 0.15s;
        }

        .back-link a:hover {
            color: var(--gold);
        }

        /* ===== ROLE HINT ===== */
        .role-hint {
            background: rgba(201, 168, 76, 0.07);
            border: 1px solid rgba(201, 168, 76, 0.2);
            border-radius: 9px;
            padding: 10px 14px;
            font-size: 12px;
            color: var(--gold-dark);
            margin-bottom: 18px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
    </style>
</head>

<body>

    <div class="login-wrapper">

        <!-- ===== BRAND HEADER ===== -->
        <div class="brand-header">
            <div class="brand-name">Elegance</div>
            <div class="gold-line"></div>
            <div class="brand-tagline">Salon & Spa Management</div>
        </div>

        <!-- ===== LOGIN CARD ===== -->
        <div class="login-card">

            <div class="card-title">Welcome Back</div>
            <div class="card-subtitle">Sign in to your account to continue</div>

            <!-- ===== ROLE HINT ===== -->
            <div class="role-hint">
                <i class="bi bi-info-circle-fill"></i>
                Staff accounts are created by admin only. Clients can register below.
            </div>

            <!-- ===== ERROR MESSAGE ===== -->
            <?php if ($error): ?>
                <div class="alert-custom alert-error">
                    <i class="bi bi-exclamation-circle-fill"></i>
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <!-- ===== LOGIN FORM ===== -->
            <form method="POST" action="">

                <!-- --- Email --- -->
                <div class="form-gap">
                    <label class="form-label-sm">Email Address</label>
                    <div class="input-group-custom">
                        <i class="bi bi-envelope input-icon"></i>
                        <input
                            type="email"
                            name="email"
                            class="form-input"
                            placeholder="your@email.com"
                            value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"
                            required>
                    </div>
                </div>

                <!-- --- Password --- -->
                <div class="form-gap">
                    <label class="form-label-sm">Password</label>
                    <div class="input-group-custom">
                        <i class="bi bi-lock input-icon"></i>
                        <input
                            type="password"
                            name="password"
                            id="password"
                            class="form-input"
                            placeholder="Enter your password"
                            required>
                        <button type="button" class="toggle-password" onclick="togglePass()">
                            <i class="bi bi-eye" id="eye-icon"></i>
                        </button>
                    </div>
                    <!-- ===== FORGOT PASSWORD LINK — below input ===== -->
                    <div style="text-align:right; margin-top:6px;">
                        <a href="<?php echo SITE_URL; ?>/forgot_password.php"
                            style="font-size:11px; color:var(--gold); text-decoration:none;">
                            Forgot password?
                        </a>
                    </div>
                </div>


                <!-- --- Submit --- -->
                <button type="submit" class="btn-gold">
                    <i class="bi bi-box-arrow-in-right"></i>
                    Sign In
                </button>

            </form>
            <!-- ===== END LOGIN FORM ===== -->

        </div>
        <!-- ===== END LOGIN CARD ===== -->

        <!-- ===== BOTTOM LINKS ===== -->
        <div class="bottom-link">
            Don't have an account?
            <a href="<?php echo SITE_URL; ?>/register.php">Register here</a>
        </div>

        <div class="back-link">
            <a href="<?php echo SITE_URL; ?>/index.php">
                <i class="bi bi-arrow-left"></i> Back to website
            </a>
        </div>

    </div>

    <!-- ===== BOOTSTRAP JS ===== -->
    <script src="assets/js/bootstrap.bundle.min.js"></script>

    <script>
        // ===== TOGGLE PASSWORD VISIBILITY =====
        function togglePass() {
            const field = document.getElementById('password');
            const icon = document.getElementById('eye-icon');

            if (field.type === 'password') {
                field.type = 'text';
                icon.className = 'bi bi-eye-slash';
            } else {
                field.type = 'password';
                icon.className = 'bi bi-eye';
            }
        }
    </script>

</body>

</html>