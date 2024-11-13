<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Redirect to login page if not logged in
    exit;
}

// Include database connection
require 'db.php'; // Make sure this path is correct relative to bet.php

// Handle bet submission
$resultMessage = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $betAmount = filter_input(INPUT_POST, 'betAmount', FILTER_SANITIZE_NUMBER_INT);
    $betChoice = filter_input(INPUT_POST, 'betChoice', FILTER_SANITIZE_STRING);
    $userId = $_SESSION['user_id'];

    if ($betAmount && $betChoice && $userId) {
        $randomResult = rand(1, 2);
        $result = ($randomResult == 1) ? 'Win' : 'Lose';

        // Use PDO to insert the bet
        $stmt = $pdo->prepare("INSERT INTO bets (user_id, bet_amount, bet_choice, result) VALUES (?, ?, ?, ?)");
        $stmt->execute([$userId, $betAmount, $betChoice, $result]);

        if ($stmt->rowCount()) {
            $resultMessage = "Bet placed successfully! Result: $result";
        } else {
            $resultMessage = "Error placing bet.";
        }
    } else {
        $resultMessage = "Invalid input. Please enter a valid bet amount and choice.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Place Your Bet - My PHP Game</title>
  <link rel="stylesheet" href="bet.css">
</head>

<body>
  <div class="container bet-container">
    <form class="bet-form" method="POST">
      <h1>Place Your Bet</h1>
      <div class="input-field">
        <label for="betAmount">Bet Amount:</label>
        <input type="number" id="betAmount" name="betAmount" required>
      </div>
      <div class="input-field">
        <label for="betChoice">Bet Choice:</label>
        <select id="betChoice" name="betChoice" required>
          <option value="choice1">Choice 1</option>
          <option value="choice2">Choice 2</option>
        </select>
      </div>

      <div class="input-field">
        <button type="submit" class="submit-btn">Place Bet</button>
      </div>
    </form>

    <?php if ($resultMessage): ?>
    <div class="result">
      <?php echo htmlspecialchars($resultMessage); ?>
    </div>
    <?php endif; ?>
  </div>
</body>

</html>
