<?php
session_start();
if (!isset($_SESSION['role'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Select Table</title>
</head>
<body>
    <h2>Welcome, Role: <?php echo $_SESSION['role']; ?></h2>

    <form action="action_select.php" method="GET">
        <label for="table">Select Table:</label>
        <select name="table" id="table" required>
            <option value="Team">Team</option>
            <option value="Player">Player</option>
            <option value="Tournament">Tournament</option>
            <option value="Matchs">Matchs</option>
            <option value="Sponsor">Sponsor</option>
            <option value="SponsoredBy">SponsoredBy</option>
            <option value="Result">Result</option>
            <option value="Team_Tournament">Team_Tournament</option>
            <option value="participates_in">participates_in</option>
        </select>
        <br><br>
        <input type="submit" value="Continue">
    </form>
</body>
</html>

