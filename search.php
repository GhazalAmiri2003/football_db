<?php

?>
<!DOCTYPE html>
<html>
<head>
    <title>Search</title>
</head>
<body>
<h2>Search in Table</h2>
<form action="search_result.php" method="GET">
    <label>Choose table:</label>
    <select name="table">
        <option value="Player">Player</option>
        <option value="Team">Team</option>
        <option value="matchs">Matches</option>
        <option value="Tournament">Tournament</option>
        <option value="Sponsor">Sponsor</option>
        <option value="Result">Result</option>
    </select><br><br>

    <label>Choose column:</label>
    <input type="text" name="column" placeholder="e.g. name" required><br><br>

    <label>Starts with:</label>
    <input type="text" name="keyword" required><br><br>

    <input type="submit" value="Search">
</form>
</body>
</html>
