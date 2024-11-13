<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Your PHP logic goes here, e.g., database connections, game logic, etc.
echo "<h1>Welcome to My PHP Game!</h1>";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My PHP Game</title>
    <link rel="stylesheet" href="style.css"> <!-- Link to your CSS file -->
</head>
<body>
    <div class="container">
        <h1>Welcome to My PHP Game!</h1>
        <p>This is a simple game where you can place bets.</p>
        
        <!-- Example of a basic form -->
        <form action="bet.php" method="POST">
            <label for="bet_amount">Enter your bet:</label>
            <input type="number" id="bet_amount" name="bet_amount" required>
            <button type="submit">Place Bet</button>
        </form>
        
        <!-- Add any additional content for the game here -->
    </div>
</body>
</html>
