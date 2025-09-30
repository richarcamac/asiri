<?php

header('Content-type: application/json');

require_once 'helpers/misc.php';

require_once 'vendor/autoload.php';

require_once "controladores/rutas.controlador.php";
require_once "controladores/usuarios.controlador.php";
require_once "controladores/productos.controlador.php";
require_once "controladores/compras.controlador.php";


require_once "modelos/usuarios.modelo.php";
require_once "modelos/productos.modelo.php";
require_once "modelos/compras.modelo.php";

$rutas = new ControladorRutas();
$rutas -> index();