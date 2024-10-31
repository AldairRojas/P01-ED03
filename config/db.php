<?php
// Datos de conexión a la base de datos
$host = "localhost";
$dbname = "denuncias_db"; // Nombre de la base de datos
$username = "root"; // Usuario por defecto en XAMPP
$password = ""; // Contraseña por defecto en XAMPP es vacía

try {
    // Crear la conexión usando PDO
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    // Configurar el manejo de errores para que lance excepciones
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Conexión exitosa";
} catch (PDOException $e) {
    // Si ocurre un error, mostrar el mensaje
    echo "Error en la conexión: " . $e->getMessage();
}
?>
