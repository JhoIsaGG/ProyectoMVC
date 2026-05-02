<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./assets/css/styles.css">
    <title>Entregas</title>
</head>
<body>
    <?php include __DIR__ . '/../navbar.php'; ?>

    <div class="mainContainer user-management-container" style="margin-top: 100px;">
        <h2 class="user-management-title">Gestión de Entregas</h2>

        <div class="actions-bar">
            <a class="btn btn-create-user" href="index.php?action=entrega_new">+ Registrar entrega</a>
        </div>

        <div class="table-responsive">
            <table class="users-table-modern">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Alumno</th>
                        <th>Evaluación</th>
                        <th>Curso</th>
                        <th>Fecha Entrega</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($items)): ?>
                        <?php foreach ($items as $item): ?>
                            <tr class="element-user">
                                <td><?php echo htmlspecialchars($item['id_entrega']); ?></td>
                                <td><?php echo htmlspecialchars($item['nombre_alumno']); ?></td>
                                <td><?php echo htmlspecialchars($item['nombre_tipo']); ?></td>
                                <td><?php echo htmlspecialchars($item['nombre_curso']); ?></td>
                                <td><?php echo htmlspecialchars($item['fecha_entrega']); ?></td>
                                <td>
                                    <?php echo ($item['estado'] == 1) ? '<span class="badge-active">Entregado</span>' : '<span class="badge-inactive">Anulado</span>'; ?>
                                </td>
                                <td>
                                    <a class="btn btn-edit-sm" href="index.php?action=entrega_edit&codigo=<?php echo urlencode($item['id_entrega']); ?>">Editar</a>
                                    <form target="fakeFrame" action="index.php?action=entrega_delete" method="POST" style="display:inline;">
                                        <input type="hidden" name="codigo" value="<?php echo htmlspecialchars($item['id_entrega']); ?>">
                                        <button class="btn btn-delete-sm" type="submit" onclick="return confirmacionEliminar();">Eliminar</button>
                                    </form>
                                    <iframe name="fakeFrame" style="display:none;"></iframe>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="7" style="text-align:center; padding:30px; color:#6c757d;">No se encontraron entregas.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <script>
        function confirmacionEliminar() {
            var r = confirm("¿Eliminar esta entrega?");
            if (r) { setTimeout(() => window.location.reload(), 500); }
            return r;
        }
    </script>
</body>
</html>
