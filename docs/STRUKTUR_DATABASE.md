# 🗄️ Struktur Database - Luxe Wash

Dokumen ini menjelaskan struktur database yang digunakan dalam aplikasi **Luxe Wash**.

## 🔧 Tabel-Tabel Utama

### 1. users
- `id` (PK)
- `username`
- `password`
- `role_id` (admin/user)
- `created_at`

### 2. pelanggan
- `id` (PK)
- `nama`
- `telepon`
- `alamat`

### 3. layanan
- `id` (PK)
- `nama_layanan`
- `harga`
- `satuan`

### 4. transaksi
- `id` (PK)
- `user_id` (FK → users.id)
- `pelanggan_id` (FK → pelanggan.id)
- `tanggal_masuk`
- `tanggal_selesai`
- `status_transaksi_id` (FK)
- `total_harga`

### 5. transaction_items
- `id` (PK)
- `transaksi_id` (FK → transaksi.id)
- `layanan_id` (FK → layanan.id)
- `jumlah`
- `subtotal`

### 6. status_transaksi
- `id` (PK)
- `status` (ex: "Proses", "Selesai", "Diambil")

### 7. pembayaran
- `id` (PK)
- `transaksi_id` (FK)
- `total_dibayar`
- `metode_pembayaran` (Cash/Transfer)
- `tanggal_bayar`

---

## 📊 Relasi Antar Tabel

- Satu `user` dapat membuat banyak `transaksi`
- Satu `pelanggan` dapat memiliki banyak `transaksi`
- Satu `transaksi` memiliki banyak `transaction_items`
- Satu `transaction_item` terhubung ke satu `layanan`
- Satu `transaksi` memiliki satu `status_transaksi` dan satu `pembayaran`

## 📎 Diagram ERD

![ERD PROJEK UAS](https://github.com/user-attachments/assets/06057697-42f9-48bb-b88e-1588e3dfb4d6)

