<?php
require __DIR__.'/bootstrap.php'; require_role(true);
if ($_SERVER['REQUEST_METHOD'] === 'POST') csrf();

$conn = db();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $industry = $_POST["industry"];

    $stmt = $conn->prepare("INSERT INTO Sponsor (name, industry) VALUES (?, ?)");
    $stmt->bind_param("ss", $name, $industry);
    $stmt->execute();
    echo "<p style='color:green;'>Sponsor inserted.</p>";
    $stmt->close();
}
?>
<form method="POST">
<input type="hidden" name="csrf" value="<?= h(token()) ?>">
  Name: <input type="text" name="name" required><br>
  Industry: <input type="text" name="industry"><br>
  <input type="submit" value="Insert">
</form>


