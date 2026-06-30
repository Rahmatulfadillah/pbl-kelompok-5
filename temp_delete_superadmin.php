<?php
$env = file('.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$cfg = [];
foreach ($env as $line) {
    if (strpos(trim($line), '#') === 0) {
        continue;
    }
    if (strpos($line, '=') !== false) {
        [$k, $v] = array_map('trim', explode('=', $line, 2));
        $cfg[$k] = $v;
    }
}

$host = $cfg['database.default.hostname'] ?? 'localhost';
$dbname = $cfg['database.default.database'] ?? 'pbl_mapping';
$user = $cfg['database.default.username'] ?? 'root';
$pass = $cfg['database.default.password'] ?? '';
$port = $cfg['database.default.port'] ?? 3306;

$mysqli = new mysqli($host, $user, $pass, $dbname, (int) $port);
if ($mysqli->connect_error) {
    fwrite(STDERR, "Connection failed: {$mysqli->connect_error}\n");
    exit(1);
}

$result = $mysqli->query('SELECT id, username, email, role, nama_lengkap FROM users WHERE role = "admin_super" ORDER BY id ASC');
$rows = $result->fetch_all(MYSQLI_ASSOC);
if (!$rows) {
    echo "No superadmin accounts found.\n";
    exit(0);
}

foreach ($rows as $row) {
    echo $row['id'] . ' | ' . $row['username'] . ' | ' . $row['email'] . ' | ' . $row['nama_lengkap'] . PHP_EOL;
}

$target = $rows[0]['username'] ?? null;
if (!$target) {
    echo "No target account found.\n";
    exit(0);
}

$delete = $mysqli->prepare('DELETE FROM users WHERE username = ? AND role = "admin_super" LIMIT 1');
$delete->bind_param('s', $target);
$delete->execute();

if ($delete->affected_rows > 0) {
    echo "Deleted superadmin: {$target}\n";
} else {
    echo "Delete failed for: {$target}\n";
}
