<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./assets/css/styles.css">
    <title>Editar Usuario</title>
</head>
<body class="user-body-bg">
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

    <div class="form-container" style="margin-top: 100px;">
        <h2 class="form-title">Editar usuario</h2>
        
        <?php if (isset($error)): ?>
            <div class="alert-error">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <form action="index.php?action=usuario_update" method="POST" class="user-form">
            
            <input type="hidden" name="id_usuario" value="<?php echo htmlspecialchars($usuario['id_usuario']); ?>">

            <div class="form-row">
                <div class="form-col">
                    <label for="nombres">Nombres:</label>
                    <input type="text" id="nombres" name="nombres" value="<?php echo htmlspecialchars($usuario['nombres']); ?>" required>
                </div>
                <div class="form-col">
                    <label for="apellidos">Apellidos:</label>
                    <input type="text" id="apellidos" name="apellidos" value="<?php echo htmlspecialchars($usuario['apellidos']); ?>" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-col">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($usuario['username']); ?>" required>
                </div>
                <div class="form-col">
                    <label for="password">Nueva clave (opcional):</label>
                    <input type="password" id="password" name="password" placeholder="Dejar en blanco para conservar">
                </div>
            </div>

            <div>
                <label for="email">Correo Electrónico:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($usuario['email']); ?>" required>
            </div>

            <div class="form-row">
                <div class="form-col">
                    <label for="telefono">Teléfono:</label>
                    <input type="text" id="telefono" name="telefono" value="<?php echo htmlspecialchars($usuario['telefono']); ?>" required>
                </div>
                <div class="form-col">
                    <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
                    <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" value="<?php echo htmlspecialchars($usuario['fecha_nacimiento']); ?>" required>
                </div>
            </div>

            <div>
                <label for="direccion">Dirección:</label>
                <textarea id="direccion" name="direccion" required><?php echo htmlspecialchars($usuario['direccion']); ?></textarea>
            </div>

            <div class="form-row">
                <div class="form-col">
                    <label for="id_rol">Rol:</label>
                    <select id="id_rol" name="id_rol" required>
                        <?php if (!empty($roles)): ?>
                            <?php foreach($roles as $rol): ?>
                                <option value="<?php echo htmlspecialchars($rol['id_rol']); ?>" <?php echo ($usuario['id_rol'] == $rol['id_rol']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($rol['nombre']); ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
                <div class="form-col">
                    <label for="estado">Estado:</label>
                    <select id="estado" name="estado">
                        <option value="1" <?php echo ($usuario['estado'] == 1) ? 'selected' : ''; ?>>Activo</option>
                        <option value="0" <?php echo ($usuario['estado'] == 0) ? 'selected' : ''; ?>>Inactivo</option>
                    </select>
                </div>
            </div>

            <div class="form-actions">
                <a class="btn btn-cancel" href="index.php?action=usuarios">Cancelar</a>
                <button class="btn btn-update" type="submit">Actualizar usuario</button>
            </div>

        </form>
    </div>
</body>
</html>