<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./assets/css/styles.css">
    <title>Asistencias</title>
</head>
<body>
    <?php include __DIR__ . '/../navbar.php'; ?>

    <div class="mainContainer user-management-container" style="margin-top: 100px;">
        <h2 class="user-management-title">Gestión de Asistencias</h2>

        <div class="actions-bar">
            <a class="btn btn-create-user" href="index.php?action=asistencia_new">+ Registrar asistencia</a>
        </div>

        <div class="table-responsive">
            <table class="users-table-modern">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Alumno</th>
                        <th>Curso</th>
                        <th>Fecha</th>
                        <th>Estado</th>
                        <th>Observaciones</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($items)): ?>
                        <?php foreach ($items as $item): ?>
                            <tr class="element-user">
                                <td><?php echo htmlspecialchars($item['id_asistencia']); ?></td>
                                <td><?php echo htmlspecialchars($item['nombre_alumno']); ?></td>
                                <td><?php echo htmlspecialchars($item['nombre_curso']); ?></td>
                                <td><?php echo htmlspecialchars($item['fecha']); ?></td>
                                <td>
                                    <?php
                                    $estadoLabel = $estados[$item['estado']] ?? 'Desconocido';
                                    $colorMap = [1 => 'badge-active', 2 => 'badge-inactive', 3 => 'badge-warn', 4 => 'badge-info'];
                                    $cls = $colorMap[$item['estado']] ?? 'badge-inactive';
                                    echo "<span class=\"{$cls}\">{$estadoLabel}</span>";
                                    ?>
                                </td>
                                <td><?php echo htmlspecialchars($item['observaciones'] ?? '—'); ?></td>
                                <td>
                                    <a class="btn btn-edit-sm" href="index.php?action=asistencia_edit&codigo=<?php echo urlencode($item['id_asistencia']); ?>">Editar</a>
                                    <form target="fakeFrame" action="index.php?action=asistencia_delete" method="POST" style="display:inline;">
                                        <input type="hidden" name="codigo" value="<?php echo htmlspecialchars($item['id_asistencia']); ?>">
                                        <button class="btn btn-delete-sm" type="submit" onclick="return confirmacionEliminar();">Eliminar</button>
                                    </form>
                                    <iframe name="fakeFrame" style="display:none;"></iframe>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="7" style="text-align:center; padding:30px; color:#6c757d;">No se encontraron registros.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <script>
        function confirmacionEliminar() {
            var r = confirm("¿Eliminar este registro de asistencia?");
            if (r) { setTimeout(() => window.location.reload(), 500); }
            return r;
        }
    </script>
</body>
</html>
