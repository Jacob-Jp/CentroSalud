<?php
include '../CabezeraPersonal/cabezera.php';
require '../inicioSesion/conexion.php';

$conexion = new conexion();
$pdo = $conexion->conectar();

$medicamentos = [];
$busqueda = "";

// Buscar medicamentos
if (isset($_POST['busqueda'])) {
    $busqueda = $_POST['busqueda'];
    $stmt = $pdo->prepare("SELECT * FROM medicamentos WHERE nombreMed LIKE :busqueda");
    $stmt->bindValue(':busqueda', "%$busqueda%");
    $stmt->execute();
    $medicamentos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    // Obtener todos los medicamentos
    $stmt = $pdo->query("SELECT * FROM medicamentos");
    $medicamentos = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Eliminar medicamento
if (isset($_POST['id'])) {
    $idMedicamento = $_POST['id'];
    $stmt = $pdo->prepare("DELETE FROM medicamentos WHERE id_Medicamento = :id");
    $stmt->bindValue(':id', $idMedicamento);
    $stmt->execute();
    // Redirigir a la misma página después de eliminar
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Inventario</title>
    <link rel="stylesheet" href="/CentroSalud/styles/styleInv.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>

<body>
    <div class="contenedor">
        <h1>Inventario de Medicamentos</h1>
        <form method="POST" action="">
            <input type="text" name="busqueda" placeholder="Buscar medicamento..."
                value="<?php echo htmlspecialchars($busqueda); ?>">
            <button type="submit">Buscar</button>
            <a class="consultar" href="agregarInventario.php">Agregar</a>
        </form>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Cantidad</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($medicamentos as $medicamento): ?>
                    <tr>
                        <td><?php echo $medicamento['id_Medicamento']; ?></td>
                        <td><?php echo htmlspecialchars($medicamento['nombreMed']); ?></td>
                        <td><?php echo $medicamento['cantidad']; ?></td>
                        <td>
                            <!-- Botón para Editar -->
                            <form action="agregarInventario.php" method="GET" style="display:inline;">
                                <input type="hidden" name="id" value="<?php echo $medicamento['id_Medicamento']; ?>">
                                <button type="submit">Editar</button>
                            </form>

                            <!-- Botón para Eliminar -->
                            <form action="" method="POST" style="display:inline;"
                                onsubmit="return confirm('¿Estás seguro de que deseas eliminar este medicamento?');">
                                <input type="hidden" name="id" value="<?php echo $medicamento['id_Medicamento']; ?>">
                                <button type="submit">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>