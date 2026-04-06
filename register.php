<?php
/* ===== INCLUDE CONFIG ===== */
require_once 'config/config.php';
require_once 'includes/db.php';

/* ===== REDIRECT IF ALREADY LOGGED IN ===== */
if (isset($_SESSION['user_id'])) {
    header('Location: ' . SITE_URL . '/dashboard/index.php');
    exit();
}

/* ===== REGISTER LOGIC ===== */
$error   = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    /* --- GET AND CLEAN FORM DATA --- */
    $name     = trim($_POST['name']);
    $email    = trim($_POST['email']);
    $phone    = trim($_POST['phone']);
    $password = trim($_POST['password']);
    $confirm  = trim($_POST['confirm_password']);

    /* --- VALIDATION --- */
    if (empty($name) || empty($email) || empty($password) || empty($confirm)) {
        $error = 'Please fill in all required fields.';

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';

    } elseif (strlen($password) < 6) {
        $error = 'Password must be at least 6 characters.';

    } elseif ($password !== $confirm) {
        $error = 'Passwords do not match.';

    } else {

        /* --- CHECK IF EMAIL ALREADY EXISTS --- */
        $check = mysqli_query($conn, "SELECT id FROM users WHERE email = '$email'");

        if (mysqli_num_rows($check) > 0) {
            $error = 'This email is already registered. Please login instead.';

        } else {

            /* --- HASH PASSWORD --- */
            $hashed = password_hash($password, PASSWORD_DEFAULT);

            /* --- INSERT NEW USER --- */
            $sql = "INSERT INTO users (name, email, phone, password, role, status)
                    VALUES ('$name', '$email', '$phone', '$hashed', 'client', 'active')";

            if (mysqli_query($conn, $sql)) {
                $success = 'Account created successfully! Redirecting to login...';
                header('Refresh: 2; URL=' . SITE_URL . '/login.php');
            } else {
                $error = 'Something went wrong. Please try again.';
            }
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
    <title>Register | <?php echo SITE_NAME; ?></title>

    <!-- ===== BOOTSTRAP 5 ===== -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- ===== BOOTSTRAP ICONS ===== -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">

    <!-- ===== GOOGLE FONTS ===== -->
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;600&family=DM+Sans:opsz,wght@9..40,400;9..40,500&display=swap" rel="stylesheet">

    <style>

        /* ===== ROOT VARIABLES ===== */
        :root {
            --gold:         #C9A84C;
            --gold-dark:    #8B6914;
            --cream:        #FAF7F2;
            --blush:        #F2E8E4;
            --rose:         #C48B8B;
            --charcoal:     #1C1C1E;
            --font-display: 'Cormorant Garamond', serif;
            --font-body:    'DM Sans', sans-serif;
        }

        /* ===== BASE ===== */
        * { margin: 0; padding: 0; box-sizing: border-box; }

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
        .register-wrapper {
            width: 100%;
            max-width: 480px;
        }

        /* ===== BRAND HEADER ===== */
        .brand-header {
            text-align: center;
            margin-bottom: 32px;
        }
        .brand-header .brand-name {
            font-family: var(--font-display);
            font-size: 36px;
            color: var(--charcoal);
            letter-spacing: 0.04em;
        }
        .brand-header .brand-tagline {
            font-size: 13px;
            color: #aaa;
            margin-top: 4px;
            letter-spacing: 0.06em;
        }
        .brand-header .gold-line {
            width: 40px;
            height: 2px;
            background: var(--gold);
            margin: 10px auto 0;
            border-radius: 2px;
        }

        /* ===== CARD ===== */
        .register-card {
            background: white;
            border-radius: 18px;
            padding: 36px 38px;
            border: 1px solid rgba(0,0,0,0.06);
            box-shadow: 0 4px 24px rgba(0,0,0,0.06);
        }
        .card-title {
            font-family: var(--font-display);
            font-size: 24px;
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
            padding: 10px 14px;
            border: 1px solid rgba(0,0,0,0.1);
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
            box-shadow: 0 0 0 3px rgba(201,168,76,0.08);
        }

        /* ===== INPUT GROUP (icon inside input) ===== */
        .input-group-custom {
            position: relative;
        }
        .input-group-custom .form-input {
            padding-left: 38px;
        }
        .input-group-custom .input-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #ccc;
            font-size: 15px;
        }
        .input-group-custom .toggle-password {
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
        .input-group-custom .toggle-password:hover { color: var(--gold); }

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
        }
        .btn-gold:hover { background: var(--gold-dark); }

        /* ===== DIVIDER ===== */
        .form-gap { margin-bottom: 16px; }

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
            background: rgba(231,76,60,0.07);
            border: 1px solid rgba(231,76,60,0.2);
            color: #C0392B;
        }
        .alert-success {
            background: rgba(39,174,96,0.07);
            border: 1px solid rgba(39,174,96,0.2);
            color: #1E8449;
        }

        /* ===== BOTTOM LINK ===== */
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
        .bottom-link a:hover { color: var(--gold-dark); }

        /* ===== BACK TO WEBSITE ===== */
        .back-link {
            text-align: center;
            margin-bottom: 20px;
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
        .back-link a:hover { color: var(--gold); }

    </style>
</head>
<body>

    <div class="register-wrapper">

        <!-- ===== BRAND HEADER ===== -->
        <div class="brand-header">
            <div class="brand-name">Elegance</div>
            <div class="gold-line"></div>
            <div class="brand-tagline">Salon & Spa Management</div>
        </div>

        <!-- ===== REGISTER CARD ===== -->
        <div class="register-card">

            <div class="card-title">Create Account</div>
            <div class="card-subtitle">Register to book appointments online</div>

            <!-- ===== ERROR / SUCCESS MESSAGES ===== -->
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

            <!-- ===== REGISTER FORM ===== -->
            <form method="POST" action="">

                <!-- --- Full Name --- -->
                <div class="form-gap">
                    <label class="form-label-sm">Full Name <span style="color:var(--rose);">*</span></label>
                    <div class="input-group-custom">
                        <i class="bi bi-person input-icon"></i>
                        <input
                            type="text"
                            name="name"
                            class="form-input"
                            placeholder="Enter your full name"
                            value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>"
                            required
                        >
                    </div>
                </div>

                <!-- --- Email --- -->
                <div class="form-gap">
                    <label class="form-label-sm">Email Address <span style="color:var(--rose);">*</span></label>
                    <div class="input-group-custom">
                        <i class="bi bi-envelope input-icon"></i>
                        <input
                            type="email"
                            name="email"
                            class="form-input"
                            placeholder="your@email.com"
                            value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"
                            required
                        >
                    </div>
                </div>

                <!-- --- Phone --- -->
                <div class="form-gap">
                    <label class="form-label-sm">Phone Number</label>
                    <div class="input-group-custom">
                        <i class="bi bi-telephone input-icon"></i>
                        <input
                            type="text"
                            name="phone"
                            class="form-input"
                            placeholder="03XX-XXXXXXX"
                            value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : ''; ?>"
                        >
                    </div>
                </div>

                <!-- --- Password --- -->
                <div class="form-gap">
                    <label class="form-label-sm">Password <span style="color:var(--rose);">*</span></label>
                    <div class="input-group-custom">
                        <i class="bi bi-lock input-icon"></i>
                        <input
                            type="password"
                            name="password"
                            id="password"
                            class="form-input"
                            placeholder="Minimum 6 characters"
                            required
                        >
                        <button type="button" class="toggle-password" onclick="togglePass('password', this)">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>

                <!-- --- Confirm Password --- -->
                <div class="form-gap">
                    <label class="form-label-sm">Confirm Password <span style="color:var(--rose);">*</span></label>
                    <div class="input-group-custom">
                        <i class="bi bi-lock-fill input-icon"></i>
                        <input
                            type="password"
                            name="confirm_password"
                            id="confirm_password"
                            class="form-input"
                            placeholder="Repeat your password"
                            required
                        >
                        <button type="button" class="toggle-password" onclick="togglePass('confirm_password', this)">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>

                <!-- --- Submit --- -->
                <div style="margin-top: 24px;">
                    <button type="submit" class="btn-gold">
                        <i class="bi bi-person-plus-fill"></i>
                        Create My Account
                    </button>
                </div>

            </form>
            <!-- ===== END REGISTER FORM ===== -->

        </div>
        <!-- ===== END REGISTER CARD ===== -->

        <!-- ===== BOTTOM LINKS ===== -->
        <div class="bottom-link">
            Already have an account?
            <a href="<?php echo SITE_URL; ?>/login.php">Login here</a>
        </div>

        <div class="back-link" style="margin-top: 12px;">
            <a href="<?php echo SITE_URL; ?>/index.php">
                <i class="bi bi-arrow-left"></i> Back to website
            </a>
        </div>

    </div>
    <!-- ===== END WRAPPER ===== -->

    <!-- ===== BOOTSTRAP JS ===== -->
    <script src="assets/js/bootstrap.bundle.min.js"></script>

    <script>
        // ===== TOGGLE PASSWORD VISIBILITY =====
        function togglePass(fieldId, btn) {
            const field = document.getElementById(fieldId);
            const icon  = btn.querySelector('i');

            if (field.type === 'password') {
                field.type  = 'text';
                icon.className = 'bi bi-eye-slash';
            } else {
                field.type  = 'password';
                icon.className = 'bi bi-eye';   
            }
        }
    </script>

</body>
</html>