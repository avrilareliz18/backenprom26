-- Ejercicios UNCOMPRES
SELECT apellidos,nombre,telefono
FROM clientes
ORDER BY apellidos,nombre;

-- ejercicio dos
SELECT *
FROM productos
WHERE stock<=50;

-- ejercicio 3
SELECT *
FROM empleados
WHERE apellidos like "a%"

-- cliente mas su pedidos
SELECT * FROM pedidos
SELECT c.nombre,
       c.apellidos,
        p.fecha_compra,
        p.cantidad
FROM pedidos AS p, clientes as c
WHERE c.ID = p.cod_cliente

-- otra forma
SELECT c.nombre,
       c.apellidos,
        p.fecha_compra,
        p.cantidad
FROM pedidos AS apellidos
INNER JOIN clientes c ON c.Id =  p.cod_cliente;

-- 005
SELECT e.apellidos,e.nombre, COUNT(e.Id) as TotalVendido
FROM empleados e
INNER JOIN pedidos p ON e.id=p.cod_empleado
GROUP BY e.id

SELECT e.apellidos,e.nombre, COUNT(e.Id) as TotalVendido
FROM empleados e
LEFT JOIN pedidos p ON e.id=p.cod_empleado
GROUP BY e.id

-- 006
SELECT p.cod_barras,p.descripcion,p.precio_unitario
FROM producto p
ORDER BY precio_unitario DESC;

-- 007
SELECT c.clientes,c.compras,a.apellido,f.fecha,p.pedido
FROM 