<?php
require 'config.php';

$kode = strtoupper(trim($_GET['kode'] ?? ''));
$barang = null;
if ($kode) {
    $s = $conn->prepare("SELECT b.*, k.nama AS nama_kategori FROM barang b JOIN kategori k ON b.kode_kategori = k.kode WHERE b.kode = ?");
    $s->bind_param("s", $kode);
    $s->execute();
    $barang = $s->get_result()->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kode       = strtoupper(trim($_POST['kode']));
    $jumlah     = intval($_POST['jumlah']);
    $keterangan = trim($_POST['keterangan']);

    $s = $conn->prepare("SELECT stok FROM barang WHERE kode = ?");
    $s->bind_param("s", $kode);
    $s->execute();
    $row = $s->get_result()->fetch_assoc();
    $stok_baru = $row['stok'] + $jumlah;

    $upd = $conn->prepare("UPDATE barang SET stok = ? WHERE kode = ?");
    $upd->bind_param("is", $stok_baru, $kode);
    $upd->execute();

    $ins = $conn->prepare("INSERT INTO riwayat_mutasi (kode_barang, tipe, jumlah, stok_akhir, keterangan) VALUES (?,?,?,?,?)");
    $tipe = 'MASUK';
    $ins->bind_param("ssiis", $kode, $tipe, $jumlah, $stok_baru, $keterangan);
    $ins->execute();

    header("Location: ../index.php?msg=Stok+berhasil+ditambahkan");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Barang Masuk</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="container">
    <h2>Barang Masuk (Tambah Stok)</h2>
    <?php if ($barang): ?>
    <div class="card" style="max-width:500px">
        <p style="margin-bottom:16px;color:#555">
            <strong><?= htmlspecialchars($barang['kode']) ?></strong> — <?= htmlspecialchars($barang['nama']) ?><br>
            Stok saat ini: <strong><?= $barang['stok'] ?> <?= htmlspecialchars($barang['satuan']) ?></strong>
        </p>
        <form method="POST">
            <input type="hidden" name="kode" value="<?= htmlspecialchars($barang['kode']) ?>">
            <div class="form-group">
                <label>Jumlah Masuk</label>
                <input type="number" name="jumlah" min="1" required>
            </div>
            <div class="form-group">
                <label>Keterangan</label>
                <input type="text" name="keterangan" placeholder="Opsional">
            </div>
            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="../index.php" class="btn btn-danger" style="margin-left:8px">Batal</a>
        </form>
    </div>
    <?php else: ?>
        <div class="alert alert-danger">Barang tidak ditemukan.</div>
        <a href="../index.php" class="btn btn-primary">Kembali</a>
    <?php endif; ?>
</div>
</body>
</html>
