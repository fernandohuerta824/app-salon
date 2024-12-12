<?php 

namespace Model;

class Servicio extends ActiveRecord {
    protected static string $tabla = 'servicios';

    protected static array $columnas = ['nombre', 'precio'];

    public string $nombre;
    public float $precio;

    public function __construct($args = []) {
        $this->id = intval($args['id']) ?? 0;
        $this->nombre = $args['nombre'] ?? '';
        $this->precio = floatval($args['precio']) ?? 0.0;
    }
    
}