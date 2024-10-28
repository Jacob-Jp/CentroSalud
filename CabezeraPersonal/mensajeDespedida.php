<?php
// Iniciar la sesión para acceder a la variable del nombre
session_start();

// Obtener el nombre del usuario desde la URL
$nombre = isset($_GET['nombre']) ? htmlspecialchars($_GET['nombre']) : '';

// Mensaje de despedida
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Despedida</title>
  <link rel="stylesheet" href="/CentroSalud/styles/style.css">
</head>

<body>
  <div class="mensaje-despedida">
    <h1>¡Nos vemos pronto, <?php echo $nombre; ?>!</h1>
    <p>Gracias por usar nuestro sistema. Esperamos verte de nuevo.</p>
    <a href="/CentroSalud/PagPersonal/index.html" class="btn-regresar">Regresar a Inicio</a>
  </div>
</body>

</html>