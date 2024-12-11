<?php

namespace Controller;

use Classes\Email;
use Model\Usuario;
use MVC\Router;

class LoginController {
    private static function redireccionar() {
        if($_SESSION['admin']){
            header('Location: /admin');
        } else {
            header('Location: /cita');
        }
    }

    public static function login(Router $router) {
        session_start();
        if($_SESSION['login']) {
            return static::redireccionar();
        }
        $auth = new Usuario();
        $exito = null;
        $mensaje = null;
        $errores = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth->sincronizar($_POST);
            $errores = $auth->validarDatosLogin();
            
            if(!count($errores)) {
                $usuario = Usuario::where('email', $_POST['email']);
                
                
                if(!$usuario || !$usuario->comprobarAcceso($auth->getPassword())) {
                    $mensaje = 'Email o contraseña incorrectos, o cuenta no confirmada (revisa tu email)';
                    $exito = false;
                } else {
                    session_start();
                    $_SESSION['id'] = $usuario->getId();
                    $_SESSION['nombre'] = $usuario->getNombre();
                    $_SESSION['email'] = $usuario->getEmail();
                    $_SESSION['login'] = true;
                    $_SESSION['admin'] = $usuario->getAdmin();

                    static::redireccionar();
                }
            }
        }

        $router->render('auth/login', [
            'titulo' => 'Login',
            'descripcion' => 'Inicia Sesion con tus datos',
            'usuario' => $auth,
            'exito' => $exito,
            'mensaje' => $mensaje,
            'errores' => $errores
        ]);
    }

    public static function logout(Router $router) {
        session_start();
        if(!$_SESSION['login']) {
            return static::redireccionar();
        }
        $router->render('', ['titulo' => 'Logout']);
    }

    public static function olvide(Router $router) {
        session_start();
        if($_SESSION['login']) {
            return static::redireccionar();
        }

        $auth = new Usuario();
        $errores = [];
        $mensaje = null;
        $exito = null;
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth->sincronizar($_POST);
            $errores = $auth->validarEmail();

            if(!count($errores)) {
                try {
                    $usuario = Usuario::where('email', $auth->getEmail());
                    $exito = true;
                    $mensaje = 'Si el email existe en nuestros registros y la cuenta esta confirmada, recibirás un enlace a tu email para restablecer tu contraseña';
                    if($usuario && $usuario->getConfirmado()) {
                       $usuario->crearToken();
                       $usuario->guardar();
                       
                       $email = new Email($usuario->getEmail(), $usuario->getNombre() . ' ' . $usuario->getApellido(), $usuario->getToken());
                       $email->enviarRecuperarPass();
                    }
                } catch (\Throwable $th) {
                    $exito = false;
                    $mensaje = 'Algo salio mal, intente de nuevo, si el problema persiste contacte a soporte';
                }

                
            }
        }

        $router->render('auth/olvide', [
            'titulo' => 'Olvidar Contraseña',
            'descripcion' => 'Ingresa tu correo para mandarte instrucciones',
            'errores' => $errores,
            'email' => $auth->getEmail(),
            'exito' => $exito,
            'mensaje' => $mensaje
        ]);
    }

    public static function recuperar(Router $router) {
        session_start();
        if($_SESSION['login']) {
            return static::redireccionar();
        }
        $router->render('', ['titulo' => 'Recuperar Contraseña']);
    }

    public static function crearCuenta(Router $router) {
        session_start();
        if($_SESSION['login']) {
            return static::redireccionar();
        }
        $usuario = new Usuario();
        $errores = [];
        $mensaje = '';
        $exito = null;
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario->sincronizar($_POST);

            $errores = $usuario->validarNuevoUsuario();
            
            if(!count($errores)) {
                $resultado = null;
                $usuario->hashPassword();
                $usuario->crearToken();
                try {
                    $resultado = $usuario->guardar();
                } catch (\Throwable $th) {
                    debug($th);
                    $exito = false;
                    $mensaje= 'Algo salio mal, intente de nuevo, si el error persiste contacte a soporte';
                }

                if($resultado) {
                    $email = new Email($usuario->getEmail(), $usuario->getNombre() . ' ' . $usuario->getApellido(), $usuario->getToken());
                    try {
                        $email->enviarConfirmacion();
                        $mensaje= 'Cuenta creada correctamente';
                        $usuario->resetar();
                        $exito = true;
                    } catch (\Throwable $th) {
                        $borrarUsuario = Usuario::where('email', $_POST['email']);
                        $borrarUsuario->borrar();
                        $exito = false;
                        $mensaje= 'Algo salio mal, intente de nuevo, si el error persiste contacte a soporte';
                    }
                       
                }
            }
            
        }

        $router->render('auth/crear-cuenta', [
            'titulo' => 'Crear Cuenta',
            'descripcion' => $exito ? 'Hemos enviado instrucciones a tu email ' . $_POST['email'] : 'Llena los datos para crear una nueva cuenta',
            'usuario' => $usuario,
            'errores' => $errores,
            'mensaje' => $mensaje,
            'exito' => $exito
        ]);
    }

    public static function confirmarCuenta(Router $router) {
        session_start();
        if($_SESSION['login']) {
            return static::redireccionar();
        }
        $token = s($_GET['token']) ? ($_GET['token']) :  'cualquierCosa';
        $usuario = Usuario::where('token', $token);
        if($usuario->getConfirmado())
            return static::redireccionar();
        $mensaje = '';
        $exito = false;
        if($usuario) {
            $usuario->setToken('');
            $usuario->setConfirmado(1);
            try {
                $usuario->guardar();
                $exito = true;
                $mensaje = 'Cuenta Confirmada!!!, Ya puedes iniciar sesion';
            } catch (\Throwable $th) {

                $mensaje= 'Algo salio mal, intente de nuevo, si el error persiste contacte a soporte';
            }

        } else {
            header('Location: /');
        }
        $router->render('auth/confirmar-cuenta', [
            'titulo' => 'Confirmar Cuenta',
            'descripcion' => '',
            'mensaje' => $mensaje,
            'exito' => $exito
        ]);
    }
}