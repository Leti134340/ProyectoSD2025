<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: inicio_sesion.php");
    exit();
}

$userid = $_SESSION['userid'];

require_once 'conex.php';
$pdo = ConectarBD();

// Consultar el puntaje real del usuario
$sqlPuntaje = "SELECT puntos_actuales FROM usuarios WHERE userid = :userid";
$stmtPuntaje = $pdo->prepare($sqlPuntaje);
$stmtPuntaje->execute(['userid' => $userid]);
$result = $stmtPuntaje->fetch();

if ($result) {
    $puntaje = (int)$result['puntos_actuales'];
} else {
    $puntaje = 0; //El puntaje es 0 por defecto
}
// Consulta los premios que el usuario puede canjear
$sql = "SELECT nombrepremio, puntosnecesarios FROM PremiosPorPunto WHERE puntosnecesarios <= :puntaje ORDER BY puntosnecesarios ASC";
$stmt = $pdo->prepare($sql);
$stmt->execute(['puntaje' => $puntaje]);
$premios = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Bienvenida</title>
    <link rel="stylesheet" href="Styles.css" type="text/css">
</head>
<body>
    <header>
        <h2><img src="iconos/logo_trashy1.png" class="logo" id="logo"></h2>
        <nav>
            <a href="#">Puntos</a>
            <a href="#">Recompensas</a>
            <a href="inicio.php">Inicio</a>
        </nav>
    </header>

    <div class="contenedor-principal">
        <div class="sombra" style="padding: 2rem; text-align: center;">
            <h2 class="titulo">¡Bienvenido, <?php echo htmlspecialchars($_SESSION['usuario']); ?>!</h2>
            <p class="texto" style="font-size: 1.5rem;">Tu puntaje actual:</p>
            <p style="font-size: 3rem; font-weight: bold; color: #1a47b0;"><?php echo $puntaje; ?> pts</p>

            <div class="ctn2" style="margin-top: 2rem;">
                <h3 class="titulo">Recompensas que puedes canjear</h3>
                <ul class="texto" style="list-style-type: none; font-size: 1.1rem; margin: 2rem;">
                    <?php if ($premios): ?>
                        <?php foreach ($premios as $premio): ?>
                            <li>🎁 <?php echo $premio['puntosnecesarios']; ?> pts - <?php echo htmlspecialchars($premio['nombrepremio']); ?></li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li>No tienes suficientes puntos para canjear recompensas aún.</li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
</body>
</html>
