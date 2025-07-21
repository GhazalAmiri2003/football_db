<?php
$conn = new mysqli("localhost", "root", "", "esports_tracker", 3307);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$table = $_GET['table'] ?? '';
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Table: <?php echo htmlspecialchars($table); ?></title>
    <style>
        table { border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #aaa; padding: 8px; text-align: left; }
        th { background-color: #f0f0f0; }
    </style>
</head>
<body>
    <h2>Table Content: <span style="color:blue;"><?php echo htmlspecialchars($table); ?></span></h2>

    <?php
    if ($table) {
        // Special JOIN queries for certain tables
        if ($table === 'Player') {
            $query = "
                SELECT 
                    p.player_id, 
                    p.name AS player_name, 
                    t.name AS team_name, 
                    TIMESTAMPDIFF(YEAR, p.birthdate, CURDATE()) AS age,
                    p.nickname
                FROM Player p
                JOIN Team t ON p.team_id = t.team_id
            ";
        } elseif ($table === 'participates_in') {
            $query = "
                SELECT p.match_id, m.match_date AS match_date, t1.name AS team1_name, t2.name AS team2_name
                FROM participates_in p
                JOIN matchs m ON p.match_id = m.match_id
                JOIN Team t1 ON p.team_id = t1.team_id
                JOIN Team t2 ON p.team_id_2 = t2.team_id
            ";
        } else {
            // Default query for other tables
            $query = "SELECT * FROM `$table`";
        }

        $result = $conn->query($query);

        if ($result && $result->num_rows > 0) {
            echo "<table><tr>";

            while ($fieldinfo = $result->fetch_field()) {
                echo "<th>{$fieldinfo->name}</th>";
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
            echo "<p>No data found in this table.</p>";
        }
    } else {
        echo "<p>No table selected.</p>";
    }

    $conn->close();
    ?>
</body>
</html>
