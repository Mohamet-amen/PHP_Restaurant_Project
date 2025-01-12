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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Waarid Restaurant</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/contact.css">
  
</head>
<body>
    <header>
        <h1>Waarid🍴Restaurant</h1>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="aboutus.php">About Us</a></li>
                <li><a href="menu.php">Menu</a></li>
                <li><a href="contact.php">Contact</a></li>
                <?php if (isset($_SESSION['username'])): ?>
                    <li><a href="logout.php">Logout (<?php echo $_SESSION['username']; ?>)</a></li>
                <?php else: ?>
                    <li><a href="login.php">Login</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <section class="contact-section">
        <h2>Contact Us</h2>
        <p>If you have any inquiries, questions, or feedback, feel free to reach out to us.</p>

                <?php
                    if (isset($_GET['status']) && $_GET['status'] == 'success') {
                        echo "<p style='color: green;'>Your message has been sent successfully!</p>";
                    }
        ?>


        <form class="contact-form" action="contact_process.php" method="POST">
            <input type="text" name="name" placeholder="Your Name" required>
            <input type="email" name="email" placeholder="Your Email" required>
            <textarea name="message" placeholder="Your Message" rows="5" required></textarea>
            <button type="submit">Send Message</button>
        </form>
    </section>

    <footer>
        <div class="footer-container">
            <div class="footer-column">
                <h3>Waarid 🍴 Restaurant</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis sodales ultrices est sit amet malesuada.</p>
            </div>
            <div class="footer-column">
                <h4>Useful Links</h4>
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Services</a></li>
                    <li><a href="#">Get Application</a></li>
                </ul>
            </div>
            <div class="footer-column">
                <h4>Legal</h4>
                <ul>
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="#">Terms & Conditions</a></li>
                    <li><a href="#">Help</a></li>
                </ul>
            </div>
            <div class="footer-column">
                <h4>Contact Us</h4>
                <p>+92 123211</p>
                <p><a href="mailto:support@waaridrestaurant.com">Email</a></p>
                <p><a href="#">Cashback</a></p>
            </div>
            <div class="footer-column">
                <h4>Follow Us</h4>
                <p>Facebook | Twitter | Instagram</p>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2025 Waarid Restaurant. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
