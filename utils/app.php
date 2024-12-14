<?php

use Model\ActiveRecord as ActiveRecord;
require __DIR__ . '/../vendor/autoload.php';
require 'config/database.php';
require 'funciones.php';
$doten = Dotenv\Dotenv::createImmutable(__DIR__);
$doten->safeLoad();


ActiveRecord::setDB(conectarDB(
    $_ENV['DB_HOST'], 
    $_ENV['DB_USER'], 
    $_ENV['DB_PASSWORD'], 
    $_ENV['DB_NAME'], 
    intval($_ENV['DB_PORT'])
));