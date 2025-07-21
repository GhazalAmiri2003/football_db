<?php
$conn = new mysqli("localhost", "root", "", "esports_tracker", 3307);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $location = $_POST["location"];
    $start = $_POST["start_date"];
    $end = $_POST["end_date"];
    $prize = $_POST["prize_pool"];

    $stmt = $conn->prepare("INSERT INTO Tournament (name, location, start_date, end_date, prize_pool) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssd", $name, $location, $start, $end, $prize);
    $stmt->execute();
    echo "<p style='color:green;'>Tournament inserted.</p>";
    $stmt->close();
}
?>
<form method="POST">
  Name: <input type="text" name="name" required><br>
  Location: <input type="text" name="location"><br>
  Start Date: <input type="date" name="start_date"><br>
  End Date: <input type="date" name="end_date"><br>
  Prize Pool: <input type="number" name="prize_pool" step="0.01"><br>
  <input type="submit" value="Insert">
</form>
