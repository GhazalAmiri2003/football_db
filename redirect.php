<?php require __DIR__.'/bootstrap.php'; require_role(); $table=table_name($_GET['table']??''); $action=$_GET['action']??'';
$insert=['Team'=>'insert_team.php','Player'=>'insert_player.php','Tournament'=>'insert_tournament.php','Matchs'=>'insert_matches.php','Sponsor'=>'insert_sponsor.php','SponsoredBy'=>'insert_sponsoredby.php','Result'=>'insert_result.php','Team_Tournament'=>'insert_team_tournament.php','participates_in'=>'insert_participates_in.php'];
if(in_array($action,['insert','update','delete'],true)) require_role(true);
if($action==='insert') $url=$insert[$table];
elseif(in_array($action,['view','search','update','delete'],true)) $url=$action.'.php?table='.rawurlencode($table);
else fail(400,'Unknown action');
header('Location: '.$url); exit;