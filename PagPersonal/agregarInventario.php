<?php
include '../CabezeraPersonal/cabezera.php';
require '../inicioSesion/conexion.php';

$conexion = new conexion();
$pdo = $conexion->conectar();

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nombreMedicamento = $_POST['nombre-medicamento'];
    $cantidadMedicamento = $_POST['cantidad-medicamento'];

    try {

        $stmt = $pdo->prepare("INSERT INTO medicamentos (nombreMed, cantidad) VALUES (:nombreMed, :cantidad)");
        $stmt->bindParam(':nombreMed', $nombreMedicamento);
        $stmt->bindParam(':cantidad', $cantidadMedicamento);
        // Ejecutar la consulta
        $stmt->execute();

        $mensaje = "Medicamento registrado correctamente";
    } catch (PDOException $e) {
        $mensaje = "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Medicamento</title>
    <link rel="stylesheet" href="/CentroSalud/styles/styleInv.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>

<body>
    <div class="contenedor">
        <h1>Agregar Medicamento</h1>
        <?php if ($mensaje): ?>
            <script>
                alert("<?php echo $mensaje; ?>");
            </script>
        <?php endif; ?>
        <div class="apartado-agregar">
            <form class="form-inventario" id="formulario-agregar-medicamento" action="" method="POST">
                <input type="text" name="nombre-medicamento" id="nombre-medicamento"
                    placeholder="Nombre del Medicamento" required>
                <input type="number" name="cantidad-medicamento" id="cantidad-medicamento" placeholder="Cantidad"
                    required>
                <div class="div-button">
                    <button type="submit" class="btn-agregar">Agregar</button>
                    <a class="consultar" href="consultaInventario.php">Inventario</a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>