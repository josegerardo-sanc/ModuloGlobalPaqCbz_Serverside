<?php
$dsn = 'mysql:dbname=local;host=localhost';
$usuario = 'root';
$contraseña = '';

try {
    $conexion_BD_PDO = new PDO($dsn, $usuario, $contraseña);
} catch (PDOException $e) {
    echo 'Falló la conexión: ' . $e->getMessage();
}
