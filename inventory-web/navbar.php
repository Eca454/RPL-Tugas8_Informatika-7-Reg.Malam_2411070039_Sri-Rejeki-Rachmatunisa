<nav>
    <a href="index.php" class="brand">📦 Inventory Gudang</a>
    <a href="index.php" <?= basename($_SERVER['PHP_SELF']) == 'index.php' ? 'class="active"' : '' ?>>Daftar Barang</a>
    <a href="tambah_barang.php" <?= basename($_SERVER['PHP_SELF']) == 'tambah_barang.php' ? 'class="active"' : '' ?>>Tambah Barang</a>
    <a href="laporan_menipis.php" <?= basename($_SERVER['PHP_SELF']) == 'laporan_menipis.php' ? 'class="active"' : '' ?>>Stok Menipis</a>
</nav>
