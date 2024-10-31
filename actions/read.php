<?php
include $_SERVER['DOCUMENT_ROOT'] . '/P01-ED03_RojasFlores/config/db.php';

$sql = "SELECT * FROM denuncias";
$stmt = $conn->prepare($sql);
$stmt->execute();
$denuncias = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($denuncias as $denuncia) {
    echo "<tr>
            <td>
                <a href='/P01-ED03_RojasFlores/views/update_form.html?id={$denuncia['id']}' class='btn btn-warning btn-sm'>✏️</a>
                <a href='/P01-ED03_RojasFlores/actions/delete.php?id={$denuncia['id']}' class='btn btn-danger btn-sm'>🗑️</a>
            </td>
            <td>{$denuncia['id']}</td>
            <td>{$denuncia['titulo']}</td>
            <td>{$denuncia['descripcion']}</td>
            <td>{$denuncia['ubicacion']}</td>
            <td>{$denuncia['ciudadano']}</td>
            <td>{$denuncia['fecha_registro']}</td>
            <td>{$denuncia['estado']}</td>
          </tr>";
}
?>
