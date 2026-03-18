DELETE DATABASE IF EXISTS relax_corp_games:
CREATE DATABASE IF NOT EXISTS relax_corp_games;
USE relax_corp_games;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    is_admin BOOLEAN 
);

