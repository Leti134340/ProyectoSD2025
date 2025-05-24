<!DOCTYPE html>
<html>
    <head>
        <meta content="text/html; charset=utf-8" http-equiv="content-type">
        <link rel="stylesheet" href="Styles.css" type="text/css">
        <title>Registro de Usuario</title>
    </head>
    <body>
        <header>
            <div class="fila"><img src="iconos/logo_trashy1.png" class="logo" id="logo"> 
                <span class="titulo-header">Registrar usuario</span>
            </div>
            <nav>
                <a href="inicio.php">Inicio</a>
                <a href="inicio_sesion.php">Inicio de sesión</a>
            </nav>
        </header>

        <div class="contenedor-principal">
        <div class="frm1">
        <form action="registrarUser.php" method="post">
            <label for="txtNombUsuario"> Nombre de Usuario: </label>
            <input type="text" id="txtNombUsuario" name="txtNombUsuario" maxlength="30" required>
            <label for="txtContrasenia"> Contraseña: </label>
            <input type="text" id="txtContrasenia" name="txtContrasenia" maxlength="10" minlenght="8" required>
            <label for="txtRepContrasenia"> Repita su contraseña: </label>
            <input type="text" id="txtRepContrasenia" name="txtRepContrasenia" maxlength="10" minlenght="8" required>
            <button type="submit">Registrar Usuario</button>
        </form>
        </div>
        </div>
    </body>
</html>