<?php
require_once 'conexion.php';
$nombre = "medico1";
$contrasena = "12345";


$contrasenaHasheada = password_hash($contrasena, PASSWORD_DEFAULT);

$stmt = $pdo->prepare("INSERT INTO usuarios (nombre, contrasena, perfil) VALUES (:nombre, :contrasena, :perfil)");
$stmt->execute(['nombre' => $nombre, 'contrasena' => $contrasenaHasheada, 'perfil' => 'medico']);

?>