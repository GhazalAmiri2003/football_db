<?php
require __DIR__ . '/bootstrap.php';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf();
    $role = $_POST['role'] ?? '';
    $password = $_POST['password'] ?? '';
    $hash = $role === 'manager' ? getenv('MANAGER_PASSWORD_HASH') : ($role === 'player' ? getenv('PLAYER_PASSWORD_HASH') : false);
    if ($hash && is_string($password) && password_verify($password, $hash)) {
        session_regenerate_id(true); $_SESSION = ['authenticated_role'=>$role];
        header('Location: table_select.php'); exit;
    }
    $error = 'Invalid credentials';
}
?>
<!DOCTYPE html><html><head><title>Login</title></head><body>
<h2>Sign in</h2><p><?= h($error) ?></p>
<form method="POST"><input type="hidden" name="csrf" value="<?= h(token()) ?>">
<label><input type="radio" name="role" value="manager" required> Manager</label><br>
<label><input type="radio" name="role" value="player" required> Player</label><br>
<label>Password <input type="password" name="password" required></label>
<button type="submit">Login</button></form></body></html>
