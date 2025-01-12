<?php
    include('db_connect.php');
    
    // Handle registration process
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Collect form data
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $sex = $_POST['sex'];
        $username = $_POST['username'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Encrypt the password
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $user_type = $_POST['user_type'];
        $user_status = $_POST['user_status'];

        // Validate profile picture
        $profile_picture = $_FILES['profile_picture']['name'];
        $profile_picture_tmp = $_FILES['profile_picture']['tmp_name'];
        $profile_picture_size = $_FILES['profile_picture']['size'];
        $profile_picture_error = $_FILES['profile_picture']['error'];
        
        $allowed_extensions = ['jpg', 'jpeg', 'png'];
        $file_extension = strtolower(pathinfo($profile_picture, PATHINFO_EXTENSION));
        
        // Check for valid file type
        if (!in_array($file_extension, $allowed_extensions)) {
            echo "Error: Only JPG, JPEG, and PNG files are allowed!";
            exit();
        }

        // Check if file size is less than 5MB
        if ($profile_picture_size > 5 * 1024 * 1024) {
            echo "Error: File size should be less than 5MB!";
            exit();
        }

        // If no error, move the file to the 'uploads' directory
        $profile_picture_path = "uploads/" . $profile_picture;
        move_uploaded_file($profile_picture_tmp, $profile_picture_path);

        // Insert user data into the database
        $sql = "INSERT INTO users (first_name, last_name, sex, username, password, email, profile_picture, user_type, user_status) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$first_name, $last_name, $sex, $username, $password, $email, $profile_picture, $user_type, $user_status]);
        
        echo "Registration successful!";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Waarid Restaurant</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/signup.css">
    
</head>
<body>
    <div class="signup-container">
        <h2>Sign Up</h2>
        
        <!-- Success Message -->
        <?php if (isset($success_message)): ?>
            <p class="success-message"><?php echo $success_message; ?></p>
        <?php endif; ?>
        
        <form action="signup.php" method="POST" enctype="multipart/form-data">
            <label for="first_name">First Name:</label>
            <input type="text" id="first_name" name="first_name" required><br>
            
            <label for="last_name">Last Name:</label>
            <input type="text" id="last_name" name="last_name" required><br>
            
            <label for="sex">Sex:</label>
            <select name="sex" id="sex" required>
                <option value=""></option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select><br>
            
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required><br>
            
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br>
            
            <label for="phone">Phone:</label>
            <input type="text" id="phone" name="phone" required><br>
            
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br>
            
            <label for="profile_picture">Profile Picture:</label>
            <input type="file" id="profile_picture" name="profile_picture" required><br>
            
            <label for="user_type">User Type:</label>
            <select name="user_type" id="user_type" required>
                <option value=""></option>
                <option value="Admin">Admin</option>
                <option value="User">User</option>
            </select><br>
            
            <label for="user_status">User Status:</label>
            <select name="user_status" id="user_status" required>
                <option value=""></option>
                <option value="Active">Active</option>
                <option value="Inactive">Inactive</option>
            </select><br>
            
            <button type="reset">Reset</button>
            <button type="submit">Submit</button>
        </form>

        <div class="form-footer">
            <p>Already have an account? <a href="login.php">Login here</a></p>
        </div>
    </div>
</body>
</html>
