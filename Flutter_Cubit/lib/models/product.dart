class Product {
  final int id;
  final String name;
  final int price;
  final String image;

  const Product({
    required this.id,
    required this.name,
    required this.price,
    required this.image,
  });
}

final List<Product> dummyProducts = [
  const Product(id: 1, name: 'Buku Tulis', price: 5000, image: '📓'),
  const Product(id: 2, name: 'Pensil 2B', price: 2000, image: '✏️'),
  const Product(id: 3, name: 'Penghapus', price: 1500, image: '🧹'),
  const Product(id: 4, name: 'Penggaris', price: 3000, image: '📏'),
  const Product(id: 5, name: 'Spidol Hitam', price: 7000, image: '🖊️'),
];
