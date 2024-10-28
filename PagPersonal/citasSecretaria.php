<?php
session_start(); // Asegúrate de que las sesiones estén iniciadas
require '../inicioSesion/conexion.php';

$conexion = new conexion();
$pdo = $conexion->conectar();

if (!$pdo) {
  die("Error en la conexión a la base de datos.");
}

// Consultar todas las citas
$stmt = $pdo->query("
    SELECT c.id_cita, c.fechaCita, c.tipo_cita, p.nombre AS nombre_paciente, m.nombre AS nombre_medico 
    FROM Cita c 
    LEFT JOIN pacientes p ON c.id_paciente = p.id_paciente 
    LEFT JOIN Medico m ON c.id_medico = m.id_medico
");

$citas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ver Todas las Citas</title>
  <link rel="stylesheet" href="/CentroSalud/styles/styleInv.css">
</head>

<body>
  <div class="container">
    <h1>Listado de Todas las Citas</h1>

    <table border="1">
      <thead>
        <tr>
          <th>Nombre del Paciente</th>
          <th>Fecha de Cita</th>
          <th>Tipo de Cita</th>
          <th>Médico</th>
          <th>Completar Cita</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($citas as $cita): ?>
          <tr>
            <td><?php echo htmlspecialchars($cita['nombre_paciente']); ?></td>
            <td><?php echo htmlspecialchars($cita['fechaCita']); ?></td>
            <td><?php echo htmlspecialchars($cita['tipo_cita']); ?></td>
            <td><?php echo isset($cita['nombre_medico']) ? htmlspecialchars($cita['nombre_medico']) : 'N/A'; ?></td>
            <td>
              <form action="completarCita.php" method="post">
                <input type="hidden" name="id_cita" value="<?php echo $cita['id_cita']; ?>">
                <input type="checkbox" name="completada" value="1"> Completar
                <button type="submit">Guardar</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</body>

</html>