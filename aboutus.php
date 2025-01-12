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
    <title>About Us - Waarid Restaurant</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/about.css">
    
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

    <!-- About Us Section -->
    <section class="about-section">
        <h2>About Us</h2>
        <p>Welcome to Waarid🍴Restaurant, where we offer an unforgettable dining experience. Our chefs are passionate about creating mouthwatering dishes that will leave you coming back for more. Whether you're here for a quick bite or a special occasion, we ensure that each meal is a memorable one.</p>
    </section>

    <!-- Mission and Vision Section -->
    <section class="mission-vision">
        <div>
            <h3>Our Mission</h3>
            <p>To provide a unique and delightful culinary experience for every guest, using the freshest ingredients and the highest level of service.</p>
        </div>
        <div>
            <h3>Our Vision</h3>
            <p>To become the leading restaurant in our region, known for our innovative dishes, exceptional service, and commitment to quality.</p>
        </div>
    </section>

    <!-- Team Section -->
    <section class="team-section">
        <h2>Meet Our Team</h2>
        <div class="team-container">
            <div class="team-member">
                <img src="images/h.jpg" alt="Chef John">
                <h3>Abdihakim Ibrahim Isse</h3>
                <p>Head Chef</p>
            </div>
            <div class="team-member">
                <img src="images/g.jpg" alt="Chef Sarah">
                <h3>Salma Mohamed Abdi</h3>
                <p>Sous Chef</p>
            </div>
            <div class="team-member">
                <img src="images/m.jpg" alt="Manager Mark">
                <h3>Mohamed Abdullahi Osman</h3>
                <p>Restaurant Manager</p>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="contact-section">
        <h2>Get in Touch</h2>
        <p>If you have any questions or want to make a reservation, feel free to reach out to us.</p>
        <a href="https://www.facebook.com/raaddigital">Contact Us</a>
    </section>

    <!-- Footer Section -->
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
                <p><a href="https://www.facebook.com/raaddigital">Email</a></p>
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
