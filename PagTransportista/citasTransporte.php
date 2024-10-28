<?php
include '../CabezeraPersonal/cabezera.php';
require '../inicioSesion/conexion.php';


session_start();

if ($_SESSION['perfil'] !== 'transportista') {
  echo "<script>
            alert('Acceso denegado. No tienes permiso para acceder a esta página. Inicia Sesion de nuevo');
            window.location.href = '/CentroSalud/inicioSesion/login.php'; // Redirigir a la página principal del médico
          </script>";
  exit();
}

$conexion = new conexion();
$pdo = $conexion->conectar();

if (!$pdo) {
  die("Error en la conexión a la base de datos.");
}

// Consultar solo citas de transporte
$stmt = $pdo->query("
    SELECT c.id_cita, c.fechaCita, p.nombre AS nombre_paciente 
    FROM Cita c 
    LEFT JOIN pacientes p ON c.id_paciente = p.id_paciente 
    WHERE c.tipo_cita = 'transporte'
");

$citas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ver Citas de Transporte</title>
  <link rel="stylesheet" href="/CentroSalud/styles/styleInv.css">
</head>

<body>
  <div class="container">
    <h1>Listado de Citas de Transporte</h1>

    <table border="1">
      <thead>
        <tr>
          <th>Nombre del Paciente</th>
          <th>Fecha de Cita</th>
          <th>Completar Cita</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($citas as $cita): ?>
          <tr>
            <td><?php echo htmlspecialchars($cita['nombre_paciente']); ?></td>
            <td><?php echo htmlspecialchars($cita['fechaCita']); ?></td>
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