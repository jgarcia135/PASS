<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "biblioteca";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$libroID = $_GET['id'];

$sql = "DELETE FROM Libro WHERE LibroID = '$libroID'";

if ($conn->query($sql) === TRUE) {
    echo "Libro eliminado exitosamente.";
} else {
    echo "Error al eliminar libro: " . $conn->error;
}

$conn->close();
?>
