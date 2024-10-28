<?php

include '../Scripts/cabezera.php';
require '../inicioSesion/conexion.php';

session_start();

if ($_SESSION['perfil'] !== 'medico') {
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

// Obtener el ID del médico de la sesión
$id_medico = $_SESSION['id_medico']; // Suponiendo que has guardado el ID del médico en la sesión

$stmt = $pdo->prepare("
    SELECT c.id_cita, c.fechaCita, c.tipo_cita, p.nombre AS nombre_paciente 
    FROM Cita c 
    LEFT JOIN pacientes p ON c.id_paciente = p.id_paciente 
    WHERE c.id_medico = :id_medico AND c.tipo_cita != 'transporte' 
");
$stmt->execute(['id_medico' => $id_medico]);

$citas = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Crear un array de eventos para FullCalendar
$eventos = [];
foreach ($citas as $cita) {
    $eventos[] = [
        'id' => $cita['id_cita'],
        'title' => $cita['nombre_paciente'],
        'start' => $cita['fechaCita'],
        'type' => $cita['tipo_cita'],
    ];
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendario de Citas del Médico</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.11.3/main.min.css" />
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }

        #calendar {
            max-width: 900px;
            margin: 0 auto;
        }
    </style>
</head>

<body>
    <div id="calendar"></div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.11.3/main.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: <?php echo json_encode($eventos); ?>,
                eventClick: function (info) {
                    alert('Cita: ' + info.event.title + '\nTipo: ' + info.event.extendedProps.type);
                },
                dateClick: function (info) {
                    alert('Fecha seleccionada: ' + info.dateStr);
                }
            });
            calendar.render();
        });
    </script>
</body>

</html>