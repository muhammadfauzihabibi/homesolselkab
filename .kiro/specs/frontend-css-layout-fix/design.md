# Frontend CSS Layout Fix - Bugfix Design

## Overview

Halaman-halaman frontend portal PemdaSolsel mengalami kerusakan tata letak (layout breakage) yang disebabkan oleh kombinasi negative margin yang tidak dikompensasi, kurangnya overflow containment pada konten embed, dan inkonsistensi penanganan responsive grid. Bug ini berdampak pada tiga halaman utama: Sarana & Prasarana, Detail Berita, dan Halaman Statis (page).

Strategi perbaikan bersifat minimal dan bertarget: memperbaiki CSS di `front.css` dan menyesuaikan markup Blade secukupnya agar layout kembali konsisten di semua ukuran layar, tanpa mengubah logika backend atau struktur data.

---

## Glossary

- **Bug_Condition (C)**: Kondisi yang memicu kerusakan tampilan — ketika elemen dengan negative margin atau konten embed dirender tanpa containment yang sesuai di konteks layout Bootstrap grid
- **Property (P)**: Perilaku yang diinginkan — setiap kartu, sidebar, dan konten body harus berada dalam batas container-nya di semua breakpoint layar
- **Preservation**: Perilaku yang ada sebelumnya dan tidak boleh berubah: fungsionalitas navigasi, animasi hover kartu, dark mode, hero banner slider, pagination, dan filter/search
- **`.page-floating-card`**: Kelas di `public/css/front.css` yang menggunakan `margin-top: -80px` untuk efek "menumpuk di atas hero" — penyebab utama overflow dan whitespace berlebihan
- **Sidebar col-lg-4**: Kolom sidebar pada `berita/detail.blade.php` yang menggunakan `margin-top: -60px; position: relative; z-index: 10` yang menyebabkan overlap tidak rapi dengan konten utama
- **`.page-detail-body`**: Kelas untuk render konten CKEditor/Tiptap — tidak memiliki `overflow: hidden` atau `max-width: 100%` sehingga iframe/video meluap
- **Bootstrap Grid overflow**: Grid 3-kolom pada `sarana_prasarana/index.blade.php` yang terpotong di sisi kanan karena container induknya tidak memiliki `overflow: hidden` yang tepat

---

## Bug Details

### Bug Condition

Bug tata letak terjadi ketika halaman frontend dirender di browser dengan salah satu dari kondisi berikut:

1. Elemen `.page-floating-card` dirender dengan `margin-top: -80px` tanpa padding atas yang dikompensasi pada container-nya, sehingga konten terpotong atau ada whitespace berlebihan tergantung konten
2. Sidebar pada halaman detail berita menggunakan negative margin (`margin-top: -60px`) dengan `position: relative` di dalam Bootstrap row, yang menyebabkan sidebar overlap atau melayang di luar batas layout
3. Konten dari CKEditor/Tiptap (terutama iframe video YouTube) dirender di dalam `.page-detail-body` tanpa `overflow: hidden` pada wrapper-nya
4. Grid kartu Sarana & Prasarana dengan `col-md-6 col-lg-4` dirender di dalam container dengan `margin-top: -50px; position: relative` yang tidak memiliki `overflow: hidden`

**Formal Specification:**
```
FUNCTION isBugCondition(pageContext)
  INPUT: pageContext = { pageName, viewportWidth, hasEmbedContent }
  OUTPUT: boolean

  IF pageName IN ['sarana_prasarana.index', 'berita.detail', 'page.show']
    AND (
      hasNegativeMarginWithoutCompensation(pageContext) OR
      hasIframeWithoutOverflowContainment(pageContext) OR
      hasSidebarWithNegativeMarginInFlexRow(pageContext)
    )
  RETURN true
  
  RETURN false
END FUNCTION
```

### Examples

- **Sarana & Prasarana — Desktop (≥992px)**: Grid 3 kolom (`col-lg-4`) dirender dalam container `margin-top: -50px; z-index: 10`. Kartu ketiga terpotong di kanan karena parent tidak memiliki `overflow: hidden` → **Bug aktif**
- **Detail Berita — Desktop (≥992px)**: Sidebar `col-lg-4` dengan `margin-top: -60px` mengambang keluar dari Bootstrap row, overlap dengan elemen di bawahnya → **Bug aktif**
- **Halaman Statis dengan video YouTube**: `<iframe>` dari CKEditor dirender di dalam `.page-detail-body` tanpa `max-width: 100%` → iframe meluap melewati card boundary → **Bug aktif**
- **Semua halaman — Mobile (<768px)**: Sidebar dan kartu tidak memiliki responsive breakpoint untuk negative margin, menyebabkan tata letak hancur pada HP → **Bug aktif**
- **Sarana & Prasarana tanpa filter aktif, grid 2 kolom (≤768px)**: Kartu dengan `col-md-6` merender dengan baik → **Bug tidak aktif** (preservasi)

---

## Expected Behavior

### Preservation Requirements

**Perilaku yang tidak boleh berubah setelah perbaikan:**
- Animasi hover pada `.card-jds-hover` (translateY, border highlight, box-shadow) harus tetap berfungsi
- Hero banner background slider (cross-fade antara bg1.jpeg, bg2.jpeg, dll.) harus tetap berjalan
- Dark mode (`[data-bs-theme="dark"]`) pada semua komponen harus tetap bekerja dengan benar
- Filter & search pada halaman Sarana & Prasarana harus tetap berfungsi (form GET)
- Pagination pada halaman Sarana & Prasarana harus tetap tampil dan berfungsi
- Sidebar "Berita Terpopuler" harus tetap tampil (hanya tata letaknya yang diperbaiki, bukan logikanya)
- Tampilan breadcrumb di hero banner harus tetap ada dan terbaca
- `sticky-top` pada sidebar berita (untuk desktop) harus tetap berfungsi setelah perbaikan

**Scope:**
Semua input yang TIDAK melibatkan kondisi bug (navigasi normal, klik tombol filter, toggle dark mode, scroll halaman) tidak boleh terpengaruh oleh perbaikan ini.

---

## Hypothesized Root Cause

Berdasarkan analisis kode di `front.css` dan ketiga file Blade:

1. **Negative Margin Tanpa Kompensasi** (Penyebab Utama):
   - `.page-floating-card { margin-top: -80px }` di `front.css` menarik kartu ke atas tanpa `padding-top` pada container `<div class="container pb-5">` di `page.blade.php`
   - Sidebar di `berita/detail.blade.php` menggunakan `style="margin-top: -60px"` langsung di elemen `.col-lg-4`, yang dalam Bootstrap row akan menyebabkan kolom keluar dari normal document flow secara tidak terprediksi

2. **Tidak Ada Overflow Containment pada Embed Content**:
   - `.page-detail-body` di `front.css` tidak mendefinisikan `overflow: hidden` atau `max-width: 100%`
   - Iframe YouTube dari CKEditor akan meluap karena tidak ada `aspect-ratio wrapper` atau `responsive embed` Bootstrap yang diterapkan

3. **Missing `overflow: hidden` pada Parent Container Sarana & Prasarana**:
   - Container `.container.pb-5` dengan `margin-top: -50px; position: relative; z-index: 10` tidak memiliki `overflow: hidden`
   - Bootstrap row `.row.g-4` di dalamnya dapat menyebabkan horizontal scroll / clipping pada viewport sempit

4. **Tidak Ada Responsive Breakpoint untuk Negative Margin**:
   - Inline style `margin-top: -60px` pada sidebar tidak di-reset di mobile, menyebabkan layout hancur di breakpoint `<992px` ketika kolom Bootstrap jatuh ke full-width

---

## Correctness Properties

Property 1: Bug Condition - Layout Elements Contained Within Boundaries

_For any_ halaman frontend yang memuat `.page-floating-card`, sidebar berita, atau konten embed (iframe/video), elemen-elemen tersebut SHALL berada dalam batas container Bootstrap-nya tanpa overflow horizontal dan tanpa overlap yang merusak tata letak pada semua breakpoint (mobile, tablet, desktop).

**Validates: Requirements 2.1, 2.2, 2.3, 2.4**

Property 2: Preservation - Existing Interactive Behavior Unchanged

_For any_ interaksi pengguna yang TIDAK melibatkan kondisi bug (hover kartu, toggle dark mode, submit filter, klik pagination, scroll sticky sidebar), perilaku visual dan fungsionalnya SHALL identik dengan perilaku sebelum perbaikan diterapkan.

**Validates: Requirements 3.1, 3.2, 3.3, 3.4**

---

## Fix Implementation

### Changes Required

Asumsi root cause di atas benar, berikut perubahan spesifik yang dibutuhkan:

**File 1**: `public/css/front.css`

**Perubahan 1 — Tambah `overflow-wrap` dan `max-width` pada `.page-detail-body`:**
- Tambahkan `max-width: 100%; overflow-x: hidden;` pada rule `.page-detail-body`
- Tambahkan rule baru untuk iframe dan video di dalam `.page-detail-body`: `max-width: 100%; height: auto;`
- Tambahkan responsive embed wrapper style: `.page-detail-body iframe { width: 100%; aspect-ratio: 16/9; }`

**Perubahan 2 — Perbaiki `.page-floating-card` negative margin compensation:**
- Tambahkan `overflow: hidden` pada `container` parent di konteks halaman statis
- Atau, lebih aman: ganti `margin-top: -80px` menjadi nilai yang lebih konservatif dan tambahkan `padding-top` pada container parent

**Perubahan 3 — Tambah `overflow: hidden` pada container Sarana & Prasarana:**
- Tambahkan CSS rule untuk `z-index` container: pastikan ada `overflow: hidden` atau `overflow: clip` agar grid tidak meluap

**Perubahan 4 — Reset negative margin sidebar pada mobile:**
- Tambahkan media query `@media (max-width: 991.98px)` untuk reset `margin-top` sidebar berita ke `0`

---

**File 2**: `resources/views/frontend/berita/detail.blade.php`

**Perubahan 5 — Pindahkan `margin-top: -60px` dari inline style ke CSS class:**
- Ganti inline `style="margin-top: -60px; position: relative; z-index: 10;"` dengan class khusus, misalnya `class="col-lg-4 sidebar-berita-col"`
- Definisikan `.sidebar-berita-col` di `front.css` dengan breakpoint yang tepat

---

**File 3**: `resources/views/frontend/page.blade.php`

**Perubahan 6 — Tambah padding kompensasi pada container:**
- Tidak diperlukan perubahan di sini jika CSS diperbaiki dengan benar

---

### Specific Implementation Steps

1. **CSS — `front.css`**: Tambahkan rule untuk iframe containment dalam `.page-detail-body`
2. **CSS — `front.css`**: Tambahkan media query reset untuk sidebar mobile
3. **CSS — `front.css`**: Tambahkan `overflow: hidden` pada container Sarana & Prasarana
4. **Blade — `berita/detail.blade.php`**: Ganti inline style dengan CSS class `sidebar-berita-col`

---

## Testing Strategy

### Validation Approach

Strategi pengujian mengikuti dua fase: pertama, konfirmasi bug terlihat pada kode yang belum diperbaiki, kemudian verifikasi perbaikan bekerja dan tidak merusak perilaku yang ada.

### Exploratory Bug Condition Checking

**Goal**: Konfirmasi kerusakan tata letak sebelum implementasi fix. Verifikasi atau bantah root cause.

**Test Plan**: Buka setiap halaman yang terdampak di browser, periksa di DevTools pada berbagai viewport width, dan dokumentasikan overflow/clipping yang terlihat.

**Test Cases**:
1. **Sarana & Prasarana Grid Overflow**: Buka `/sarana-prasarana`, resize viewport ke 1200px, verifikasi kartu ke-3 terpotong di kanan → **diharapkan gagal pada kode unfixed**
2. **Berita Detail Sidebar Float**: Buka halaman detail berita, verifikasi sidebar mengambang di luar row → **diharapkan gagal pada kode unfixed**
3. **Page Iframe Overflow**: Buka halaman statis dengan konten YouTube embed, verifikasi iframe meluap → **diharapkan gagal pada kode unfixed**
4. **Mobile Sidebar Stack**: Resize ke 768px, verifikasi sidebar berita tidak overlap dengan artikel → **mungkin gagal pada kode unfixed**

**Expected Counterexamples**:
- Horizontal scrollbar muncul pada halaman Sarana & Prasarana di viewport <1200px
- Sidebar berita overlap dengan elemen di bawah `page-floating-card`
- Iframe YouTube meluap melewati batas card

### Fix Checking

**Goal**: Verifikasi bahwa setelah perbaikan, semua halaman terdampak menampilkan tata letak yang benar.

**Pseudocode:**
```
FOR ALL pageContext WHERE isBugCondition(pageContext) DO
  result := renderPage(pageContext, fixedCSS)
  ASSERT elementsWithinContainerBounds(result)
  ASSERT noHorizontalOverflow(result)
  ASSERT noUnintendedOverlap(result)
END FOR
```

### Preservation Checking

**Goal**: Verifikasi bahwa perbaikan tidak merusak perilaku yang sudah ada.

**Pseudocode:**
```
FOR ALL pageContext WHERE NOT isBugCondition(pageContext) DO
  ASSERT renderPage(pageContext, originalCSS) === renderPage(pageContext, fixedCSS)
END FOR
```

**Testing Approach**: Property-based testing direkomendasikan untuk verifikasi preservation karena:
- Dapat men-generate berbagai kombinasi viewport width × breakpoint
- Mencakup edge case: konten sangat panjang, judul berita sangat pendek, tanpa gambar
- Memberikan garansi kuat bahwa perilaku tidak berubah untuk semua input non-buggy

**Test Cases**:
1. **Dark Mode Preservation**: Toggle dark mode setelah fix, verifikasi warna kartu, teks, dan border identik dengan sebelumnya
2. **Hover Animation Preservation**: Hover pada `.card-jds-hover`, verifikasi `translateY(-6px)` dan border highlight tetap aktif
3. **Sidebar Sticky Preservation**: Scroll halaman detail berita (desktop), verifikasi sidebar `sticky-top` masih menempel di posisi yang benar
4. **Filter Sarana & Prasarana Preservation**: Submit form filter kategori, verifikasi hasil grid tetap tampil dengan benar

### Unit Tests

- Test CSS rule specificity: pastikan media query baru tidak konflik dengan rules yang sudah ada
- Test overflow containment: verifikasi iframe di dalam `.page-detail-body` tidak meluap pada viewport 320px, 768px, dan 1440px
- Test negative margin reset: verifikasi sidebar di mobile (<992px) memiliki `margin-top: 0`

### Property-Based Tests

- Generate random viewport widths antara 320px–2560px dan verifikasi tidak ada horizontal overflow pada semua halaman terdampak
- Generate random konten CKEditor (dengan/tanpa iframe, dengan/tanpa tabel) dan verifikasi semua terkandung dalam `.page-floating-card`
- Generate random jumlah kartu Sarana & Prasarana (1–50 item) dan verifikasi grid selalu consistent di semua breakpoint

### Integration Tests

- Test full page render Sarana & Prasarana dengan filter aktif pada mobile viewport
- Test detail berita dengan sidebar penuh (5 berita terpopuler) + artikel panjang pada tablet viewport
- Test halaman statis dengan konten CKEditor kompleks (tabel, accordion, iframe) pada semua breakpoint
