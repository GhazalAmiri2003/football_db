<?php require __DIR__.'/bootstrap.php'; require_role(); $conn=db(); $table=table_name($_GET['table']??'');
echo '<h2>'.h($table).'</h2>';
if($table==='Player') $sql='SELECT p.player_id,p.name AS player_name,t.name AS team_name,TIMESTAMPDIFF(YEAR,p.birthdate,CURDATE()) AS age,p.nickname FROM Player p JOIN Team t ON p.team_id=t.team_id';
elseif($table==='participates_in') $sql='SELECT p.match_id,m.match_date,t1.name AS team1_name,t2.name AS team2_name FROM participates_in p JOIN Matchs m ON p.match_id=m.match_id JOIN Team t1 ON p.team_id=t1.team_id JOIN Team t2 ON p.team_id_2=t2.team_id';
else $sql='SELECT * FROM '.identifier($table);
show_rows($conn->query($sql));