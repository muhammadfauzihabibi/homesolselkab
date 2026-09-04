# Bugfix Requirements Document

## Introduction

Portal resmi Pemerintah Kabupaten Solok Selatan (PemdaSolsel) memiliki tiga halaman frontend yang tampilannya rusak akibat permasalahan CSS layout. Halaman yang terdampak adalah: halaman daftar Sarana & Prasarana, halaman detail Berita, dan halaman statis (Page). Kerusakan tampilan berdampak langsung pada pengalaman pengguna publik yang mengakses portal resmi pemerintah dan mengurangi kredibilitas tampilan resmi.

Tiga kondisi bug teridentifikasi:
- **Bug A**: Grid kartu pada halaman Sarana & Prasarana terpotong di tepi kanan layar
- **Bug B**: Sidebar "Berita Terpopuler" pada halaman detail Berita melayang keluar dari batas layout
- **Bug C**: Konten CKEditor dan iframe embed pada halaman statis meluap keluar dari `.page-floating-card`

---

## Bug Analysis

### Current Behavior (Defect)

**Bug A — Sarana & Prasarana Card Grid Overflow**

1.1 WHEN pengguna membuka halaman `/sarana-prasarana` di viewport lebar ≤1200px THEN sistem menampilkan kartu ke-3 dalam baris yang terpotong di tepi kanan layar sehingga tidak terlihat sepenuhnya

1.2 WHEN pengguna membuka halaman `/sarana-prasarana` di perangkat mobile THEN sistem tidak memberikan padding yang cukup di sisi kanan container sehingga konten menyentuh tepi layar

1.3 WHEN kartu-kartu Sarana & Prasarana ditampilkan dalam grid 3 kolom THEN sistem menampilkan kartu dengan tinggi yang tidak seragam dan spacing yang tidak konsisten antar kartu

**Bug B — Sidebar Berita Detail Floating Out-of-Bounds**

1.4 WHEN pengguna membuka halaman detail berita (misal `/berita/{slug}`) di desktop THEN sistem menampilkan sidebar "Berita Terpopuler" (col-lg-4) yang melayang keluar dari area konten karena `margin-top: -60px; position: relative` menyebabkan overlap tidak rapi dengan hero section

1.5 WHEN pengguna membuka halaman detail berita di mobile atau tablet (viewport < 992px) THEN sistem tidak menyembunyikan atau mereposisi `margin-top: -60px` sehingga sidebar tetap melayang di posisi yang salah dan menimpa konten lain

**Bug C — Page/Halaman Statis Content Overflow**

1.6 WHEN halaman statis mengandung konten CKEditor yang memiliki video embed YouTube (iframe) THEN sistem menampilkan iframe yang meluap keluar dari batas lebar `.page-floating-card`, melebihi lebar container induknya

1.7 WHEN halaman statis ditampilkan THEN sistem menampilkan area konten CKEditor yang terlalu sempit dan tidak memanfaatkan lebar container secara optimal, dengan whitespace berlebihan di sisi kanan

1.8 WHEN `.page-floating-card` dirender dengan `margin-top: -80px` THEN sistem tidak menyediakan `padding-top` yang memadai pada container pembungkusnya sehingga card menimpa elemen di atasnya secara tidak terkontrol

---

### Expected Behavior (Correct)

**Bug A — Sarana & Prasarana Card Grid Overflow**

2.1 WHEN pengguna membuka halaman `/sarana-prasarana` di viewport lebar ≤1200px THEN sistem SHALL menampilkan seluruh kartu dalam grid sepenuhnya tanpa ada kartu yang terpotong di tepi layar

2.2 WHEN pengguna membuka halaman `/sarana-prasarana` di perangkat mobile THEN sistem SHALL menerapkan padding horizontal yang cukup pada container agar konten tidak menyentuh tepi layar

2.3 WHEN kartu-kartu Sarana & Prasarana ditampilkan dalam grid THEN sistem SHALL menampilkan kartu dengan tinggi seragam (`h-100` atau `align-items-stretch`) dan spacing yang konsisten di semua ukuran layar

**Bug B — Sidebar Berita Detail Floating Out-of-Bounds**

2.4 WHEN pengguna membuka halaman detail berita di desktop THEN sistem SHALL menampilkan sidebar "Berita Terpopuler" di dalam batas layout Bootstrap grid tanpa melayang melewati batas container hero section

2.5 WHEN pengguna membuka halaman detail berita di mobile atau tablet (viewport < 992px) THEN sistem SHALL memposisikan sidebar secara normal di bawah konten artikel utama, tanpa `margin-top` negatif yang berlaku

**Bug C — Page/Halaman Statis Content Overflow**

2.6 WHEN halaman statis mengandung konten CKEditor dengan iframe embed THEN sistem SHALL membatasi lebar iframe agar tidak melebihi lebar container induknya dengan `max-width: 100%` dan wrapper responsive

2.7 WHEN halaman statis ditampilkan THEN sistem SHALL menampilkan konten CKEditor yang mengisi lebar area `.page-floating-card` secara penuh tanpa whitespace yang tidak proporsional di sisi kanan

2.8 WHEN `.page-floating-card` dirender dengan `margin-top: -80px` THEN sistem SHALL memastikan container pembungkus memiliki `overflow: hidden` atau `padding-top` yang cukup untuk mencegah overlap yang merusak layout

---

### Unchanged Behavior (Regression Prevention)

3.1 WHEN pengguna membuka halaman detail berita di desktop (viewport ≥ 992px) THEN sistem SHALL CONTINUE TO menampilkan layout dua kolom (artikel col-lg-8 dan sidebar col-lg-4) berdampingan

3.2 WHEN pengguna menggulir halaman detail berita di desktop THEN sistem SHALL CONTINUE TO menampilkan sidebar yang `sticky-top` mengikuti posisi scroll seperti sebelumnya

3.3 WHEN kartu Sarana & Prasarana menampilkan gambar, badge kategori, badge kondisi, nama, lokasi, dan pengelola THEN sistem SHALL CONTINUE TO menampilkan semua informasi tersebut tanpa ada yang hilang atau tertutup

3.4 WHEN pengguna menggunakan filter pencarian atau dropdown kategori/kecamatan di halaman Sarana & Prasarana THEN sistem SHALL CONTINUE TO memproses filter dan menampilkan hasil yang relevan

3.5 WHEN halaman statis menampilkan konten CKEditor berupa teks, tabel, gambar, dan accordion (`details/summary`) THEN sistem SHALL CONTINUE TO menampilkan semua elemen tersebut dengan styling yang sudah ada (`page-detail-body`)

3.6 WHEN dark mode diaktifkan THEN sistem SHALL CONTINUE TO menerapkan semua override dark mode pada kartu, sidebar, floating card, dan konten detail tanpa ada perubahan warna yang rusak

3.7 WHEN pengguna mengakses halaman Sarana & Prasarana yang memiliki lebih dari satu halaman data THEN sistem SHALL CONTINUE TO menampilkan pagination dengan styling kustom yang sudah ada

3.8 WHEN hero background slider berjalan di semua halaman yang menggunakannya THEN sistem SHALL CONTINUE TO melakukan cross-fade gambar setiap 4 detik tanpa gangguan dari perubahan layout

---

## Bug Condition Pseudocode

### Bug A — Card Grid Overflow

```pascal
FUNCTION isBugConditionA(X)
  INPUT: X = { viewport_width: integer, column_count: integer, container_has_overflow_hidden: boolean }
  OUTPUT: boolean

  RETURN X.viewport_width <= 1200 AND X.column_count = 3 AND NOT X.container_has_overflow_hidden
END FUNCTION

// Property: Fix Checking — Grid tidak terpotong
FOR ALL X WHERE isBugConditionA(X) DO
  result ← renderSaranaPrasaranaGrid'(X)
  ASSERT result.all_cards_fully_visible = true
  ASSERT result.right_edge_padding >= 12px
END FOR

// Property: Preservation Checking
FOR ALL X WHERE NOT isBugConditionA(X) DO
  ASSERT renderSaranaPrasaranaGrid(X) = renderSaranaPrasaranaGrid'(X)
END FOR
```

### Bug B — Sidebar Out-of-Bounds

```pascal
FUNCTION isBugConditionB(X)
  INPUT: X = { viewport_width: integer, sidebar_margin_top: integer }
  OUTPUT: boolean

  RETURN X.sidebar_margin_top < 0 AND X.viewport_width < 992
END FUNCTION

// Property: Fix Checking — Sidebar tidak overlap di mobile
FOR ALL X WHERE isBugConditionB(X) DO
  result ← renderBeritaDetailLayout'(X)
  ASSERT result.sidebar_within_bounds = true
  ASSERT result.sidebar_margin_top_mobile = 0
END FOR

// Property: Preservation Checking
FOR ALL X WHERE NOT isBugConditionB(X) DO
  ASSERT renderBeritaDetailLayout(X) = renderBeritaDetailLayout'(X)
END FOR
```

### Bug C — Iframe/Content Overflow dari Floating Card

```pascal
FUNCTION isBugConditionC(X)
  INPUT: X = { content_type: string, element_width: integer, container_width: integer }
  OUTPUT: boolean

  RETURN (X.content_type IN ['iframe', 'video_embed']) AND X.element_width > X.container_width
END FUNCTION

// Property: Fix Checking — Iframe tidak meluap dari container
FOR ALL X WHERE isBugConditionC(X) DO
  result ← renderPageContent'(X)
  ASSERT result.element_width <= result.container_width
  ASSERT result.overflow_hidden = true
END FOR

// Property: Preservation Checking
FOR ALL X WHERE NOT isBugConditionC(X) DO
  ASSERT renderPageContent(X) = renderPageContent'(X)
END FOR
```
