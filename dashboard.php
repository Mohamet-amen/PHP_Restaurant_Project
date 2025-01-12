<?php
session_start();
include('db_connect.php'); // Make sure db_connect.php has your database connection setup

// Check if the user is logged in
if (!isset($_SESSION['user_id']) && !isset($_COOKIE['user_id'])) {
    header("Location: login.php");
    exit();
}

// Restore session if cookies exist but no session is active
if (!isset($_SESSION['user_id']) && isset($_COOKIE['user_id'])) {
    $_SESSION['user_id'] = $_COOKIE['user_id'];
    $_SESSION['username'] = $_COOKIE['username'];
    $_SESSION['user_type'] = $_COOKIE['user_type'];
}

// Restrict access to Admin users
if ($_SESSION['user_type'] != 'Admin') {
    header("Location: login.php");
    exit();
}

// Handle Insert (Create User) functionality
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'create') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $user_type = $_POST['user_type'];
    $user_status = $_POST['user_status'];

    // Insert the new user into the database using a prepared statement
    $sql = "INSERT INTO users (first_name, last_name, email, user_type, user_status) VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$first_name, $last_name, $email, $user_type, $user_status]);

    header("Location: dashboard.php?msg=User+added");
    exit();
}

// Handle Delete functionality
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
    if (filter_var($user_id, FILTER_VALIDATE_INT)) {
        $sql = "DELETE FROM users WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$user_id]);

        header("Location: dashboard.php?msg=User+deleted");
        exit();
    }
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
    <title>Dashboard - Waarid Restaurant</title>
    <link rel="stylesheet" href="css/dashboard.css">
</head>
<body>
    <header>
        <h1>Admin Dashboard</h1>
        <nav>
            <ul>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <section class="main-content">
        <h2>Manage Users</h2>
        <?php if (isset($_GET['msg'])): ?>
            <p class="success"><?php echo htmlspecialchars($_GET['msg']); ?></p>
        <?php endif; ?>

        <!-- Add User Form -->
        <h3>Add New User</h3>
        <form method="POST" action="">
            <input type="hidden" name="action" value="create">
            <label for="first_name">First Name:</label>
            <input type="text" id="first_name" name="first_name" required><br>

            <label for="last_name">Last Name:</label>
            <input type="text" id="last_name" name="last_name" required><br>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br>

            <label for="user_type">User Type:</label>
            <select id="user_type" name="user_type" required>
                <option value="Admin">Admin</option>
                <option value="User">User</option>
            </select><br>

            <label for="user_status">Status:</label>
            <select id="user_status" name="user_status" required>
                <option value="Active">Active</option>
                <option value="Inactive">Inactive</option>
            </select><br>

            <button type="submit">Add User</button>
        </form>

        <!-- User Table -->
        <h3>All Users</h3>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>User Type</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user['id']); ?></td>
                        <td><?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></td>
                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                        <td><?php echo htmlspecialchars($user['user_type']); ?></td>
                        <td><?php echo htmlspecialchars($user['user_status']); ?></td>
                        <td>
                            <a href="javascript:void(0);" onclick="openEditModal(<?php echo htmlspecialchars($user['id']); ?>, '<?php echo htmlspecialchars($user['first_name']); ?>', '<?php echo htmlspecialchars($user['last_name']); ?>', '<?php echo htmlspecialchars($user['email']); ?>', '<?php echo htmlspecialchars($user['user_type']); ?>', '<?php echo htmlspecialchars($user['user_status']); ?>')">Edit</a> |
                            <a href="dashboard.php?action=delete&user_id=<?php echo htmlspecialchars($user['id']); ?>" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>

    <!-- Edit User Modal -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeEditModal()">&times;</span>
            <h2>Edit User</h2>
            <form id="editForm" method="POST" action="update_user.php">
                <input type="hidden" id="editUserId" name="user_id">
                <label for="editFirstName">First Name:</label>
                <input type="text" id="editFirstName" name="first_name" required><br>

                <label for="editLastName">Last Name:</label>
                <input type="text" id="editLastName" name="last_name" required><br>

                <label for="editEmail">Email:</label>
                <input type="email" id="editEmail" name="email" required><br>

                <label for="editUserType">User Type:</label>
                <select id="editUserType" name="user_type">
                    <option value="Admin">Admin</option>
                    <option value="User">User</option>
                </select><br>

                <label for="editUserStatus">Status:</label>
                <select id="editUserStatus" name="user_status">
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                </select><br>

                <button type="submit">Update</button>
            </form>
        </div>
    </div>

    <script>
        function openEditModal(id, first_name, last_name, email, user_type, user_status) {
            document.getElementById("editUserId").value = id;
            document.getElementById("editFirstName").value = first_name;
            document.getElementById("editLastName").value = last_name;
            document.getElementById("editEmail").value = email;
            document.getElementById("editUserType").value = user_type;
            document.getElementById("editUserStatus").value = user_status;
            document.getElementById("editModal").style.display = "block";
        }
        function closeEditModal() {
            document.getElementById("editModal").style.display = "none";
        }
    </script>
</body>
</html>
