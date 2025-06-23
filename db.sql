CREATE DATABASE IF NOT EXISTS quote_app;
USE quote_app;
CREATE TABLE IF NOT EXISTS quotes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    quote_text TEXT NOT NULL,
    author VARCHAR(100) NOT NULL,
    category VARCHAR(50) NOT NULL,
    quote_date DATE NOT NULL
);