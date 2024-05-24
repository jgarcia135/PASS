<?php
// Conexión a la base de datos
$servername = "localhost"; // Puedes usar "127.0.0.1" también
$username = "root"; // Usuario por defecto de XAMPP
$password = ""; // Sin contraseña por defecto
$dbname = "biblioteca"; // Reemplaza con el nombre de tu base de datos

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$sql = "SELECT * FROM Libro";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <style>
    body {
    font-family: 'Arial', sans-serif;
    background-image: url('Biblioteca.jpeg'); /* Cambiar 'ruta_de_tu_imagen.jpg' por la ruta de tu imagen de fondo */
    background-size: cover; /* Para que la imagen de fondo cubra todo el cuerpo */
    margin: 0;
    padding: 0;
    align-items: center;
    justify-content: center;
    height: 100vh;
    position: relative; /* Agregado para posicionar los logotipos relativos al cuerpo */
}

.logo-izquierda {
    position: absolute;
    top: -80px;
    left: 10px;
}

.logo-derecha {
    position: absolute;
    top: -80px;
    right: 10px;
}

header {
    text-align: center; /* Para centrar el contenido del encabezado */
}

h1 {
    font-family: 'Sitka Small', sans-serif; /* Cambiar el tipo de letra a Sitka Small */
    font-weight: bold; /* Negrilla */
}


h2 {
    font-family: 'Sitka Small', sans-serif; /* Cambiar el tipo de letra a Sitka Small */
    font-weight: bold; /* Negrilla */
    text-decoration-color: blue;
}


table {
    border-collapse: collapse;
    width: 100%;
}

th, td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
}

th {
    background-color: #333;
    color: white;
    font-weight: bold; /* Negrilla */
}

tr:nth-child(even) {
    background-color: #f2f2f2;
}

/* Colores para las celdas */
td.libro-id {
    background-color: #87CEFA; /* Azul claro */
}

td.titulo {
    background-color: #ffcccb; /* Rojo claro */
}

td.autor {
    background-color: #add8e6; /* Azul claro */
}

td.anio {
    background-color: #90ee90; /* Verde claro */
}

td.genero {
    background-color: #f0e68c; /* Amarillo claro */
}

td.estado {
    background-color: #98fb98; /* Verde claro */
}

td.acciones {
    background-color: #ffa07a; /* Salmon claro */
}

/* Botones pequeños */
.btn-prestamo, .btn-devolucion, .btn-eliminar {
    padding: 5px;
    background-color: #323;
    color: #fff;
    border: none;
    cursor: pointer;
}

.btn-prestamo:hover, .btn-devolucion:hover, .btn-eliminar:hover {
    background-color: #555;
}
    </style>
    <title>Base de Datos de Biblioteca</title>
</head>
<body>

    <header>
        <img src="logito.png" alt="Logo Izquierda" class="logo logo-izquierda">
        <h1>Base de Datos de Biblioteca</h1>
        <img src="logito.png" alt="Logo Derecha" class="logo logo-derecha">
    </header>

    <section id="book-list">
        <h2>Lista de Libros</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Autor</th>
                    <th>Año</th>
                    <th>Género</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<tr>';
                        echo '<td class="libro-id">' . $row['LibroID'] . '</td>';
                        echo '<td class="titulo">' . $row['titulo'] . '</td>';
                        echo '<td class="autor">' . $row['autor'] . '</td>';
                        echo '<td class="anio">' . $row['anio_publicacion'] . '</td>';
                        echo '<td class="genero">' . $row['genero'] . '</td>';
                        
                        // Agregar lógica para el estado del libro (disponible o no disponible)
                        $estado = ($row['disponible'] == 1) ? 'Disponible' : 'No Disponible';
                        echo '<td class="estado">' . $estado . '</td>';

                        // Botones para préstamo, devolución y eliminación
                        echo '<td class="acciones">';
                        if ($row['disponible'] == 1) {
                            echo '<button class="btn-prestamo" onclick="redirigirFormulario(' . $row['LibroID'] . ')">Préstamo</button>';
                        } else {
                            echo '<button class="btn-devolucion" onclick="realizarAccion(' . $row['LibroID'] . ', \'devolucion\')">Devolución</button>';
                        }
                        echo '<button class="btn-eliminar" onclick="eliminarLibro(' . $row['LibroID'] . ')">Eliminar Libro</button>';
                        echo '</td>';
                        
                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td colspan="7">No hay libros disponibles.</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </section>

    <section id="additional-content">
        <p>
            ¡Bienvenido a nuestra biblioteca virtual! Aquí puedes encontrar información sobre los libros disponibles.
        </p>
        
        <p>
            ¿Quieres agregar un nuevo libro? 
            <a href="formulario_agregar_libro.php"><button type="button">Agregar Libro</button></a>
        </p>
    </section>

    <script>
        function redirigirFormulario(libroID) {
            window.location.href = "formulario_prestamo.php?libroID=" + libroID;
        }

        function realizarAccion(libroID, accion) {
            // Realizar una solicitud AJAX para manejar el préstamo o la devolución
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    // Manejar la respuesta del servidor (puedes mostrar un mensaje o realizar otras acciones)
                    alert(this.responseText);
                    // Recargar la página para reflejar los cambios
                    location.reload();
                }
            };
            xhttp.open("GET", "accion_libro.php?id=" + libroID + "&accion=" + accion, true);
            xhttp.send();
        }

        function eliminarLibro(libroID) {
            if (confirm("¿Estás seguro de que quieres eliminar este libro?")) {
                // Realizar una solicitud AJAX para eliminar el libro
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        // Manejar la respuesta del servidor (puedes mostrar un mensaje o realizar otras acciones)
                        alert(this.responseText);
                        // Recargar la página para reflejar los cambios
                        location.reload();
                    }
                };
                xhttp.open("GET", "eliminar_libro.php?id=" + libroID, true);
                xhttp.send();
            }
        }
    </script>

</body>
</html>
