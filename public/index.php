<?php 

require_once '../utils/app.php';

use Controller\APIController;
use Controller\CitaController;
use MVC\Router;
use Controller\LoginController;

$router = new Router();

//Auth
$router->get('/', [LoginController::class, 'login']);
$router->post('/', [LoginController::class, 'login']);
$router->get('/logout', [LoginController::class, 'logout']);

//Recuperar contraseña
$router->get('/olvide', [LoginController::class, 'olvide']);
$router->post('/olvide', [LoginController::class, 'olvide']);
$router->get('/recuperar', [LoginController::class, 'recuperar']);
$router->post('/recuperar', [LoginController::class, 'recuperar']);

//Crear Cuentas
$router->get('/crear-cuenta', [LoginController::class, 'crearCuenta']);
$router->post('/crear-cuenta', [LoginController::class, 'crearCuenta']);

//Confirmar cuenta
$router->get('/confirmar-cuenta', [LoginController::class, 'confirmarCuenta']);

//Area privada
$router->get('/cita', [CitaController::class, 'index']);

//API de citas
$router->get('/api/servicios', [APIController::class, 'index']);
$router->post('/api/citas', [APIController::class, 'guardar']);


$router->comprobarRutas();