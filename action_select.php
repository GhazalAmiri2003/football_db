<?php
session_start();
$role = $_SESSION['role'] ?? '';
$table = $_GET['table'] ?? '';

if (!$table || !$role) {
    echo "Missing role or table.";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head><title>Select Action</title></head>
<body>
    <h2>Selected Table: <?php echo htmlspecialchars($table); ?></h2>
    <h3>Your Role: <?php echo htmlspecialchars($role); ?></h3>

    <form action="redirect.php" method="GET">
        <input type="hidden" name="table" value="<?php echo htmlspecialchars($table); ?>">

        <label for="action">Choose an action:</label>
        <select name="action" id="action" required>
            <option value="view">View</option>
            <?php if ($role === 'manager'): ?>
                <option value="insert">Insert</option>
                <option value="update">Update</option>
                <option value="delete">Delete</option>
            <?php endif; ?>
            <option value="search">Search</option>
        </select>
        <br><br>
        <input type="submit" value="Continue">
    </form>
</body>
</html>
