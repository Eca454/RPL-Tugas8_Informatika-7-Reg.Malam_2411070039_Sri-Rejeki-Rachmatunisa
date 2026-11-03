<?php
require 'inventory-web/config.php';

// Ambil semua barang beserta nama kategori
$sql = "SELECT b.*, k.nama AS nama_kategori
        FROM barang b
        JOIN kategori k ON b.kode_kategori = k.kode
        ORDER BY b.kode_kategori, b.kode";
$result = $conn->query($sql);

// Statistik
$total     = $conn->query("SELECT COUNT(*) AS n FROM barang")->fetch_assoc()['n'];
$menipis   = $conn->query("SELECT COUNT(*) AS n FROM barang WHERE stok <= stok_minimum AND stok > 0")->fetch_assoc()['n'];
$habis     = $conn->query("SELECT COUNT(*) AS n FROM barang WHERE stok = 0")->fetch_assoc()['n'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Inventory Gudang</title>
    <link rel="stylesheet" href="inventory-web/style.css">
</head>
<body>
<?php include 'inventory-web/navbar.php'; ?>
<div class="container">
    <h2>Daftar Barang</h2>

    <?php if (isset($_GET['msg'])): ?>
        <div class="alert alert-success"><?= htmlspecialchars($_GET['msg']) ?></div>
    <?php endif; ?>
    <?php if (isset($_GET['err'])): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($_GET['err']) ?></div>
    <?php endif; ?>

    <!-- Statistik -->
    <div class="stats">
        <div class="stat-card">
            <div class="number"><?= $total ?></div>
            <div class="label">Total Jenis Barang</div>
        </div>
        <div class="stat-card">
            <div class="number" style="color:#28a745"><?= $total - $menipis - $habis ?></div>
            <div class="label">Stok Aman</div>
        </div>
        <div class="stat-card">
            <div class="number" style="color:#ffc107"><?= $menipis ?></div>
            <div class="label">Stok Menipis</div>
        </div>
        <div class="stat-card">
            <div class="number" style="color:#dc3545"><?= $habis ?></div>
            <div class="label">Stok Habis</div>
        </div>
    </div>

    <div class="card">
        <div style="display:flex;justify-content:flex-end;margin-bottom:14px">
            <a href="inventory-web/tambah_barang.php" class="btn btn-primary">+ Tambah Barang</a>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Nama Barang</th>
                    <th>Kategori</th>
                    <th>Stok</th>
                    <th>Satuan</th>
                    <th>Harga Beli</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php while ($b = $result->fetch_assoc()):
                if ($b['stok'] == 0) {
                    $status = 'HABIS'; $badge = 'badge-habis';
                } elseif ($b['stok'] <= $b['stok_minimum']) {
                    $status = 'MENIPIS'; $badge = 'badge-menipis';
                } else {
                    $status = 'AMAN'; $badge = 'badge-aman';
                }
            ?>
                <tr>
                    <td><?= htmlspecialchars($b['kode']) ?></td>
                    <td><?= htmlspecialchars($b['nama']) ?></td>
                    <td><?= htmlspecialchars($b['nama_kategori']) ?></td>
                    <td><?= $b['stok'] ?></td>
                    <td><?= htmlspecialchars($b['satuan']) ?></td>
                    <td>Rp <?= number_format($b['harga_beli'], 0, ',', '.') ?></td>
                    <td><span class="badge <?= $badge ?>"><?= $status ?></span></td>
                    <td>
                        <a href="inventory-web/barang_masuk.php?kode=<?= $b['kode'] ?>" class="btn btn-success btn-sm">Masuk</a>
                        <a href="inventory-web/barang_keluar.php?kode=<?= $b['kode'] ?>" class="btn btn-warning btn-sm">Keluar</a>
                        <a href="inventory-web/riwayat.php?kode=<?= $b['kode'] ?>" class="btn btn-primary btn-sm">Riwayat</a>
                        <a href="inventory-web/hapus_barang.php?kode=<?= $b['kode'] ?>"
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('Hapus barang <?= htmlspecialchars($b['nama'], ENT_QUOTES) ?>?')">Hapus</a>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
