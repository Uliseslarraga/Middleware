-- Creamos la base de datos
CREATE TABLE users(id serial PRIMARY KEY, nombre text, apellidos text);

CREATE TABLE tasks(id serial PRIMARY KEY, nombre text, descripcion text, fecha date, FOREIGN KEY(id_user) REFERENCES users (id));