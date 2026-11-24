<?php
require __DIR__.'/bootstrap.php'; require_role(true);
if ($_SERVER['REQUEST_METHOD'] === 'POST') csrf();

// DB connection
$conn = db();

$error = "";
$success = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $nickname = $_POST["nickname"];
    $birthdate = $_POST["birthdate"];
    $team_id = $_POST["team_id"];

    // Server-side age validation
    $today = new DateTime();
    $dob = new DateTime($birthdate);
    $age = $today->diff($dob)->y;

    if ($age < 16) {
        $error = "Player must be at least 16 years old.";
    } else {
        $stmt = $conn->prepare("INSERT INTO Player (name, nickname, birthdate, team_id) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $name, $nickname, $birthdate, $team_id);

        if ($stmt->execute()) {
            $success = "Player inserted successfully!";
        } else {
            $error = "Error: " . 'Check input and database constraints';
        }

        $stmt->close();
    }
}

// Fetch teams for dropdown
$teams = $conn->query("SELECT team_id, name FROM Team");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Insert Player</title>
</head>
<body>
    <h2>Insert New Player</h2>

    <?php if ($success) echo "<p style='color:green;'>$success</p>"; ?>
    <?php if ($error) echo "<p style='color:red;'>$error</p>"; ?>

    <form method="POST">
<input type="hidden" name="csrf" value="<?= h(token()) ?>">
        <label for="name">Player Name:</label><br>
        <input type="text" name="name" required><br><br>

        <label for="nickname">Nickname:</label><br>
        <input type="text" name="nickname"><br><br>

        <label for="birthdate">Birthdate:</label><br>
        <input type="date" name="birthdate" required max="<?php echo date('Y-m-d', strtotime('-16 years')); ?>"><br><br>

        <label for="team_id">Select Team:</label><br>
        <select name="team_id" required>
            <option value="">-- Select --</option>
            <?php while ($row = $teams->fetch_assoc()): ?>
                <option value="<?php echo $row['team_id']; ?>">
                    <?php echo htmlspecialchars($row['name']); ?>
                </option>
            <?php endwhile; ?>
        </select><br><br>

        <input type="submit" value="Insert Player">
    </form>
</body>
</html>
