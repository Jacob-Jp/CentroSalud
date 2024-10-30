<?php
require '../inicioSesion/conexion.php';

$conexion = new conexion();
$pdo = $conexion->conectar();

if (!$pdo) {
  die("Error en la conexión a la base de datos.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_cita'])) {
  $id_cita = $_POST['id_cita'];

  $stmt = $pdo->prepare("DELETE FROM cita WHERE id_cita = :id_cita");
  $stmt->execute(['id_cita' => $id_cita]);

  header("Location: /CentroSalud/PagMedico/verCitas.php");
  exit();
} else {
  echo "Solicitud no válida.";
}
?>