<?php include __DIR__ . '/../template/barra.php' ?>
<?php
    date_default_timezone_set('America/Mexico_City');
?>

<h2>Buscar Citas</h2>
<div class="busqueda">
    <form action="" class="formulario">
        <div class="campo">
            <label for="fecha">Fecha: </label>
            <input 
                type="date"
                id="fecha"
                name="fecha"
                value="<?php echo $fecha?>"
            >
        </div>
    </form>
</div>

<div id="citas-admin">
    <ul class="citas">
        <?php $total = $idCita = 0; foreach($citas as $key => $cita): ?>
            <?php if($idCita !== $cita->id): $idCita = $cita->id?>
                <li>
                    <p>Nombre: <span><?php echo $cita->nombre ?></span></p>
                    <p>Hora: <span><?php echo $cita->hora ?></span></p>
                    <p>Email: <span><?php echo $cita->email ?></span></p>
                    <p>Telefono: <span><?php echo $cita->telefono ?></span></p>
                    <h3>Servicios</h3>
            <?php endif ?>
            <p class="servicio"><?php echo $cita->servicio . " $" . $cita->precio ?></p>
            <?php
                $total += $cita->precio;
                $actual = $cita->id;
                $proximo = $citas[$key + 1]->id ?? 0;

                if($actual !== $proximo) : ?>
                    <p>Total: <span>$<?php echo $total ?></span></p>
                    <form action="/api/eliminar" method="post">
                        <input type="hidden" name="id" value="<?php echo $cita->id ?>">
                        <input type="submit" class="boton" value="Eliminar">
                    </form>
                    
                <?php $total = 0; endif ?>
        <?php endforeach ?>
        
    </ul>
</div>


<?php 
    $script = "<script src='build/js/buscador.js'></script>"
?>