<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "biblioteca";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];

$sql = "INSERT INTO Estudiante (Nombre, Apellido) VALUES ('$nombre', '$apellido')";

if ($conn->query($sql) === TRUE) {
    echo "Estudiante registrado exitosamente.";
} else {
    echo "Error al registrar estudiante: " . $conn->error;
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Formulario de Registro de Estudiante</title>
</head>
<body>

    <header>
        <img src="logito.png" alt="Logo Izquierda" class="logo logo-izquierda">
        <h1>Formulario de Registro de Estudiante</h1>
        <img src="logito.png" alt="Logo Derecha" class="logo logo-derecha">
    </header>

    <section id="estudiante-form">
        <h2>Registro de Estudiante</h2>
        <form method="post" action="registrar_estudiante.php">
            <label for="nombre">Nombre:</label>
            <input type="text" name="Nombre" required>

            <label for="apellido">Apellido:</label>
            <input type="text" name="Apellido" required>

            <button type="submit">Registrar Estudiante</button>
        </form>
    </section>

    <section id="additional-content">
        <p>
            ¿Ya tienes un estudiante registrado? 
            <a href="libros_disponibles.php"><button type="button">Realizar Préstamo</button></a>
        </p>
        <p>
            <a href="index.php"><button type="button">Regresar al Inicio</button></a>
        </p>
    </section>

</body>
</html>
