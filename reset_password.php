<?php
session_start();
include('db_connect.php');

// Validate the reset token and allow password reset
if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Check if the token exists in the database and is valid
    $sql = "SELECT * FROM users WHERE reset_token = ? AND reset_token_expiry > NOW()";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$token]);
    $user = $stmt->fetch();

    if ($user) {
        // Handle password reset
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $new_password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Secure password hashing

            // Update the password in the database and clear the reset token
            $update_sql = "UPDATE users SET password = ?, reset_token = NULL, reset_token_expiry = NULL WHERE id = ?";
            $update_stmt = $pdo->prepare($update_sql);
            $update_stmt->execute([$new_password, $user['id']]);

            echo "Password reset successful. You can now <a href='login.php'>login</a>.";
        }
    } else {
        echo "Invalid or expired token.";
    }
} else {
    echo "No reset token provided.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="password-reset-container">
        <h2>Reset Password</h2>
        <form action="reset_password.php?token=<?php echo $_GET['token']; ?>" method="POST">
            <label for="password">New Password:</label>
            <input type="password" id="password" name="password" required><br>

            <button type="submit">Reset Password</button>
        </form>
        <p><a href="login.php">Back to Login</a></p>
    </div>
</body>
</html>
