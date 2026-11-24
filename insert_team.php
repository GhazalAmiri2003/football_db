<?php
require __DIR__.'/bootstrap.php'; require_role(true);
if ($_SERVER['REQUEST_METHOD'] === 'POST') csrf();


$conn = db();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $country = $_POST["country"];

    $stmt = $conn->prepare("INSERT INTO Team (name, country) VALUES (?, ?)");
    $stmt->bind_param("ss", $name, $country);

    if ($stmt->execute()) {
        echo "<p style='color:green;'>Team inserted successfully!</p>";
    } else {
        echo "<p style='color:red;'>Error: " . 'Check input and database constraints' . "</p>";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Insert Team</title>
</head>
<body>
    <h2>Insert New Team</h2>

    <form method="POST">
<input type="hidden" name="csrf" value="<?= h(token()) ?>">
        <label for="name">Team Name:</label><br>
        <input type="text" name="name" required><br><br>

        <label for="country">Country / Region:</label><br>
        <select name="country" required>
            <option value="">-- Select --</option>
            <option value="Europe">Europe</option>
            <option value="Asia">Asia</option>
            <option value="North America">North America</option>
            <option value="South America">South America</option>
            <option value="Africa">Africa</option>
            <option value="Oceania">Oceania</option>
        </select><br><br>

        <input type="submit" value="Insert Team">
    </form>
</body>
</html>

