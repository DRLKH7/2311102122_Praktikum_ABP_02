# Sistem Penilaian Mahasiswa

Sistem web sederhana untuk menampilkan dan menghitung nilai mahasiswa secara profesional dengan desain dark mode elegan.

## ✨ Fitur Utama
- 📝 **Form Input Mahasiswa** - Tambah data mahasiswa dengan validasi lengkap
- 📊 **Tabel Data** - Tampilan data mahasiswa yang terorganisir dengan sorting NIM
- 🎯 **Perhitungan Otomatis** - Hitung nilai akhir, grade, dan status lulus/tidak
- 📈 **Statistik Kelas** - Rata-rata, nilai tertinggi, jumlah lulus/tidak lulus
- 🌙 **Dark Mode Elegan** - Desain modern dengan tema gelap yang nyaman
- 📱 **Responsive** - Tampil optimal di desktop dan mobile

## 📸 Screenshot

### Form Tambah Data Mahasiswa
![Form Input](/form.png)
*Tampilan form untuk menambah data mahasiswa baru dengan preview nilai real-time*

### Tabel Data dan Statistik
![Data Table](/data.png)
*Tampilan tabel data mahasiswa dan statistik kelas lengkap*

## 🚀 Cara Menjalankan

### Persyaratan
- PHP 7.4 atau lebih baru
- Browser modern (Chrome, Firefox, Edge)

### Langkah Instalasi
1. **Clone repository** (jika diperlukan)
2. **Masuk ke folder project**
   ```bash
   cd sistemmahasiswa
   ```
3. **Jalankan server PHP**
   ```bash
   php -S localhost:8000
   ```
4. **Buka di browser**
   - Kunjungi: `http://localhost:8000`
   - Sistem siap digunakan!

## 📋 Cara Penggunaan
1. **Tambah Data**: Isi form dengan data mahasiswa (nama, NIM, nilai Tugas/UTS/UAS)
2. **Preview**: Lihat preview nilai akhir, grade, dan status secara real-time
3. **Submit**: Klik "Tambah Mahasiswa" untuk menyimpan data
4. **Lihat Data**: Data akan muncul di tabel dengan sorting berdasarkan NIM
5. **Statistik**: Lihat ringkasan statistik kelas di bagian bawah

## 🛠️ Teknologi yang Digunakan
- **Backend**: PHP 8+ (Session, Array Processing)
- **Frontend**: HTML5, CSS3, JavaScript
- **Framework**: Bootstrap 5
- **Styling**: Custom Dark Theme dengan Glassmorphism

## 📁 Struktur File
```
sistemmahasiswa/
├── index.php          # File utama aplikasi
├── function.php       # Library fungsi perhitungan
├── style.css          # Styling custom dark theme
└── README.md          # Dokumentasi ini
```

---
**🎓 Dibuat untuk keperluan pendidikan - Praktikum ABP 02**
