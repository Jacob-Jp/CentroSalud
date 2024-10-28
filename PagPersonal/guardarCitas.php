<?php
include '../CabezeraPersonal/cabezera.php';
require '../inicioSesion/conexion.php';

$conexion = new conexion();
$pdo = $conexion->conectar();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $tipoCita = $_POST['tipo-cita'];
  $idPaciente = $_POST['id_paciente'];
  $fechaCita = $_POST['fecha_cita'];
  $idMedico = $_POST['id_medico'] ?? null;

  $stmtCita = $pdo->prepare("INSERT INTO Cita (id_paciente, id_medico, fechaCita, tipo_cita) VALUES (?, ?, ?, ?)");
  $stmtCita->execute([$idPaciente, $idMedico, $fechaCita, $tipoCita]);

  $idCita = $pdo->lastInsertId();

  if ($tipoCita === 'consulta') {
    $motivo = $_POST['motivo'];
    $stmtConsulta = $pdo->prepare("INSERT INTO Consulta (id_cita, motivo) VALUES (?, ?)");
    $stmtConsulta->execute([$idCita, $motivo]);
  } elseif ($tipoCita === 'analisis') {
    $tipoAnalisis = $_POST['tipo_analisis'];
    $stmtAnalisis = $pdo->prepare("INSERT INTO Analisis (id_cita, tipo_analisis) VALUES (?, ?)");
    $stmtAnalisis->execute([$idCita, $tipoAnalisis]);
  } elseif ($tipoCita === 'transporte') {
    $destino = $_POST['destino'];
    $horaSalida = $_POST['hora_salida'];
    $stmtTransporte = $pdo->prepare("INSERT INTO Transporte (id_cita, destino, hora_salida) VALUES (?, ?, ?)");
    $stmtTransporte->execute([$idCita, $destino, $horaSalida]);
  }

  echo "<script>alert('Cita registrada correctamente');</script>";
}
?>