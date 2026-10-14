-- DROP DATABASE IF EXISTS dbventaCompu;
-- CREATE DATABASE dbventaCompu;
-- USE dbventaCompu;


-- Opcional: Limpia las tablas previas para evitar conflictos de ejecuciones antiguas
DROP TABLE IF EXISTS pedido_producto;
DROP TABLE IF EXISTS pedido;
DROP TABLE IF EXISTS proveedor_producto;
DROP TABLE IF EXISTS proveedor;
DROP TABLE IF EXISTS productos;
DROP TABLE IF EXISTS usuarios;
DROP TABLE IF EXISTS clientes;

CREATE TABLE clientes(
    id int not null PRIMARY KEY auto_increment,
    ci VARCHAR (20) not null,
    nombre VARCHAR (50) not NULL,
    apellidos VARCHAR (50) not null,
    direccion VARCHAR (250),
    telefono VARCHAR (15)
) ENGINE=InnoDB;

CREATE TABLE usuarios (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    cod_cliente INT NOT NULL UNIQUE, 
    email VARCHAR(100) NOT NULL UNIQUE, 
    password_hash VARCHAR(255) NOT NULL, 
    estado_cuenta VARCHAR(20) DEFAULT 'Activo',
    ultimo_acceso DATETIME,
    -- Nombre único para esta FK
    CONSTRAINT fk_usuario_cliente FOREIGN KEY (cod_cliente) REFERENCES clientes(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE productos(
    id int not null PRIMARY KEY auto_increment,
    codbarras VARCHAR (100) not null,
    descripcion VARCHAR (100) not NULL,
    stock INT not null CHECK(stock>=0),
    precio_unitario DECIMAL(10,2) not null
) ENGINE=InnoDB;

-- creamos la tabla proveedor
CREATE TABLE proveedor(
    id int not null PRIMARY KEY auto_increment,
    ci VARCHAR (20) not null,
    nombre VARCHAR (50) not null,
    apellidos VARCHAR (50) not NULL
) ENGINE=InnoDB;

CREATE TABLE proveedor_producto (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    cod_proveedor INT NOT NULL,
    cod_producto INT NOT NULL,
    CONSTRAINT fk_prov_prod_proveedor FOREIGN KEY (cod_proveedor) REFERENCES proveedor(id),
    CONSTRAINT fk_prov_prod_producto FOREIGN KEY (cod_producto) REFERENCES productos(id)
) ENGINE=InnoDB;

CREATE TABLE pedido(
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    cod_cliente INT NOT NULL,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Corregido para evitar errores de fecha en versiones antiguas
    estado VARCHAR(20) DEFAULT 'Pendiente',  
    -- Nombre único para esta FK para que no choque con la de usuarios
    CONSTRAINT fk_pedido_cliente FOREIGN KEY(cod_cliente) REFERENCES clientes(id)
) ENGINE=InnoDB;

CREATE TABLE pedido_producto(
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    cod_pedido INT NOT NULL,
    cod_producto INT NOT NULL,
    cantidad INT NOT NULL CHECK(cantidad > 0),
    precio_unitario DECIMAL(10,2) NOT NULL,
    descuento DECIMAL(10,2) DEFAULT 0.0, -- Corregido: Sin paréntesis
    CONSTRAINT fk_ped_prod_pedido FOREIGN KEY(cod_pedido) REFERENCES pedido(id),
    CONSTRAINT fk_ped_prod_producto FOREIGN KEY(cod_producto) REFERENCES productos(id)
) ENGINE=InnoDB;
