<?php
require __DIR__.'/bootstrap.php'; require_role(true); $conn=db(); $table=table_name($_GET['table']??''); [$columns,$keys]=metadata($conn,$table);
if (!$keys) fail(400,'Table has no primary key');
$message='';
if ($_SERVER['REQUEST_METHOD']==='POST') {
    csrf(); $values=$_POST['pk']??[];
    if (!is_array($values)) fail(400,'Invalid key');
    $params=[]; $conditions=[];
    foreach($keys as $key) { if(!isset($values[$key])||!is_string($values[$key])) fail(400,'Missing key'); $conditions[]=identifier($key).'=?'; $params[]=$values[$key]; }
    $where=implode(' AND ',$conditions);
    $column=$_POST['column']??''; $value=$_POST['value']??'';
    if(!in_array($column,$columns,true)||in_array($column,$keys,true)||!is_string($value)) fail(400,'Invalid column');
    $sql='UPDATE '.identifier($table).' SET '.identifier($column).'=? WHERE '.$where;
    array_unshift($params,$value);
    try { $stmt=$conn->prepare($sql); $stmt->bind_param(str_repeat('s',count($params)),...$params); $stmt->execute(); $message='Affected rows: '.$stmt->affected_rows; }
    catch(Throwable $e) { $message='Operation failed. Check constraints and input.'; }
}
?>
<h2>Update <?= h($table) ?></h2><p><?= h($message) ?></p>
<form method="POST"><input type="hidden" name="csrf" value="<?= h(token()) ?>">
<?php foreach($keys as $key): ?><label><?= h($key) ?><input name="pk[<?= h($key) ?>]" required></label><br><?php endforeach; ?>
<select name="column"><?php foreach(array_diff($columns,$keys) as $column): ?><option value="<?= h($column) ?>"><?= h($column) ?></option><?php endforeach; ?></select><input name="value" required><button type="submit">Update</button></form>