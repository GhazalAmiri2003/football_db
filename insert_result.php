<?php
require __DIR__.'/bootstrap.php'; require_role(true);
if ($_SERVER['REQUEST_METHOD'] === 'POST') csrf();

$conn = db();if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $match_id = $_POST["match_id"];
    $team_id = $_POST["team_id"];
    $score = $_POST["score"];

    $sql = "INSERT INTO Result (match_id, team_id, score) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iii", $match_id, $team_id, $score);

    if ($stmt->execute()) {
        echo "Result inserted successfully.";
    } else {
        echo "Error: " . 'Check input and database constraints';
    }
}
?>

<form method="POST">
<input type="hidden" name="csrf" value="<?= h(token()) ?>">
    Match ID: <input type="number" name="match_id" required><br>
    Team ID: <input type="number" name="team_id" required><br>
    Score: <input type="number" name="score" required><br>
    <input type="submit" value="Insert Result">
</form>