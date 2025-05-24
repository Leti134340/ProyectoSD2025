<!DOCTYPE html>
<html>
    <head>
        <meta content="text/html; charset=utf-8" http-equiv="content-type">
        <link rel="stylesheet" href="Styles.css" type="text/css">
        <title>Inicio de sesion</title>
    </head>
    <body>
    <header>
            <div class="fila"><img src="iconos/logo_trashy1.png" class="logo" id="logo"> 
                <span class="titulo-header">Inicio de sesión</span>
            </div>

            <nav>
                <a href="inicio.php">Inicio</a>
                <a href="#">Puntos</a>
                <a href="registro_usuario.php">Registro</a>
            </nav>
        </header>

        
        <div class="contenedor-principal">
        <div class="frm1">
        <form action="proc_login.php" method="post">
            <label for="txtNombUsuario">Nombre de usuario:</label>
            <input type="text" id="txtNombUsuario" name="txtNombUsuario" maxlength="30" required>
            <label for="txtContrasenia">Contraseña:</label>
            <input type="password" name="txtContrasenia" id="txtContrasenia" maxlength="10" required>
            <button type="submit">Iniciar Sesión</button>
        </form>
        </div>
        </div>
        <script src="javas.js">
        </script>
    </body>
</html>