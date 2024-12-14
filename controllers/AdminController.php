<?php 

namespace Controller;
date_default_timezone_set('America/Mexico_City');
use Model\AdminCita;
use MVC\Router;

class AdminController { 
    public static function index(Router $router) {
        session_start();
        if(!$_SESSION['login'])
            return header('Location: /');

        if(!$_SESSION['admin'])
            return header('Location: /');
        $fecha = $_GET['fecha'];

        $arrayFecha = explode('-', $fecha);

        if(count($arrayFecha) !== 3 ||!checkdate($arrayFecha[1], $arrayFecha[2], $arrayFecha[0])) $fecha = date('Y-m-d');
        $consulta = "SELECT citas.id, citas.hora, CONCAT( usuarios.nombre, ' ', usuarios.apellido) as nombre, ";
        $consulta .= " usuarios.email, usuarios.telefono, servicios.nombre as servicio, servicios.precio  ";
        $consulta .= " FROM citas  ";
        $consulta .= " LEFT OUTER JOIN usuarios ";
        $consulta .= " ON citas.usuarioId=usuarios.id  ";
        $consulta .= " LEFT OUTER JOIN citas_servicios ";
        $consulta .= " ON citas_servicios.citaId=citas.id ";
        $consulta .= " LEFT OUTER JOIN servicios ";
        $consulta .= " ON servicios.id=citas_servicios.servicioId";
        $consulta .= " WHERE fecha = '$fecha' ORDER BY hora";

        $ad = new AdminCita();
        $citas = $ad->SQL($consulta);
        
        $router->render('admin/index', [
            'titulo' => 'Admin', 
            'descripcion' => 'Administra las citas',
            'nombre' => $_SESSION['nombre'],
            'citas' => $citas,
            'fecha' => $fecha,
            'path' => '/admin'
        ]);
    }
}