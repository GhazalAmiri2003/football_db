<?php
$conn = new mysqli("localhost", "root", "", "esports_tracker", 3307);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

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
  Name: <input type="text" name="name" required><br>
  Industry: <input type="text" name="industry"><br>
  <input type="submit" value="Insert">
</form>


