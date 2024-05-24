<?php
function conectarBaseDeDatos() {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "biblioteca";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    return $conn;
}

function obtenerInformacionLibro($libroID, $conn) {
    $libro = null;

    $sql = "SELECT * FROM Libro WHERE LibroID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $libroID);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $libro = $result->fetch_assoc();
    }

    $stmt->close();

    return $libro;
}



function registrarPrestamo($libroID, $fechaPrestamo, $fechaDevolucionPrevista, $conn) {
    $sqlPrestamo = "INSERT INTO Prestamo (LibroID, FechaPrestamo, FechaDevolucionPrevista, EstadoPrestamo) 
                    VALUES (?, ?, ?, 'Pendiente')";

    $stmt = $conn->prepare($sqlPrestamo);
    $stmt->bind_param("iss", $libroID, $fechaPrestamo, $fechaDevolucionPrevista);

    if ($stmt->execute()) {
        echo "Préstamo registrado exitosamente.";
    } else {
        echo "Error al registrar el préstamo: " . $stmt->error;
    }

    $stmt->close();
}

// Obtener el ID del libro de la URL
$libroID = isset($_GET['libroID']) ? intval($_GET['libroID']) : 0;

// Validar el ID del libro
if ($libroID <= 0) {
    echo "ID del libro no válido.";
    exit();
}

// Conectar a la base de datos
$conn = conectarBaseDeDatos();

// Obtener información del libro
$libro = obtenerInformacionLibro($libroID, $conn);

if (!$libro) {
    echo "Libro no encontrado.";
    exit();
}

// Manejar el formulario de préstamo
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fechaPrestamo = $_POST['fechaPrestamo'];
    $fechaDevolucionPrevista = $_POST['fechaDevolucionPrevista'];

    // Validar y limpiar los datos del formulario según sea necesario

    // Registrar el préstamo
    registrarPrestamo($libroID, $fechaPrestamo, $fechaDevolucionPrevista, $conn);
}

// Cerrar la conexión a la base de datos
$conn->close();
?>
<!-- Resto del código HTML sigue igual -->

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        header {
            background-color: #333;
            color: white;
            padding: 10px;
            text-align: center;
        }

        #prestamo-form {
            max-width: 600px;
            margin: 20px auto;
        }

        form {
            border-collapse: collapse;
            width: 100%;
        }

        label {
            display: block;
            margin: 10px 0;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 8px;
            margin: 5px 0;
            box-sizing: border-box;
        }

        button {
            background-color: #333;
            color: white;
            padding: 10px;
            border: none;
            cursor: pointer;
            margin-right: 10px;
        }

        button:hover {
            background-color: #555;
        }

  h2 {
    color: #333; /* Color del texto */
    font-size: 24px; /* Tamaño de la fuente */
    font-weight: bold; /* Negrita */
    background-color: #f0f0f0; /* Color de fondo */
    padding: 10px; /* Espaciado interno */
    border-radius: 8px; /* Bordes redondeados */
}


    </style>
    <title>Formulario de Préstamo</title>
</head>
<body>

    <header>
        <img src="logito.png" alt="Logo Izquierda" class="logo logo-izquierda">
        <h1>Formulario de Préstamo</h1>
        <img src="logito.png" alt="Logo Derecha" class="logo logo-derecha">
    </header>

    <section id="prestamo-form">
        <h2 class="titulo-destacado">PRESTAMO DEL LIBRO <?php echo $libro['titulo']; ?></h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?libroID=" . $libroID; ?>">
            <table>
                    <td><label for="fechaPrestamo">Fecha de Préstamo:</label></td>
                    <td><input type="date" name="fechaPrestamo" value="<?php echo date('Y-m-d'); ?>" required></td>
                </tr>
                <tr>
                    <td><label for="fechaDevolucionPrevista">Fecha de Devolución Prevista:</label></td>
                    <td><input type="date" name="fechaDevolucionPrevista" required></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <button type="submit">Registrar Préstamo</button>
                        <a href="formulario_estudiante.php"><button type="button">Registrar Estudiante</button></a>
                        <a href="index.php"><button type="button">Regresar</button></a>

                    </td>
                </tr>
            </table>
        </form>
    </section>

</body>
</html>
