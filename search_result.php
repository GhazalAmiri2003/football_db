<?php
// search_result.php
$conn = new mysqli("localhost", "root", "", "esports_tracker", 3307);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$table = $_GET['table'] ?? '';
$column = $_GET['column'] ?? '';
$keyword = $_GET['keyword'] ?? '';

if ($table && $column && $keyword) {
    $query = "SELECT * FROM `$table` WHERE `$column` LIKE '$keyword%'";
    $result = $conn->query($query);

    echo "<h2>Results in <span style='color:blue;'>$table</span></h2>";

    if ($result && $result->num_rows > 0) {
        echo "<table border='1'><tr>";
        while ($field = $result->fetch_field()) {
            echo "<th>{$field->name}</th>";
        }
        echo "</tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            foreach ($row as $val) {
                echo "<td>" . htmlspecialchars($val) . "</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No results found starting with '$keyword' in $column.</p>";
    }
} else {
    echo "<p>Invalid search parameters.</p>";
}

$conn->close();
?>
