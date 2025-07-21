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

// مرحلهٔ اول: گرفتن ستون‌ها و کلیدها از جدول
$columns = [];
$primaryKeys = [];

if ($table) {
    $cols = $conn->query("SHOW COLUMNS FROM `$table`");
    if ($cols) {
        while ($col = $cols->fetch_assoc()) {
            $columns[] = $col['Field'];
            if (strpos($col['Key'], 'PRI') !== false) {
                $primaryKeys[] = $col['Field'];
            }
        }
    } else {
        $error = "Could not fetch columns for table: $table";
    }
}

// وقتی فرم ارسال می‌شه
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $table = $_POST["table"];
    $pk_column = $_POST["pk_column"];
    $pk_value = $_POST["pk_value"];
    $target_column = $_POST["target_column"];
    $new_value = $_POST["new_value"];

    $sql = "UPDATE `$table` SET `$target_column` = ? WHERE `$pk_column` = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        $error = "Invalid query or table/column name.";
    } else {
        $stmt->bind_param("ss", $new_value, $pk_value);
        if ($stmt->execute()) {
            $success = "Updated successfully.";
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
    <title>Update Record in <?php echo htmlspecialchars($table); ?></title>
</head>
<body>
    <h2>Update a Record in Table: <span style="color:blue;"><?php echo htmlspecialchars($table); ?></span></h2>

    <?php if ($success) echo "<p style='color:green;'>$success</p>"; ?>
    <?php if ($error) echo "<p style='color:red;'>$error</p>"; ?>

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

        <label>Column to Update:</label><br>
        <select name="target_column" required>
            <?php foreach ($columns as $col): ?>
                <option value="<?php echo $col; ?>"><?php echo $col; ?></option>
            <?php endforeach; ?>
        </select><br><br>

        <label>New Value:</label><br>
        <input type="text" name="new_value" required><br><br>

        <input type="submit" name="update" value="Update">
    </form>
</body>
</html>


