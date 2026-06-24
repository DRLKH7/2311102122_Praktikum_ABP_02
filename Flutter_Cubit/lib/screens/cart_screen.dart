import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import '../cubit/cart_cubit.dart';
import '../cubit/cart_state.dart';

class CartScreen extends StatelessWidget {
  const CartScreen({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Keranjang Belanja'),
        actions: [
          IconButton(
            icon: const Icon(Icons.delete_sweep),
            onPressed: () {
              context.read<CartCubit>().clearCart();
            },
            tooltip: 'Kosongkan Keranjang',
          ),
        ],
      ),
      body: BlocBuilder<CartCubit, CartState>(
        builder: (context, state) {
          if (state.items.isEmpty) {
            return const Center(child: Text('Keranjang kosong'));
          }

          return Column(
            children: [
              Expanded(
                child: ListView.builder(
                  itemCount: state.items.length,
                  itemBuilder: (context, index) {
                    final cartItem = state.items[index];
                    final product = cartItem.product;
                    return ListTile(
                      leading: Text(product.image, style: const TextStyle(fontSize: 32)),
                      title: Text(product.name),
                      subtitle: Column(
                        crossAxisAlignment: CrossAxisAlignment.start,
                        children: [
                          Text('Rp ${product.price}'),
                          const SizedBox(height: 8),
                          Row(
                            mainAxisSize: MainAxisSize.min,
                            children: [
                              IconButton(
                                padding: EdgeInsets.zero,
                                constraints: const BoxConstraints(),
                                icon: const Icon(Icons.remove_circle_outline, color: Colors.orange),
                                onPressed: () {
                                  context.read<CartCubit>().removeItem(product);
                                },
                              ),
                              const SizedBox(width: 12),
                              Text('${cartItem.quantity}', style: const TextStyle(fontSize: 16, fontWeight: FontWeight.bold)),
                              const SizedBox(width: 12),
                              IconButton(
                                padding: EdgeInsets.zero,
                                constraints: const BoxConstraints(),
                                icon: const Icon(Icons.add_circle_outline, color: Colors.green),
                                onPressed: () {
                                  context.read<CartCubit>().addItem(product);
                                },
                              ),
                            ],
                          ),
                        ],
                      ),
                      trailing: IconButton(
                        icon: const Icon(Icons.delete, color: Colors.red),
                        onPressed: () {
                          context.read<CartCubit>().deleteItem(product);
                        },
                      ),
                    );
                  },
                ),
              ),
              Container(
                padding: const EdgeInsets.all(16),
                decoration: BoxDecoration(
                  color: Colors.white,
                  boxShadow: [
                    BoxShadow(
                      color: Colors.grey.withOpacity(0.2),
                      spreadRadius: 1,
                      blurRadius: 5,
                      offset: const Offset(0, -2),
                    ),
                  ],
                ),
                child: Row(
                  mainAxisAlignment: MainAxisAlignment.spaceBetween,
                  children: [
                    const Text(
                      'Total Harga:',
                      style: TextStyle(fontSize: 18, fontWeight: FontWeight.bold),
                    ),
                    Text(
                      'Rp ${state.totalPrice}',
                      style: const TextStyle(fontSize: 18, fontWeight: FontWeight.bold, color: Colors.blue),
                    ),
                  ],
                ),
              ),
            ],
          );
        },
      ),
    );
  }
}
