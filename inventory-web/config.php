<?php
$host   = 'localhost';
$db     = 'inventory_gudang';
$user   = 'root';
$pass   = '';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die('Koneksi gagal: ' . $conn->connect_error);
}
$conn->set_charset('utf8mb4');
