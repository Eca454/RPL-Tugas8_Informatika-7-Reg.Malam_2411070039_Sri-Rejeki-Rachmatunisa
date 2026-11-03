<?php
require 'config.php';

$result = $conn->query("
    SELECT b.*, k.nama AS nama_kategori
    FROM barang b
    JOIN kategori k ON b.kode_kategori = k.kode
    WHERE b.stok <= b.stok_minimum
    ORDER BY b.stok ASC
");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Stok Menipis</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="container">
    <h2>Peringatan: Stok Menipis / Habis</h2>
    <div class="card">
        <?php if ($result->num_rows === 0): ?>
            <p style="color:#155724;font-weight:600">✓ Semua barang dalam kondisi stok aman.</p>
        <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Nama Barang</th>
                    <th>Kategori</th>
                    <th>Stok</th>
                    <th>Minimum</th>
                    <th>Satuan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php while ($b = $result->fetch_assoc()):
                $status = $b['stok'] == 0 ? 'HABIS' : 'MENIPIS';
                $badge  = $b['stok'] == 0 ? 'badge-habis' : 'badge-menipis';
            ?>
                <tr>
                    <td><?= htmlspecialchars($b['kode']) ?></td>
                    <td><?= htmlspecialchars($b['nama']) ?></td>
                    <td><?= htmlspecialchars($b['nama_kategori']) ?></td>
                    <td><?= $b['stok'] ?></td>
                    <td><?= $b['stok_minimum'] ?></td>
                    <td><?= htmlspecialchars($b['satuan']) ?></td>
                    <td><span class="badge <?= $badge ?>"><?= $status ?></span></td>
                    <td>
                        <a href="barang_masuk.php?kode=<?= $b['kode'] ?>" class="btn btn-success btn-sm">+ Stok</a>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
