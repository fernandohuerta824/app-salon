
<?php if(isset($errores['nombre'])) : ?>
        <p class="alerta error"><?php echo $errores['nombre'] ?></p>
    <?php endif ?>
<div class="campo">
    <label for="nombre">Nombre: </label>
    <input 
        type="text"
        id="nombre"
        name="nombre"
        placeholder="Escribe el nombre del servicio"
        value="<?php echo $servicio->nombre ?>"
    >
</div>

<?php if(isset($errores['precio'])) : ?>
        <p class="alerta error"><?php echo $errores['precio'] ?></p>
<?php endif ?>
<div class="campo">
    <label for="precio">Precio: </label>
    <input 
        type="number"
        id="precio"
        name="precio"
        placeholder="Escribe el precio del servicio"
        min=1
        value="<?php echo $servicio->precio ?>"

    >
</div>