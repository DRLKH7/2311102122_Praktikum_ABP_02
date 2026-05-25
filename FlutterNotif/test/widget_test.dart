// This is a basic Flutter widget test for the FlutterNotif application.
import 'package:flutter/material.dart';
import 'package:flutter_test/flutter_test.dart';
import 'package:flutter_notif/main.dart';

void main() {
  testWidgets('App renders dashboard and action buttons', (WidgetTester tester) async {
    // Build our app and trigger a frame.
    await tester.pumpWidget(const MyApp());

    // Verifikasi bahwa Identitas Mahasiswa dirender
    expect(find.text('Darrel Khayru Adityansah'), findsOneWidget);
    expect(find.text('NIM: 2311102122'), findsOneWidget);

    // Verifikasi bahwa tombol Buka Kamera dan Pilih Galeri dirender di layar
    expect(find.text('Buka Kamera'), findsOneWidget);
    expect(find.text('Pilih Galeri'), findsOneWidget);
  });
}
