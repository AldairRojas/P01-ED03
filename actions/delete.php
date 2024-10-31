<?php
include $_SERVER['DOCUMENT_ROOT'] . '/P01-ED03_RojasFlores/config/db.php';

if (isset($_POST['id'])) {
    $id = $_POST['id'];

    $sql = "DELETE FROM denuncias WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        header("Location: ../views/index.php?mensaje=eliminado");
        exit;
    } else {
        echo "Error al eliminar la denuncia.";
    }
} else {
    echo "ID de denuncia no especificado.";
}
?>
    