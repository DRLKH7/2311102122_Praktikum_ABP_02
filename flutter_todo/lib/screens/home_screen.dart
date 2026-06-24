import 'package:flutter/material.dart';
import 'package:provider/provider.dart';
import '../models/todo_model.dart';

class HomeScreen extends StatelessWidget {
  final TextEditingController _controller = TextEditingController();

  HomeScreen({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('To-Do List'),
        backgroundColor: Colors.blue,
        foregroundColor: Colors.white,
        actions: [
          // Tombol hapus semua
          Consumer<Todo>(
            builder: (context, todo, child) {
              return IconButton(
                icon: const Icon(Icons.delete_sweep),
                onPressed: todo.todos.isEmpty ? null : todo.removeAllTodos,
              );
            },
          ),
        ],
      ),
      body: Column(
        children: [
          // Input tambah tugas
          Padding(
            padding: const EdgeInsets.all(16.0),
            child: Row(
              children: [
                Expanded(
                  child: TextField(
                    controller: _controller,
                    decoration: const InputDecoration(
                      hintText: 'Tambahkan tugas...',
                      border: OutlineInputBorder(),
                    ),
                  ),
                ),
                const SizedBox(width: 8),
                ElevatedButton(
                  onPressed: () {
                    final todo = Provider.of<Todo>(context, listen: false);
                    todo.addTodo(_controller.text);
                    _controller.clear();
                  },
                  child: const Text('Tambah'),
                ),
              ],
            ),
          ),
          // Daftar tugas
          Expanded(
            child: Consumer<Todo>(
              builder: (context, todo, child) {
                if (todo.todos.isEmpty) {
                  return const Center(
                    child: Text('Belum ada tugas. Tambahkan tugas baru!'),
                  );
                }
                return ListView.builder(
                  itemCount: todo.todos.length,
                  itemBuilder: (context, index) {
                    return ListTile(
                      title: Text(todo.todos[index]),
                      trailing: IconButton(
                        icon: const Icon(Icons.delete, color: Colors.red),
                        onPressed: () => todo.removeTodoAt(index),
                      ),
                    );
                  },
                );
              },
            ),
          ),
        ],
      ),
    );
  }
}
