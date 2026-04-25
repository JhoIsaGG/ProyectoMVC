<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./assets/css/styles.css">
    <title>Editar Evaluacion</title>
</head>
<body class="user-body-bg">

    <?php include __DIR__ . '/../navbar.php'; ?>

    <div class="form-container" style="margin-top: 100px;">
        <h2 class="form-title">Editar Evaluacion</h2>
        
        <?php if (isset($error)): ?>
            <div class="alert-error">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <form action="index.php?action=evaluacion_update" method="POST" class="user-form">
            <input type="hidden" name="id_evaluacion" value="<?php echo htmlspecialchars($evaluacion['id_evaluacion']); ?>">
            <div class="form-col">
                <label for="id_curso">Curso:</label>
                <select id="id_curso" name="id_curso" required>
                    <option value="">Seleccione un curso...</option>
                    <?php foreach ($cursos as $curso): ?>
                        <option value="<?php echo htmlspecialchars($curso['id_curso']); ?>" <?php echo ($evaluacion['id_curso'] == $curso['id_curso']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($curso['nombre']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-col">
                <label for="nota">Nota:</label>
                <input type="text" id="nota" name="nota" value="<?php echo htmlspecialchars($evaluacion['nota']); ?>" required>
            </div>
            <div class="form-col">
                <label for="id_tipo_evaluacion">Tipo de Evaluación:</label>
                <select id="id_tipo_evaluacion" name="id_tipo_evaluacion" required>
                    <option value="">Seleccione un tipo...</option>
                    <?php foreach ($tipos as $tipo): ?>
                        <option value="<?php echo htmlspecialchars($tipo['id_tipo_evaluacion']); ?>" <?php echo ($evaluacion['id_tipo_evaluacion'] == $tipo['id_tipo_evaluacion']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($tipo['nombre']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-col">
                <label for="fecha_publicacion">Fecha_publicacion:</label>
                <input type="date" id="fecha_publicacion" name="fecha_publicacion" value="<?php echo htmlspecialchars($evaluacion['fecha_publicacion']); ?>" required>
            </div>
            <div class="form-col">
                <label for="fecha_entrega">Fecha_entrega:</label>
                <input type="date" id="fecha_entrega" name="fecha_entrega" value="<?php echo htmlspecialchars($evaluacion['fecha_entrega']); ?>" required>
            </div>
            <div class="form-col">
                <label for="observaciones">Observaciones:</label>
                <input type="text" id="observaciones" name="observaciones" value="<?php echo htmlspecialchars($evaluacion['observaciones']); ?>" required>
            </div>
            <div class="form-col">
                <label for="estado">Estado:</label>
                <select id="estado" name="estado">
                    <option value="1" <?php echo ($evaluacion['estado'] == 1) ? 'selected' : ''; ?>>Activo</option>
                    <option value="0" <?php echo ($evaluacion['estado'] == 0) ? 'selected' : ''; ?>>Inactivo</option>
                </select>
            </div>
            <div class="form-actions">
                <a class="btn btn-cancel" href="index.php?action=evaluaciones">Cancelar</a>
                <button class="btn btn-update" type="submit">Actualizar</button>
            </div>
        </form>
    </div>
</body>
</html>