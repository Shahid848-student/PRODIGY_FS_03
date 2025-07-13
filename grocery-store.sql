
CREATE DATABASE IF NOT EXISTS grocery_store;
USE grocery_store;

DROP TABLE IF EXISTS products;

CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    image VARCHAR(100) NOT NULL,
    price INT NOT NULL,
    description VARCHAR(255)
);

INSERT INTO products (name, image, price, description) VALUES
('Apple', 'apple.jpg', 50, 'Fresh and juicy apples'),
('Banana', 'banana.jpg', 30, 'Sweet ripe bananas'),
('Tomato', 'tomato.jpg', 20, 'Organic red tomatoes'),
('Milk', 'milk.jpg', 60, 'Farm-fresh pure milk'),
('Onion', 'onion.jpg', 25, 'Crisp, clean onions'),
('Potato', 'potato.jpg', 18, 'Best for fries & curry'),
('Orange', 'orange.jpg', 45, 'Sweet juicy oranges'),
('Cabbage', 'cabbage.jpg', 22, 'Fresh green cabbage'),
('Rice', 'rice.jpg', 70, 'Long grain basmati rice'),
('Oil', 'oil.jpg', 120, 'Refined sunflower cooking oil');
