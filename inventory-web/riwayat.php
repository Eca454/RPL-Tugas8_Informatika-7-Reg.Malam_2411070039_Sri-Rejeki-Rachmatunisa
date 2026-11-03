<?php
require 'config.php';

$kode = strtoupper(trim($_GET['kode'] ?? ''));
$barang = null;
$riwayat = [];

if ($kode) {
    $s = $conn->prepare("SELECT * FROM barang WHERE kode = ?");
    $s->bind_param("s", $kode);
    $s->execute();
    $barang = $s->get_result()->fetch_assoc();

    if ($barang) {
        $r = $conn->prepare("SELECT * FROM riwayat_mutasi WHERE kode_barang = ? ORDER BY waktu DESC");
        $r->bind_param("s", $kode);
        $r->execute();
        $riwayat = $r->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Riwayat Mutasi</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="container">
    <?php if ($barang): ?>
        <h2>Riwayat Mutasi: [<?= htmlspecialchars($barang['kode']) ?>] <?= htmlspecialchars($barang['nama']) ?></h2>
        <div class="card">
            <?php if (empty($riwayat)): ?>
                <p style="color:#888">Belum ada riwayat mutasi.</p>
            <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Waktu</th>
                        <th>Tipe</th>
                        <th>Jumlah</th>
                        <th>Stok Akhir</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($riwayat as $r): ?>
                    <tr>
                        <td><?= $r['waktu'] ?></td>
                        <td>
                            <span class="badge <?= $r['tipe'] === 'MASUK' ? 'badge-aman' : 'badge-menipis' ?>">
                                <?= $r['tipe'] ?>
                            </span>
                        </td>
                        <td><?= $r['jumlah'] ?></td>
                        <td><?= $r['stok_akhir'] ?></td>
                        <td><?= htmlspecialchars($r['keterangan']) ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <?php endif; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-danger">Barang tidak ditemukan.</div>
    <?php endif; ?>
    <a href="../index.php" class="btn btn-primary">← Kembali</a>
</div>
</body>
</html>
