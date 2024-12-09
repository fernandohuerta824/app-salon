<form class="formulario" action="/crear-cuenta" method="post">
    <div class="campo">
        <label for="nombre">Nombre: </label>
        <input 
            type="text"
            name="nombre"
            id="name"
            placeholder="Esribe Tu Nombre"
        >
    </div>

    <div class="campo">
        <label for="apellido">Apellido: </label>
        <input 
            type="text"
            name="apellido"
            id="apellido"
            placeholder="Esribe Tu Apellido"
        >
    </div>

    <div class="campo">
        <label for="telefono">Telefono: </label>
        <input 
            type="tel"
            name="telefono"
            id="telefono"
            placeholder="Esribe Tu Telefono"
        >
    </div>

    <div class="campo">
        <label for="email">Email: </label>
        <input 
            type="email"
            name="email"
            id="email"
            placeholder="Esribe Tu Email"
        >
    </div>

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