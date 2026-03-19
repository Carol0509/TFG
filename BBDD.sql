DELETE DATABASE IF EXISTS relax_corp_games:
CREATE DATABASE IF NOT EXISTS relax_corp_games;
USE relax_corp_games;


-- CREACION DE TABLAS DE LA BASE DE DATOS --

-- Tabla de usuarios --
CREATE TABLE users (
    id INT AUTO_INCREMENT UNSIGNED PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT NOW(),
    is_admin BOOLEAN DEFAULT FALSE
);

-- Tabla de resultados --

CREATE TABLE scores (
    id INT AUTO_INCREMENT UNSIGNED PRIMARY KEY,
    user_id INT NOT NULL,
    game_id INT NOT NULL,
    score INT NOT NULL,
    created_at TIMESTAMP DEFAULT NOW(),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
 -- Tabla de juegos --
CREATE TABLE games (
    id INT AUTO_INCREMENT UNSIGNED PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE,
    description TEXT,
    created_at TIMESTAMP DEFAULT NOW(),
    FOREIGN KEY (id) REFERENCES scores(game_id) ON DELETE CASCADE
);


-- CREACION DEL USUARIO ADMINISTRADOR Y OTORGACION DE PERMISOS --

CREATE USER 'admin'@'*' IDENTIFIED BY 'contraseña';
GRANT ALL PRIVILEGES ON relax_corp_games.* TO 'admin'@'*';
FLUSH PRIVILEGES;
INSERT INTO users (username, password, is_admin) VALUES ('admin', 'contraseña', TRUE);


