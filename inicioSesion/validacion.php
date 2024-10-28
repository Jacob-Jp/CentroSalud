<?php
require_once 'conexion.php';

// Instanciar la clase y obtener la conexión
$conexion = new conexion();
$pdo = $conexion->conectar();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $nombre = $_POST['Nombre'];
  $contrasena = $_POST['Contra'];
  $perfilSeleccionado = $_POST['perfil'];

  if ($pdo) {
    // Consultar la tabla de Usuario para autenticar
    $stmt = $pdo->prepare("SELECT * FROM usuario WHERE nombre = :nombre AND perfil = :perfil");
    $stmt->execute(['nombre' => $nombre, 'perfil' => $perfilSeleccionado]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verificar que se encontró el usuario
    if ($usuario) {
      // Verificar la contraseña
      if (password_verify($contrasena, $usuario['contrasena'])) {
        // Determinar en qué tabla buscar según el perfil
        switch ($perfilSeleccionado) {
          case 'medico':
            $perfilStmt = $pdo->prepare("SELECT id_medico, nombre FROM Medico WHERE id_usuario = :id_usuario");
            break;
          case 'secretaria':
            $perfilStmt = $pdo->prepare("SELECT nombre FROM Secretaria WHERE id_usuario = :id_usuario");
            break;
          case 'transportista':
            $perfilStmt = $pdo->prepare("SELECT nombre FROM Transportista WHERE id_usuario = :id_usuario");
            break;
          default:
            echo "Perfil no reconocido.";
            exit();
        }

        // Obtener el nombre correspondiente desde la tabla específica
        $perfilStmt->execute(['id_usuario' => $usuario['id_usuario']]);
        $perfilInfo = $perfilStmt->fetch(PDO::FETCH_ASSOC);

        if ($perfilInfo) {
          // Redirigir según el perfil y pasar el nombre para mostrar "Bienvenido, [Nombre]"
          session_start();
          $_SESSION['nombre'] = $perfilInfo['nombre'];
          $_SESSION['perfil'] = $perfilSeleccionado;

          // Guardar el ID del médico en la sesión si es un médico
          if ($perfilSeleccionado == 'medico') {
            $_SESSION['id_medico'] = $perfilInfo['id_medico']; // Almacenar el ID del médico
            header("Location: /CentroSalud/PagMedico/citasMedico.php");
          } elseif ($perfilSeleccionado == 'secretaria') {
            header("Location: /CentroSalud/PagPersonal/calendarioCitas.php");
          } elseif ($perfilSeleccionado == 'transportista') {
            header("Location: /CentroSalud/PagTransporte/citasTransporte.php");
          }
          exit();
        } else {
          echo "Error: No se encontró el perfil asociado.";
        }
      } else {
        echo "Contraseña incorrecta.";
      }
    } else {
      echo "Usuario no encontrado.";
    }
  } else {
    echo "Error en la conexión a la base de datos.";
  }
}
?>