-- ============================================
-- Sistem Inventory Gudang - Database Setup
-- ============================================

CREATE DATABASE IF NOT EXISTS inventory_gudang CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE inventory_gudang;

-- Tabel Kategori
CREATE TABLE IF NOT EXISTS kategori (
    kode VARCHAR(10) PRIMARY KEY,
    nama VARCHAR(100) NOT NULL
);

-- Tabel Barang
CREATE TABLE IF NOT EXISTS barang (
    kode VARCHAR(10) PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    kode_kategori VARCHAR(10) NOT NULL,
    satuan VARCHAR(20) NOT NULL,
    stok INT DEFAULT 0,
    harga_beli DECIMAL(15,2) DEFAULT 0,
    stok_minimum INT DEFAULT 5,
    FOREIGN KEY (kode_kategori) REFERENCES kategori(kode)
);

-- Tabel Riwayat Mutasi
CREATE TABLE IF NOT EXISTS riwayat_mutasi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kode_barang VARCHAR(10) NOT NULL,
    tipe ENUM('MASUK','KELUAR') NOT NULL,
    jumlah INT NOT NULL,
    stok_akhir INT NOT NULL,
    keterangan VARCHAR(255),
    waktu DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (kode_barang) REFERENCES barang(kode)
);

-- Data Awal Kategori
INSERT INTO kategori VALUES
('ELK', 'Elektronik'),
('ATK', 'Alat Tulis Kantor'),
('KBR', 'Kebutuhan Rumah Tangga');

-- Data Awal Barang
INSERT INTO barang VALUES
('B001', 'Laptop ASUS VivoBook', 'ELK', 'unit',  10, 7500000, 2),
('B002', 'Mouse Wireless',       'ELK', 'unit',  25,  150000, 5),
('B003', 'Keyboard Mechanical',  'ELK', 'unit',  15,  350000, 3),
('B004', 'Pulpen Ballpoint',     'ATK', 'lusin', 30,   12000, 5),
('B005', 'Buku Tulis A5',        'ATK', 'rim',   20,   45000, 5),
('B006', 'Stabilo Warna',        'ATK', 'set',    8,   25000, 3),
('B007', 'Sabun Cuci Piring',    'KBR', 'botol', 40,   18000, 10),
('B008', 'Tisu Gulung',          'KBR', 'pack',   3,   22000, 5);
