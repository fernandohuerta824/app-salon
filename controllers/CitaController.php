<?php

namespace Controller;

use MVC\Router;

class CitaController {
    

    public static function index(Router $router) {
        session_start();
        if(!$_SESSION['login'])
            return header('Location: /');

        if($_SESSION['admin'])
            return header('Location: /admin');

        $router->render('cita/index', [
            'titulo' => 'Citas',
            'descripcion' => 'Haz tu cita',
            'nombre' => $_SESSION['nombre'] . ' ' . $_SESSION['apellido'] 
        ]);
    } 
}