<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $bet_amount = $_POST['bet_amount'];
    $bet_choice = $_POST['bet_choice'];
    $result = (rand(0, 1) == 1) ? 'Win' : 'Lose'; // Simple 50/50 outcome

    $stmt = $pdo->prepare("INSERT INTO bets (user_id, bet_amount, bet_choice, result) VALUES (?, ?, ?, ?)");
    $stmt->execute([$_SESSION['user_id'], $bet_amount, $bet_choice, $result]);

    echo "Bet placed! Result: $result";
}
?>

<form method="POST">
    <input type="number" name="bet_amount" placeholder="Bet Amount" required>
    <input type="text" name="bet_choice" placeholder="Your Choice" required>
    <button type="submit">Place Bet</button>
</form>
