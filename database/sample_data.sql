-- Clear existing data
SET FOREIGN_KEY_CHECKS = 0;
TRUNCATE TABLE cart;
TRUNCATE TABLE wishlist;
TRUNCATE TABLE reviews;
TRUNCATE TABLE order_items;
TRUNCATE TABLE orders;
TRUNCATE TABLE products;
TRUNCATE TABLE categories;
TRUNCATE TABLE users;
TRUNCATE TABLE coupons;
TRUNCATE TABLE shipping_methods;
SET FOREIGN_KEY_CHECKS = 1;

-- Insert Categories with Unsplash images
INSERT INTO categories (name, slug, description, image_url) VALUES
('Electronics', 'electronics', 'Latest electronic gadgets and devices', 'https://images.unsplash.com/photo-1498049794561-7780e7231661'),
('Fashion', 'fashion', 'Trendy clothing and accessories', 'https://images.unsplash.com/photo-1445205170230-053b83016050'),
('Home & Living', 'home-living', 'Home decor and furniture', 'https://images.unsplash.com/photo-1484101403633-562f891dc89a'),
('Sports', 'sports', 'Sports equipment and accessories', 'https://images.unsplash.com/photo-1517649763962-0c623066013b');

-- Insert Users (password: password123)
INSERT INTO users (username, email, password, first_name, last_name, address, phone, is_admin) VALUES
('admin', 'admin@rudrashop.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Admin', 'User', 'Admin Address', '1234567890', true),
('john_doe', 'john@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'John', 'Doe', '123 Main St, City', '9876543210', false),
('jane_smith', 'jane@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Jane', 'Smith', '456 Oak St, Town', '8765432109', false);

-- Insert Products
INSERT INTO products (name, slug, description, price, sale_price, category_id, stock, image_url, is_featured) VALUES
('Smart Watch Pro', 'smart-watch-pro', 'Advanced smartwatch with health monitoring features', 199.99, 179.99, 1, 50, 'https://images.unsplash.com/photo-1606813907077-3b66ca6ff65b', true),
('Wireless Earbuds', 'wireless-earbuds', 'Premium wireless earbuds with noise cancellation', 149.99, NULL, 1, 100, 'https://images.unsplash.com/photo-1589987607627-6e051486b989', true),
('Leather Wallet', 'leather-wallet', 'Handcrafted genuine leather wallet', 49.99, 39.99, 2, 75, 'https://images.unsplash.com/photo-1581578731548-c64695cc6954', true),
('Designer Sunglasses', 'designer-sunglasses', 'UV protected polarized sunglasses', 89.99, NULL, 2, 30, 'https://images.unsplash.com/photo-1517841905240-472988babdf9', false),
('Yoga Mat', 'yoga-mat', 'Premium non-slip yoga mat', 29.99, NULL, 4, 100, 'https://images.unsplash.com/photo-1614846027585-c3c273b6469e', true),
('Table Lamp', 'table-lamp', 'Modern LED table lamp with adjustable brightness', 39.99, 34.99, 3, 45, 'https://images.unsplash.com/photo-1507473885765-e6ed057f782c', false),
('Fitness Tracker', 'fitness-tracker', 'Water-resistant fitness band with heart rate monitor', 79.99, NULL, 1, 60, 'https://images.unsplash.com/photo-1557935728-e6d1684e0944', true),
('Backpack', 'backpack', 'Waterproof laptop backpack with USB charging port', 59.99, 49.99, 2, 40, 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62', true);

-- Insert Shipping Methods
INSERT INTO shipping_methods (name, price, estimated_days, is_active) VALUES
('Standard Shipping', 5.99, '5-7 business days', true),
('Express Shipping', 12.99, '2-3 business days', true),
('Next Day Delivery', 19.99, '1 business day', true),
('Free Shipping', 0.00, '7-10 business days', true);

-- Insert Orders
INSERT INTO orders (user_id, total_amount, status, shipping_address, payment_status) VALUES
(2, 349.98, 'delivered', '123 Main St, City', 'paid'),
(2, 89.99, 'processing', '123 Main St, City', 'paid'),
(3, 119.98, 'pending', '456 Oak St, Town', 'pending');

-- Insert Order Items
INSERT INTO order_items (order_id, product_id, quantity, price) VALUES
(1, 1, 1, 199.99),
(1, 2, 1, 149.99),
(2, 4, 1, 89.99),
(3, 3, 1, 49.99),
(3, 5, 1, 29.99);

-- Insert Reviews
INSERT INTO reviews (product_id, user_id, rating, comment) VALUES
(1, 2, 5, 'Great smartwatch! Battery life is amazing.'),
(2, 2, 4, 'Good sound quality, comfortable to wear.'),
(3, 2, 5, 'Excellent quality leather, very durable.'),
(1, 3, 4, 'Nice features but a bit pricey.'),
(2, 3, 5, 'Perfect for workouts!');

-- Insert Wishlist Items
INSERT INTO wishlist (user_id, product_id) VALUES
(2, 5),
(2, 6),
(3, 1),
(3, 8);

-- Insert Coupons
INSERT INTO coupons (code, discount_percent, valid_from, valid_to, min_purchase, is_active) VALUES
('WELCOME10', 10.00, '2024-01-01 00:00:00', '2024-12-31 23:59:59', 50.00, true),
('SUMMER20', 20.00, '2024-06-01 00:00:00', '2024-08-31 23:59:59', 100.00, true),
('FLASH25', 25.00, '2024-03-01 00:00:00', '2024-03-07 23:59:59', 150.00, false);

-- Insert Cart Items
INSERT INTO cart (user_id, product_id, quantity) VALUES
(2, 7, 1),
(2, 8, 1),
(3, 4, 2);