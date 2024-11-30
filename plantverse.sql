CREATE DATABASE plantverse;

USE plantverse;

CREATE TABLE users (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(30) NOT NULL,
    email VARCHAR(50) NOT NULL,
    phone INT(20) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') NOT NULL DEFAULT 'user',
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);


CREATE TABLE IF NOT EXISTS products ( 
    product_id VARCHAR(30) PRIMARY KEY, 
    name VARCHAR(255) NOT NULL, 
    description TEXT NOT NULL, 
    price DECIMAL(10, 2) NOT NULL, 
    image_url VARCHAR(255) NOT NULL, 
    product_type VARCHAR(30) NOT NULL, 
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP );



CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    address VARCHAR(255) NOT NULL,
    country VARCHAR(100) NOT NULL,
    card_info VARCHAR(19) NOT NULL,
    card_expiry VARCHAR(5) NOT NULL,
    card_cvc VARCHAR(3) NOT NULL,
    total DECIMAL(10, 2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id)
);