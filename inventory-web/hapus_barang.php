<?php
require 'config.php';

$kode = strtoupper(trim($_GET['kode'] ?? ''));
if (!$kode) {
    header("Location: index.php");
    exit;
}

$stmt = $conn->prepare("DELETE FROM barang WHERE kode = ?");
$stmt->bind_param("s", $kode);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    header("Location: index.php?msg=Barang+berhasil+dihapus");
} else {
    header("Location: index.php?err=Barang+tidak+ditemukan");
}
exit;
