<?php
if ($_SERVER['REQUEST_URI'] === '/') {
    include 'inicio.php';
} else {
    return false;
}
?>