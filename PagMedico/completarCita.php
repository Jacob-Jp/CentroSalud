<?php

require '../inicioSesion/conexion.php';

$conexion = new conexion();
$pdo = $conexion->conectar();

if (!$pdo) {
  die("Error en la conexión a la base de datos.");
}

// Verificar si se recibió el ID de la cita
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_cita'])) {
  $id_cita = $_POST['id_cita'];

  // Actualizar el estado de la cita a "completada"
  $stmt = $pdo->prepare("UPDATE cita SET estado = 'completada' WHERE id_cita = :id_cita");
  $stmt->execute(['id_cita' => $id_cita]);

  // Redirigir al listado de citas después de completar
  header("Location: /CentroSalud/PagMedico/citasMedico.php");
  exit();
} else {
  echo "Solicitud no válida.";
}
?>