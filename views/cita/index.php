<?php
    date_default_timezone_set('America/Mexico_City');
?>

<?php include __DIR__ . '/../template/barra.php' ?>


<div id="app">
    <nav class="tabs">
        <button class="actual" type="button" data-paso="1">Servicios</button>
        <button type="button" data-paso="2">Informacion cita</button>
        <button type="button" data-paso="3">Resumen</button>

    </nav>

    <div id="paso-1" class="seccion mostrar">
        <h2>Servicios</h2>
        <p class="text-center">Elige tus servicios a continuacion</p>
        <div id="servicios" class="listado-servicios">

        </div>
    </div>

    <div id="paso-2" class="seccion ocultar">
        <h2>Tus datos y cita</h2>
        <p class="text-center">Coloca los datos y fecha de tu cita</p>

        <form class="formulario">
            <div class="campo">
                <label for="nombre">Nombre: </label>
                <input 
                    type="text"
                    id="nombre"
                    name="nombre"
                    value="<?php echo $nombre ?>"
                    disabled
                >
            </div>

            <div class="campo">
                <label for="fecha">Fecha: </label>
                <input 
                    type="date"
                    id="fecha"
                    name="fecha"
                    min="<?php echo date('Y-m-d', strtotime('+1 day')) ?>"
                >
            </div>

            <div class="campo">
                <label for="hora">Hora: </label>
                <input 
                    type="time"
                    id="hora"
                    name="hora"
                >
            </div>
        </form>
    </div>

    <div id="paso-3" class="seccion ocultar">
        <h2>Resumen</h2>
        <p class="text-center">Verifica que la informacion sea correcta</p>

        <div class="resumen-datos"> 

        </div>
    </div>


    <div class="paginacion">
        <button class="boton ocultar" id="anterior">&laquo; Anterior</button>
        <button class="boton" id="siguiente">Siguiente &raquo;</button>

    </div>
</div>

<?php 
$script = "
    <script src='build/js/app.js'></script>
"
?>