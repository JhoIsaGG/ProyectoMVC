<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./assets/css/styles.css">
    <title>Editar Curso</title>
</head>
<body class="user-body-bg">

    <?php include __DIR__ . '/../navbar.php'; ?>

    <div class="form-container" style="margin-top: 100px;">
        <h2 class="form-title">Editar Curso</h2>
        
        <?php if (isset($error)): ?>
            <div class="alert-error">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <form action="index.php?action=curso_update" method="POST" class="user-form">
            <input type="hidden" name="id_curso" value="<?php echo htmlspecialchars($curso['id_curso']); ?>">
            <div class="form-col">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($curso['nombre']); ?>" required>
            </div>
            <div class="form-col">
                <label for="id_idioma">Idioma:</label>
                <select id="id_idioma" name="id_idioma" required>
                    <option value="">Seleccione un idioma...</option>
                    <?php foreach ($idiomas as $idioma): ?>
                        <option value="<?php echo htmlspecialchars($idioma['id_idioma']); ?>" <?php echo ($curso['id_idioma'] == $idioma['id_idioma']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($idioma['nombre']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-col">
                <label for="id_nivel">Nivel:</label>
                <select id="id_nivel" name="id_nivel" required>
                    <option value="">Seleccione un nivel...</option>
                    <?php foreach ($niveles as $nivel): ?>
                        <option value="<?php echo htmlspecialchars($nivel['id_nivel']); ?>" <?php echo ($curso['id_nivel'] == $nivel['id_nivel']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($nivel['nombre']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-col">
                <label for="id_profesor">Profesor (ID):</label>
                <select id="id_profesor" name="id_profesor" required>
                    <option value="">Seleccione un profesor...</option>
                    <?php foreach ($profesores as $prof): ?>
                        <option value="<?php echo htmlspecialchars($prof['id_profesor']); ?>" <?php echo ($curso['id_profesor'] == $prof['id_profesor']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($prof['id_profesor']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-col">
                <label for="fecha_inicio">Fecha_inicio:</label>
                <input type="date" id="fecha_inicio" name="fecha_inicio" value="<?php echo htmlspecialchars($curso['fecha_inicio']); ?>" required>
            </div>
            <div class="form-col">
                <label for="fecha_fin">Fecha_fin:</label>
                <input type="date" id="fecha_fin" name="fecha_fin" value="<?php echo htmlspecialchars($curso['fecha_fin']); ?>" required>
            </div>
            <div class="form-col">
                <label for="horario">Horario:</label>
                <input type="text" id="horario" name="horario" value="<?php echo htmlspecialchars($curso['horario']); ?>" required>
            </div>
            <div class="form-col">
                <label for="cupo_maximo">Cupo_maximo:</label>
                <input type="text" id="cupo_maximo" name="cupo_maximo" value="<?php echo htmlspecialchars($curso['cupo_maximo']); ?>" required>
            </div>
            <div class="form-col">
                <label for="estado">Estado:</label>
                <select id="estado" name="estado">
                    <option value="1" <?php echo ($curso['estado'] == 1) ? 'selected' : ''; ?>>Activo</option>
                    <option value="0" <?php echo ($curso['estado'] == 0) ? 'selected' : ''; ?>>Inactivo</option>
                </select>
            </div>
            <div class="form-actions">
                <a class="btn btn-cancel" href="index.php?action=cursos">Cancelar</a>
                <button class="btn btn-update" type="submit">Actualizar</button>
            </div>
        </form>
    </div>
</body>
</html>