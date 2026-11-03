# Sistem Inventory Gudang

Tugas Individu RPL — Implementasi Coding Standard & Version Control

## Cara Menjalankan

```bash
cd sistem-inventory
python main.py
```

> Membutuhkan Python 3.10+

## Fitur

- Lihat daftar semua barang beserta status stok
- Tambah & hapus barang
- Catat barang masuk dan barang keluar
- Riwayat mutasi stok per barang
- Laporan stok menipis / habis secara otomatis

## Struktur File

| File | Keterangan |
|------|------------|
| `main.py` | Entry point dan UI menu terminal |
| `inventory.py` | Logika CRUD, mutasi stok, laporan |
| `models.py` | Model data `Barang` dan `Kategori` |

## Coding Standard yang Diterapkan

- Docstring pada setiap kelas dan fungsi
- Type hints pada parameter dan return value
- SRP: setiap modul satu tanggung jawab
- Penamaan deskriptif dalam Bahasa Indonesia
- Validasi input di setiap titik penerimaan data
- Konstanta untuk nilai threshold

## Git Commit

```bash
git init
git add models.py
git commit -m "feat: tambah model data Barang dan Kategori"

git add inventory.py
git commit -m "feat: tambah logika inventory, mutasi stok, dan laporan"

git add main.py README.md
git commit -m "feat: tambah UI terminal main.py dan dokumentasi README"
```
