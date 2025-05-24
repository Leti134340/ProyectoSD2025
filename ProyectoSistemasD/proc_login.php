<?php
    require_once 'conex.php';

    session_start();

    if(!isset($_POST['txtNombUsuario'], $_POST['txtContrasenia']) ||
        empty(trim($_POST['txtNombUsuario'])) || empty(($_POST['txtContrasenia']))){
            echo '<script>alert("Por favor, ingrese los datos completos"); window.location.href="inicio_sesion.php";</script>';
            exit();
        }

    $usuario = trim($_POST['txtNombUsuario']);
    $contrasenia = $_POST['txtContrasenia'];

    $pdo = ConectarBD();

    $sql = "SELECT userid, usuario, contrasenia FROM usuarios WHERE usuario = :usuario";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['usuario' => $usuario]);
    $userData = $stmt->fetch();

    if($userData['usuario'] && $userData['contrasenia'] === $contrasenia){
        $_SESSION['usuario'] = $userData['usuario'];
        $_SESSION['userid'] = $userData['userid'];
        echo "<script>alert('Inicio de sesión correcto. Bienvenido usuario: {$userData['usuario']}.'); window.location.href='bienvenida.php';</script>";
        exit();
    }else{
        echo "<script>alert('Usuario o contraseña incorrectos.'); window.location.href='inicio_sesion.php';</script>";
        exit();
    }
?>