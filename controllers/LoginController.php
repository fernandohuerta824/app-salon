<?php

namespace Controller;

use MVC\Router;

class LoginController {
    public static function login(Router $router) {
        $router->render('auth/login', [
            'titulo' => 'Login',
            'descripcion' => 'Inicia Sesion con tus datos'
        ]);
    }

    public static function logout(Router $router) {
        $router->render('', ['titulo' => 'Logout']);
    }

    public static function olvide(Router $router) {
        $router->render('auth/olvide', [
            'titulo' => 'Olvidar Contraseña',
            'descripcion' => 'Ingresa tu correo para mandarte instrucciones'
        ]);
    }

    public static function recuperar(Router $router) {
        $router->render('', ['titulo' => 'Recuperar Contraseña']);
    }

    public static function crearCuenta(Router $router) {
        $router->render('auth/crear-cuenta', [
            'titulo' => 'Crear Cuenta',
            'descripcion' => 'Llena los datos para crear una nueva cuenta'
        ]);
    }
}