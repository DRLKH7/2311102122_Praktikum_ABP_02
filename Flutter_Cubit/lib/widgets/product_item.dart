import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import '../cubit/cart_cubit.dart';
import '../cubit/cart_state.dart';
import '../models/product.dart';

class ProductItem extends StatelessWidget {
  final Product product;

  const ProductItem({Key? key, required this.product}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return Card(
      margin: const EdgeInsets.symmetric(horizontal: 16, vertical: 8),
      child: ListTile(
        leading: Text(product.image, style: const TextStyle(fontSize: 32)),
        title: Text(product.name),
        subtitle: Text('Rp ${product.price}'),
        trailing: BlocBuilder<CartCubit, CartState>(
          builder: (context, state) {
            final quantity = context.read<CartCubit>().getQuantity(product);
            
            if (quantity > 0) {
              return Row(
                mainAxisSize: MainAxisSize.min,
                children: [
                  InkWell(
                    borderRadius: BorderRadius.circular(20),
                    onTap: () {
                      context.read<CartCubit>().removeItem(product);
                    },
                    child: const Padding(
                      padding: EdgeInsets.all(4.0),
                      child: Icon(Icons.remove_circle_outline, color: Colors.red),
                    ),
                  ),
                  const SizedBox(width: 8),
                  Text('$quantity', style: const TextStyle(fontSize: 16, fontWeight: FontWeight.bold)),
                  const SizedBox(width: 8),
                  InkWell(
                    borderRadius: BorderRadius.circular(20),
                    onTap: () {
                      context.read<CartCubit>().addItem(product);
                    },
                    child: const Padding(
                      padding: EdgeInsets.all(4.0),
                      child: Icon(Icons.add_circle_outline, color: Colors.green),
                    ),
                  ),
                ],
              );
            } else {
              return IconButton(
                icon: const Icon(Icons.add_shopping_cart, color: Colors.green),
                onPressed: () {
                  context.read<CartCubit>().addItem(product);
                },
              );
            }
          },
        ),
      ),
    );
  }
}
