<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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

// Retrieve users from the database
$stmt_users = $pdo->query("SELECT * FROM users");
$users = $stmt_users->fetchAll(PDO::FETCH_ASSOC);

// Retrieve bets from the database
$stmt_bets = $pdo->query("SELECT bets.*, users.username FROM bets JOIN users ON bets.user_id = users.id");
$bets = $stmt_bets->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My PHP Game</title>
    <link rel="stylesheet" href="css/style.css"> <!-- Link to your CSS file -->
</head>

<body>
    <div class="container">
        <h1>Welcome to My PHP Game!</h1>
        <p>This is a simple game where you can place bets.</p>

        <!-- Form to place a bet -->
        <form action="bet.php" method="POST">
            <label for="bet_amount">Enter your bet:</label>
            <input type="number" id="bet_amount" name="bet_amount" required>
            <button type="submit">Place Bet</button>
        </form>

        <!-- Display the list of users -->
        <h2>Registered Users</h2>
        <ul>
            <?php foreach ($users as $user): ?>
            <li><?php echo htmlspecialchars($user['username']); ?></li>
            <?php endforeach; ?>
        </ul>

        <!-- Display the list of bets -->
        <h2>Recent Bets</h2>
        <table>
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Bet Amount</th>
                    <th>Bet Choice</th>
                    <th>Result</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($bets as $bet): ?>
                <tr>
                    <td><?php echo htmlspecialchars($bet['username']); ?></td>
                    <td><?php echo htmlspecialchars($bet['bet_amount']); ?></td>
                    <td><?php echo htmlspecialchars($bet['bet_choice']); ?></td>
                    <td><?php echo htmlspecialchars($bet['result']); ?></td>
                    <td><?php echo htmlspecialchars($bet['created_at']); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>