<?php
include $_SERVER['DOCUMENT_ROOT'] . '/P01-ED03_RojasFlores/config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Capturar datos del formulario
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $ubicacion = $_POST['ubicacion'];
    $estado = $_POST['estado'];
    $ciudadano = $_POST['ciudadano'];
    $telefono_ciudadano = $_POST['telefono_ciudadano'];
    $fecha_registro = $_POST['fecha_registro'] ?? date('Y-m-d');

    // Insertar datos en la base de datos
    $sql = "INSERT INTO denuncias (titulo, descripcion, ubicacion, estado, ciudadano, telefono_ciudadano, fecha_registro) 
            VALUES (:titulo, :descripcion, :ubicacion, :estado, :ciudadano, :telefono_ciudadano, :fecha_registro)";
    $stmt = $conn->prepare($sql);

    $stmt->bindParam(':titulo', $titulo);
    $stmt->bindParam(':descripcion', $descripcion);
    $stmt->bindParam(':ubicacion', $ubicacion);
    $stmt->bindParam(':estado', $estado);
    $stmt->bindParam(':ciudadano', $ciudadano);
    $stmt->bindParam(':telefono_ciudadano', $telefono_ciudadano);
    $stmt->bindParam(':fecha_registro', $fecha_registro);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        // Redirigir a la página principal con un mensaje de éxito
        header("Location: /P01-ED03_RojasFlores/views/index.php?mensaje=creado");
        exit();
    } else {
        echo "Error al crear la denuncia. Por favor, intenta nuevamente.";
    }
}
?>
