<?php

namespace Controller;

use MVC\Router;

class LoginController {
    public static function login(Router $router) {
        $router->render('', ['titulo' => 'Login']);
    }

    public static function logout(Router $router) {
        $router->render('', ['titulo' => 'Logout']);
    }

    public static function olvide(Router $router) {
        $router->render('', ['titulo' => 'Olvidar Contraseña']);
    }

    public static function recuperar(Router $router) {
        $router->render('', ['titulo' => 'Recuperar Contraseña']);
    }

    public static function crearCuenta(Router $router) {
        $router->render('', ['titulo' => 'Crear Cuenta']);
    }
}