<?php
$isRoot = basename(dirname($_SERVER['PHP_SELF'])) !== 'inventory-web';
$base   = $isRoot ? 'inventory-web/' : '';
$root   = $isRoot ? '' : '../';
?>
<nav>
    <a href="<?= $root ?>index.php" class="brand">📦 Inventory Gudang</a>
    <a href="<?= $root ?>index.php" <?= basename($_SERVER['PHP_SELF']) == 'index.php' ? 'class="active"' : '' ?>>Daftar Barang</a>
    <a href="<?= $base ?>tambah_barang.php" <?= basename($_SERVER['PHP_SELF']) == 'tambah_barang.php' ? 'class="active"' : '' ?>>Tambah Barang</a>
    <a href="<?= $base ?>laporan_menipis.php" <?= basename($_SERVER['PHP_SELF']) == 'laporan_menipis.php' ? 'class="active"' : '' ?>>Stok Menipis</a>
</nav>
