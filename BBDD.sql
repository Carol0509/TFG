DROP DATABASE IF EXISTS relax_copr_games;
CREATE DATABASE IF NOT EXISTS relax_corp_games;
USE relax_corp_games;


-- CREACION DE TABLAS DE LA BASE DE DATOS --

-- Tabla de usuarios --
CREATE TABLE users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    is_admin TINYINT(1) NOT NULL DEFAULT 0
);

 -- Tabla de juegos --
CREATE TABLE games (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    game_name VARCHAR(50) NOT NULL UNIQUE,
    game_description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);



-- Tabla de resultados --

CREATE TABLE scores (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    game_id INT UNSIGNED NOT NULL,
    score INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (game_id) REFERENCES games(id) ON DELETE CASCADE
);


-- CREACION DEL USUARIO ADMINISTRADOR Y OTORGACION DE PERMISOS --

CREATE USER 'admin'@'*' IDENTIFIED BY 'contraseña';
GRANT ALL PRIVILEGES ON relax_corp_games.* TO 'admin'@'*';
FLUSH PRIVILEGES;
INSERT INTO users (username, password, is_admin) VALUES ('admin', 'contraseña', TRUE);


