CREATE DATABASE product;
Use product
CREATE TABLE product_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    productname VARCHAR(255) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    quantity INT NOT NULL,
    image VARCHAR(2083),
    create_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    update_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP);
CREATE USER 'product' IDENTIFIED BY 'passwd123';
GRANT ALL PRIVILEGES ON product.* TO 'product';
FLUSH PRIVILEGES;
