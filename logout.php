<?php
    session_start(); // Start the session
    
    // Destroy all session variables
    session_unset();
    
    // Destroy the session
    session_destroy();
    
    // Remove cookies if they exist
    if (isset($_COOKIE['user_id'])) {
        setcookie('user_id', '', time() - 3600, '/');  // Expire the cookie
    }
    if (isset($_COOKIE['username'])) {
        setcookie('username', '', time() - 3600, '/');  // Expire the cookie
    }
    
    // Redirect the user to the login page
    header("Location: login.php");
    exit();
    ?>