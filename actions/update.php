<?php
include $_SERVER['DOCUMENT_ROOT'] . '/P01-ED03_RojasFlores/config/db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Consulta para obtener los datos de la denuncia específica
    $sql = "SELECT * FROM denuncias WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);
    $denuncia = $stmt->fetch(PDO::FETCH_ASSOC);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $ubicacion = $_POST['ubicacion'];
    $estado = $_POST['estado'];
    $ciudadano = $_POST['ciudadano'];

    // Consulta para actualizar los datos
    $sql = "UPDATE denuncias SET titulo = ?, descripcion = ?, ubicacion = ?, estado = ?, ciudadano = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$titulo, $descripcion, $ubicacion, $estado, $ciudadano, $id]);

    header("Location: /P01-ED03_RojasFlores/views/index.php?mensaje=actualizado");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Actualizar Denuncia</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Actualizar Denuncia</h1>

        <form action="/P01-ED03_RojasFlores/actions/update.php" method="POST">
            <input type="hidden" name="id" value="<?= $denuncia['id'] ?>">

            <div class="mb-3">
                <label for="titulo" class="form-label">Título</label>
                <input type="text" class="form-control" name="titulo" value="<?= $denuncia['titulo'] ?>" required>
            </div>

            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea class="form-control" name="descripcion" rows="3" required><?= $denuncia['descripcion'] ?></textarea>
            </div>

            <div class="mb-3">
                <label for="ubicacion" class="form-label">Ubicación</label>
                <input type="text" class="form-control" name="ubicacion" value="<?= $denuncia['ubicacion'] ?>" required>
            </div>

            <div class="mb-3">
                <label for="estado" class="form-label">Estado</label>
                <select class="form-control" name="estado" required>
                    <option value="Pendiente" <?= $denuncia['estado'] == 'Pendiente' ? 'selected' : '' ?>>Pendiente</option>
                    <option value="En proceso" <?= $denuncia['estado'] == 'En proceso' ? 'selected' : '' ?>>En proceso</option>
                    <option value="Resuelto" <?= $denuncia['estado'] == 'Resuelto' ? 'selected' : '' ?>>Resuelto</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="ciudadano" class="form-label">Ciudadano</label>
                <input type="text" class="form-control" name="ciudadano" value="<?= $denuncia['ciudadano'] ?>" required>
            </div>

            <div class="d-flex justify-content-between">
                <a href="/P01-ED03_RojasFlores/views/index.php" class="btn btn-secondary">Volver a la lista de denuncias</a>
                <button type="submit" class="btn btn-primary">Actualizar</button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
