<?php
class conexion
{
  private $conexion;
  private $db;
  private $servidor;
  private $User;
  private $Pass;

  // Constructor que inicializa variables
  function __construct()
  {
    $this->db = "CentroSalud2";
    $this->servidor = "localhost";
    $this->User = "root";
    $this->Pass = "3110";
  }

  // Conectar a la base de datos usando PDO
  function conectar()
  {
    try {
      $this->conexion = new PDO("mysql:host=$this->servidor;dbname=$this->db", $this->User, $this->Pass);
      $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      return $this->conexion;
    } catch (PDOException $e) {
      echo "<font color='red'>(!) Error de Conexión: " . $e->getMessage() . " (!)</font>";
      return false;
    }
  }
}
?>