<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./assets/css/styles.css">
    <title>Cursos</title>
</head>
<body>

    <?php include __DIR__ . '/../navbar.php'; ?>

    <div class="mainContainer user-management-container" style="margin-top: 100px;">
        <h2 class="user-management-title">Gestión de Cursos</h2>
        
        <div class="actions-bar">
            <a class="btn btn-create-user" href="index.php?action=curso_new">+ Crear nuevo</a>
        </div>
        
        <div class="table-responsive">
            <table class="users-table-modern">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Idioma</th>
                        <th>Nivel</th>
                        <th>Profesor</th>
                        <th>Fecha Inicio</th>
                        <th>Fecha Fin</th>
                        <th>Horario</th>
                        <th>Cupo</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($items)): ?>
                        <?php foreach ($items as $item): ?>
                            <tr class="element-user">
                                <td><?php echo htmlspecialchars($item['id_curso']); ?></td>
                                <td><?php echo htmlspecialchars($item['nombre']); ?></td>
                                <td><?php echo htmlspecialchars($item['nombre_idioma']); ?></td>
                                <td><?php echo htmlspecialchars($item['nombre_nivel']); ?></td>
                                <td><?php echo htmlspecialchars($item['nombre_profesor']); ?></td>
                                <td><?php echo htmlspecialchars($item['fecha_inicio']); ?></td>
                                <td><?php echo htmlspecialchars($item['fecha_fin']); ?></td>
                                <td><?php echo htmlspecialchars($item['horario']); ?></td>
                                <td><?php echo htmlspecialchars($item['cupo_maximo']); ?></td>
                                <td>
                                    <?php if ($item['estado'] == 1): ?>
                                        <span class="badge-active">Activo</span>
                                    <?php else: ?>
                                        <span class="badge-inactive">Inactivo</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($item['estado'] == 1): ?>
                                        <a class="btn btn-edit-sm" href="index.php?action=curso_edit&codigo=<?php echo urlencode($item['id_curso']); ?>">Editar</a>
                                        <form target="fakeFrame" action="index.php?action=curso_delete" method="POST" style="display:inline;">
                                            <input type="hidden" name="codigo" value="<?php echo htmlspecialchars($item['id_curso']); ?>">
                                            <button class="btn btn-delete-sm" type="submit" onclick="return confirmacionEliminar();">Eliminar</button>
                                        </form>
                                    <?php else: ?>
                                        <form target="fakeFrame" action="index.php?action=curso_reactivate" method="POST" style="display:inline;">
                                            <input type="hidden" name="codigo" value="<?php echo htmlspecialchars($item['id_curso']); ?>">
                                            <button class="btn btn-reactivate-sm" type="submit" onclick="return confirmacionReactivar();">Reactivar</button>
                                        </form>
                                    <?php endif; ?>
                                    <iframe name="fakeFrame" class="fakeFrame" style="display:none;"></iframe>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="10" style="text-align: center; padding: 30px; color: #6c757d;">No se encontraron registros.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <script>
        function confirmacionEliminar() {
            var respuesta = confirm("¿Estás seguro de que deseas eliminar este registro?");
            if (respuesta) { setTimeout(() => window.location.reload(), 500); }
            return respuesta;
        }
        function confirmacionReactivar() {
            var respuesta = confirm("¿Estás seguro de que deseas reactivar este registro?");
            if (respuesta) { setTimeout(() => window.location.reload(), 500); }
            return respuesta;
        }
    </script>
</body>
</html>