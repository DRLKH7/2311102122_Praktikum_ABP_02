import 'package:firebase_core/firebase_core.dart';
import 'package:firebase_messaging/firebase_messaging.dart';
import 'package:flutter/material.dart';
import 'package:provider/provider.dart';
import 'models/todo_model.dart';
import 'screens/home_screen.dart';
import 'services/notification_service.dart';

void main() async {
  WidgetsFlutterBinding.ensureInitialized();

  try {
    // 1. Inisialisasi Firebase
    await Firebase.initializeApp();

    // 2. Inisialisasi Local Notification
    await NotificationService.initLocalNotifications();

    // 3. Register background handler (harus top-level function)
    FirebaseMessaging.onBackgroundMessage(NotificationService.backgroundHandler);

    // 4. Minta izin notifikasi
    await FirebaseMessaging.instance.requestPermission();

    // 5. Dapatkan FCM Token (untuk testing)
    final token = await FirebaseMessaging.instance.getToken();
    print('FCM Token: $token');

    // 6. Handle Notifikasi di Foreground
    FirebaseMessaging.onMessage.listen((RemoteMessage message) {
      NotificationService.handleForegroundMessage(message);
    });
  } catch (e) {
    print('Firebase initialization error (Abaikan jika di Web): $e');
  }

  runApp(const MyApp());
}

class MyApp extends StatelessWidget {
  const MyApp({super.key});

  @override
  Widget build(BuildContext context) {
    return ChangeNotifierProvider(
      create: (context) => Todo(),
      child: MaterialApp(
        title: 'Flutter To-Do',
        theme: ThemeData(primarySwatch: Colors.blue),
        home: HomeScreen(),
      ),
    );
  }
}
