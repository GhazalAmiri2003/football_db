<?php
require __DIR__.'/bootstrap.php'; require_role(true);
if ($_SERVER['REQUEST_METHOD'] === 'POST') csrf();

$conn = db();if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $team_id = $_POST["team_id"];
    $tournament_id = $_POST["tournament_id"];
    $rank = $_POST["rank"];

    $sql = "INSERT INTO TeamTournament (team_id, tournament_id, rank) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iii", $team_id, $tournament_id, $rank);

    if ($stmt->execute()) {
        echo "Participation inserted successfully.";
    } else {
        echo "Error: " . 'Check input and database constraints';
    }
}
?>

<form method="POST">
<input type="hidden" name="csrf" value="<?= h(token()) ?>">
    Team ID: <input type="number" name="team_id" required><br>
    Tournament ID: <input type="number" name="tournament_id" required><br>
    Rank: <input type="number" name="rank"><br>
    <input type="submit" value="Insert Participation">
</form>
