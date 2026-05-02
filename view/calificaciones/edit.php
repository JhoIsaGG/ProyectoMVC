<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./assets/css/styles.css">
    <title>Editar Calificación</title>
</head>
<body class="user-body-bg">
    <?php include __DIR__ . '/../navbar.php'; ?>

    <div class="form-container" style="margin-top: 100px;">
        <h2 class="form-title">Editar Calificación</h2>

        <?php if (isset($error)): ?>
            <div class="alert-error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form action="index.php?action=calificacion_update" method="POST" class="user-form">
            <input type="hidden" name="id_calificacion" value="<?php echo htmlspecialchars($calificacion['id_calificacion']); ?>">

            <div class="form-row">
                <div class="form-col">
                    <label for="id_evaluacion">Evaluación:</label>
                    <select id="id_evaluacion" name="id_evaluacion" required>
                        <option value="">Seleccione una evaluación...</option>
                        <?php foreach ($evaluaciones as $ev): ?>
                            <option value="<?php echo htmlspecialchars($ev['id_evaluacion']); ?>"
                                <?php echo ($calificacion['id_evaluacion'] == $ev['id_evaluacion']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($ev['nombre_curso'] . ' — ' . $ev['nombre_tipo'] . ' (máx. ' . $ev['punteo'] . ')'); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-col">
                    <label for="id_alumno">Alumno:</label>
                    <select id="id_alumno" name="id_alumno" required>
                        <option value="">Seleccione un alumno...</option>
                        <?php foreach ($alumnos as $alumno): ?>
                            <option value="<?php echo htmlspecialchars($alumno['id_alumno']); ?>"
                                <?php echo ($calificacion['id_alumno'] == $alumno['id_alumno']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($alumno['id_alumno'] . ' - ' . $alumno['nombres'] . ' ' . $alumno['apellidos']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-col">
                    <label for="nota">Nota:</label>
                    <input type="number" step="0.01" min="0" id="nota" name="nota"
                        value="<?php echo htmlspecialchars($calificacion['nota']); ?>" required>
                </div>
            </div>
            <div>
                <label for="comentarios_profesor">Comentarios del Profesor:</label>
                <textarea id="comentarios_profesor" name="comentarios_profesor"><?php echo htmlspecialchars($calificacion['comentarios_profesor'] ?? ''); ?></textarea>
            </div>
            <div class="form-actions">
                <a class="btn btn-cancel" href="index.php?action=calificaciones">Cancelar</a>
                <button class="btn btn-update" type="submit">Actualizar</button>
            </div>
        </form>
    </div>
</body>
</html>
