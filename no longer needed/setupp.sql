-- Create the database
CREATE DATABASE IF NOT EXISTS school_db;
USE school_db;

-- Create teachers table
CREATE TABLE IF NOT EXISTS teachers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    phone VARCHAR(20) NOT NULL,
    address TEXT NOT NULL,
    cin VARCHAR(20) NOT NULL UNIQUE
);

