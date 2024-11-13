<?php
session_start();

// Database connection settings
$host = 'localhost'; // Database host
$dbname = 'betting_game'; // Database name
$username_db = 'root'; // Your database username
$password_db = ''; // Your database password

// PDO connection
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username_db, $password_db);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Database connection failed: ' . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Simple validation: Ensure username and password are not empty
    if (empty($username) || empty($password)) {
        echo 'Username and password cannot be empty!';
        exit;
    }

    // Retrieve the user from the database by username
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    // Check if the user exists
    if ($user) {
        // Verify the password using password_verify
        if (password_verify($password, $user['password'])) {
            // Password is correct, start the session and redirect to the bet or home page
            $_SESSION['user'] = $username;
            header('Location: bet.php');
            exit;
        } else {
            // Invalid password
            echo 'Invalid credentials.';
        }
    } else {
        // User not found
        echo 'Invalid credentials.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - My PHP Game</title>
  <link rel="stylesheet" href="css/login.css">
</head>

<body>
  <div class="container login-container">
    <form class="login-form" method="POST">
      <h1>Login</h1>
      <div class="input-field">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
      </div>
      <div class="input-field">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
      </div>
      <div class="input-field">
        <button type="submit" class="submit-btn">Login</button>
      </div>
      <div class="register-link">
        <p>Don't have an account? <a href="register.php">Register here</a></p>
      </div>
    </form>
  </div>
</body>

</html>