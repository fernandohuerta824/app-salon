<form class="formulario" action="/" method="post">
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
            placeholder="Ingresa tu email"
            value="<?php echo $usuario->getEmail(); ?>"
        >
    </div>

    <?php if(isset($errores['password'])) : ?>
        <p class="alerta error"><?php echo $errores['password'] ?></p>
    <?php endif ?>
    <div class="campo">
        <label for="password">Contraseña: </label>
        <input 
            type="password"
            id="password"
            name="password"
            placeholder="Ingresa tu contraseña"
        >
    </div>

    <input class="boton" type="submit" value="Iniciar Sesion">
</form>

<div class="acciones">
    <a href="/crear-cuenta">Crear Cuenta</a>
    <a href="/olvide">Recuperar contraseña</a>
</div>