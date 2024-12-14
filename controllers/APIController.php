<?php

namespace Controller;

use Model\Cita;
use Model\CitasServicios;
use Model\Servicio;

class APIController {
    
    public static function index() {
        session_start();
        header('Content-Type: application/json');
        if(!$_SESSION['login']) {
            http_response_code(401);
            echo json_encode(['message' => 'Not authenticated'], JSON_UNESCAPED_UNICODE);
            exit;
        }   
        $servicios = Servicio::todos();
        http_response_code(200);
        echo json_encode($servicios, JSON_UNESCAPED_UNICODE);
    }

    public static function guardar() {
        header('Content-Type: application/json');
        try {
            session_start();
            if(!$_SESSION['login']) {
                http_response_code(401);
                echo json_encode(['data' => ['error' => 'No autenticado']], JSON_UNESCAPED_UNICODE);
                exit;
            }  

            $data = json_decode(file_get_contents('php://input'));

            $citaArgs = ['fecha' => $data->fecha, 'hora' => $data->hora, 'usuarioId' => $_SESSION['id']];

        
            $cita = new Cita($citaArgs);
            $errores = $cita->validar();
            if(count($errores) || !count($data->servicios)) { 
                http_response_code(422);
                echo json_encode(['data' => !count($errores) ? ['error' => 'Debe haber almenos un servicio'] : $errores , 'mensaje' => 'Datos no validos', 'cita' => $cita], JSON_UNESCAPED_UNICODE);
                exit;
            }
            $citaId = $cita->guardar();
            if($citaId) {
                foreach($data->servicios as $servicio) {
                    $citasServicios = new CitasServicios(['citaId' => $citaId, 'servicioId' => $servicio->id]);
                    $citasServicios->guardar();
                }
                http_response_code(201);
                echo json_encode(['data' =>['cita' => $citaId, 'exito' => 'Cita creada correctamente']], JSON_UNESCAPED_UNICODE);
                exit;
            }

            http_response_code(500);
            echo json_encode(['data' => ['error' => 'Algo salio mal']], JSON_UNESCAPED_UNICODE);
            exit;
        } catch (\Throwable $th) {
            http_response_code(500);
            echo json_encode(['data' => ['error' => 'Algo salio mal']], JSON_UNESCAPED_UNICODE);
            exit;
        }
        
    }

    public static function eliminar() {
        $id = intval($_POST['id'] )?? 0; 
        session_start();
        if(!$_SESSION['login'])
            return header('Location: /');

        if(!$_SESSION['admin'])
            return header('Location: /');
        $cita = Cita::encontrarPorID($id);
        if($cita)
            $cita->borrar();
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
}