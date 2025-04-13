DROP DATABASE IF EXISTS contacts_app;

CREATE DATABASE contacts_app;

USE contacts_app;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    email VARCHAR(255) UNIQUE,
    password VARCHAR(255)
);

CREATE TABLE contacts(
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    user_id INT NOT NULL,
    phone_number VARCHAR(255),
    FOREIGN KEY(user_id) REFERENCES users(id)
);

CREATE TABLE contact_address(
    id INT AUTO_INCREMENT PRIMARY KEY,
    address VARCHAR(255),
    user_id INT NOT NULL,
    FOREIGN KEY(user_id) REFERENCES contacts(id)
);

-- INSERT INTO contacts (name, phone_number) VALUES ("Pepe", "122334556");
-- INSERT INTO contacts (name, phone_number) VALUES ("Meh", "127842");
-- INSERT INTO contacts (name, phone_number) VALUES ("test", "97685");
-- INSERT INTO users (name, email, password) VALUES ("test", "test@gmail.com", 1234);
