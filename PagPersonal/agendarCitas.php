<?php
include '../CabezeraPersonal/cabezera.php';
require '../inicioSesion/conexion.php';

session_start();

if ($_SESSION['perfil'] !== 'secretaria') {
    echo "<script>
            alert('Acceso denegado. No tienes permiso para acceder a esta página. Inicia Sesion de nuevo');
            window.location.href = '/CentroSalud/inicioSesion/login.php'; // Redirigir a la página principal del médico
          </script>";
    exit();
}

$conexion = new conexion();
$pdo = $conexion->conectar();


$pacientes = $pdo->query("SELECT id_paciente, nombre FROM Pacientes")->fetchAll(PDO::FETCH_ASSOC);
$medicos = $pdo->query("SELECT id_medico, nombre FROM Medico")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendar Citas</title>
    <link rel="stylesheet" href="/CentroSalud/styles/stylesC.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <script>
        function mostrarFormulario() {
            const tipoCita = document.getElementById('tipo-cita').value;
            const formularios = document.querySelectorAll('.formulario');
            formularios.forEach(formulario => {
                formulario.style.display = 'none';
            });
            if (tipoCita) {
                document.getElementById(tipoCita).style.display = 'block';
            }
        }
    </script>
</head>

<body>
    <div class="contenedor-citas">
        <h1 class="citas">Agendar Citas</h1>
        <label for="tipo-cita">Selecciona el tipo de cita:</label>
        <select id="tipo-cita" name="tipo-cita" onchange="mostrarFormulario()">
            <option value="">Seleccione</option>
            <option value="cita-consulta">Cita Consulta</option>
            <option value="cita-analisis">Cita Análisis</option>
            <option value="cita-transporte">Cita Transporte</option>
        </select>

        <form id="cita-consulta" class="formulario" method="POST" action="/CentroSalud/PagPersonal/guardarCitas.php"
            style="display:none;">
            <input type="hidden" name="tipo-cita" value="consulta">
            <h2>Cita Consulta</h2>
            <label for="paciente-consulta">Paciente:</label>
            <select id="paciente-consulta" name="id_paciente" required>
                <option value="">Seleccione</option>
                <?php foreach ($pacientes as $paciente) { ?>
                    <option value="<?= $paciente['id_paciente'] ?>"><?= $paciente['nombre'] ?></option>
                <?php } ?>
            </select><br>
            <label for="medico-consulta">Médico:</label>
            <select id="medico-consulta" name="id_medico" required>
                <option value="">Seleccione</option>
                <?php foreach ($medicos as $medico) { ?>
                    <option value="<?= $medico['id_medico'] ?>"><?= $medico['nombre'] ?></option>
                <?php } ?>
            </select><br>
            <label for="fecha-consulta">Fecha de Cita:</label>
            <input type="date" id="fecha-consulta" name="fecha_cita" required><br>
            <label for="motivo">Motivo:</label>
            <input type="text" id="motivo" name="motivo" required><br>
            <input type="submit" value="Guardar">
        </form>

        <form id="cita-analisis" class="formulario" method="POST" action="/CentroSalud/PagPersonal/guardarCitas.php"
            style="display:none;">
            <input type="hidden" name="tipo-cita" value="analisis">
            <h2>Cita Análisis</h2>
            <label for="paciente-analisis">Paciente:</label>
            <select id="paciente-analisis" name="id_paciente" required>
                <option value="">Seleccione</option>
                <?php foreach ($pacientes as $paciente) { ?>
                    <option value="<?= $paciente['id_paciente'] ?>"><?= $paciente['nombre'] ?></option>
                <?php } ?>
            </select><br>
            <label for="fecha-analisis">Fecha de Cita:</label>
            <input type="date" id="fecha-analisis" name="fecha_cita" required><br>
            <label for="tipo-analisis">Tipo de Análisis:</label>
            <input type="text" id="tipo-analisis" name="tipo_analisis" required><br>
            <input type="submit" value="Guardar">
        </form>

        <form id="cita-transporte" class="formulario" method="POST" action="/CentroSalud/PagPersonal/guardarCitas.php"
            style="display:none;">
            <input type="hidden" name="tipo-cita" value="transporte">
            <h2>Cita Transporte</h2>
            <label for="paciente-transporte">Paciente:</label>
            <select id="paciente-transporte" name="id_paciente" required>
                <option value="">Seleccione</option>
                <?php foreach ($pacientes as $paciente) { ?>
                    <option value="<?= $paciente['id_paciente'] ?>"><?= $paciente['nombre'] ?></option>
                <?php } ?>
            </select><br>
            <label for="destino">Destino:</label>
            <input type="text" id="destino" name="destino" required><br>
            <label for="hora_salida">Hora de Salida:</label>
            <input type="time" id="hora_salida" name="hora_salida" required><br>
            <input type="submit" value="Guardar">
        </form>
    </div>
</body>

</html>