<form class="formulario" action="/olvide" method="post">
    <?php include __DIR__ . '/../template/mensaje.php' ?>

    <?php if(isset($errores['email'])) : ?>
        <p class="alerta error"><?php echo $errores['email'] ?></p>
    <?php endif ?>
    <div class="campo">
            <label for="email">Email: </label>
            <input 
                type="email"
                name="email"
                id="email"
                placeholder="Escribe Tu Email"
                value="<?php echo $email?>"
            >
    </div>

    <input type="submit" class="boton" value="Enviar Correo">
</form>

<div class="acciones">
    <a href="/">Iniciar Sesion</a>
    <a href="/crear-cuenta">Crear Cuenta</a>
</div>