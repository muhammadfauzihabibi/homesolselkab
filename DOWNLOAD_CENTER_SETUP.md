# Download Center - Setup Documentation

## ✅ Fitur Lengkap Download Center

### **Struktur Database**
- `kategori_unduhans` - Tabel kategori dokumen
- `jenis_unduhans` - Tabel jenis dokumen per kategori
- `unduhans` - Tabel dokumen unduhan (updated dengan kolom baru)

### **Kolom Baru di Tabel `unduhans`:**
- `kategori_unduhan_id` (Foreign Key)
- `jenis_unduhan_id` (Foreign Key)
- `judul` (String) - Judul dokumen
- `tahun` (Year) - Tahun dokumen
- `deskripsi` (Text) - Deskripsi lengkap
- `file` (String) - Path file atau URL
- `google_drive_url` (String) - URL Google Drive
- `jumlah_unduhan` (Integer) - Counter download
- `tanggal_publikasi` (Timestamp) - Tanggal publikasi
- `urutan` (Integer) - Urutan tampil

---

## 🚀 Routes yang Tersedia

### **Frontend (Public)**
```
GET /semua/unduhan               → frontend.unduhan.index
GET /unduh/{slug}                → frontend.unduhan.download
```

### **Admin Panel**
```
# Kelola Dokumen
GET    /unduhan                  → unduhan.index
GET    /unduhan/create           → unduhan.create
POST   /unduhan                  → unduhan.store
GET    /unduhan/{id}/edit        → unduhan.edit
PUT    /unduhan/{id}             → unduhan.update
DELETE /unduhan/{id}             → unduhan.destroy

# Kelola Kategori
GET    /admin/unduhan/kategori               → admin.unduhan.kategori.index
GET    /admin/unduhan/kategori/create        → admin.unduhan.kategori.create
POST   /admin/unduhan/kategori               → admin.unduhan.kategori.store
GET    /admin/unduhan/kategori/{id}/edit     → admin.unduhan.kategori.edit
PUT    /admin/unduhan/kategori/{id}          → admin.unduhan.kategori.update
DELETE /admin/unduhan/kategori/{id}          → admin.unduhan.kategori.destroy
POST   /admin/unduhan/kategori/update-urutan → admin.unduhan.kategori.update-urutan

# Kelola Jenis Dokumen
GET    /admin/unduhan/jenis               → admin.unduhan.jenis.index
GET    /admin/unduhan/jenis/create        → admin.unduhan.jenis.create
POST   /admin/unduhan/jenis               → admin.unduhan.jenis.store
GET    /admin/unduhan/jenis/{id}/edit     → admin.unduhan.jenis.edit
PUT    /admin/unduhan/jenis/{id}          → admin.unduhan.jenis.update
DELETE /admin/unduhan/jenis/{id}          → admin.unduhan.jenis.destroy
POST   /admin/unduhan/jenis/update-urutan → admin.unduhan.jenis.update-urutan

# AJAX API
GET /admin/unduhan/jenis/by-kategori?kategori_id={id} → admin.unduhan.jenis.by-kategori
```

---

## 📋 Data Seeder Default

### **6 Kategori Dokumen:**
1. **Anggaran** (icon: bi-cash-stack)
2. **Laporan** (icon: bi-file-earmark-text)
3. **Perencanaan** (icon: bi-diagram-3)
4. **Regulasi** (icon: bi-book)
5. **Statistik** (icon: bi-bar-chart-line)
6. **Publikasi** (icon: bi-newspaper)

### **24 Jenis Dokumen** (contoh):
- Anggaran: APBDes, LPJ, Realisasi
- Laporan: LKPJ, LPPD, Laporan Tahunan
- Perencanaan: RKPD, RPJMD, Renstrad
- Regulasi: Perda, Perbup, SK Bupati
- Statistik: Dalam Angka, Profil Daerah
- Publikasi: Buletin, Siaran Pers

---

## 🎯 Testing Checklist

### **1. Test Admin Panel**
```
✓ Akses /admin/unduhan/kategori
  - Create new kategori
  - Edit existing kategori
  - Delete kategori
  - Reorder kategori

✓ Akses /admin/unduhan/jenis
  - Create jenis (pilih kategori)
  - Edit jenis
  - Delete jenis
  - Filter by kategori

✓ Akses /unduhan
  - Create dokumen baru:
    * Pilih kategori → jenis load otomatis
    * Isi Google Drive URL (REQUIRED)
    * Isi metadata (tahun dan deskripsi)
  - Edit dokumen
  - Delete dokumen
  - Filter by kategori, jenis, tahun, status
  - Search dokumen
```

### **2. Test Frontend**
```
✓ Akses /semua/unduhan
  - Lihat kategori cards
  - Click kategori → filter otomatis
  - Gunakan filter dropdown:
    * Kategori → Jenis load dinamis
    * Tahun
    * Search
  - Pagination works
  - Empty state shows when no data

✓ Test Download
  - Click "Unduh Dokumen" button
  - Verify counter `jumlah_unduhan` increment
  - Verify redirect ke Google Drive
  - Verify direct download URL conversion
```

### **3. Test Google Drive URL Conversion**
```
Pattern 1: https://drive.google.com/file/d/FILE_ID/view
→ Converts to: https://drive.google.com/uc?export=download&id=FILE_ID

Pattern 2: https://drive.google.com/uc?export=download&id=FILE_ID
→ Already direct download (no conversion)

Pattern 3: https://drive.google.com/open?id=FILE_ID
→ Converts to: https://drive.google.com/uc?export=download&id=FILE_ID
```

---

## 🛠️ Commands

### **Run Seeder**
```bash
php artisan db:seed --class=KategoriJenisUnduhanSeeder
```

### **Clear Cache**
```bash
php artisan optimize:clear
# atau individual:
php artisan route:clear
php artisan view:clear
php artisan config:clear
php artisan cache:clear
```

### **Check Routes**
```bash
php artisan route:list --name=unduhan
php artisan route:list --name=admin.unduhan
```

---

## 🐛 Troubleshooting

### **Error: Column 'tanggal_publikasi' not found**
**Fixed:** Migration sudah dijalankan, scope Ordered() menggunakan `latest()`

### **Error: Relationship 'kategoriUnduhan' undefined**
**Fixed:** Alias method ditambahkan di models

### **Error: Cannot end section without starting one**
**Fixed:** Double `@endsection` sudah dihapus di view files

### **Error: Cannot end push stack**
**Fixed:** `@endpush` diganti dari `@endsection` di scripts section

---

## 📁 File Structure

```
app/
├── Http/Controllers/
│   ├── UnduhanController.php
│   ├── KategoriUnduhanController.php
│   └── JenisUnduhanController.php
├── Models/
│   ├── Unduhan.php
│   ├── KategoriUnduhan.php
│   └── JenisUnduhan.php

database/
├── migrations/
│   ├── 2026_09_08_014618_create_kategori_unduhans_table.php
│   ├── 2026_09_08_014624_create_jenis_unduhans_table.php
│   ├── 2026_09_08_014625_update_unduhans_table_for_new_structure.php
│   └── 2026_09_08_032648_add_missing_columns_to_unduhans_table.php
└── seeders/
    └── KategoriJenisUnduhanSeeder.php

resources/views/
├── admin/unduhan/
│   ├── index.blade.php
│   ├── create.blade.php
│   ├── edit.blade.php
│   ├── kategori/
│   │   ├── index.blade.php
│   │   ├── create.blade.php
│   │   └── edit.blade.php
│   └── jenis/
│       ├── index.blade.php
│       ├── create.blade.php
│       └── edit.blade.php
└── frontend/unduhan/
    └── index.blade.php
```

---

## ✅ Status: READY TO USE!

Semua fitur sudah lengkap dan siap digunakan. Silakan test melalui browser dengan mengakses URL di atas.

**Admin Panel Access:**
- Login sebagai admin
- Lihat sidebar → "Download Center" dropdown
- Kelola Kategori, Jenis, dan Dokumen

**Frontend Access:**
- Buka `/semua/unduhan` di browser
- Gunakan filter dan search
- Test download dokumen

---

*Last Updated: 2026-09-08*
