<?php
include '../CabezeraPersonal/cabezera.php';
require '../inicioSesion/conexion.php';

$conexion = new conexion();
$pdo = $conexion->conectar();

$medicamentos = [];
$busqueda = "";


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
            <a href="agregarInventario.php">Agregar</a>
        </form>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Cantidad</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($medicamentos as $medicamento): ?>
                    <tr>
                        <td><?php echo $medicamento['id_Medicamento']; ?></td>
                        <td><?php echo htmlspecialchars($medicamento['nombreMed']); ?></td>
                        <td><?php echo $medicamento['cantidad']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>