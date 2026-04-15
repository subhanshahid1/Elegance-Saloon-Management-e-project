<?php
require_once 'config/config.php';
require_once 'includes/db.php';

if (isset($_SESSION['user_id'])) {
    header('Location: ' . SITE_URL . '/dashboard/index.php');
    exit();
}

$error   = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    /* Get Data */
    $name     = trim($_POST['name']);
    $email    = trim($_POST['email']);
    $phone    = trim($_POST['phone']);
    $password = trim($_POST['password']);
    $confirm  = trim($_POST['confirm_password']);
    $gender   = trim($_POST['gender']);
    $dob      = trim($_POST['dob']);
    $role     = trim($_POST['role']);

    /* Validation */
    if (empty($name) || empty($email) || empty($password) || empty($confirm) || empty($role)) {
        $error = 'Please fill in all required fields.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
    } elseif (strlen($password) < 6) {
        $error = 'Password must be at least 6 characters.';
    } elseif ($password !== $confirm) {
        $error = 'Passwords do not match.';
    } else {

        /* Check Email */
        $email_escaped = mysqli_real_escape_string($conn, $email);
        $check = mysqli_query($conn, "SELECT id FROM users WHERE email = '$email_escaped'");

        if (mysqli_num_rows($check) > 0) {
            $error = 'This email is already registered.';
        } else {

            /* Hash Password */
            $hashed = password_hash($password, PASSWORD_DEFAULT);

            /* Prepare Data */
            $name_esc   = mysqli_real_escape_string($conn, $name);
            $phone_esc  = mysqli_real_escape_string($conn, $phone);
            $gender_esc = mysqli_real_escape_string($conn, $gender);
            $role_esc   = mysqli_real_escape_string($conn, $role);
            $dob_val    = !empty($dob) ? "'" . mysqli_real_escape_string($conn, $dob) . "'" : "NULL";

            /* Insert User */
            $sql = "INSERT INTO users (name, email, phone, password, role, status, gender, dob)
                    VALUES ('$name_esc', '$email_escaped', '$phone_esc', '$hashed', '$role_esc', 'active', '$gender_esc', $dob_val)";

            if (mysqli_query($conn, $sql)) {
                $success = 'Account created successfully! Redirecting...';
                header('Refresh: 2; URL=' . SITE_URL . '/login.php');
            } else {
                $error = 'Database error. Please try again.';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | <?php echo SITE_NAME; ?></title>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;600&family=DM+Sans:opsz,wght@9..40,400;9..40,500&display=swap" rel="stylesheet">

    <style>
        :root {
            --gold: #C9A84C;
            --gold-dark: #8B6914;
            --cream: #FAF7F2;
            --charcoal: #1C1C1E;
            --rose: #C48B8B;
            --font-display: 'Cormorant Garamond', serif;
            --font-body: 'DM Sans', sans-serif;
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

        .register-wrapper {
            width: 100%;
            max-width: 500px;
        }

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

        .gold-line {
            width: 40px;
            height: 2px;
            background: var(--gold);
            margin: 10px auto;
            border-radius: 2px;
        }

        .register-card {
            background: white;
            border-radius: 18px;
            padding: 36px 38px;
            border: 1px solid rgba(0, 0, 0, 0.06);
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06);
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
            padding: 10px 14px;
            border: 1px solid rgba(0, 0, 0, 0.1);
            border-radius: 9px;
            font-size: 13px;
            transition: border-color 0.15s;
        }

        .form-input:focus {
            border-color: var(--gold);
            outline: none;
            box-shadow: 0 0 0 3px rgba(201, 168, 76, 0.08);
        }

        .input-group-custom {
            position: relative;
        }

        .input-group-custom .form-input {
            padding-left: 38px;
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
            background: none;
            border: none;
            cursor: pointer;
        }

        .btn-gold {
            width: 100%;
            padding: 12px;
            background: var(--gold);
            border: none;
            border-radius: 9px;
            color: white;
            font-weight: 500;
            transition: 0.15s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-gold:hover {
            background: var(--gold-dark);
        }

        .form-gap {
            margin-bottom: 16px;
        }

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

        .alert-success {
            background: rgba(39, 174, 96, 0.07);
            border: 1px solid rgba(39, 174, 96, 0.2);
            color: #1E8449;
        }

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
    </style>
</head>

<body>

    <div class="register-wrapper">
        <div class="brand-header">
            <div class="brand-name">Elegance</div>
            <div class="gold-line"></div>
            <div class="brand-tagline">Salon & Spa Management</div>
        </div>

        <div class="register-card">
            <div class="card-title">Create Account</div>
            <div class="card-subtitle">Join us for a personalized beauty experience</div>

            <?php if ($error): ?>
                <div class="alert-custom alert-error"><i class="bi bi-exclamation-circle-fill"></i> <?php echo $error; ?></div>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="alert-custom alert-success"><i class="bi bi-check-circle-fill"></i> <?php echo $success; ?></div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="form-gap">
                    <label class="form-label-sm">Full Name <span style="color:var(--rose);">*</span></label>
                    <div class="input-group-custom">
                        <i class="bi bi-person input-icon"></i>
                        <input type="text" name="name" class="form-input" placeholder="Enter your full name" value="<?php echo htmlspecialchars($name ?? ''); ?>" required>
                    </div>
                </div>

                <div class="row g-2 form-gap">
                    <div class="col-md-7">
                        <label class="form-label-sm">Email Address <span style="color:var(--rose);">*</span></label>
                        <div class="input-group-custom">
                            <i class="bi bi-envelope input-icon"></i>
                            <input type="email" name="email" class="form-input" placeholder="your@email.com" value="<?php echo htmlspecialchars($email ?? ''); ?>" required>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <label class="form-label-sm">Phone</label>
                        <input type="text" name="phone" class="form-input" placeholder="03XX-XXXXXXX" value="<?php echo htmlspecialchars($phone ?? ''); ?>">
                    </div>
                </div>

                <div class="form-gap">
                    <label class="form-label-sm">Account Role <span style="color:var(--rose);">*</span></label>
                    <select name="role" class="form-input" required>
                        <option value="client" <?php echo (isset($role) && $role == 'client') ? 'selected' : ''; ?>>Client</option>
                        <option value="stylist" <?php echo (isset($role) && $role == 'stylist') ? 'selected' : ''; ?>>Stylist</option>
                        <option value="receptionist" <?php echo (isset($role) && $role == 'receptionist') ? 'selected' : ''; ?>>Receptionist</option>
                        <option value="admin" <?php echo (isset($role) && $role == 'admin') ? 'selected' : ''; ?>>Admin</option>
                    </select>
                </div>

                <div class="row g-2 form-gap">
                    <div class="col-6">
                        <label class="form-label-sm">Gender</label>
                        <select name="gender" class="form-input">
                            <option value="">Select</option>
                            <option value="male" <?php echo (isset($gender) && $gender == 'male') ? 'selected' : ''; ?>>Male</option>
                            <option value="female" <?php echo (isset($gender) && $gender == 'female') ? 'selected' : ''; ?>>Female</option>
                            <option value="other" <?php echo (isset($gender) && $gender == 'other') ? 'selected' : ''; ?>>Other</option>
                        </select>
                    </div>
                    <div class="col-6">
                        <label class="form-label-sm">Date of Birth</label>
                        <input type="date" name="dob" class="form-input" value="<?php echo htmlspecialchars($dob ?? ''); ?>">
                    </div>
                </div>

                <div class="row g-2 form-gap">
                    <div class="col-6">
                        <label class="form-label-sm">Password <span style="color:var(--rose);">*</span></label>
                        <div class="input-group-custom">
                            <i class="bi bi-lock input-icon"></i>
                            <input type="password" name="password" id="password" class="form-input" required>
                            <button type="button" class="toggle-password" onclick="togglePass('password', this)"><i class="bi bi-eye"></i></button>
                        </div>
                    </div>
                    <div class="col-6">
                        <label class="form-label-sm">Confirm <span style="color:var(--rose);">*</span></label>
                        <div class="input-group-custom">
                            <i class="bi bi-lock-fill input-icon"></i>
                            <input type="password" name="confirm_password" id="confirm_password" class="form-input" required>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn-gold mt-3">
                    <i class="bi bi-person-plus-fill"></i> Create My Account
                </button>
            </form>
        </div>

        <div class="bottom-link">
            Already have an account? <a href="<?php echo SITE_URL; ?>/login.php">Login here</a>
        </div>
    </div>

    <script>
        function togglePass(id, btn) {
            const field = document.getElementById(id);
            const icon = btn.querySelector('i');
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