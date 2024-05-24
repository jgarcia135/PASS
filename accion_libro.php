<?php
// accion_libro.php

// Obtener los parámetros de la solicitud GET
$libroID = $_GET['id'];
$accion = $_GET['accion'];

// Realizar acciones en la base de datos según la acción solicitada
// Puedes implementar aquí la lógica para actualizar el estado del libro (préstamo o devolución)

// Enviar una respuesta al cliente (puedes personalizar el mensaje según la acción)
echo "La acción de $accion para el libro con ID $libroID se ha realizado correctamente.";
?>
