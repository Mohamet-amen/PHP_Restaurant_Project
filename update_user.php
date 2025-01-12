<?php
session_start();
include('db_connect.php');

// Check if the user is logged in, either via session or cookies
if (!isset($_SESSION['user_id']) && !isset($_COOKIE['user_id'])) {
    header("Location: login.php");
    exit();
}

// If no session but cookies are present, restore session from cookies
if (!isset($_SESSION['user_id']) && isset($_COOKIE['user_id'])) {
    $_SESSION['user_id'] = $_COOKIE['user_id'];
    $_SESSION['username'] = $_COOKIE['username'];
    $_SESSION['user_type'] = $_COOKIE['user_type']; // Set user type from cookie, if stored
}

// Check if the user is an admin
if ($_SESSION['user_type'] != 'Admin') {
    header("Location: login.php");
    exit();
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['user_id'])) {
    // Get the user ID and other details from the form
    $user_id = $_POST['user_id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $user_type = $_POST['user_type'];
    $user_status = $_POST['user_status'];

    // Validate the input
    if (empty($first_name) || empty($last_name) || empty($email)) {
        echo "Please fill all fields.";
        exit();
    }

    // Prevent SQL Injection by using prepared statements
    $sql = "UPDATE users SET first_name = ?, last_name = ?, email = ?, user_type = ?, user_status = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $updated = $stmt->execute([$first_name, $last_name, $email, $user_type, $user_status, $user_id]);

    if ($updated) {
        // Redirect to dashboard with a success message
        header("Location: dashboard.php?");
        exit();
    } else {
        echo "Error updating user.";
    }
} else {
    echo "Invalid request.";
}
?>
