<!DOCTYPE html>
<html lang="en">
<head>
    <title>Primer Formulario</title>
</head>
<body>
<?php
$nombre = $_GET['nombre'];
$apellido = $_GET['apellido'];
$direccion = $_GET['direccion'];
$ciudad = $_GET['ciudad'];
?>
<h1>Hola <?= $nombre ?> <?= $apellido ?>
    <br>
    Dirección <?= $direccion ?>
    <br>
    Ciudad <?= $ciudad ?></h1>
</body>
</html>