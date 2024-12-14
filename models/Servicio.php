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
        $this->precio = floatval($args['precio']) ?? 0;
    }
    
    public function validar(bool $isAct = false) :array {
        if(!$this->nombre)
            self::$errores['nombre'] = 'El nombre es obligatorio';
        else if(!$isAct && $this->where('nombre', $this->nombre))
            self::$errores['nombre'] = 'El servicio ya existe';
        if($this->precio < 1)
            self::$errores['precio'] = 'El precio deber ser mayor a cero';
        return self::$errores;
    }
}