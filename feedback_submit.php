<?php
// 1. Double check this path! 
// If your config is inside an 'includes' folder, change this to 'includes/config.php'
$configPath = 'includes/db.php'; 

if (file_exists($configPath)) {
    require_once $configPath;
} else {
    header('Content-Type: application/json');
    echo json_encode(['status' => 'error', 'message' => 'Config file not found at: ' . $configPath]);
    exit;
}

// 2. Ensure we return JSON
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // 3. Check if $conn exists (This was your specific error)
    if (!isset($conn)) {
        echo json_encode(['status' => 'error', 'message' => 'Database variable $conn is not defined in config.php']);
        exit;
    }

    $name = mysqli_real_escape_string($conn, $_POST['name'] ?? '');
    $email = mysqli_real_escape_string($conn, $_POST['email'] ?? '');
    $rating = intval($_POST['rating'] ?? 0);
    $message = mysqli_real_escape_string($conn, $_POST['message'] ?? '');

    if ($rating === 0 || empty($name)) {
        echo json_encode(['status' => 'error', 'message' => 'Please provide a name and star rating.']);
        exit;
    }

    $sql = "INSERT INTO feedbacks (name, email, rating, message, status) 
            VALUES ('$name', '$email', $rating, '$message', 'new')";

    if (mysqli_query($conn, $sql)) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => mysqli_error($conn)]);
    }
}
?>