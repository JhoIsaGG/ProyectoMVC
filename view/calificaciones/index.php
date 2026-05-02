<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./assets/css/styles.css">
    <title>Calificaciones</title>
</head>
<body>
    <?php include __DIR__ . '/../navbar.php'; ?>

    <div class="mainContainer user-management-container" style="margin-top: 100px;">
        <h2 class="user-management-title">Gestión de Calificaciones</h2>

        <div class="actions-bar">
            <a class="btn btn-create-user" href="index.php?action=calificacion_new">+ Crear nueva</a>
        </div>

        <div class="table-responsive">
            <table class="users-table-modern">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Alumno</th>
                        <th>Curso</th>
                        <th>Tipo Evaluación</th>
                        <th>Nota</th>
                        <th>Punteo Máx.</th>
                        <th>Comentarios</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($items)): ?>
                        <?php foreach ($items as $item): ?>
                            <tr class="element-user">
                                <td><?php echo htmlspecialchars($item['id_calificacion']); ?></td>
                                <td><?php echo htmlspecialchars($item['nombre_alumno']); ?></td>
                                <td><?php echo htmlspecialchars($item['nombre_curso']); ?></td>
                                <td><?php echo htmlspecialchars($item['nombre_tipo']); ?></td>
                                <td><strong><?php echo htmlspecialchars($item['nota']); ?></strong></td>
                                <td><?php echo htmlspecialchars($item['punteo_maximo']); ?></td>
                                <td><?php echo htmlspecialchars($item['comentarios_profesor'] ?? '—'); ?></td>
                                <td>
                                    <a class="btn btn-edit-sm" href="index.php?action=calificacion_edit&codigo=<?php echo urlencode($item['id_calificacion']); ?>">Editar</a>
                                    <form target="fakeFrame" action="index.php?action=calificacion_delete" method="POST" style="display:inline;">
                                        <input type="hidden" name="codigo" value="<?php echo htmlspecialchars($item['id_calificacion']); ?>">
                                        <button class="btn btn-delete-sm" type="submit" onclick="return confirmacionEliminar();">Eliminar</button>
                                    </form>
                                    <iframe name="fakeFrame" class="fakeFrame" style="display:none;"></iframe>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" style="text-align:center; padding:30px; color:#6c757d;">No se encontraron registros.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <script>
        function confirmacionEliminar() {
            var r = confirm("¿Eliminar esta calificación?");
            if (r) { setTimeout(() => window.location.reload(), 500); }
            return r;
        }
    </script>
</body>
</html>
