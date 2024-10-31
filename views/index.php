<?php
include $_SERVER['DOCUMENT_ROOT'] . '/P01-ED03_RojasFlores/config/db.php';

$sql = "SELECT * FROM denuncias";
$stmt = $conn->prepare($sql);
$stmt->execute();
$denuncias = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Denuncias</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h1 class="text-center text-primary">Denuncias</h1>

        <?php
        if (isset($_GET['mensaje'])) {
            $mensaje = $_GET['mensaje'];
            if ($mensaje == 'creado') {
                echo "<div class='alert alert-success'>Denuncia creada con éxito.</div>";
            } elseif ($mensaje == 'editado') {
                echo "<div class='alert alert-warning'>Denuncia editada correctamente.</div>";
            } elseif ($mensaje == 'eliminado') {
                echo "<div class='alert alert-danger'>Denuncia eliminada correctamente.</div>";
            }
        }
        ?>

        <div class="d-flex justify-content-between mb-3">
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createModal">Nuevo</button>
            <input type="text" id="searchInput" class="form-control w-25" placeholder="Buscar" onkeyup="filterTable()">
        </div>

        <table class="table table-bordered table-striped" id="denunciasTable">
            <thead class="table-dark">
                <tr>
                    <th>Opciones</th>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Descripción</th>
                    <th>Ubicación</th>
                    <th>Ciudadano</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($denuncias as $denuncia): ?>
                <tr>
                    <td>
                        <a href="../actions/update.php?id=<?= $denuncia['id'] ?>" class="btn btn-warning btn-sm">✏️</a>
                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal" data-id="<?= $denuncia['id'] ?>">🗑️</button>
                    </td>
                    <td><?= $denuncia['id'] ?></td>
                    <td><?= $denuncia['titulo'] ?></td>
                    <td><?= $denuncia['descripcion'] ?></td>
                    <td><?= $denuncia['ubicacion'] ?></td>
                    <td><?= $denuncia['ciudadano'] ?></td>
                    <td><?= $denuncia['fecha_registro'] ?></td>
                    <td><?= $denuncia['estado'] ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="../actions/create.php" method="POST" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel">Nueva Denuncia</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="titulo" class="form-label">Título</label>
                        <input type="text" class="form-control" name="titulo" required>
                    </div>
                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <textarea class="form-control" name="descripcion" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="ubicacion" class="form-label">Ubicación</label>
                        <input type="text" class="form-control" name="ubicacion" required>
                    </div>
                    <div class="mb-3">
                        <label for="ciudadano" class="form-label">Ciudadano</label>
                        <input type="text" class="form-control" name="ciudadano" required>
                    </div>
                    <div class="mb-3">
                        <label for="fecha_registro" class="form-label">Fecha</label>
                        <input type="date" class="form-control" name="fecha_registro" required>
                    </div>
                    <div class="mb-3">
                        <label for="estado" class="form-label">Estado</label>
                        <select class="form-control" name="estado">
                            <option value="Pendiente">Pendiente</option>
                            <option value="En proceso">En proceso</option>
                            <option value="Resuelto">Resuelto</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="confirmDeleteLabel">Eliminar registro</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¿Deseas eliminar el registro?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <form id="deleteForm" action="../actions/delete.php" method="POST">
                        <input type="hidden" name="id" id="deleteId" value="">
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let deleteId = null;

        document.addEventListener('DOMContentLoaded', function () {
            const confirmDeleteModal = document.getElementById('confirmDeleteModal');
            confirmDeleteModal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                deleteId = button.getAttribute('data-id');
                document.getElementById('deleteId').value = deleteId;
            });
        });

        function filterTable() {
            const input = document.getElementById('searchInput');
            const filter = input.value.toUpperCase();
            const table = document.getElementById('denunciasTable');
            const tr = table.getElementsByTagName('tr');

            for (let i = 1; i < tr.length; i++) {
                let td = tr[i].getElementsByTagName('td');
                let match = false;
                for (let j = 0; j < td.length; j++) {
                    if (td[j]) {
                        if (td[j].textContent.toUpperCase().indexOf(filter) > -1) {
                            match = true;
                        }
                    }
                }
                tr[i].style.display = match ? '' : 'none';
            }
        }
    </script>

    <footer class="text-center mt-5 p-3 border-top">
        <p class="text-muted">Elaborado por: Aldair Alberto Rojas Flores</p>
    </footer>
</body>
</html>
