import 'package:firebase_messaging/firebase_messaging.dart';
import 'package:flutter_local_notifications/flutter_local_notifications.dart';

class NotificationService {
  static final FlutterLocalNotificationsPlugin _localNotifications =
      FlutterLocalNotificationsPlugin();

  // Inisialisasi local notification
  static Future<void> initLocalNotifications() async {
    const AndroidInitializationSettings androidSettings =
        AndroidInitializationSettings('@mipmap/ic_launcher');
    const DarwinInitializationSettings iosSettings =
        DarwinInitializationSettings();
    const InitializationSettings settings = InitializationSettings(
      android: androidSettings,
      iOS: iosSettings,
    );
    await _localNotifications.initialize(settings);
  }

  // Tampilkan notifikasi lokal
  static Future<void> showLocalNotification({
    required String title,
    required String body,
  }) async {
    const AndroidNotificationDetails androidDetails =
        AndroidNotificationDetails(
      'todo_channel',
      'Todo Channel',
      importance: Importance.high,
      priority: Priority.high,
    );
    const DarwinNotificationDetails iosDetails =
        DarwinNotificationDetails();
    const NotificationDetails details = NotificationDetails(
      android: androidDetails,
      iOS: iosDetails,
    );
    await _localNotifications.show(
      0,
      title,
      body,
      details,
    );
  }

  // Handler untuk notifikasi di foreground
  static void handleForegroundMessage(RemoteMessage message) {
    final notification = message.notification;
    if (notification != null) {
      showLocalNotification(
        title: notification.title ?? 'Notifikasi',
        body: notification.body ?? '',
      );
    }
  }

  // Handler untuk notifikasi di background
  @pragma('vm:entry-point')
  static Future<void> backgroundHandler(RemoteMessage message) async {
    // Firebase di-inisialisasi ulang di isolate background
    // Tampilkan notifikasi lokal
    final notification = message.notification;
    if (notification != null) {
      await showLocalNotification(
        title: notification.title ?? 'Notifikasi',
        body: notification.body ?? '',
      );
    }
  }
}
