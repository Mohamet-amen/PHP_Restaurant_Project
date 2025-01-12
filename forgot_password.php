<?php
session_start();
include('db_connect.php');

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];

    // Check if the user exists
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user) {
        // Generate a unique token for the password reset link
        $token = bin2hex(random_bytes(50)); // Secure token
        $token_expiry = date("Y-m-d H:i:s", strtotime("+1 hour")); // Expiry time is 1 hour from now

        // Store the token and expiry time in the database
        $update_sql = "UPDATE users SET reset_token = ?, reset_token_expiry = ? WHERE id = ?";
        $update_stmt = $pdo->prepare($update_sql);
        $update_stmt->execute([$token, $token_expiry, $user['id']]);

        // Send a password reset email (you can use PHP mail function or an email service)
        $reset_link = "http://yourdomain.com/reset_password.php?token=" . $token;
        $subject = "Password Reset Request";
        $message = "Hello " . $user['username'] . ",\n\nTo reset your password, please click the link below:\n" . $reset_link;
        $headers = "From: no-reply@yourdomain.com";

        if (mail($user['email'], $subject, $message, $headers)) {
            echo "Password reset link sent to your email!";
        } else {
            echo "Failed to send email. Please try again.";
        }
    } else {
        echo "User not found!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="password-reset-container">
        <h2>Forgot Password</h2>
        <form action="forgot_password.php" method="POST">
            <label for="username">Enter your username:</label>
            <input type="text" id="username" name="username" required><br>

            <button type="submit">Reset Password</button>
        </form>
        <p><a href="login.php">Back to Login</a></p>
    </div>
</body>
</html>
