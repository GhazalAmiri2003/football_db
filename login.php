<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $_SESSION['role'] = $_POST['role'];
    header("Location: table_select.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head><title>Login</title></head>
<body>
    <h2>Select Role</h2>
    <form method="POST">
        <label><input type="radio" name="role" value="manager" required> Manager</label><br>
        <label><input type="radio" name="role" value="player" required> Player</label><br><br>
        <input type="submit" value="Login">
    </form>
</body>
</html>
