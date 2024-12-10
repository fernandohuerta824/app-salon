<?php

namespace Model;

class Usuario extends ActiveRecord {
    protected static string $tabla = 'usuarios';

    protected static array $columnas = ['nombre', 'apellido', 'email', 'password', 'telefono', 'admin', 'token', 'creado_en', 'confirmado'];

    protected string $nombre;
    protected string $apellido;
    protected string $email;
    protected string $password;
    protected string $telefono;
    protected int $admin;
    protected string $token;
    protected string $creado_en;
    protected int $confirmado;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? 0;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
        $this->admin = $args['admin'] ?? 0;
        $this->token = $args['token'] ?? '';
        $this->creado_en = $args['creado_en'] ?? date('Y-m-d H:i:s');
        $this->confirmado = $args['confirmado'] ?? 0; 
    }

    public function validarNuevoUsuario(): array {
        if(!$this->nombre)
            self::$errores['nombre'] = 'El nombre es obligatorio';

        if(strlen($this->nombre) > 60)
            self::$errores['nombre'] = 'El nombre debe tener menos de 60 caracteres';

        if(!$this->apellido)
            self::$errores['apellido'] = 'El apellido es obligatorio';

        if(strlen($this->apellido) > 60)
            self::$errores['apellido'] = 'El apellido es debe tener menos de 60 caracteres';   
        
        if (!preg_match('/^\d{10}$/', $this->telefono))
            self::$errores['telefono'] = 'El telefono debe ser valido';    

        if($this->where('telefono', $this->telefono))
            self::$errores['telefono'] = 'El telefono ya esta registrado';   

        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL))
            self::$errores['email'] = 'El email debe ser valido'; 
        
        if($this->where('email', $this->email))
            self::$errores['email'] = 'El email ya esta registrado'; 

        if(strlen($this->password) < 8)
            self::$errores['password'] = 'La contraseña debe tener al menos 8 caracteres';  
        return self::$errores;
    }

    public function hashPassword() {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    public function crearToken() {
        $this->token = uniqid(rand());
    }

    public function getNombre(): string {
        return $this->nombre;
    }

    public function setNombre(string $nombre): void {
        $this->nombre = $nombre;
    }

    public function getApellido(): string {
        return $this->apellido;
    }

    public function setApellido(string $apellido): void {
        $this->apellido = $apellido;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function setEmail(string $email): void {
        $this->email = $email;
    }

    public function getPassword(): string {
        return $this->password;
    }

    public function setPassword(string $password): void {
        $this->password = $password;
    }

    public function getTelefono(): string {
        return $this->telefono;
    }

    public function setTelefono(string $telefono): void {
        $this->telefono = $telefono;
    }

    public function getAdmin(): bool {
        return $this->admin;
    }

    public function setAdmin(bool $admin): void {
        $this->admin = $admin;
    }

    public function getToken(): string {
        return $this->token;
    }

    public function setToken(string $token): void {
        $this->token = $token;
    }

    public function getCreadoEn(): string {
        return $this->creado_en;
    }

    public function setCreadoEn(string $creado_en): void {
        $this->creado_en = $creado_en;
    }

    public function getConfirmado(): bool {
        return $this->confirmado;
    }

    public function setConfirmado(bool $confirmado): void {
        $this->confirmado = $confirmado;
    }

    

}