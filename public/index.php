<?php
if($_SERVER['REQUEST_METHOD']=='OPTIONS')
    {
        exit;
    }
require_once "../src/Router.php";
require_once "../src/Controllers/UserController.php";
require_once "../src/Controllers/ProductoController.php";
require_once "../src/Controllers/ClienteController.php";
require_once "../src/Controllers/Pedido_productoController.php";
require_once "../src/Controllers/PedidoController.php";
require_once "../src/Controllers/Proveedor_productoController.php";
require_once "../src/Controllers/ProveedorController.php";
require_once "../src/Controllers/UsuarioController.php";

use App\Router;

$route=new Router();
//direccion para usuarios
$route->add('GET','/','UserController@getAll');
$route->add('GET','/users','UserController@getAll');

//direccion de productos
$route->add('GET','/productos','ProductoController@getAll'); 
$route->add('POST','/productos','ProductoController@add'); 
$route->add('PUT','/productos/{id}','ProductoController@update');

//direccion para clientes
$route->add('GET','/clientes','ClienteController@getAll'); 

//direccion para proveedor
$route->add('GET','/proveedor','ProveedorController@getAll');

//direccion de proveedor_producto
$route->add('GET','/proveedor_producto','Proveedor_productoController@getAll');

//direccion de pedido
$route->add('GET','/pedido','PedidoController@getAll');

//direccion de pedido_producto
$route->add('GET','/pedido_producto','Pedido_productoController@getAll');

$route->run();