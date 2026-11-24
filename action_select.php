<?php require __DIR__.'/bootstrap.php'; require_role(); $table=table_name($_GET['table']??''); ?>
<!DOCTYPE html><html><head><title>Select Action</title></head><body><h2><?= h($table) ?></h2>
<form action="redirect.php" method="GET"><input type="hidden" name="table" value="<?= h($table) ?>"><select name="action">
<option value="view">View</option><option value="search">Search</option>
<?php if($_SESSION['authenticated_role']==='manager'): ?><option value="insert">Insert</option><option value="update">Update</option><option value="delete">Delete</option><?php endif; ?>
</select><button>Continue</button></form></body></html>