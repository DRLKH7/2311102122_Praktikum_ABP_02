# Laporan Implementasi Cubit pada Aplikasi Keranjang Belanja

## 1. Pendahuluan
Aplikasi ini adalah sebuah aplikasi daftar produk sederhana yang dibangun menggunakan framework Flutter. Aplikasi ini telah menerapkan **Cubit** (sebuah varian dari BLoC - Business Logic Component) sebagai mekanisme *state management* untuk mengelola state dari keranjang belanja (*shopping cart*).

## 2. Review Kesesuaian Kebutuhan
Berdasarkan tinjauan (*review*) pada kode sumber (*source code*) di direktori `Flutter_Cubit`, aplikasi ini **telah sepenuhnya sesuai** dengan instruksi dan persyaratan yang diminta:
1. **Minimal 5 Produk**: Terdapat 5 data produk statis (`dummyProducts`) di dalam `lib/models/product.dart` (Buku Tulis, Pensil 2B, Penghapus, Penggaris, Spidol Hitam).
2. **Menggunakan BLoC/Cubit untuk Tambah/Hapus Produk**: Terdapat `CartCubit` (`lib/cubit/cart_cubit.dart`) yang memiliki fungsi `addItem` dan `removeItem`.
3. **Tampilkan jumlah item di keranjang secara real-time**: Jumlah barang tampil secara reaktif di pojok kanan atas ikon keranjang (badge) pada `ProductListScreen`.
4. **Penggunaan `BlocProvider` dan `BlocBuilder`**: `BlocProvider` membungkus root aplikasi di `main.dart`, dan `BlocBuilder` digunakan pada daftar produk maupun keranjang untuk merefleksikan perubahan secara otomatis.

## 3. Penjelasan Implementasi Cubit

### A. State Management (`CartState` dan `CartCubit`)
- **`CartState`** (`lib/cubit/cart_state.dart`): Mengelola data *state* keranjang. State ini menyimpan *list* `items` berisi daftar objek `Product`. Terdapat *getter* `totalItems` untuk menghitung jumlah item, dan `totalPrice` untuk total harga.
- **`CartCubit`** (`lib/cubit/cart_cubit.dart`): Mengelola *logic* aplikasi. Cubit ini meng-inisialisasi keranjang kosong. Fungsi utamanya antara lain:
  - `addItem(Product)`: Menambahkan produk ke dalam keranjang lalu melakukan `emit` state terbaru.
  - `removeItem(Product)`: Menghapus produk spesifik dari keranjang dan meng-`emit` state terbaru.
  - `clearCart()`: Mengosongkan keranjang.

### B. Injeksi State (`BlocProvider`)
Pada file `lib/main.dart`, `BlocProvider` diinisialisasi di level paling atas (`MyApp`) agar state keranjang dapat diakses secara global oleh seluruh halaman (Screen) yang membutuhkannya:
```dart
return BlocProvider(
  create: (_) => CartCubit(),
  child: MaterialApp( ... ),
);
```

### C. Reaktivitas UI (`BlocBuilder`)
Aplikasi menggunakan `BlocBuilder<CartCubit, CartState>` pada beberapa bagian UI untuk bereaksi (*rebuild*) terhadap perubahan state secara *real-time*:
- **Badge Jumlah Item**: Pada `lib/screens/product_list_screen.dart`, `BlocBuilder` menampilkan badge merah pada ikon keranjang yang angkanya berubah seketika ketika fungsi `addItem` atau `removeItem` dipanggil.
- **Daftar Keranjang**: Pada `lib/screens/cart_screen.dart`, `BlocBuilder` menampilkan semua produk yang masuk ke dalam keranjang, beserta akumulasi "Total Harga".
- **Ikon Keranjang di Item Produk**: Pada `lib/widgets/product_item.dart`, `BlocBuilder` memeriksa apakah produk sudah ada di keranjang untuk mengubah ikon hijau (Tambah) menjadi ikon merah (Hapus).

## 4. Tampilan Aplikasi (Screenshot)
*(Silakan lampirkan *screenshot* aplikasi Anda di bagian ini untuk melengkapi laporan)*

- **Gambar 1: Tampilan Daftar Produk** 
  *(Screenshot halaman utama yang memuat daftar 5 produk dan ikon keranjang di atas)*
- **Gambar 2: Proses Menambah Produk ke Keranjang** 
  *(Screenshot ketika menekan tombol tambah keranjang hijau pada salah satu item produk)*
- **Gambar 3: Tampilan Jumlah Item pada Keranjang (Real-time)** 
  *(Screenshot badge merah di kanan atas yang memuat angka jumlah barang setelah item ditambahkan)*
- **Gambar 4: Halaman Keranjang Belanja** 
  *(Screenshot halaman `CartScreen` yang menampilkan list barang di dalam keranjang beserta total harganya)*

## Kesimpulan
Aplikasi telah diimplementasikan dengan sangat baik menggunakan arsitektur Cubit. Pemisahan antara *Business Logic* (`cubit/`) dan *UI/Presentation* (`screens/`, `widgets/`) membuat kode lebih bersih, mudah dibaca, dan *scalable* untuk pengembangan fitur ke depannya.
