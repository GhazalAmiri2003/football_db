<?php
require __DIR__.'/bootstrap.php'; require_role(true);
if ($_SERVER['REQUEST_METHOD'] === 'POST') csrf();

$conn = db();
$sponsors = $conn->query("SELECT sponsor_id, name FROM Sponsor");
$tournaments = $conn->query("SELECT tournament_id, name FROM Tournament");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sid = $_POST["sponsor_id"];
    $tid = $_POST["tournament_id"];
    $amount = $_POST["amount"];

    $stmt = $conn->prepare("INSERT INTO SponsoredBy (sponsor_id, tournament_id, amount) VALUES (?, ?, ?)");
    $stmt->bind_param("iid", $sid, $tid, $amount);
    $stmt->execute();
    echo "<p style='color:green;'>Sponsorship inserted.</p>";
    $stmt->close();
}
?>
<form method="POST">
<input type="hidden" name="csrf" value="<?= h(token()) ?>">
  Sponsor:
  <select name="sponsor_id">
    <?php while ($row = $sponsors->fetch_assoc()): ?>
      <option value="<?= $row['sponsor_id'] ?>"><?= htmlspecialchars($row['name']) ?></option>
    <?php endwhile; ?>
  </select><br>
  Tournament:
  <select name="tournament_id">
    <?php while ($row = $tournaments->fetch_assoc()): ?>
      <option value="<?= $row['tournament_id'] ?>"><?= htmlspecialchars($row['name']) ?></option>
    <?php endwhile; ?>
  </select><br>
  Amount: <input type="number" name="amount" step="0.01"><br>
  <input type="submit" value="Insert">
</form>