<?php require __DIR__.'/bootstrap.php'; require_role(); $conn=db(); $table=table_name($_GET['table']??''); [$columns]=metadata($conn,$table); $column=$_GET['column']??''; $keyword=$_GET['keyword']??'';
if(!in_array($column,$columns,true)||!is_string($keyword)||strlen($keyword)>255) fail(400,'Invalid search');
$pattern=strtr($keyword,['!'=>'!!','%'=>'!%','_'=>'!_']).'%';
$stmt=$conn->prepare('SELECT * FROM '.identifier($table).' WHERE '.identifier($column)." LIKE ? ESCAPE '!'"); $stmt->bind_param('s',$pattern); $stmt->execute(); show_rows($stmt->get_result());