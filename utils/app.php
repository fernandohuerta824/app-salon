<?php

require 'config/database.php';
require 'funciones.php';

require __DIR__ . '/../vendor/autoload.php';

use Model\ActiveRecord as ActiveRecord;


ActiveRecord::setDB(conectarDB('localhost', 'root', 'cr7eselmejorjugador', 'appsalon', 3306));