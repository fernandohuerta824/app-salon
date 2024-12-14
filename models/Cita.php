<?php 

namespace Model;
date_default_timezone_set('America/Mexico_City');
use DateTime;
class Cita extends ActiveRecord{
    protected static string $tabla = 'citas';

    protected static array $columnas = ['fecha', 'hora', 'usuarioId'];

    public string $fecha;
    public string $hora;
    public int $usuarioId;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? 0;
        $this->fecha = $args['fecha'] ?? '';
        $this->hora = $args['hora'] ?? '';
        $this->usuarioId = $args['usuarioId'] ?? 0;

    }

    public function validar(): array {
        $fechaObj = DateTime::createFromFormat('Y-m-d', $this->fecha);
        $horaObj = DateTime::createFromFormat('H:i', $this->hora);
        $fechaHoy = new DateTime();
        $dia = intval(!$fechaObj ? 0 : $fechaObj->format('N'));
        $hora = intval(!$horaObj ? 0 : $horaObj->format('H'));
        if(!$fechaObj || $fechaObj->format('Y-m-d') !== $this->fecha)
            self::$errores['error'] = 'Fecha no valida';
        else if($fechaObj < $fechaHoy)
            self::$errores['error'] = 'La fecha deber ser posterior al dia de hoy';
        else if($dia === 7) 
            self::$errores['error'] = 'El domingo no es un dia valido';
        else if(!$horaObj || $horaObj->format('H:i') !== $this->hora)
            self::$errores['error'] = 'Hora no valida';
        else if($dia === 6 && ($hora < 10 || $hora > 15))
            self::$errores['error'] = 'Horario no valido los sabados, horario sabados: 10:00 - 15:00';
        else if($hora < 8 || $hora > 19)
            self::$errores['error'] = 'Horario no valido entre semana, horario entre semana: 08:00 - 19:00';

        return self::$errores;
    }
}