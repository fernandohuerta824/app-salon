<form class="formulario" action="/crear-cuenta" method="post">
    <?php include __DIR__ . '/../template/mensaje.php' ?>


    <?php if(isset($errores['nombre'])) : ?>
        <p class="alerta error"><?php echo $errores['nombre'] ?></p>
    <?php endif ?>
    <div class="campo">
        <label for="nombre">Nombre: </label>
        <input 
            type="text"
            name="nombre"
            id="nombre"
            placeholder="Esribe Tu Nombre"
            value="<?php echo s($usuario->getNombre()) ?>"
        >
    </div>

    <?php if(isset($errores['apellido'])) : ?>
        <p class="alerta error"><?php echo $errores['apellido'] ?></p>
    <?php endif ?>
    <div class="campo">
        <label for="apellido">Apellido: </label>
        <input 
            type="text"
            name="apellido"
            id="apellido"
            placeholder="Esribe Tu Apellido"
            value="<?php echo s($usuario->getApellido()) ?>"
        >
    </div>

    <?php if(isset($errores['telefono'])) : ?>
        <p class="alerta error"><?php echo $errores['telefono'] ?></p>
    <?php endif ?>
    <div class="campo">
        <label for="telefono">Telefono: </label>
        <input 
            type="tel"
            name="telefono"
            id="telefono"
            placeholder="Esribe Tu Telefono"
            value="<?php echo s($usuario->getTelefono()) ?>"
        >
    </div>
    
    <?php if(isset($errores['email'])) : ?>
        <p class="alerta error"><?php echo $errores['email'] ?></p>
    <?php endif ?>
    <div class="campo">
        <label for="email">Email: </label>
        <input 
            type="email"
            name="email"
            id="email"
            placeholder="Esribe Tu Email"
            value="<?php echo s($usuario->getEmail()) ?>"
        >
    </div>

    <?php if(isset($errores['password'])) : ?>
        <p class="alerta error"><?php echo $errores['password'] ?></p>
    <?php endif ?>
    <div class="campo">
        <label for="password">Contraseña: </label>
        <input 
            type="password"
            name="password"
            id="password"
            placeholder="Esribe Tu Contraseña"
        >
    </div>

    <input type="submit" class="boton" value="Crear Cuenta">
</form>

<div class="acciones">
    <a href="/">Iniciar Sesion</a>
    <a href="/olvide">Recuperar contraseña</a>
</div>