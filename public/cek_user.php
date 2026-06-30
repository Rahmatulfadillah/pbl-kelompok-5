<?php
// Akses: http://localhost:8080/cek_user.php

$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'pbl_mapping';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

echo "<h2>Data User di Database</h2>";

$result = $conn->query("SELECT id, username, password, nama_lengkap, role, is_active FROM users");

echo "<table border='1' cellpadding='8' style='border-collapse: collapse;'>";
echo "<tr bgcolor='#ddd'><th>ID</th><th>Username</th><th>Password</th><th>Nama Lengkap</th><th>Role</th><th>Active</th></tr>";

while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>{$row['id']}</td>";
    echo "<td><strong>{$row['username']}</strong></td>";
    echo "<td><code>{$row['password']}</code></td>";
    echo "<td>{$row['nama_lengkap']}</td>";
    echo "<td>{$row['role']}</td>";
    echo "<td>" . ($row['is_active'] ? '✅' : '❌') . "</td>";
    echo "</tr>";
}
echo "</table>";

$conn->close();
?>

<hr>
<h3>Test Login Manual:</h3>
<form method="POST" action="/auth/doLogin" style="margin-top: 10px;">
    <label>Username:</label><br>
    <input type="text" name="username" value="admin" style="padding: 5px; width: 200px;"><br><br>
    <label>Password:</label><br>
    <input type="password" name="password" value="admin123" style="padding: 5px; width: 200px;"><br><br>
    <button type="submit" style="padding: 8px 20px; background: blue; color: white; border: none; border-radius: 5px;">Login</button>
</form>

<p><br><a href="/auth/login">Klik disini untuk ke halaman login →</a></p>