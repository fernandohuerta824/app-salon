<?php

namespace Model;

class CitasServicios extends ActiveRecord {
    protected static string $tabla = 'citas_servicios';

    protected static array $columnas = ['citaId', 'servicioId'];

    public int $citaId;
    public int $servicioId;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? 0;
        $this->citaId = $args['citaId'] ?? 0;
        $this->servicioId = $args['servicioId'] ?? 0;
    }

}