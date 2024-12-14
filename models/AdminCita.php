<?php 

namespace Model;

class AdminCita extends ActiveRecord{ 
    protected static string $tabla = 'citas_servicios';
    protected static array $columnas = ['hora', 'nombre', 'email', 'telefono', 'servicio', 'precio'];

    public string $hora;
    public string $nombre;
    public string $email;
    public string $telefono;
    public string $servicio;
    public float $precio;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? 0;
        $this->hora = $args['hora'] ?? '';
        $this->nombre = $args['nombre'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
        $this->servicio = $args['servicio'] ?? '';
        $this->precio = $args['precio'] ?? 0.0;

    }

}