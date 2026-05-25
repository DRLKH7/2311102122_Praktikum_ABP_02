import 'dart:io';
import 'package:flutter/material.dart';
import 'package:image_picker/image_picker.dart';
import 'package:flutter_local_notifications/flutter_local_notifications.dart';
import 'package:permission_handler/permission_handler.dart';

// Global instance untuk lokal notifikasi agar bisa diakses dari mana saja
final FlutterLocalNotificationsPlugin flutterLocalNotificationsPlugin =
    FlutterLocalNotificationsPlugin();

void main() async {
  // Wajib dipanggil sebelum inisialisasi plugin/binding asinkronus
  WidgetsFlutterBinding.ensureInitialized();

  // Inisialisasi awal notifikasi lokal untuk platform Android
  const AndroidInitializationSettings initializationSettingsAndroid =
      AndroidInitializationSettings('@mipmap/ic_launcher');

  const InitializationSettings initializationSettings = InitializationSettings(
    android: initializationSettingsAndroid,
  );

  await flutterLocalNotificationsPlugin.initialize(
    initializationSettings,
  );

  runApp(const MyApp());
}

class MyApp extends StatelessWidget {
  const MyApp({super.key});

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      title: 'Flutter Notif & Hardware API',
      debugShowCheckedModeBanner: false,
      themeMode: ThemeMode.dark,
      darkTheme: ThemeData(
        brightness: Brightness.dark,
        primaryColor: const Color(0xFF6366F1), // Indigo Accent
        scaffoldBackgroundColor: const Color(0xFF0F172A), // Slate 900
        cardColor: const Color(0xFF1E293B), // Slate 800
        dividerColor: const Color(0xFF334155), // Slate 700
        textTheme: const TextTheme(
          headlineMedium: TextStyle(
            fontSize: 22,
            fontWeight: FontWeight.bold,
            color: Colors.white,
            letterSpacing: 0.5,
          ),
          titleMedium: TextStyle(
            fontSize: 16,
            fontWeight: FontWeight.w600,
            color: Color(0xFFCBD5E1), // Slate 300
          ),
          bodyMedium: TextStyle(
            fontSize: 14,
            color: Color(0xFF94A3B8), // Slate 400
          ),
        ),
      ),
      home: const NotificationHardwareScreen(),
    );
  }
}

class NotificationHardwareScreen extends StatefulWidget {
  const NotificationHardwareScreen({super.key});

  @override
  State<NotificationHardwareScreen> createState() =>
      _NotificationHardwareScreenState();
}

class _NotificationHardwareScreenState
    extends State<NotificationHardwareScreen> {
  File? _imageFile; // Menyimpan file foto terpilih
  final ImagePicker _picker = ImagePicker(); // Instance image_picker

  @override
  void initState() {
    super.initState();
    // Request izin notifikasi saat pertama kali membuka aplikasi (Android 13+)
    _requestNotificationPermission();
  }

  // 1. Request Izin Notifikasi (Untuk Android 13+)
  Future<void> _requestNotificationPermission() async {
    if (await Permission.notification.isDenied) {
      await Permission.notification.request();
    }
  }

  // 2. Tampilkan Notifikasi Lokal
  Future<void> _showNotification(String title, String body) async {
    // Detail notifikasi khusus Android
    const AndroidNotificationDetails androidPlatformChannelSpecifics =
        AndroidNotificationDetails(
      'praktikum_abp_channel', // ID Channel
      'Praktikum ABP Notif', // Nama Channel
      channelDescription: 'Channel notifikasi untuk tugas praktikum ABP',
      importance: Importance.max,
      priority: Priority.high,
      showWhen: true,
      playSound: true,
      enableVibration: true,
    );

    const NotificationDetails platformChannelSpecifics = NotificationDetails(
      android: androidPlatformChannelSpecifics,
    );

    // Kirim notifikasi dengan ID acak
    await flutterLocalNotificationsPlugin.show(
      DateTime.now().millisecond,
      title,
      body,
      platformChannelSpecifics,
    );
  }

  // 3. Request Izin Galeri dengan Penanganan Versi Android
  Future<bool> _checkAndRequestGalleryPermission() async {
    // Pada Android 13+, gunakan Permission.photos
    if (await Permission.photos.request().isGranted) {
      return true;
    }
    // Fallback untuk Android 12 ke bawah, gunakan Permission.storage
    if (await Permission.storage.request().isGranted) {
      return true;
    }
    return false;
  }

  // 4. Buka Kamera
  Future<void> _openCamera() async {
    // Cek Izin Kamera
    PermissionStatus cameraStatus = await Permission.camera.status;

    if (cameraStatus.isGranted) {
      // Jalankan Kamera jika izin diberikan
      try {
        final XFile? photo = await _picker.pickImage(
          source: ImageSource.camera,
          imageQuality: 85, // Kompresi kualitas agar hemat memori
        );

        if (photo != null) {
          setState(() {
            _imageFile = File(photo.path);
          });
          ScaffoldMessenger.of(context).showSnackBar(
            const SnackBar(content: Text('Foto berhasil diambil dari kamera!')),
          );
          // Tembak Notifikasi
          await _showNotification(
            'Ambil Foto Berhasil! 📸',
            'Foto baru telah diambil menggunakan kamera HP fisik Anda.',
          );
        } else {
          // Kasus: User membatalkan pengambilan gambar
          ScaffoldMessenger.of(context).showSnackBar(
            const SnackBar(content: Text('Batal mengambil foto.')),
          );
        }
      } catch (e) {
        _showErrorDialog('Gagal membuka kamera: $e');
      }
    } else if (cameraStatus.isDenied) {
      // Request izin jika baru pertama kali atau pernah menolak sekali
      PermissionStatus reqStatus = await Permission.camera.request();
      if (reqStatus.isGranted) {
        _openCamera();
      } else {
        _showPermissionDeniedDialog('Kamera');
      }
    } else {
      // Permanen ditolak (isPermanentlyDenied)
      _showPermissionDeniedDialog('Kamera');
    }
  }

  // 5. Pilih Foto dari Galeri
  Future<void> _openGallery() async {
    bool hasPermission = await _checkAndRequestGalleryPermission();

    if (hasPermission) {
      try {
        final XFile? image = await _picker.pickImage(
          source: ImageSource.gallery,
          imageQuality: 85,
        );

        if (image != null) {
          setState(() {
            _imageFile = File(image.path);
          });
          ScaffoldMessenger.of(context).showSnackBar(
            const SnackBar(content: Text('Foto berhasil dipilih dari galeri!')),
          );
          // Tembak Notifikasi
          await _showNotification(
            'Pilih Foto Berhasil! 🖼️',
            'Foto berhasil didapatkan dari galeri perangkat Anda.',
          );
        } else {
          // Kasus: User membatalkan pemilihan gambar
          ScaffoldMessenger.of(context).showSnackBar(
            const SnackBar(content: Text('Batal memilih foto dari galeri.')),
          );
        }
      } catch (e) {
        _showErrorDialog('Gagal mengakses galeri: $e');
      }
    } else {
      _showPermissionDeniedDialog('Galeri/Penyimpanan');
    }
  }

  // Dialog Informative saat izin ditolak
  void _showPermissionDeniedDialog(String permissionName) {
    showDialog(
      context: context,
      builder: (BuildContext context) => AlertDialog(
        title: Text('Izin $permissionName Diperlukan'),
        content: Text(
          'Aplikasi membutuhkan akses $permissionName untuk menjalankan fitur ini. '
          'Silakan berikan izin di pengaturan sistem perangkat Anda.',
        ),
        actions: <Widget>[
          TextButton(
            child: const Text('Batal'),
            onPressed: () => Navigator.of(context).pop(),
          ),
          ElevatedButton(
            style: ElevatedButton.styleFrom(
              backgroundColor: const Color(0xFF6366F1), // Indigo
            ),
            child: const Text('Buka Pengaturan'),
            onPressed: () {
              Navigator.of(context).pop();
              openAppSettings(); // Membuka menu info aplikasi di HP fisik secara otomatis
            },
          ),
        ],
      ),
    );
  }

  // Dialog Penanganan Error Umum
  void _showErrorDialog(String message) {
    showDialog(
      context: context,
      builder: (BuildContext context) => AlertDialog(
        title: const Text('Terjadi Kesalahan'),
        content: Text(message),
        actions: <Widget>[
          TextButton(
            child: const Text('Tutup'),
            onPressed: () => Navigator.of(context).pop(),
          ),
        ],
      ),
    );
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: SafeArea(
        child: SingleChildScrollView(
          physics: const BouncingScrollPhysics(),
          child: Padding(
            padding: const EdgeInsets.symmetric(horizontal: 20.0, vertical: 24.0),
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                // 1. Header Identitas Mahasiswa (Konsisten dengan Tugas 2)
                Container(
                  padding: const EdgeInsets.all(20),
                  decoration: BoxDecoration(
                    gradient: const LinearGradient(
                      colors: [Color(0xFF4F46E5), Color(0xFF6366F1)], // Indigo Gradients
                      begin: Alignment.topLeft,
                      end: Alignment.bottomRight,
                    ),
                    borderRadius: BorderRadius.circular(20),
                    boxShadow: [
                      BoxShadow(
                        color: const Color(0xFF6366F1).withOpacity(0.3),
                        blurRadius: 15,
                        offset: const Offset(0, 8),
                      ),
                    ],
                  ),
                  child: const Row(
                    children: [
                      CircleAvatar(
                        radius: 30,
                        backgroundColor: Colors.white,
                        child: Text(
                          'DP',
                          style: TextStyle(
                            fontSize: 22,
                            fontWeight: FontWeight.bold,
                            color: Color(0xFF4F46E5),
                          ),
                        ),
                      ),
                      SizedBox(width: 16),
                      Expanded(
                        child: Column(
                          crossAxisAlignment: CrossAxisAlignment.start,
                          children: [
                            Text(
                              'Praktikum ABP - Notifikasi & API',
                              style: TextStyle(
                                fontSize: 13,
                                color: Color(0xFFE0E7FF),
                                fontWeight: FontWeight.w500,
                              ),
                            ),
                            SizedBox(height: 4),
                            Text(
                              'Darrel Khayru Adityansah',
                              style: TextStyle(
                                fontSize: 19,
                                fontWeight: FontWeight.bold,
                                color: Colors.white,
                              ),
                            ),
                            Text(
                              'NIM: 2311102122',
                              style: TextStyle(
                                fontSize: 12,
                                color: Color(0xFFC7D2FE),
                              ),
                            ),
                          ],
                        ),
                      ),
                    ],
                  ),
                ),
                
                const SizedBox(height: 28),
                
                // Judul Section Preview
                const Padding(
                  padding: EdgeInsets.only(left: 4.0, bottom: 12.0),
                  child: Text(
                    'Pratinjau Foto (Preview)',
                    style: TextStyle(
                      fontSize: 18,
                      fontWeight: FontWeight.bold,
                      color: Colors.white,
                    ),
                  ),
                ),

                // 2. Container Pratinjau Foto dengan Styling Premium
                Container(
                  width: double.infinity,
                  height: 320,
                  decoration: BoxDecoration(
                    color: Theme.of(context).cardColor,
                    borderRadius: BorderRadius.circular(20),
                    border: Border.all(
                      color: _imageFile != null
                          ? const Color(0xFF6366F1) // Indigo Border jika ada gambar
                          : const Color(0xFF334155), // Slate Border jika kosong
                      width: 2,
                    ),
                    boxShadow: [
                      BoxShadow(
                        color: Colors.black.withOpacity(0.2),
                        blurRadius: 10,
                        offset: const Offset(0, 6),
                      ),
                    ],
                  ),
                  child: ClipRRect(
                    borderRadius: BorderRadius.circular(18),
                    child: _imageFile != null
                        ? Image.file(
                            _imageFile!,
                            fit: BoxFit.cover,
                          )
                        : Column(
                            mainAxisAlignment: MainAxisAlignment.center,
                            children: [
                              Container(
                                padding: const EdgeInsets.all(16),
                                decoration: BoxDecoration(
                                  color: const Color(0xFF6366F1).withOpacity(0.1),
                                  shape: BoxShape.circle,
                                ),
                                child: const Icon(
                                  Icons.image_not_supported_outlined,
                                  size: 48,
                                  color: Color(0xFF6366F1),
                                ),
                              ),
                              const SizedBox(height: 16),
                              const Text(
                                'Belum Ada Foto Terpilih',
                                style: TextStyle(
                                  fontSize: 16,
                                  fontWeight: FontWeight.bold,
                                  color: Colors.white,
                                ),
                              ),
                              const SizedBox(height: 6),
                              const Padding(
                                padding: EdgeInsets.symmetric(horizontal: 32.0),
                                child: Text(
                                  'Silakan ambil foto menggunakan kamera langsung atau pilih dari galeri HP Anda.',
                                  textAlign: TextAlign.center,
                                  style: TextStyle(
                                    fontSize: 12,
                                    color: Color(0xFF94A3B8),
                                  ),
                                ),
                              ),
                            ],
                          ),
                  ),
                ),
                
                const SizedBox(height: 32),

                // Judul Section Aksi
                const Padding(
                  padding: EdgeInsets.only(left: 4.0, bottom: 12.0),
                  child: Text(
                    'API Perangkat Keras & Kontrol',
                    style: TextStyle(
                      fontSize: 18,
                      fontWeight: FontWeight.bold,
                      color: Colors.white,
                    ),
                  ),
                ),

                // 3. Panel Kontrol Tombol Pemicu Perangkat Keras
                Row(
                  children: [
                    // Tombol Buka Kamera (Indigo Accent)
                    Expanded(
                      child: ElevatedButton.icon(
                        style: ElevatedButton.styleFrom(
                          backgroundColor: const Color(0xFF6366F1),
                          foregroundColor: Colors.white,
                          padding: const EdgeInsets.symmetric(vertical: 16),
                          shape: RoundedRectangleBorder(
                            borderRadius: BorderRadius.circular(16),
                          ),
                          elevation: 4,
                        ),
                        onPressed: _openCamera,
                        icon: const Icon(Icons.camera_alt_rounded),
                        label: const Text(
                          'Buka Kamera',
                          style: TextStyle(
                            fontSize: 14,
                            fontWeight: FontWeight.bold,
                          ),
                        ),
                      ),
                    ),
                    
                    const SizedBox(width: 14),
                    
                    // Tombol Buka Galeri (Rose/Pink Accent)
                    Expanded(
                      child: ElevatedButton.icon(
                        style: ElevatedButton.styleFrom(
                          backgroundColor: const Color(0xFFEC4899),
                          foregroundColor: Colors.white,
                          padding: const EdgeInsets.symmetric(vertical: 16),
                          shape: RoundedRectangleBorder(
                            borderRadius: BorderRadius.circular(16),
                          ),
                          elevation: 4,
                        ),
                        onPressed: _openGallery,
                        icon: const Icon(Icons.photo_library_rounded),
                        label: const Text(
                          'Pilih Galeri',
                          style: TextStyle(
                            fontSize: 14,
                            fontWeight: FontWeight.bold,
                          ),
                        ),
                      ),
                    ),
                  ],
                ),
                
                const SizedBox(height: 40),
                
                // 4. Footer Keterangan Instansi
                const Center(
                  child: Column(
                    children: [
                      Divider(color: Color(0xFF334155)),
                      SizedBox(height: 12),
                      Text(
                        'Praktikum ABP 2026 - Institut Teknologi',
                        style: TextStyle(
                          fontSize: 11,
                          color: Color(0xFF64748B),
                        ),
                      ),
                      SizedBox(height: 2),
                      Text(
                        'Modul Hardware API & Local Notifications',
                        style: TextStyle(
                          fontSize: 10,
                          color: Color(0xFF475569),
                        ),
                      ),
                    ],
                  ),
                ),
              ],
            ),
          ),
        ),
      ),
    );
  }
}
