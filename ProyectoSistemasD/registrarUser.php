<?php
require_once 'conex.php';

if (
    !isset($_POST['txtNombUsuario'], $_POST['txtContrasenia'], $_POST['txtRepContrasenia']) ||
    empty(trim($_POST['txtNombUsuario'])) ||
    empty(trim($_POST['txtContrasenia'])) ||
    empty(trim($_POST['txtRepContrasenia']))
) {
    echo "<script>alert('Por favor, complete todos los campos.'); window.location.href='registro_usuario.php';</script>";
    exit();
}

$usuario = trim($_POST['txtNombUsuario']);
$contrasenia = trim($_POST['txtContrasenia']);
$repContrasenia = trim($_POST['txtRepContrasenia']);

if ($contrasenia !== $repContrasenia) {
    echo "<script>alert('Las contraseñas no coinciden.'); window.location.href='registro_usuario.php';</script>";
    exit();
}

$pdo = ConectarBD();

// Verificar si el nombre de usuario ya existe
$sql_check = "SELECT usuario FROM usuarios WHERE usuario = :usuario";
$stmt_check = $pdo->prepare($sql_check);
$stmt_check->execute(['usuario' => $usuario]);

if ($stmt_check->fetch()) {
    echo "<script>alert('El nombre de usuario ya está registrado.'); window.location.href='registro_usuario.php';</script>";
    exit();
}

// Insertar nuevo usuario
$sql_insert = "INSERT INTO usuarios (usuario, contrasenia) VALUES (:usuario, :contrasenia)";
$stmt_insert = $pdo->prepare($sql_insert);

if ($stmt_insert->execute(['usuario' => $usuario, 'contrasenia' => $contrasenia])) {
    echo "<script>alert('Usuario registrado exitosamente.'); window.location.href='inicio_sesion.php';</script>";
} else {
    echo "<script>alert('Error al registrar usuario.'); window.location.href='registro_usuario.php';</script>";
}
?>
