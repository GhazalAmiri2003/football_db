<?php
require __DIR__.'/bootstrap.php'; require_role(true);
if ($_SERVER['REQUEST_METHOD'] === 'POST') csrf();

$conn = db();
$tournaments = $conn->query("SELECT tournament_id, name FROM Tournament");
$teams = $conn->query("SELECT team_id, name FROM Team");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tid = $_POST["tournament_id"];
    $t1 = $_POST["team1_id"];
    $t2 = $_POST["team2_id"];
    $date = $_POST["match_date"];
    $s1 = $_POST["score_team1"];
    $s2 = $_POST["score_team2"];

    $stmt = $conn->prepare("INSERT INTO Matchs (tournament_id, team1_id, team2_id, match_date, score_team1, score_team2) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iiisii", $tid, $t1, $t2, $date, $s1, $s2);
    $stmt->execute();
    echo "<p style='color:green;'>Match inserted.</p>";
    $stmt->close();
}
?>
<form method="POST">
<input type="hidden" name="csrf" value="<?= h(token()) ?>">
  Tournament:
  <select name="tournament_id">
    <?php while ($row = $tournaments->fetch_assoc()): ?>
      <option value="<?= $row['tournament_id'] ?>"><?= htmlspecialchars($row['name']) ?></option>
    <?php endwhile; ?>
  </select><br>
  Team 1:
  <select name="team1_id">
    <?php while ($row = $teams->fetch_assoc()): ?>
      <option value="<?= $row['team_id'] ?>"><?= htmlspecialchars($row['name']) ?></option>
    <?php endwhile; ?>
  </select><br>
  Team 2:
  <select name="team2_id">
    <?php
    $teams2 = $conn->query("SELECT team_id, name FROM Team");
    while ($row = $teams2->fetch_assoc()): ?>
      <option value="<?= $row['team_id'] ?>"><?= htmlspecialchars($row['name']) ?></option>
    <?php endwhile; ?>
  </select><br>
  Date: <input type="date" name="match_date"><br>
  Score Team 1: <input type="number" name="score_team1"><br>
  Score Team 2: <input type="number" name="score_team2"><br>
  <input type="submit" value="Insert">
</form>