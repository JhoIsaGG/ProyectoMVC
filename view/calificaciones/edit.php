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
                    <label for="id_entrega">Entrega:</label>
                    <select id="id_entrega" name="id_entrega" required>
                        <?php foreach ($entregas as $en): ?>
                            <option value="<?php echo htmlspecialchars($en['id_entrega']); ?>" <?php echo ($calificacion['id_entrega'] == $en['id_entrega']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($en['nombre_alumno'] . " - " . $en['nombre_tipo'] . " (" . $en['nombre_curso'] . ")"); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
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
