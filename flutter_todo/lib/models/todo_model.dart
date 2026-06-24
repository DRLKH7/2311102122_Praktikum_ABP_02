import 'package:flutter/foundation.dart';

class Todo with ChangeNotifier {
  final List<String> _todos = [];

  List<String> get todos => _todos;

  void addTodo(String task) {
    if (task.trim().isNotEmpty) {
      _todos.add(task.trim());
      notifyListeners(); // Memberi tahu UI bahwa ada perubahan
    }
  }

  void removeAllTodos() {
    _todos.clear();
    notifyListeners();
  }

  void removeTodoAt(int index) {
    _todos.removeAt(index);
    notifyListeners();
  }
}
