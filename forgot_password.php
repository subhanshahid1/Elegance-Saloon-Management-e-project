<?php
/* ===== INCLUDES ===== */
require_once 'config/config.php';
require_once 'includes/db.php';

/* ===== PHPMAILER IMPORTS ===== */
require_once 'includes/phpmailer/Exception.php';
require_once 'includes/phpmailer/PHPMailer.php';
require_once 'includes/phpmailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

/* ===== REDIRECT IF ALREADY LOGGED IN ===== */
if (isset($_SESSION['user_id'])) {
    header('Location: ' . SITE_URL . '/index.php');
    exit();
}

/* ===== FORGOT PASSWORD LOGIC ===== */
$error   = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    /* --- GET EMAIL --- */
    $email = trim($_POST['email']);
    $email = mysqli_real_escape_string($conn, $email);

    /* --- CHECK IF EMAIL EXISTS --- */
    $result = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email' AND status = 'active' LIMIT 1");

    if (mysqli_num_rows($result) === 0) {
        $error = 'No active account found with this email address.';

    } else {

        /* --- GENERATE UNIQUE TOKEN --- */
        $token   = bin2hex(random_bytes(32));
        $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));

        /* --- DELETE ANY OLD TOKENS FOR THIS EMAIL --- */
        mysqli_query($conn, "DELETE FROM password_resets WHERE email = '$email'");

        /* --- SAVE NEW TOKEN TO DATABASE --- */
        $sql = "INSERT INTO password_resets (email, token, expires_at)
                VALUES ('$email', '$token', '$expires')";
        mysqli_query($conn, $sql);

        /* --- BUILD RESET LINK --- */
        $resetLink = SITE_URL . '/reset_password.php?token=' . $token;

        /* --- SEND EMAIL USING PHPMAILER --- */
        $mail = new PHPMailer(true);

        try {
            /* --- SERVER SETTINGS --- */
            $mail->isSMTP();
            $mail->Host       = MAIL_HOST;
            $mail->SMTPAuth   = true;
            $mail->Username   = MAIL_USERNAME;
            $mail->Password   = MAIL_PASSWORD;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = MAIL_PORT;

            /* --- SENDER & RECIPIENT --- */
            $mail->setFrom(MAIL_FROM, MAIL_NAME);
            $mail->addAddress($email);

            /* --- EMAIL CONTENT --- */
            $mail->isHTML(true);
            $mail->Subject = 'Reset Your Password — ' . SITE_NAME;
            $mail->Body    = '
                <div style="font-family: DM Sans, sans-serif; max-width: 500px; margin: 0 auto; padding: 30px;">
                    <h2 style="color: #C9A84C; font-family: Cormorant Garamond, serif;">Elegance Salon</h2>
                    <p style="color: #333;">You requested to reset your password.</p>
                    <p style="color: #333;">Click the button below to reset it. This link expires in <strong>1 hour</strong>.</p>
                    <a href="' . $resetLink . '"
                       style="display:inline-block; margin-top:16px; padding:12px 28px;
                              background:#C9A84C; color:white; text-decoration:none;
                              border-radius:8px; font-weight:500;">
                        Reset My Password
                    </a>
                    <p style="color:#aaa; font-size:12px; margin-top:24px;">
                        If you did not request this, ignore this email. Your password will not change.
                    </p>
                </div>
            ';

            $mail->send();
            $success = 'Password reset link has been sent to your email. Check your inbox.';

        } catch (Exception $e) {
            $error = 'Email could not be sent. Error: ' . $mail->ErrorInfo;
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
    <title>Forgot Password — <?php echo SITE_NAME; ?></title>

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

        /* ===== WRAPPER ===== */
        .wrapper { width: 100%; max-width: 420px; }

        /* ===== BRAND ===== */
        .brand-header { text-align: center; margin-bottom: 32px; }
        .brand-name {
            font-family: var(--font-display);
            font-size: 38px;
            color: var(--charcoal);
            letter-spacing: 0.04em;
        }
        .gold-line {
            width: 40px; height: 2px;
            background: var(--gold);
            margin: 10px auto;
            border-radius: 2px;
        }
        .brand-tagline {
            font-size: 12px;
            color: #bbb;
            letter-spacing: 0.1em;
            text-transform: uppercase;
        }

        /* ===== CARD ===== */
        .card-box {
            background: white;
            border-radius: 18px;
            padding: 36px 38px;
            border: 1px solid rgba(0,0,0,0.06);
            box-shadow: 0 4px 24px rgba(0,0,0,0.06);
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
            line-height: 1.6;
        }

        /* ===== FORM ===== */
        .form-label-sm {
            font-size: 11px;
            font-weight: 500;
            color: #999;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-bottom: 6px;
            display: block;
        }
        .form-input {
            width: 100%;
            padding: 10px 14px 10px 38px;
            border: 1px solid rgba(0,0,0,0.1);
            border-radius: 9px;
            font-size: 13px;
            font-family: var(--font-body);
            color: var(--charcoal);
            outline: none;
            transition: border-color 0.15s;
        }
        .form-input:focus {
            border-color: var(--gold);
            box-shadow: 0 0 0 3px rgba(201,168,76,0.08);
        }
        .input-wrap { position: relative; }
        .input-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #ccc;
            font-size: 15px;
        }

        /* ===== BUTTON ===== */
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
            margin-top: 22px;
        }
        .btn-gold:hover { background: var(--gold-dark); }

        /* ===== ALERTS ===== */
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

        /* ===== BOTTOM LINKS ===== */
        .bottom-link {
            text-align: center;
            margin-top: 20px;
            font-size: 13px;
            color: #aaa;
        }
        .bottom-link a {
            color: var(--gold);
            text-decoration: none;
            font-weight: 500;
        }
        .bottom-link a:hover { color: var(--gold-dark); }

    </style>
</head>
<body>

    <div class="wrapper">

        <!-- ===== BRAND HEADER ===== -->
        <div class="brand-header">
            <div class="brand-name">Elegance</div>
            <div class="gold-line"></div>
            <div class="brand-tagline">Salon & Spa Management</div>
        </div>

        <!-- ===== CARD ===== -->
        <div class="card-box">

            <div class="card-title">Forgot Password?</div>
            <div class="card-subtitle">
                Enter your registered email address and we will send you a link to reset your password.
            </div>

            <!-- ===== ERROR MESSAGE ===== -->
            <?php if ($error): ?>
                <div class="alert-custom alert-error">
                    <i class="bi bi-exclamation-circle-fill"></i>
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <!-- ===== SUCCESS MESSAGE ===== -->
            <?php if ($success): ?>
                <div class="alert-custom alert-success">
                    <i class="bi bi-check-circle-fill"></i>
                    <?php echo $success; ?>
                </div>
            <?php endif; ?>

            <!-- ===== FORM — hide after success ===== -->
            <?php if (!$success): ?>
                <form method="POST" action="">

                    <!-- --- Email --- -->
                    <div>
                        <label class="form-label-sm">Email Address</label>
                        <div class="input-wrap">
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

                    <!-- --- Submit --- -->
                    <button type="submit" class="btn-gold">
                        <i class="bi bi-send-fill"></i>
                        Send Reset Link
                    </button>

                </form>
            <?php endif; ?>

        </div>
        <!-- ===== END CARD ===== -->

        <!-- ===== BOTTOM LINK ===== -->
        <div class="bottom-link">
            Remember your password?
            <a href="<?php echo SITE_URL; ?>/login.php">Back to Login</a>
        </div>

    </div>

    <!-- ===== BOOTSTRAP JS ===== -->
    <script src="assets/js/bootstrap.bundle.min.js"></script>

</body>
</html>