<?php
session_start();
include('db_connect.php');

// Check if the user is logged in, either via session or cookies
if (!isset($_SESSION['user_id']) && !isset($_COOKIE['user_id'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_SESSION['user_id']) && isset($_COOKIE['user_id'])) {
    $_SESSION['user_id'] = $_COOKIE['user_id'];
    $_SESSION['username'] = $_COOKIE['username'];
    $_SESSION['user_type'] = $_COOKIE['user_type'];
}

if ($_SESSION['user_type'] != 'User') {
    header("Location: login.php");
    exit();
}

// Handle the form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and validate the input using PDO
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format";
        exit();
    }

    // Prepare SQL query to insert the data into the database
    try {
        $sql = "INSERT INTO contact_messages (name, email, message) VALUES (:name, :email, :message)";
        $stmt = $pdo->prepare($sql);

        // Bind parameters
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':message', $message);

        // Execute the query
        if ($stmt->execute()) {
            // Data inserted successfully, redirect to contact page with success status
            header("Location: contact.php?status=success");
            exit();
        } else {
            // In case of an error, display the error message
            die("Error: Failed to insert data.");
        }
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}
?>
