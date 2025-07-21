<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'manager') {
    echo "<h3 style='color:red;'>Access Denied. Only managers can insert data.</h3>";
    exit;
}

$conn = new mysqli("localhost", "root", "", "esports_tracker", 3307);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$success = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $match_id = $_POST["match_id"] ?? '';
    $team1_id = $_POST["team_id"] ?? '';
    $team2_id = $_POST["team_id_2"] ?? '';

    if ($match_id && $team1_id && $team2_id) {
        if ($team1_id === $team2_id) {
            $error = "Team 1 and Team 2 must be different.";
        } else {
            $stmt = $conn->prepare("INSERT INTO participates_in (match_id, team_id, team_id_2) VALUES (?, ?, ?)");
            $stmt->bind_param("iii", $match_id, $team1_id, $team2_id);

            if ($stmt->execute()) {
                $success = "Participation inserted successfully!";
            } else {
                $error = "Error: " . $stmt->error;
            }

            $stmt->close();
        }
    } else {
        $error = "All fields are required.";
    }
}

// گرفتن تیم‌ها و مسابقه‌ها برای dropdown
$teams = $conn->query("SELECT team_id, name FROM Team");
$matches = $conn->query("SELECT match_id FROM Matchs");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Insert Participation</title>
</head>
<body>
    <h2>Insert Team Participation in a Match</h2>

    <?php if ($success) echo "<p style='color:green;'>$success</p>"; ?>
    <?php if ($error) echo "<p style='color:red;'>$error</p>"; ?>

    <form method="POST">
        <label for="match_id">Select Match:</label><br>
        <select name="match_id" required>
            <option value="">-- Select Match --</option>
            <?php while ($row = $matches->fetch_assoc()): ?>
                <option value="<?php echo $row['match_id']; ?>">
                    Match #<?php echo $row['match_id']; ?>
                </option>
            <?php endwhile; ?>
        </select><br><br>

        <label for="team_id">Select Team 1:</label><br>
        <select name="team_id" required>
            <option value="">-- Select Team 1 --</option>
            <?php while ($row = $teams->fetch_assoc()): ?>
                <option value="<?php echo $row['team_id']; ?>">
                    <?php echo htmlspecialchars($row['name']); ?>
                </option>
            <?php endwhile; ?>
        </select><br><br>

        <?php
        // دوباره کوئری تیم‌ها برای Team 2 (چون قبلی مصرف شده)
        $teams2 = $conn->query("SELECT team_id, name FROM Team");
        ?>

        <label for="team_id_2">Select Team 2:</label><br>
        <select name="team_id_2" required>
            <option value="">-- Select Team 2 --</option>
            <?php while ($row = $teams2->fetch_assoc()): ?>
                <option value="<?php echo $row['team_id']; ?>">
                    <?php echo htmlspecialchars($row['name']); ?>
                </option>
            <?php endwhile; ?>
        </select><br><br>

        <input type="submit" value="Insert Participation">
    </form>
</body>
</html>
