<?php

namespace Controller;

use Model\Servicio;
Use MVC\Router;

class ServicioController {
    public static function index(Router $router) {
        session_start();
        if(!$_SESSION['login'])
            return header('Location: /');

        if(!$_SESSION['admin'])
            return header('Location: /');

        $servicios = Servicio::todos();
        
        $router->render('servicios/index', [
            'titulo' => 'Servicios',
            'descripcion' => 'Administracion de Servicios',
            'path' => '/servicios',
            'nombre' => $_SESSION['nombre'],
            'servicios' => $servicios
        ]);
    }

    public static function crear(Router $router) {
        session_start();
        if(!$_SESSION['login'])
            return header('Location: /');

        if(!$_SESSION['admin'])
            return header('Location: /');
        $servicio = new Servicio();
        $errores = [];
        $exito = null;
        $mensaje = null;
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $servicio->sincronizar($_POST);
            $errores = $servicio->validar();

            if(!count($errores)) {
                try {
                    $servicio->guardar();
                    $exito = true;
                    $mensaje = 'Servicio creado correctamente';
                    $servicio->resetar();
                } catch (\Throwable $th) {
                    $exito = false;
                    $mensaje = 'Algo salio mal, intente de nuevo';
                }
            }
        }
        
        $router->render('servicios/crear', [
            'titulo' => 'Servicios',
            'descripcion' => 'Llena todos los campos para crear un nuevo servicio',
            'path' => '/servicios/crear',
            'nombre' => $_SESSION['nombre'],
            'servicio' => $servicio,
            'errores' => $errores,
            'exito' => $exito,
            'mensaje' => $mensaje
        ]); 
    }

    public static function actualizar(Router $router) {
        session_start();
        if(!$_SESSION['login'])
            return header('Location: /');

        if(!$_SESSION['admin'])
            return header('Location: /');
        $id = $_GET['id'];
        $servicio = Servicio::encontrarPorID($id);

        $errores = [];
        $exito = null;
        $mensaje = null;
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $servicio->sincronizar($_POST);
            $errores = $servicio->validar(true);
            if(!count($errores)) {
                try {
                    $servicio->guardar();
                    $exito = true;
                    $mensaje = 'Servicio actualizado correctamente';
                } catch (\Throwable $th) {
                    $exito = false;
                    $mensaje = 'Algo salio mal, intente de nuevo';
                }
            }
        }
        
        $router->render('servicios/actualizar', [
            'titulo' => 'Actualizar servicio',
            'descripcion' => 'Llena el formulario para actualizar',
            'path' => '/servicios',
            'nombre' => $_SESSION['nombre'],
            'servicio' => $servicio,
            'exito' => $exito,
            'mensaje' => $mensaje,
            'errores' => $errores
        ]);
    }

    public static function eliminar(Router $router) {
        session_start();
        if(!$_SESSION['login'])
            return header('Location: /');

        if(!$_SESSION['admin'])
            return header('Location: /');
        $id = $_POST['id'];
        $servicio = Servicio::encontrarPorID($id);
        
        if($servicio)
            $servicio->borrar();

        header('Location: /servicios');
    }
}