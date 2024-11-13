<?php
// Start the session to manage user data (if necessary)
session_start();

// Database connection settings
$host = 'localhost'; // Database host
$dbname = 'betting_game'; // Database name
$username_db = 'root'; // Your database username
$password_db = ''; // Your database password

// PDO connection
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username_db, $password_db);
    // Set the PDO error mode to exception to catch errors
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Display connection error if any
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

    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Check if the user already exists
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $existing_user = $stmt->fetch();

    if ($existing_user) {
        echo 'Username already exists. Please choose another one.';
        exit;
    }

    // Insert the new user into the database
    try {
        $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->execute([$username, $hashed_password]);

        // Store user data in session
        $_SESSION['user'] = $username;

        // Redirect to the login page after successful registration
        header('Location: login.php');
        exit;
    } catch (PDOException $e) {
        // Handle error during insert
        echo 'Error during registration: ' . $e->getMessage();
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register - My PHP Game</title>
  <link rel="stylesheet" href="register.css">
</head>

<body>
  <div class="container register-container">
    <form class="register-form" method="POST">
      <h1>Register</h1>
      <div class="input-field">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
      </div>
      <div class="input-field">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
      </div>
      <div class="input-field">
        <button type="submit" class="submit-btn">Register</button>
      </div>
      <div class="already-registered">
        <p>Already have an account? <a href="login.php">Login here</a></p>
      </div>
    </form>
  </div>
</body>

</html>