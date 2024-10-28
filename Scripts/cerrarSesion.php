<?php
session_start();
$nombre = $_SESSION['nombre']; // Guarda el nombre del usuario
session_destroy(); // Destruye todas las sesiones
header("Location: mensajeDespedida.php?nombre=" . urlencode($nombre)); // Redirige con el nombre
exit();
?>