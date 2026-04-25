<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./assets/css/styles.css">
    <title>Editar Profesor</title>
</head>
<body class="user-body-bg">
    <?php include __DIR__ . '/../navbar.php'; ?>

    <div class="form-container" style="margin-top: 100px;">
        <h2 class="form-title">Editar Profesor</h2>
        
        <?php if (isset($error)): ?>
            <div class="alert-error">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <form action="index.php?action=profesor_update" method="POST" class="user-form">
            
            <input type="hidden" name="id_profesor" value="<?php echo htmlspecialchars($profesor['id_profesor']); ?>">
            <input type="hidden" name="id_usuario" value="<?php echo htmlspecialchars($profesor['id_usuario']); ?>">
            <input type="hidden" name="id_rol" value="<?php echo htmlspecialchars($profesor['id_rol']); ?>">

            <div class="form-row">
                <div class="form-col">
                    <label for="nombres">Nombres:</label>
                    <input type="text" id="nombres" name="nombres" value="<?php echo htmlspecialchars($profesor['nombres']); ?>" required>
                </div>
                <div class="form-col">
                    <label for="apellidos">Apellidos:</label>
                    <input type="text" id="apellidos" name="apellidos" value="<?php echo htmlspecialchars($profesor['apellidos']); ?>" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-col">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($profesor['username']); ?>" required>
                </div>
                <div class="form-col">
                    <label for="password">Nueva clave (opcional):</label>
                    <input type="password" id="password" name="password" placeholder="Dejar en blanco para conservar">
                </div>
            </div>

            <div>
                <label for="email">Correo Electrónico:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($profesor['email']); ?>" required>
            </div>

            <div class="form-row">
                <div class="form-col">
                    <label for="telefono">Teléfono:</label>
                    <input type="text" id="telefono" name="telefono" value="<?php echo htmlspecialchars($profesor['telefono']); ?>" required>
                </div>
                <div class="form-col">
                    <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
                    <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" value="<?php echo htmlspecialchars($profesor['fecha_nacimiento']); ?>" required>
                </div>
            </div>

            <div>
                <label for="direccion">Dirección:</label>
                <textarea id="direccion" name="direccion" required><?php echo htmlspecialchars($profesor['direccion']); ?></textarea>
            </div>

            <div class="form-row">
                <div class="form-col">
                    <label for="estado">Estado:</label>
                    <select id="estado" name="estado">
                        <option value="1" <?php echo ($profesor['estado'] == 1) ? 'selected' : ''; ?>>Activo</option>
                        <option value="0" <?php echo ($profesor['estado'] == 0) ? 'selected' : ''; ?>>Inactivo</option>
                    </select>
                </div>
            </div>

            <div id="seccion_idiomas" style="margin-top: 15px;">
                <label>Idiomas que domina:</label>
                <div class="checkbox-group" style="display:flex; flex-wrap:wrap; gap:10px;">
                    <?php if (!empty($idiomas)): ?>
                        <?php foreach($idiomas as $idioma): ?>
                            <label style="display:flex; align-items:center; gap:5px; font-weight:normal;">
                                <input type="checkbox" name="id_idiomas[]" value="<?php echo htmlspecialchars($idioma['id_idioma']); ?>" <?php echo (isset($idiomasSeleccionados) && in_array($idioma['id_idioma'], $idiomasSeleccionados)) ? 'checked' : ''; ?>>
                                <?php echo htmlspecialchars($idioma['nombre']); ?>
                            </label>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

            <div class="form-actions">
                <a class="btn btn-cancel" href="index.php?action=profesores">Cancelar</a>
                <button class="btn btn-update" type="submit">Actualizar profesor</button>
            </div>

        </form>
    </div>
</body>
</html>