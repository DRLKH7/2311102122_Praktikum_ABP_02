import 'package:flutter_bloc/flutter_bloc.dart';
import 'cart_state.dart';
import '../models/product.dart';
import '../models/cart_item.dart';

class CartCubit extends Cubit<CartState> {
  CartCubit() : super(const CartState());

  void addItem(Product product) {
    final existingIndex = state.items.indexWhere((item) => item.product.id == product.id);
    
    if (existingIndex >= 0) {
      final newItems = List<CartItem>.from(state.items);
      final existingItem = newItems[existingIndex];
      newItems[existingIndex] = existingItem.copyWith(quantity: existingItem.quantity + 1);
      emit(state.copyWith(items: newItems));
    } else {
      final newItems = List<CartItem>.from(state.items)..add(CartItem(product: product));
      emit(state.copyWith(items: newItems));
    }
  }

  void removeItem(Product product) {
    final existingIndex = state.items.indexWhere((item) => item.product.id == product.id);
    
    if (existingIndex >= 0) {
      final newItems = List<CartItem>.from(state.items);
      final existingItem = newItems[existingIndex];
      
      if (existingItem.quantity > 1) {
        newItems[existingIndex] = existingItem.copyWith(quantity: existingItem.quantity - 1);
      } else {
        newItems.removeAt(existingIndex);
      }
      emit(state.copyWith(items: newItems));
    }
  }

  void deleteItem(Product product) {
    final newItems = List<CartItem>.from(state.items)
      ..removeWhere((item) => item.product.id == product.id);
    emit(state.copyWith(items: newItems));
  }

  int getQuantity(Product product) {
    final index = state.items.indexWhere((item) => item.product.id == product.id);
    if (index >= 0) return state.items[index].quantity;
    return 0;
  }

  void clearCart() {
    emit(state.copyWith(items: <CartItem>[]));
  }
}
