<?php require __DIR__.'/bootstrap.php'; require_role(); ?>
<!DOCTYPE html><html><head><title>Select Table</title></head><body>
<h2>Welcome, <?= h($_SESSION['authenticated_role']) ?></h2>
<form action="action_select.php" method="GET"><select name="table" required>
<?php foreach(tables() as $table): ?><option value="<?= h($table) ?>"><?= h($table) ?></option><?php endforeach; ?>
</select><button>Continue</button></form>
<form action="logout.php" method="POST"><input type="hidden" name="csrf" value="<?= h(token()) ?>"><button>Logout</button></form></body></html>