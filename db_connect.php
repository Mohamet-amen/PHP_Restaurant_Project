<?php
$host = 'localhost';
$dbname = 'waarid_restaurant';
$username = 'root'; // Change to your database username
$password = '1234'; // Change to your database password

try {
    // Create a PDO instance
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
