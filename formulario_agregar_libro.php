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
            text-align: center;
            padding: 15px 0;
        }

        h1 {
            margin: 0;
        }

        h2 {
            color: black;
        }

        #agregar-libro-form {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        label {
            display: block;
            margin: 10px 0 5px;
            font-weight: bold;
            color: black; /* Cambiado a azul */
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            box-sizing: border-box;
        }

        button {
            background-color: #333;
            color: white;
            padding: 10px;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #555;
        }

        #additional-content {
            margin-top: 20px;
            text-align: center;
        }

        #additional-content button {
            background-color: #333;
            color: white;
            padding: 10px;
            border: none;
            cursor: pointer;
        }

        #additional-content button:hover {
            background-color: #555;
        }
        .error-message {
            color: red;
        }

        .success-message {
            color: green;
        }
    </style>
    <title>Agregar Libro</title>
</head>
<body>

    <header>
        <img src="logito.png" alt="Logo Izquierda" class="logo logo-izquierda">
        <h1>Agregar Libro</h1>
        <img src="logito.png" alt="Logo Derecha" class="logo logo-derecha">
    </header>

    <section id="agregar-libro-form">
        <h2>Formulario para Agregar Libro</h2>

        <?php
        // Conexión a la base de datos (reemplaza estos valores con los tuyos)
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "biblioteca";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }

        $showErrorMessage = false;

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $id = $_POST['id'];
            $titulo = $_POST['titulo'];
            $autor = $_POST['autor'];
            $anio = $_POST['anio'];
            $genero = $_POST['genero'];

            if (empty($id) || empty($titulo) || empty($autor) || empty($anio) || empty($genero)) {
                $showErrorMessage = true;
            } else {
                // Verificar si el ID ya existe en la base de datos
                $check_id_sql = "SELECT * FROM Libro WHERE LibroID = '$id'";
                $result = $conn->query($check_id_sql);

                if ($result->num_rows > 0) {
                    echo '<p class="error-message">El ID ya está en uso. Cambia el ID por favor.</p>';
                    $showErrorMessage = true;
                } else {
                    // Insertar el libro si el ID no está duplicado
                    $sql = "INSERT INTO Libro (LibroID, titulo, autor, anio_publicacion, genero) VALUES ('$id', '$titulo', '$autor', $anio, '$genero')";

                    if ($conn->query($sql) === TRUE) {
                        echo '<p class="success-message">Libro agregado exitosamente.</p>';
                    } else {
                        echo "Error al agregar libro: " . $conn->error;
                        $showErrorMessage = true;
                    }
                }
            }
        } else {
            $showErrorMessage = true;
        }

        if ($showErrorMessage) {
            echo '<p class="error-message">Digite por favor.</p>';
        }

        $conn->close();
        ?>

        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="id">ID:</label>
            <input type="text" name="id" required>

            <label for="titulo">Título:</label>
            <input type="text" name="titulo" required>

            <label for="autor">Autor:</label>
            <input type="text" name="autor" required>

            <label for="anio">Año de Publicación:</label>
            <input type="number" name="anio" required>

            <label for="genero">Género:</label>
            <input type="text" name="genero" required>

            <button type="submit">Agregar Libro</button>
        </form>
    </section>

    <section id="additional-content">
        <p>
            <a href="index.php"><button type="button">Regresar al Inicio</button></a>
        </p>
    </section>

</body>
</html>
