<?php
include '../CabezeraPersonal/cabezera.php';
require '../inicioSesion/conexion.php';

$conexion = new conexion();
$pdo = $conexion->conectar();

// Inicializar variables
$idMedicamento = null;
$nombreMed = '';
$cantidad = '';

// Comprobar si se está editando un medicamento
if (isset($_GET['id'])) {
    $idMedicamento = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM medicamentos WHERE id_Medicamento = :id");
    $stmt->bindValue(':id', $idMedicamento);
    $stmt->execute();
    $medicamento = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($medicamento) {
        $nombreMed = $medicamento['nombreMed'];
        $cantidad = $medicamento['cantidad'];
    }
}

// Procesar el formulario de agregar/editar
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombreMed = $_POST['nombreMed'];
    $cantidad = $_POST['cantidad'];


    try {

        if ($idMedicamento) {
            // Actualizar medicamento existente
            $stmt = $pdo->prepare("UPDATE medicamentos SET nombreMed = :nombreMed, cantidad = :cantidad WHERE id_Medicamento = :id");
            $stmt->bindValue(':nombreMed', $nombreMed);
            $stmt->bindValue(':cantidad', $cantidad);
            $stmt->bindValue(':id', $idMedicamento);
            $stmt->execute();
        } else {
            // Agregar nuevo medicamento
            $stmt = $pdo->prepare("INSERT INTO medicamentos (nombreMed, cantidad) VALUES (:nombreMed, :cantidad)");
            $stmt->bindValue(':nombreMed', $nombreMed);
            $stmt->bindValue(':cantidad', $cantidad);
            $stmt->execute();
        }

    } catch (PDOException $e) {
        $mensaje = "Error: " . $e->getMessage();
    }

    // Redirigir después de agregar o editar
    header("Location: consultaInventario.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $idMedicamento ? 'Editar' : 'Agregar'; ?> Medicamento</title>
    <link rel="stylesheet" href="/CentroSalud/styles/styleInv.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>

<body>
    <div class="contenedor">
        <h1><?php echo $idMedicamento ? 'Editar' : 'Agregar'; ?> Medicamento</h1>
        <form method="POST" action="">
            <input type="text" name="nombreMed" placeholder="Nombre del Medicamento"
                value="<?php echo htmlspecialchars($nombreMed); ?>" required>
            <input type="number" name="cantidad" placeholder="Cantidad"
                value="<?php echo htmlspecialchars($cantidad); ?>" required>
            <button type="submit"><?php echo $idMedicamento ? 'Actualizar' : 'Agregar'; ?></button>
            <a class="consultar" href="consultaInventario.php">Inventario</a>
        </form>
    </div>
</body>

</html>