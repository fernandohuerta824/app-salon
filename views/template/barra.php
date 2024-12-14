<div class="barra">
    <p>Hola: <?php echo $nombre ?></p>
    <a href="/logout" class="boton">Cerrar Sesion</a>
</div>

<?php if($_SESSION['admin']) :?>
    <div class="barra-servicios">
        <a class="boton<?php echo $path === '/admin' ? ' actual' : '' ?>" href="/admin">Ver citas</a>
        <a class="boton<?php echo $path === '/servicios' ? ' actual' : '' ?>" href="/servicios">Ver servicios</a>
        <a class="boton<?php echo $path === '/servicios/crear' ? ' actual' : '' ?>" href="/servicios/crear">Nuevo servicio</a>
    </div>
<?php endif ?>