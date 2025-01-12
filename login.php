<?php
session_start(); // Start the session
include('db_connect.php');
// Check if the user is already logged in (i.e., if the session or cookie is set)
if (isset($_SESSION['user_id']) || isset($_COOKIE['user_id'])) {
    header("Location: dashboard.php");
    header("Location: index.php");
    exit(); // Ensure that no further code is executed
}
// Handle login process
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $rememberMe = isset($_POST['remember_me']) ? true : false;

    // Query to fetch user data from the database based on the username
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    // Check if the user exists and the password is correct
    if ($user && password_verify($password, $user['password'])) {
        // Start the session and set user data
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['user_type'] = $user['user_type']; // Store user type in session

        // Optionally set cookies if "Remember Me" is checked
        if ($rememberMe) {
            setcookie("user_id", $user['id'], time() + (5 * 60), "/");  // 5 minutes
            setcookie("username", $user['username'], time() + (5 * 60), "/");  // 5 minutes
        }

        // Redirect the user based on user type
        if ($user['user_type'] == 'Admin') {
            header("Location: dashboard.php");
        } else {
            header("Location: index.php");  // Regular user redirected to the main page
        }
        exit(); // Make sure to exit after redirection to stop further code execution
    } else {
        $error = "Invalid username or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Waarid Restaurant</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>
        <form action="login.php" method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required><br>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br>

            <div class="remember-me">
                <input type="checkbox" id="remember_me" name="remember_me">
                <label for="remember_me">Remember me</label>
            </div>

            <button type="reset">Reset</button>
            <button type="submit">Login</button>
        </form>
        <div class="links">
            <a href="signup.php">Sign Up</a> | <a href="forgot_password.php">Forgot Password?</a>
        </div>
    </div>
</body>
</html>
