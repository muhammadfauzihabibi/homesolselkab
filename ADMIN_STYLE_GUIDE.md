# Admin Panel Style Guide - Pemda Solok Selatan

## 🎨 Design System Overview

Sistem admin menggunakan **Soft Organic & Lime Pastel Theme** dengan dukungan dark mode penuh melalui Bootstrap 5.3 dan CSS Variables.

---

## 📐 Standardisasi yang Sudah Diterapkan

### ✅ CSS Global Standardization (Otomatis)

Semua standardisasi berikut sudah diterapkan secara **global di CSS** (`public/css/dashboard-bootstrap5.css`), sehingga **TIDAK PERLU** mengubah setiap view file satu per satu.

#### 1. **Border Radius - 16px Standard**

```css
/* Otomatis diterapkan ke semua form controls */
.form-control,
.form-select {
  border-radius: 16px !important;
}

textarea.form-control {
  border-radius: 16px !important;
}
```

**Impact:** Semua input, select, dan textarea di admin panel otomatis menggunakan 16px border-radius.

#### 2. **Form Control Styling**

```css
.form-control,
.form-select {
  background-color: var(--card-sub-bg) !important;
  color: var(--text-dark) !important;
  border: none !important;
  padding: 0.625rem 0.75rem; /* py-2.5 px-3 equivalent */
}
```

**Impact:** Semua form controls punya styling konsisten dengan background adaptif (light/dark mode).

#### 3. **Input Group Consistency**

```css
.input-group .form-control:first-child {
  border-top-left-radius: 16px !important;
  border-bottom-left-radius: 16px !important;
}

.input-group .input-group-text {
  background-color: var(--card-sub-bg) !important;
  border: none !important;
}
```

**Impact:** Input groups dengan icon otomatis konsisten.

#### 4. **Button Styling**

```css
.btn {
  border-radius: var(--radius-pill) !important; /* 999px */
  font-weight: 600;
}

.btn-dark-pill {
  background-color: var(--btn-dark) !important;
  color: var(--bg-main) !important;
}

.btn-glass-pill {
  background: var(--btn-icon-bg);
  color: var(--text-dark);
}

.btn-glass-icon {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  background: var(--btn-icon-bg);
}
```

**Impact:** Semua button otomatis punya styling konsisten.

---

## 🎨 CSS Variables (Theme System)

### Light Mode
```css
--bg-main: #f3f4f0;           /* Background utama */
--card-bg: #ffffff;           /* Card background */
--card-sub-bg: #f8faf9;       /* Input/sub-card background */
--card-sub-hover: #f1f5f3;    /* Hover state */
--text-dark: #09090b;         /* Text utama */
--text-muted: #71717a;        /* Text secondary */
--btn-dark: #18181b;          /* Primary button */
--radius-xl: 28px;            /* Card radius */
--radius-pill: 999px;         /* Button radius */
```

### Dark Mode
```css
--bg-main: #0f172a;           /* Dark background */
--card-bg: #1e293b;           /* Dark card */
--card-sub-bg: #334155;       /* Dark input */
--text-dark: #f8fafc;         /* Light text */
--btn-dark: #f8fafc;          /* White button */
```

---

## 📝 Pattern untuk Form Views

### Standard Form Layout (Sudah Otomatis Styled oleh CSS)

```blade
@extends('layouts.admin')

@section('title', 'Tambah Data')

@section('content')
  <!-- Header -->
  <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
    <div>
      <h1 class="fw-bold text-main mb-1" style="font-size:1.5rem;">Judul Halaman</h1>
      <p class="text-muted-custom mb-0 fs-7">Subtitle atau deskripsi</p>
    </div>
  </div>

  <!-- Form Card -->
  <div class="glass-card p-4 shadow-sm w-100">
    <form action="{{ route('module.store') }}" method="POST" enctype="multipart/form-data">
      @csrf

      <!-- Input Text (Otomatis 16px border-radius) -->
      <div class="mb-4">
        <label for="nama" class="form-label fw-bold text-main">
          Nama <span class="text-danger">*</span>
        </label>
        <input type="text" 
               name="nama" 
               id="nama" 
               class="form-control @error('nama') is-invalid @enderror"
               placeholder="Masukkan nama" 
               value="{{ old('nama') }}" 
               required>
        @error('nama')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <!-- Select (Otomatis 16px border-radius) -->
      <div class="mb-4">
        <label for="kategori" class="form-label fw-bold text-main">
          Kategori <span class="text-danger">*</span>
        </label>
        <select name="kategori" id="kategori" class="form-select @error('kategori') is-invalid @enderror" required>
          <option value="">-- Pilih --</option>
          <option value="A">Kategori A</option>
        </select>
        @error('kategori')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <!-- Textarea (Otomatis 16px border-radius) -->
      <div class="mb-4">
        <label for="deskripsi" class="form-label fw-bold text-main">Deskripsi</label>
        <textarea name="deskripsi" 
                  id="deskripsi" 
                  rows="4" 
                  class="form-control @error('deskripsi') is-invalid @enderror"
                  placeholder="Deskripsi...">{{ old('deskripsi') }}</textarea>
        @error('deskripsi')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <!-- File Upload -->
      <div class="mb-4">
        <label for="image" class="form-label fw-bold text-main">Upload Gambar</label>
        <input type="file" 
               name="image" 
               id="image" 
               class="form-control @error('image') is-invalid @enderror"
               accept="image/*">
        <small class="text-muted-custom mt-1 d-block fs-8">Format: JPG, PNG. Max 2MB.</small>
        @error('image')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <!-- Toggle Switch -->
      <div class="mb-4">
        <div class="p-3 rounded-4" style="background: var(--card-sub-bg);">
          <div class="form-check form-switch d-flex align-items-center gap-2 ps-0">
            <input class="form-check-input ms-0" 
                   type="checkbox" 
                   name="aktif" 
                   value="1" 
                   id="aktif" 
                   style="width: 2.8em; height: 1.5em;" 
                   {{ old('aktif', true) ? 'checked' : '' }}>
            <label class="form-check-label fw-bold text-main fs-7 ms-2" for="aktif">
              Status Aktif
            </label>
          </div>
          <small class="text-muted-custom d-block ms-5 mt-1 fs-8">
            Deskripsi toggle ini
          </small>
        </div>
      </div>

      <!-- Action Buttons -->
      <div class="d-flex flex-wrap gap-2 justify-content-end pt-3" 
           style="border-top: 1px solid var(--card-sub-bg);">
        <a href="{{ route('module.index') }}" 
           class="btn btn-glass-pill px-4 py-2 fs-7 d-flex align-items-center gap-2">
          <i class="bi bi-arrow-left"></i> Kembali
        </a>
        <button type="submit" class="btn btn-dark-pill px-4 py-2 fs-7">
          <i class="bi bi-check-lg me-1"></i>Simpan
        </button>
      </div>

    </form>
  </div>
@endsection
```

### Standard Index/List View

```blade
@extends('layouts.admin')

@section('title', 'Manajemen Data')

@section('content')
  <!-- Header -->
  <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
    <div>
      <h1 class="fw-bold text-main mb-1" style="font-size:1.5rem;">Manajemen Data</h1>
      <p class="text-muted-custom mb-0 fs-7">Kelola data module</p>
    </div>
    <div>
      <a href="{{ route('module.create') }}" class="btn btn-dark-pill d-flex align-items-center gap-2">
        <i class="bi bi-plus-lg"></i> Tambah Baru
      </a>
    </div>
  </div>

  <!-- Filter & Search (Otomatis styled) -->
  <div class="glass-card p-3 mb-4 shadow-sm">
    <form action="{{ route('module.index') }}" method="GET" class="row g-3 align-items-center">
      <div class="col-md-6">
        <input type="text" name="search" class="form-control" placeholder="Cari..." value="{{ request('search') }}">
      </div>
      <div class="col-md-2">
        <button type="submit" class="btn btn-dark-pill w-100 py-2 fs-7">Filter</button>
      </div>
    </form>
  </div>

  <!-- Data Table -->
  <div class="glass-card p-3 shadow-sm">
    <div class="table-responsive">
      <table class="table align-middle border-0 mb-0 glass-table">
        <thead>
          <tr class="text-muted-custom fs-8 text-uppercase">
            <th class="border-0">#</th>
            <th class="border-0">Nama</th>
            <th class="border-0 text-center">Status</th>
            <th class="border-0 text-end">Aksi</th>
          </tr>
        </thead>
        <tbody class="fs-7 fw-semibold text-main">
          @forelse($items as $index => $item)
            <tr>
              <td>{{ $items->firstItem() + $index }}</td>
              <td>{{ $item->nama }}</td>
              <td class="text-center">
                @if($item->aktif)
                  <span class="badge bg-success-subtle text-success-emphasis">Aktif</span>
                @else
                  <span class="badge bg-danger-subtle text-danger-emphasis">Nonaktif</span>
                @endif
              </td>
              <td class="text-end">
                <div class="d-flex justify-content-end gap-2">
                  <a href="{{ route('module.edit', $item) }}" 
                     class="btn btn-glass-icon d-flex align-items-center justify-content-center">
                    <i class="bi bi-pencil-square text-primary"></i>
                  </a>
                  <form action="{{ route('module.destroy', $item) }}" method="POST" class="delete-form">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-glass-icon">
                      <i class="bi bi-trash text-danger"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="4" class="text-center py-5 text-muted-custom">
                <i class="bi bi-inbox fs-1 d-block mb-2 opacity-50"></i>
                Belum ada data
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    @if($items->hasPages())
      <div class="d-flex justify-content-between align-items-center pt-3 mt-3" 
           style="border-top: 1px solid var(--card-sub-bg);">
        <small class="text-muted-custom">
          Menampilkan {{ $items->firstItem() }} - {{ $items->lastItem() }} dari {{ $items->total() }}
        </small>
        <div>{{ $items->links('pagination::bootstrap-5') }}</div>
      </div>
    @endif
  </div>
@endsection
```

---

## 🎯 Utility Classes

### Typography
```
.text-main          - Main text color (adaptive)
.text-muted-custom  - Muted/secondary text
.fw-bold            - Font weight 700
.fw-semibold        - Font weight 600
.fs-7               - Font size 0.875rem
.fs-8               - Font size 0.75rem
```

### Buttons
```
.btn-dark-pill      - Primary action button (dark/white adaptive)
.btn-glass-pill     - Secondary glass button
.btn-glass-icon     - Circular icon button (40x40px)
```

### Cards
```
.glass-card         - Main card container (28px radius, shadow)
.glass-table        - Table with glass styling
```

### Badges
```
.glass-badge        - Badge with pill shape
```

---

## ✅ Checklist: Apakah View Sudah Sesuai Standard?

Untuk memastikan view Anda mengikuti standardisasi:

### Form Views:
- [ ] Menggunakan `class="form-control"` untuk input (BUKAN inline style border-radius)
- [ ] Menggunakan `class="form-select"` untuk select
- [ ] Label menggunakan `class="form-label fw-bold text-main"`
- [ ] Required field ada `<span class="text-danger">*</span>`
- [ ] Error validation: `@error` dengan `invalid-feedback`
- [ ] Helper text: `<small class="text-muted-custom fs-8">`
- [ ] Button footer: `d-flex justify-content-end gap-2` dengan `btn-glass-pill` dan `btn-dark-pill`

### Index Views:
- [ ] Header dengan title (h1 1.5rem) dan subtitle (fs-7)
- [ ] Filter dalam `glass-card p-3 mb-4`
- [ ] Table menggunakan `class="glass-table"`
- [ ] Pagination ada info "Menampilkan X - Y dari Z"
- [ ] Empty state dengan icon dan message

---

## 🚀 Yang TIDAK PERLU Diubah

Karena CSS sudah global, **TIDAK PERLU**:
1. ❌ Menambah inline style `border-radius: 16px` ke setiap input
2. ❌ Menambah inline style `background: var(--card-sub-bg)` ke setiap input
3. ❌ Mengubah views yang sudah ada jika sudah menggunakan class standar Bootstrap
4. ❌ Membuat Blade components untuk form elements

**Cukup pastikan menggunakan class standard:**
- `form-control` untuk input
- `form-select` untuk select
- `form-check-input` untuk checkbox/radio
- `btn btn-dark-pill` untuk primary button
- `btn btn-glass-pill` untuk secondary button

CSS akan **otomatis** handle styling!

---

## 📱 Responsive Behavior

CSS sudah include responsive adjustments:
- Mobile (< 768px): Font size lebih kecil, padding compact
- Desktop: Full padding dan font size normal

---

## 🌓 Dark Mode Support

Semua styling otomatis adapt dengan dark mode melalui CSS variables:
```css
[data-bs-theme="dark"] .form-control {
  background-color: #334155 !important;
  color: #f8fafc !important;
}
```

Toggle dark mode: Tombol di sidebar (sudah built-in di layout).

---

## 📊 Status Standardisasi

| Aspek | Status | Catatan |
|-------|--------|---------|
| Border Radius | ✅ Global | 16px untuk form, 28px untuk card |
| Padding Input | ✅ Global | py-2.5 px-3 otomatis |
| Form Colors | ✅ Global | var(--card-sub-bg) otomatis |
| Button Styling | ✅ Global | Pill shape otomatis |
| Table Styling | ✅ Global | Glass effect otomatis |
| Pagination | ✅ Global | Styled otomatis |
| Dark Mode | ✅ Global | Adaptive otomatis |

---

## 🔧 Troubleshooting

### Q: Input saya masih kotak (bukan rounded)?
**A:** Pastikan menggunakan class `form-control`, bukan custom class lain.

### Q: Warna input tidak sesuai theme?
**A:** Clear browser cache: `Ctrl+F5` atau `php artisan view:clear`

### Q: Dark mode tidak bekerja?
**A:** Pastikan `data-bs-theme` attribute ada di `<html>` tag (sudah built-in di layout).

---

## 📝 Kesimpulan

**Standardisasi sudah SELESAI melalui CSS global!**

Yang perlu dilakukan developer:
1. ✅ Gunakan class standard Bootstrap (`form-control`, `form-select`, dll)
2. ✅ Ikuti pattern HTML yang ada di guide ini
3. ✅ CSS akan otomatis handle styling consistency

**TIDAK PERLU:**
- ❌ Blade components kompleks
- ❌ Inline styles manual
- ❌ Mengubah setiap view file

---

*Last Updated: 2026-09-08*  
*Version: 2.0 - CSS Global Approach*
