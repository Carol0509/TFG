DELETE DATABASE IF EXISTS relax_corp_games:
CREATE DATABASE IF NOT EXISTS relax_corp_games;
USE relax_corp_games;


-- CREACION DE TABLAS DE LA BASE DE DATOS --

-- Tabla de usuarios --
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    is_admin BOOLEAN DEFAULT FALSE
);

-- Tabla de resultados --

CREATE TABLE scores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    game VARCHAR(50) NOT NULL,
    score INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
 -- Tabla de juegos --
CREATE TABLE games (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id) REFERENCES scores(game) ON DELETE CASCADE
);


-- CREACION DEL USUARIO ADMINISTRADOR Y OTORGACION DE PERMISOS --

CREATE USER 'admin'@'*' IDENTIFIED BY 'contraseña';
GRANT ALL PRIVILEGES ON relax_corp_games.* TO 'admin'@'*';
FLUSH PRIVILEGES;
INSERT INTO users (username, password, is_admin) VALUES ('admin', 'contraseña', TRUE);


