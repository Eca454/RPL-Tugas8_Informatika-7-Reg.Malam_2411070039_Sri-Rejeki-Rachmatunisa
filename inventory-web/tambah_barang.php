<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kode      = strtoupper(trim($_POST['kode']));
    $nama      = trim($_POST['nama']);
    $kat       = trim($_POST['kode_kategori']);
    $satuan    = trim($_POST['satuan']);
    $harga     = floatval($_POST['harga_beli']);
    $min_stok  = intval($_POST['stok_minimum']);

    $cek = $conn->prepare("SELECT kode FROM barang WHERE kode = ?");
    $cek->bind_param("s", $kode);
    $cek->execute();
    if ($cek->get_result()->num_rows > 0) {
        header("Location: tambah_barang.php?err=Kode+$kode+sudah+digunakan");
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO barang (kode, nama, kode_kategori, satuan, stok, harga_beli, stok_minimum) VALUES (?,?,?,?,0,?,?)");
    $stmt->bind_param("ssssdi", $kode, $nama, $kat, $satuan, $harga, $min_stok);
    $stmt->execute();
    header("Location: ../index.php?msg=Barang+$nama+berhasil+ditambahkan");
    exit;
}

$kategori = $conn->query("SELECT * FROM kategori");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Barang</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="container">
    <h2>Tambah Barang Baru</h2>

    <?php if (isset($_GET['err'])): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($_GET['err']) ?></div>
    <?php endif; ?>

    <div class="card" style="max-width:500px">
        <form method="POST">
            <div class="form-group">
                <label>Kode Barang</label>
                <input type="text" name="kode" required placeholder="Contoh: B009">
            </div>
            <div class="form-group">
                <label>Nama Barang</label>
                <input type="text" name="nama" required>
            </div>
            <div class="form-group">
                <label>Kategori</label>
                <select name="kode_kategori" required>
                    <option value="">-- Pilih Kategori --</option>
                    <?php while ($k = $kategori->fetch_assoc()): ?>
                        <option value="<?= $k['kode'] ?>"><?= htmlspecialchars($k['nama']) ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Satuan</label>
                <input type="text" name="satuan" required placeholder="unit / pcs / lusin / ...">
            </div>
            <div class="form-group">
                <label>Harga Beli (Rp)</label>
                <input type="number" name="harga_beli" min="0" required>
            </div>
            <div class="form-group">
                <label>Stok Minimum</label>
                <input type="number" name="stok_minimum" min="0" value="5" required>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="../index.php" class="btn btn-danger" style="margin-left:8px">Batal</a>
        </form>
    </div>
</div>
</body>
</html>
