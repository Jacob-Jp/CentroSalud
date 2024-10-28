<?php
require_once 'conexion.php';

// Instanciar la clase y obtener la conexión
$conexion = new conexion();
$pdo = $conexion->conectar();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $nombre = $_POST['Nombre'];
  $contrasena = $_POST['Contra'];
  $perfilSeleccionado = $_POST['perfil'];

  if ($nombre === 'Administrador' && $contrasena === 'admin1234') {
    // Configurar la sesión para el administrador
    $_SESSION['nombre'] = 'Administrador';
    $_SESSION['perfil'] = 'administrador';
    header("Location: /CentroSalud/AdminPanel/index.php");
    exit();
  } else {
    $perfilSeleccionado = $_POST['perfil'] ?? '';
  }


  if ($pdo) {
    $stmt = $pdo->prepare("SELECT * FROM usuario WHERE nombre = :nombre AND perfil = :perfil");
    $stmt->execute(['nombre' => $nombre, 'perfil' => $perfilSeleccionado]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario) {

      if (password_verify($contrasena, $usuario['contrasena'])) {

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


        $perfilStmt->execute(['id_usuario' => $usuario['id_usuario']]);
        $perfilInfo = $perfilStmt->fetch(PDO::FETCH_ASSOC);

        if ($perfilInfo) {

          session_start();
          $_SESSION['nombre'] = $perfilInfo['nombre'];
          $_SESSION['perfil'] = $perfilSeleccionado;


          if ($perfilSeleccionado == 'medico') {
            $_SESSION['id_medico'] = $perfilInfo['id_medico'];
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