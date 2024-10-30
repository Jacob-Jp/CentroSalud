<?php
session_start(); // Asegúrate de que las sesiones estén iniciadas
include '../Scripts/cabezera.php';
require '../inicioSesion/conexion.php';

$conexion = new conexion();
$pdo = $conexion->conectar();

if (!$pdo) {
  die("Error en la conexión a la base de datos.");
}

// Obtener el ID del médico de la sesión
$id_medico = $_SESSION['id_medico']; // Suponiendo que has guardado el ID del médico en la sesión

$stmt = $pdo->prepare("
    SELECT c.id_cita, c.fechaCita, c.tipo_cita, c.estado, p.nombre AS nombre_paciente 
    FROM Cita c 
    LEFT JOIN pacientes p ON c.id_paciente = p.id_paciente 
    WHERE c.id_medico = :id_medico AND c.tipo_cita != 'transporte' 
");
$stmt->execute(['id_medico' => $id_medico]);

$citas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ver Citas del Médico</title>
  <link rel="stylesheet" href="/CentroSalud/styles/styleInv.css">
</head>

<body>
  <div class="container">
    <h1>Listado de Citas del Médico</h1>

    <table border="1">
      <thead>
        <tr>
          <th>Nombre del Paciente</th>
          <th>Fecha de Cita</th>
          <th>Tipo de Cita</th>
          <th>Estado Cita</th>
          <th>Completar Cita</th>
          <th>Eliminar Cita</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($citas as $cita): ?>
          <tr>
            <td><?php echo htmlspecialchars($cita['nombre_paciente']); ?></td>
            <td><?php echo htmlspecialchars($cita['fechaCita']); ?></td>
            <td><?php echo htmlspecialchars($cita['tipo_cita']); ?></td>
            <td><?php echo htmlspecialchars($cita['estado']) ?></td>
            <td>
              <!-- Formulario para completar la cita -->
              <form action="completarCita.php" method="post">
                <input type="hidden" name="id_cita" value="<?php echo $cita['id_cita']; ?>">
                <button type="submit">Completar</button>
              </form>
            </td>
            <td>
              <!-- Formulario para eliminar la cita -->
              <form action="eliminarCita.php" method="post">
                <input type="hidden" name="id_cita" value="<?php echo $cita['id_cita']; ?>">
                <button type="submit"
                  onclick="return confirm('¿Estás seguro de que deseas eliminar esta cita?');">Eliminar</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</body>

</html>