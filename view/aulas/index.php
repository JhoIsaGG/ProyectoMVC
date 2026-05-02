<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./assets/css/styles.css">
    <title>Aulas</title>
</head>
<body>
    <?php include __DIR__ . '/../navbar.php'; ?>

    <div class="mainContainer user-management-container" style="margin-top: 100px;">
        <h2 class="user-management-title">Gestión de Aulas</h2>

        <div class="actions-bar">
            <a class="btn btn-create-user" href="index.php?action=aula_new">+ Crear aula</a>
        </div>

        <div class="table-responsive">
            <table class="users-table-modern">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Capacidad</th>
                        <th>Tipo</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($items)): ?>
                        <?php foreach ($items as $item): ?>
                            <tr class="element-user">
                                <td><?php echo htmlspecialchars($item['id_aula']); ?></td>
                                <td><?php echo htmlspecialchars($item['nombre']); ?></td>
                                <td><?php echo htmlspecialchars($item['capacidad']); ?></td>
                                <td><?php echo htmlspecialchars($tipos[$item['tipo']] ?? $item['tipo']); ?></td>
                                <td>
                                    <?php if ($item['estado'] == 1): ?>
                                        <span class="badge-active">Activa</span>
                                    <?php else: ?>
                                        <span class="badge-inactive">Inactiva</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($item['estado'] == 1): ?>
                                        <a class="btn btn-edit-sm" href="index.php?action=aula_edit&codigo=<?php echo urlencode($item['id_aula']); ?>">Editar</a>
                                        <form target="fakeFrame" action="index.php?action=aula_delete" method="POST" style="display:inline;">
                                            <input type="hidden" name="codigo" value="<?php echo htmlspecialchars($item['id_aula']); ?>">
                                            <button class="btn btn-delete-sm" type="submit" onclick="return confirmacionEliminar();">Desactivar</button>
                                        </form>
                                    <?php else: ?>
                                        <form target="fakeFrame" action="index.php?action=aula_reactivate" method="POST" style="display:inline;">
                                            <input type="hidden" name="codigo" value="<?php echo htmlspecialchars($item['id_aula']); ?>">
                                            <button class="btn btn-reactivate-sm" type="submit" onclick="return confirmacionReactivar();">Reactivar</button>
                                        </form>
                                    <?php endif; ?>
                                    <iframe name="fakeFrame" style="display:none;"></iframe>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="6" style="text-align:center; padding:30px; color:#6c757d;">No se encontraron registros.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <script>
        function confirmacionEliminar() {
            var r = confirm("¿Desactivar esta aula?");
            if (r) { setTimeout(() => window.location.reload(), 500); }
            return r;
        }
        function confirmacionReactivar() {
            var r = confirm("¿Reactivar esta aula?");
            if (r) { setTimeout(() => window.location.reload(), 500); }
            return r;
        }
    </script>
</body>
</html>
