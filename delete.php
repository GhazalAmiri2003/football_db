<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

$role = $_SESSION['role'] ?? '';

if ($role !== 'manager') {
    echo "<h3 style='color:red;'>Access Denied. Only managers are allowed to perform this action.</h3>";
    exit;
}

$conn = new mysqli("localhost", "root", "", "esports_tracker", 3307);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$table = $_GET['table'] ?? '';
$success = "";
$error = "";

// گرفتن کلیدهای اصلی جدول
$primaryKeys = [];

if ($table) {
    $result = $conn->query("SHOW COLUMNS FROM `$table`");
    if ($result) {
        while ($col = $result->fetch_assoc()) {
            if (strpos($col['Key'], 'PRI') !== false) {
                $primaryKeys[] = $col['Field'];
            }
        }
    } else {
        $error = "Failed to fetch columns from table.";
    }
}

// حذف رکورد وقتی فرم ارسال شود
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    $table = $_POST["table"];
    $pk_column = $_POST["pk_column"];
    $pk_value = $_POST["pk_value"];

    $sql = "DELETE FROM `$table` WHERE `$pk_column` = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        $error = "Invalid table or column.";
    } else {
        $stmt->bind_param("s", $pk_value);
        if ($stmt->execute()) {
            $success = "Deleted successfully.";
        } else {
            $error = "Error: " . $stmt->error;
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Delete Record from <?php echo htmlspecialchars($table); ?></title>
</head>
<body>
    <h2>Delete Record from Table: <span style="color:blue;"><?php echo htmlspecialchars($table); ?></span></h2>

    <?php if ($success) echo "<p style='color:green;'>$success</p>"; ?>
    <?php if ($error) echo "<p style='color:red;'>$error</p>"; ?>

    <?php if (!empty($primaryKeys)): ?>
    <form method="POST">
        <input type="hidden" name="table" value="<?php echo htmlspecialchars($table); ?>">

        <label>Primary Key Column:</label><br>
        <select name="pk_column" required>
            <?php foreach ($primaryKeys as $pk): ?>
                <option value="<?php echo $pk; ?>"><?php echo $pk; ?></option>
            <?php endforeach; ?>
        </select><br><br>

        <label>Primary Key Value:</label><br>
        <input type="text" name="pk_value" required><br><br>

        <input type="submit" name="delete" value="Delete">
    </form>
    <?php else: ?>
        <p style="color:red;">No primary key found in table or invalid table name.</p>
    <?php endif; ?>
</body>
</html>

