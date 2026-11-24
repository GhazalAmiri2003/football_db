<?php
declare(strict_types=1);
ini_set('display_errors', '0');
session_start();
function h($value): string { return htmlspecialchars((string)$value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); }
function fail(int $status, string $message): void { http_response_code($status); exit(h($message)); }
function token(): string { if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(32)); return $_SESSION['csrf']; }
function csrf(): void { if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !is_string($_POST['csrf'] ?? null) || !hash_equals(token(), $_POST['csrf'])) fail(403, 'Invalid request'); }
function require_role(bool $manager = false): void {
    $role = $_SESSION['authenticated_role'] ?? '';
    if (!in_array($role, ['manager','player'], true)) { header('Location: login.php'); exit; }
    if ($manager && $role !== 'manager') fail(403, 'Manager access required');
}
function tables(): array { return ['Team','Player','Tournament','Matchs','Sponsor','SponsoredBy','Result','Team_Tournament','participates_in']; }
function table_name($name): string {
    if (!is_string($name)) fail(400, 'Invalid table');
    foreach (tables() as $table) if (strcasecmp($table, $name) === 0) return $table;
    fail(400, 'Invalid table'); return '';
}
function db(): mysqli {
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    try {
        $user = getenv('DB_USER');
        if (!$user) throw new RuntimeException('DB_USER required');
        $conn = new mysqli(getenv('DB_HOST') ?: '127.0.0.1', $user, getenv('DB_PASSWORD') ?: '', getenv('DB_NAME') ?: 'esports_tracker', (int)(getenv('DB_PORT') ?: 3307));
        $conn->set_charset('utf8mb4'); return $conn;
    } catch (Throwable $e) { error_log('Database unavailable'); fail(503, 'Database unavailable'); }
}
function identifier(string $name): string { return '`' . str_replace('`', '``', $name) . '`'; }
function metadata(mysqli $conn, string $table): array {
    $result = $conn->query('SHOW COLUMNS FROM ' . identifier(table_name($table)));
    $columns=[]; $keys=[];
    while ($row=$result->fetch_assoc()) { $columns[]=$row['Field']; if ($row['Key']==='PRI') $keys[]=$row['Field']; }
    return [$columns,$keys];
}
function show_rows(mysqli_result $result): void {
    echo '<table border="1"><tr>';
    foreach ($result->fetch_fields() as $f) echo '<th>'.h($f->name).'</th>';
    echo '</tr>';
    while ($row=$result->fetch_assoc()) { echo '<tr>'; foreach ($row as $v) echo '<td>'.h($v).'</td>'; echo '</tr>'; }
    echo '</table>';
}
