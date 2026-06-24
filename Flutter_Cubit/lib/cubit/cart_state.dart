import 'package:equatable/equatable.dart';
import '../models/cart_item.dart';

class CartState extends Equatable {
  final List<CartItem> items;

  const CartState({this.items = const []});

  int get totalItems => items.fold(0, (sum, item) => sum + item.quantity);
  int get totalPrice => items.fold(0, (sum, item) => sum + (item.product.price * item.quantity));

  CartState copyWith({List<CartItem>? items}) {
    return CartState(items: items ?? this.items);
  }

  @override
  List<Object?> get props => [items];
}
