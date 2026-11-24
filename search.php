<?php require __DIR__.'/bootstrap.php'; require_role(); $table=table_name($_GET['table']??'Player'); $conn=db(); [$columns]=metadata($conn,$table); ?>
<h2>Search <?= h($table) ?></h2><form action="search_result.php" method="GET">
<input type="hidden" name="table" value="<?= h($table) ?>"><select name="column"><?php foreach($columns as $column): ?><option value="<?= h($column) ?>"><?= h($column) ?></option><?php endforeach; ?></select>
<input name="keyword" required placeholder="Starts with"><button>Search</button></form>