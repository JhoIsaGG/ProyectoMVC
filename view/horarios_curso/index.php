<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./assets/css/styles.css">
    <title>Horarios de Curso</title>
</head>
<body>
    <?php include __DIR__ . '/../navbar.php'; ?>

    <div class="mainContainer user-management-container" style="margin-top: 100px;">
        <h2 class="user-management-title">Gestión de Horarios</h2>

        <div class="actions-bar">
            <a class="btn btn-create-user" href="index.php?action=horario_new">+ Agregar horario</a>
        </div>

        <div class="table-responsive">
            <table class="users-table-modern">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Curso</th>
                        <th>Aula</th>
                        <th>Capacidad</th>
                        <th>Día</th>
                        <th>Hora Inicio</th>
                        <th>Hora Fin</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($items)): ?>
                        <?php foreach ($items as $item): ?>
                            <tr class="element-user">
                                <td><?php echo htmlspecialchars($item['id_horario']); ?></td>
                                <td><?php echo htmlspecialchars($item['nombre_curso']); ?></td>
                                <td><?php echo htmlspecialchars($item['nombre_aula']); ?></td>
                                <td><?php echo htmlspecialchars($item['capacidad_aula']); ?></td>
                                <td><?php echo htmlspecialchars($dias[$item['dia_semana']] ?? $item['dia_semana']); ?></td>
                                <td><?php echo htmlspecialchars(substr($item['hora_inicio'], 0, 5)); ?></td>
                                <td><?php echo htmlspecialchars(substr($item['hora_fin'], 0, 5)); ?></td>
                                <td>
                                    <a class="btn btn-edit-sm" href="index.php?action=horario_edit&codigo=<?php echo urlencode($item['id_horario']); ?>">Editar</a>
                                    <form target="fakeFrame" action="index.php?action=horario_delete" method="POST" style="display:inline;">
                                        <input type="hidden" name="codigo" value="<?php echo htmlspecialchars($item['id_horario']); ?>">
                                        <button class="btn btn-delete-sm" type="submit" onclick="return confirmacionEliminar();">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <iframe name="fakeFrame" style="display:none;"></iframe>
                    <?php else: ?>
                        <tr><td colspan="8" style="text-align:center; padding:30px; color:#6c757d;">No se encontraron registros.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <script>
        function confirmacionEliminar() {
            var r = confirm("¿Eliminar este horario?");
            if (r) { setTimeout(() => window.location.reload(), 500); }
            return r;
        }
    </script>
</body>
</html>
