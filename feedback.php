<?php require_once 'config/config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback | Elegance Saloon</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        /* (Keep your styles here) */
        /* Global Fix */
        html, body { max-width: 100%; overflow-x: hidden; }
        .page-hero { background: linear-gradient(rgba(0,0,0,0.65), rgba(0,0,0,0.65)), url('https://images.unsplash.com/photo-1560066984-138dadb4c035?q=80&w=1600') center/cover no-repeat; padding: 90px 0 70px; text-align: center; }
        .page-hero h1 { font-family: var(--font-primary); font-size: clamp(2.2rem, 6vw, 3.8rem); color: var(--primary-gold); text-transform: uppercase; letter-spacing: 6px; margin-bottom: 12px; }
        /* ... rest of your CSS ... */
        .feedback-page { padding: 80px 0; background: var(--bg-black); }
        .feedback-container { background: var(--bg-card); border: 1px solid #222; overflow: hidden; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.7); }
        .feedback-visual { background: linear-gradient(rgba(0,0,0,0.3), rgba(0,0,0,0.3)), url('Eimages/about5.jpg') center/cover no-repeat; min-height: 100%; }
        .feedback-content { padding: 60px; }
        .feedback-content h2 { font-family: var(--font-primary); font-size: 2.8rem; color: var(--text-white); margin-bottom: 5px; text-transform: uppercase; letter-spacing: 2px; }
        .feedback-content h2 em { color: var(--primary-gold); font-style: normal; }
        .subtitle { font-size: 0.75rem; text-transform: uppercase; letter-spacing: 3px; color: var(--text-muted); margin-bottom: 40px; display: block; }
        .form-group-custom { position: relative; margin-bottom: 35px; }
        .form-input-minimal { width: 100%; background: transparent; border: none; border-bottom: 1px solid rgba(255, 255, 255, 0.1); padding: 12px 0; color: var(--text-white); font-size: 1rem; transition: 0.4s ease; border-radius: 0; }
        .form-input-minimal:focus { outline: none; box-shadow: none; border-bottom-color: var(--primary-gold); }
        .label-minimal { position: absolute; left: 0; top: 12px; color: var(--text-muted); pointer-events: none; transition: 0.3s ease; text-transform: uppercase; font-size: 0.7rem; letter-spacing: 2px; }
        .form-input-minimal:focus ~ .label-minimal, .form-input-minimal:valid ~ .label-minimal { top: -20px; font-size: 0.6rem; color: var(--primary-gold); letter-spacing: 3px; }
        .rating-container { margin-bottom: 35px; }
        .rating-title { font-size: 0.65rem; text-transform: uppercase; letter-spacing: 2px; color: var(--primary-gold); margin-bottom: 10px; display: block; }
        .star-rating { display: flex; flex-direction: row-reverse; justify-content: flex-end; gap: 10px; }
        .star-rating input { display: none; }
        .star-rating label { font-size: 1.8rem; color: #333; cursor: pointer; transition: 0.3s ease; }
        .star-rating label:hover, .star-rating label:hover ~ label, .star-rating input:checked ~ label { color: var(--primary-gold); }
        .btn-submit-luxury { background: transparent; color: var(--primary-gold); border: 1px solid var(--primary-gold); padding: 18px 0; text-transform: uppercase; letter-spacing: 4px; font-weight: bold; font-size: 0.75rem; width: 100%; transition: all 0.5s cubic-bezier(0.19, 1, 0.22, 1); position: relative; z-index: 1; overflow: hidden; cursor: pointer; }
        .btn-submit-luxury::before { content: ""; position: absolute; top: 0; left: -100%; width: 100%; height: 100%; background: var(--primary-gold); transition: all 0.5s cubic-bezier(0.19, 1, 0.22, 1); z-index: -1; }
        .btn-submit-luxury:hover { color: #000; }
        .btn-submit-luxury:hover::before { left: 0; }
        .success-overlay { display: none; text-align: center; animation: fadeIn 0.8s ease forwards; }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        @media (max-width: 768px) { .feedback-content { padding: 40px 25px; } .feedback-content h2 { font-size: 2rem; } }
    </style>
</head>
<body>

<?php include('includes/header.php'); ?>

<section class="page-hero">
    <h1>Feedback</h1>
    <div class="breadcrumb-row">
        <a href="index.php">Home</a>
        <span>&#8250;</span>
        <span>Feedback</span>
    </div>
</section>

<section class="feedback-page">
    <div class="container">
        <div class="feedback-container">
            <div class="row g-0">
                <div class="col-md-5 d-none d-md-block">
                    <div class="feedback-visual h-100"></div>
                </div>

                <div class="col-md-7 feedback-content">
                    <div id="formContainer">
                        <header>
                            <span class="subtitle">Client Relations</span>
                            <h2>Your <em>Experience</em></h2>
                        </header>

                        <form id="luxuryFeedback" class="mt-5" autocomplete="off">
                            <div class="form-group-custom">
                                <input type="text" class="form-input-minimal" id="name" name="name" required>
                                <label class="label-minimal" for="name">Full Name</label>
                            </div>

                            <div class="form-group-custom">
                                <input type="email" class="form-input-minimal" id="email" name="email" required>
                                <label class="label-minimal" for="email">Email Address</label>
                            </div>

                            <div class="rating-container">
                                <span class="rating-title">Rate the service quality</span>
                                <div class="star-rating">
                                    <input type="radio" name="rating" id="s5" value="5" required>
                                    <label for="s5">★</label>
                                    <input type="radio" name="rating" id="s4" value="4">
                                    <label for="s4">★</label>
                                    <input type="radio" name="rating" id="s3" value="3">
                                    <label for="s3">★</label>
                                    <input type="radio" name="rating" id="s2" value="2">
                                    <label for="s2">★</label>
                                    <input type="radio" name="rating" id="s1" value="1">
                                    <label for="s1">★</label>
                                </div>
                            </div>

                            <div class="form-group-custom">
                                <textarea class="form-input-minimal" id="msg" name="message" rows="3" required></textarea>
                                <label class="label-minimal" for="msg">How can we improve your next visit?</label>
                            </div>

                            <button type="submit" id="submitBtn" class="btn-submit-luxury">Submit Feedback</button>
                        </form>
                    </div>

                    <div class="success-overlay" id="successMsg">
                        <h2>Thank <em>You</em></h2>
                        <p class="mt-3" style="color: #aaa; letter-spacing: 1px;">
                            Your feedback has been successfully submitted to our management.
                        </p>
                        <a href="index.php" class="btn-submit-luxury d-inline-block mt-4" style="width: auto; padding: 12px 40px; text-decoration: none;">
                            Back to Home
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include('includes/footer.php'); ?>

<script>
    document.getElementById("luxuryFeedback").addEventListener("submit", function(e) {
        e.preventDefault();
        
        const btn = document.querySelector(".btn-submit-luxury");
        const formContainer = document.getElementById("formContainer");
        const successMsg = document.getElementById("successMsg");

        // UI Feedback
        btn.innerText = "Processing...";
        btn.style.opacity = "0.7";
        btn.disabled = true;

        // Collect data
        const formData = new FormData(this);

        // Send to PHP
        fetch('feedback_submit.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text()) // Get raw text first to catch PHP errors
        .then(text => {
            try {
                const data = JSON.parse(text);
                if(data.status === 'success') {
                    formContainer.style.display = "none";
                    successMsg.style.display = "block";
                } else {
                    alert("Submission Error: " + (data.message || "Unknown error"));
                    resetBtn(btn);
                }
            } catch (err) {
                console.error("Server sent back non-JSON:", text);
                alert("Server Error. Please check the console.");
                resetBtn(btn);
            }
        })
        .catch(error => {
            console.error('Fetch Error:', error);
            alert("Network Error. Check your internet connection.");
            resetBtn(btn);
        });
    });

    function resetBtn(btn) {
        btn.innerText = "Submit Feedback";
        btn.style.opacity = "1";
        btn.disabled = false;
    }
</script>
<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/script.js"></script>
</body>
</html>