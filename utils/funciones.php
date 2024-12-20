<?php

function auth () {
    session_start();

    if(!isset($_SESSION['usuario'])) {
        header('Location: /');
        exit;
    }
}

function debug($variable) {
    echo '<pre>';
    var_dump($variable);
    echo '</pre>';
    exit;
}

function s($html): string {
    return htmlspecialchars($html);
}

function redireccionarRol() {
    if($_SESSION['admin']){
        header('Location: /admin');
    } else {
        header('Location: /cita');
    }
}