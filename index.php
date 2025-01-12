<?php
session_start();
include('db_connect.php');

// Check if the user is logged in, either via session or cookies
if (!isset($_SESSION['user_id']) && !isset($_COOKIE['user_id'])) {
    header("Location: login.php");
    exit();  // Stop further execution to ensure no content is shown to logged-out users
}

// Optionally: If no session but cookies are present, restore session from cookies
if (!isset($_SESSION['user_id']) && isset($_COOKIE['user_id'])) {
    $_SESSION['user_id'] = $_COOKIE['user_id'];
    $_SESSION['username'] = $_COOKIE['username'];
    $_SESSION['user_type'] = $_COOKIE['user_type']; // Set the user type from cookie, if stored
}
// Check if the user has 'Admin' user type (could be stored in session or cookie)
if ($_SESSION['user_type'] != 'User') {
    header("Location: login.php"); // Redirect non-admins to login page
    exit();
}
// Fetch all users
$sql = "SELECT * FROM users";
$stmt = $pdo->query($sql);
$users = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Waarid Restaurant - Home</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/index.css">
</head>
<body>
    <header>
        <h1>Waarid🍴Restaurant</h1>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="login.php">Login</a></li>
                <li><a href="signup.php">Sign_Up</a></li>
                <li><a href="aboutus.php">About</a></li>
                <li><a href="contact.php">Contact</a></li>
                <li><a href="menu.php">Menu</a></li>
            </ul>
        </nav>
    </header>
    <section class="main-content">
        <!-- Intro Section -->
        <div class="intro">
            <div>
                <h2>Welcome to <br> Waarid🍴Restaurant</h2>
                <p>Discover the best culinary experience with our delicious meals prepared by top chefs. Come in and enjoy a fantastic dining experience.</p>
                <a href="menu.php" class="order-button">Order Now</a>
            </div>
            <div>
                <img src="images/hero-img.png" alt="Delicious Food">
            </div>
        </div>
        <!-- Product Grid Section -->
        <h2>Our Delicious Menu</h2>
        <div class="product-grid">
            <!-- Product 1 -->
            <div class="product-card">
                <img src="images/1.jpg" alt="Barger">
                <div class="product-info">
                    <h3>Barger</h3>
                    <p>Best Barger to eat in the city</p>
                    <p class="price">$25</p>
                    <button class="view-button">View</button>
                </div>
            </div>
            <!-- Product 2 -->
            <div class="product-card">
                <img src="images/2.jpg" alt="Slashio">
                <div class="product-info">
                    <h3>Slashio</h3>
                    <p>Delicious slashio food for eat and buy</p>
                    <p class="price">$99</p>
                    <button class="view-button">View</button>
                </div>
            </div>
            <!-- Product 3 -->
            <div class="product-card">
                <img src="images/3.jpg" alt="Avocado & Egg Toast">
                <div class="product-info">
                    <h3>Avocado & Egg Toast</h3>
                    <p>Avocado and egg toast for a healthy breakfast</p>
                    <p class="price">$200</p>
                    <button class="view-button">View</button>
                </div>
            </div>
            <!-- Product 4 -->
            <div class="product-card">
                <img src="images/4.jpg" alt="Con Ice-cream">
                <div class="product-info">
                    <h3>Con Ice-cream</h3>
                    <p>Cone-shaped ice cream with a variety of flavors</p>
                    <p class="price">$30</p>
                    <button class="view-button">View</button>
                </div>
            </div>
              <!-- Product 5 -->
              <div class="product-card">
                <img src="images/5.jpg" alt="Con Ice-cream">
                <div class="product-info">
                    <h3>Con Ice-cream</h3>
                    <p>Cone-shaped ice cream with a variety of flavors</p>
                    <p class="price">$30</p>
                    <button class="view-button">View</button>
                </div>
            </div>
              <!-- Product 6 -->
              <div class="product-card">
                <img src="images/6.jpg" alt="Con Ice-cream">
                <div class="product-info">
                    <h3>Con Ice-cream</h3>
                    <p>Cone-shaped ice cream with a variety of flavors</p>
                    <p class="price">$30</p>
                    <button class="view-button">View</button>
                </div>
            </div>
              <!-- Product 7 -->
              <div class="product-card">
                <img src="images/7.jpg" alt="Con Ice-cream">
                <div class="product-info">
                    <h3>Con Ice-cream</h3>
                    <p>Cone-shaped ice cream with a variety of flavors</p>
                    <p class="price">$30</p>
                    <button class="view-button">View</button>
                </div>
            </div>
              <!-- Product 8 -->
              <div class="product-card">
                <img src="images/8.jpg" alt="Con Ice-cream">
                <div class="product-info">
                    <h3>Con Ice-cream</h3>
                    <p>Cone-shaped ice cream with a variety of flavors</p>
                    <p class="price">$30</p>
                    <button class="view-button">View</button>
                </div>
            </div>
        </div>
    </section>

    <!-- Updated Footer Section -->
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
                <h4>Social Media</h4>
                <ul>
                    <li><a href="#">Facebook</a></li>
                    <li><a href="#">Twitter</a></li>
                    <li><a href="#">Instagram</a></li>
                    <li><a href="#">YouTube</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>Copyright &copy; 2025 <span>Waarid🍴Restaurant</span> All rights reserved</p>
        </div>
    </footer>
</body>
</html>