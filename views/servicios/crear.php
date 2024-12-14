<?php include __DIR__ . '/../template/barra.php' ?>
<?php include __DIR__ . '/../template/mensaje.php' ?>
<form class="formulario" action="/servicios/crear" method="post">
    <?php include __DIR__ . '/formulario.php'; ?>

    <input type="submit" class="boton" value="Guardar Servicio">
</form>