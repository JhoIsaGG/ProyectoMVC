<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./assets/css/styles.css">
    <title>Usuarios</title>
</head>
<body>
    <header>
        <nav>
            <div class="logo">Academia de Idiomas</div>
            <ul class="nav-links">
                <li><a href="index.php?action=home">Inicio</a></li>
                <li><a href="index.php?action=cursos">Cursos</a></li>
                <li><a href="index.php?action=evaluaciones">Evaluaciones</a></li>
                <li><a href="index.php?action=idiomas">Idiomas</a></li>
                <li><a href="index.php?action=inscripciones">Inscripciones</a></li>
                <li><a href="index.php?action=niveles">Niveles</a></li>
                <li><a href="index.php?action=profesores">Profesores</a></li>
                <li><a href="index.php?action=usuarios">Usuarios</a></li>
                <li><a href="index.php?action=roles">Roles</a></li>
                <li><a href="index.php?action=tipos_evaluacion">Tipos</a></li>
            </ul>
            <?php if (isset($_SESSION['usuario'])): ?>
                <a href="index.php?action=logout" class="btn">Cerrar Sesión</a>
            <?php endif; ?>
        </nav>
    </header>

    <div class="mainContainer user-management-container" style="margin-top: 100px;">
        <h2 class="user-management-title">Gestión de Usuarios</h2>
        
        <div class="actions-bar">
            <a class="btn btn-create-user" href="index.php?action=usuario_new">+ Crear nuevo usuario</a>
            <form method="POST" action="index.php?action=usuario_search" class="search-form">
                <input class="input-search" type="text" name="nombre" placeholder="Buscar por nombre...">
                <button class="btn btn-search" type="submit">Buscar</button>
            </form>
        </div>
        
        <div class="table-responsive">
            <table class="users-table-modern">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombres</th>
                        <th>Apellidos</th>
                        <th>Username</th>
                        <th>Rol</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($usuarios)): ?>
                        <?php foreach ($usuarios as $user): ?>
                            <tr class="element-user">
                                <td><?php echo htmlspecialchars($user['id_usuario']); ?></td>
                                <td><?php echo htmlspecialchars($user['nombres']); ?></td>
                                <td><?php echo htmlspecialchars($user['apellidos']); ?></td>
                                <td><?php echo htmlspecialchars($user['username']); ?></td>
                                <td><?php echo htmlspecialchars($user['rol'] ?? 'Sin Rol'); ?></td>
                                <td>
                                    <?php if ($user['estado'] == 1): ?>
                                        <span class="badge-active">Activo</span>
                                    <?php else: ?>
                                        <span class="badge-inactive">Inactivo</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($user['estado'] == 1): ?>
                                        <a class="btn btn-edit-sm" href="index.php?action=usuario_edit&codigo=<?php echo urlencode($user['id_usuario']); ?>">Editar</a>
                                        <form target="fakeFrame" action="index.php?action=usuario_delete" method="POST" style="display:inline;">
                                            <input type="hidden" name="codigo" value="<?php echo htmlspecialchars($user['id_usuario']); ?>">
                                            <button class="btn btn-delete-sm" type="submit" onclick="return confirmacionEliminar('<?php echo htmlspecialchars($user['nombres'] . ' ' . $user['apellidos']); ?>');">Eliminar</button>
                                        </form>
                                    <?php else: ?>
                                        <form target="fakeFrame" action="index.php?action=usuario_reactivate" method="POST" style="display:inline;">
                                            <input type="hidden" name="codigo" value="<?php echo htmlspecialchars($user['id_usuario']); ?>">
                                            <button class="btn btn-reactivate-sm" type="submit" onclick="return confirmacionReactivar('<?php echo htmlspecialchars($user['nombres'] . ' ' . $user['apellidos']); ?>');">Reactivar</button>
                                        </form>
                                    <?php endif; ?>
                                    <iframe name="fakeFrame" class="fakeFrame"></iframe>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" style="text-align: center; padding: 30px; color: #6c757d;">No se encontraron usuarios.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <script>
        function confirmacionEliminar(nombre) {
            var respuesta = confirm("¿Estás seguro de que deseas eliminar el usuario " + nombre + "?");
            if (respuesta) {
                setTimeout(() => window.location.reload(), 500);
            }
            return respuesta;
        }
        function confirmacionReactivar(nombre) {
            var respuesta = confirm("¿Estás seguro de que deseas reactivar el usuario " + nombre + "?");
            if (respuesta) {
                setTimeout(() => window.location.reload(), 500);
            }
            return respuesta;
        }
    </script>
</body>
</html>