<?php include __DIR__ . '/../template/barra.php' ?>

<div class="servicios">
    <?php foreach($servicios as $servicio): ?>
        <li>
            <p>Nombre: <span><?php echo $servicio->nombre ?></span></p>
            <p>Precio: <span><?php echo '$' . $servicio->precio ?></span></p>

            <div class="acciones">
                <a class="boton-actualizar" href="/servicios/actualizar?id=<?php echo $servicio->id?>">Actualizar</a>
                <form action="/servicios/eliminar" method="post">
                    <input type="hidden" name="id" value="<?php echo $servicio->id ?>">
                    <input type="submit" value="Borrar" class="boton">
                </form>
            </div>
        </li>
    <?php endforeach ?>
</div>