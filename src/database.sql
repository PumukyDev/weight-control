/* Creación de la base de datos */
CREATE DATABASE IF NOT EXISTS PesoFraya;
USE PesoFraya;

/* Tabla usuarios */
CREATE TABLE Users(
    id_user INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    surnames VARCHAR(150) NOT NULL,
    birth DATE NOT NULL
);

/* Tabla pesajes */
CREATE TABLE Pesajes(
    id_pesaje INT AUTO_INCREMENT PRIMARY KEY,
    peso FLOAT NOT NULL,
    altura FLOAT NOT NULL, -- La altura será en metros (Ej: 1.75)
    fecha DATE NOT NULL,
    id_user INT NOT NULL,
    FOREIGN KEY (id_user) REFERENCES Users(id_user)
);