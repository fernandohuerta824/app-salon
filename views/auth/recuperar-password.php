<form class="formulario" method="POST">
    <?php include __DIR__ . '/../template/mensaje.php' ?>

    <?php if(isset($errores['password'])) : ?>
        <p class="alerta error"><?php echo $errores['password'] ?></p>
    <?php endif ?>
    <div class="campo">
        <label for="password">Contraseña: </label>
        <input 
            type="password"
            name="password"
            id="password"
            placeholder="Escribe tu nueva contraseña"
        >
    </div>
   
    <input type="submit" class="boton" value="Restablecer">
</form>

<div class="acciones">
    <a href="/">Iniciar Sesion</a>
    <a href="/crear-cuenta">Crear Cuenta</a>
</div>