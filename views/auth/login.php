<form class="formulario" action="/" method="post">
    <div class="campo">
        <label for="email">Email: </label>
        <input 
            type="email"
            name="email"
            id="email"
            placeholder="Ingresa tu email"
        >
    </div>

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