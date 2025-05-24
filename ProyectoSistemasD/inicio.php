<!DOCTYPE html>
<html>
    <head>
        <meta content="text/html; charset=utf-8" http-equiv="content-type">
        <link rel="stylesheet" href="Styles.css" type="text/css">
        <title>Inicio</title>
    </head>
    <body>
        <header>
           <div class="fila"><img src="iconos/logo_trashy1.png" class="logo" id="logo"> 
                <span class="titulo-header">¡Bienvenidos a Trashy!</span>
            </div>
            <nav>
                <a href="#puntos">Puntos</a>
                <a href="registro_usuario.php">Registro</a>
                <a href="inicio_sesion.php">Inicio de sesión</a>
            </nav>
        </header>

        <div class="ctn1">
            <h1 class="titulo"><img src="iconos/reciclaje_azul2.png" alt= "icono reciclaje" class = "icono"> Propósito <img src="iconos/reciclaje_azul2.png" class = "icono"></h1>
            <a class="texto">Fomentar la cultura del reciclaje en la comunidad universitaria 
                mediante el uso de un sistema inteligente de separación de residuos que 
                premia las buenas prácticas ambientales.<br/><br/></a>
            <h1 class="titulo"><img src="iconos/trash.png" alt= "icono reciclaje" class = "icono"> Misión <img src="iconos/trash.png" alt= "icono reciclaje" class = "icono"></h1>
            <a class="texto" >Desarrollar una solución tecnológica que facilite la correcta separación de residuos dentro del campus universitario, 
                promoviendo el cuidado del medio ambiente y generando hábitos sostenibles entre estudiantes, docentes y personal, 
                incentivando su participación con un sistema de puntos por uso responsable.<br/><br/></a>
            <h1 class="titulo"><img src="iconos/basura_azul.png" alt= "icono reciclaje" class = "icono"> Visión <img src="iconos/basura_azul.png" alt= "icono reciclaje" class = "icono"></h1>
            <a class="texto">Convertirnos en un referente de innovación ecológica en instituciones educativas, 
                logrando una universidad más limpia, 
                consciente y comprometida con el desarrollo sostenible mediante el uso de tecnología accesible y educativa.<br/><br/></a>
        </div>

       <?php
    require_once 'conex.php'; // Tu archivo de conexión con función ConectarBD()

    $pdo = ConectarBD();

    $sql = "SELECT puntosnecesarios, nombrepremio FROM PremiosPorPunto ORDER BY puntosnecesarios ASC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $premios = $stmt->fetchAll();
?>

<div class="ctn2" id="puntos">
    <h2 class="titulo">Sistema de puntos</h2>
    <p class="texto">Nuestro proyecto lleva un sistema de puntos, es decir, 
        que cuenta las veces que se utilice el basurero para obtener beneficios en el campus universitario, 
        más específicamente, descuentos y beneficios en la cafetería y en algunos casos académicos.
        A continuación, les dejamos los beneficios que ofrece este sistema: 
    </p>
    <div class="centrar">
        <table>
            <thead>
                <tr>
                    <th>No. de puntos</th>
                    <th>Beneficio</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($premios as $premio): ?>
                    <tr>
                        <td><?= htmlspecialchars($premio['puntosnecesarios']) ?></td>
                        <td><?= htmlspecialchars($premio['nombrepremio']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

        </div>
        <script type="text/javascript" src="javas.js">
        </script>
        <?php
            
        ?>
    </body>
</html>
