<?php

namespace Controller;

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
}