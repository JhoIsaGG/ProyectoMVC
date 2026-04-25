<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./assets/css/styles.css">
    <title>Profesores</title>
</head>
<body>

    <?php include __DIR__ . '/../navbar.php'; ?>

    <div class="mainContainer user-management-container" style="margin-top: 100px;">
        <h2 class="user-management-title">Gestión de Profesores</h2>
        
        <div class="actions-bar">
            <a class="btn btn-create-user" href="index.php?action=profesor_new">+ Crear nuevo</a>
        </div>
        
        <div class="table-responsive">
            <table class="users-table-modern">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Nombre Completo</th>
                        <th>Cursos Dictados</th>
                        <th>Idiomas</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($items)): ?>
                        <?php foreach ($items as $item): ?>
                            <tr class="element-user">
                                <td><?php echo htmlspecialchars($item['id_profesor']); ?></td>
                                <td><span class="user-chip user-chip-admin"><?php echo htmlspecialchars($item['username']); ?></span></td>
                                <td><?php echo htmlspecialchars($item['nombres'] . ' ' . $item['apellidos']); ?></td>
                                <td>
                                    <?php 
                                        if (!empty($item['cursos_dictados'])) {
                                            $cursos = explode(', ', $item['cursos_dictados']);
                                            foreach($cursos as $curso) {
                                                echo '<span class="user-chip user-chip-student" style="margin-right:4px;">' . htmlspecialchars($curso) . '</span>';
                                            }
                                        } else {
                                            echo '<span style="color:#999; font-style:italic;">Ninguno</span>';
                                        }
                                    ?>
                                </td>
                                <td>
                                    <?php 
                                        if (!empty($item['idiomas_hablados'])) {
                                            $idiomas = explode(', ', $item['idiomas_hablados']);
                                            foreach($idiomas as $idioma) {
                                                echo '<span class="user-chip user-chip-active" style="margin-right:4px;">' . htmlspecialchars($idioma) . '</span>';
                                            }
                                        } else {
                                            echo '<span style="color:#999; font-style:italic;">Ninguno</span>';
                                        }
                                    ?>
                                </td>
                                <td>
                                    <a class="btn btn-edit-sm" href="index.php?action=profesor_edit&codigo=<?php echo urlencode($item['id_profesor']); ?>">Editar</a>
                                    <form target="fakeFrame" action="index.php?action=profesor_delete" method="POST" style="display:inline;">
                                        <input type="hidden" name="codigo" value="<?php echo htmlspecialchars($item['id_profesor']); ?>">
                                        <button class="btn btn-delete-sm" type="submit" onclick="return confirmacionEliminar();">Eliminar</button>
                                    </form>
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