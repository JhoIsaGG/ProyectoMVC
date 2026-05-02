<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./assets/css/styles.css">
    <title>Calificar Entrega</title>
</head>
<body class="user-body-bg">
    <?php include __DIR__ . '/../navbar.php'; ?>

    <div class="form-container" style="margin-top: 100px;">
        <h2 class="form-title">Calificar Entrega</h2>

        <?php if (isset($error)): ?>
            <div class="alert-error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form action="index.php?action=calificacion_create" method="POST" class="user-form">
            <div class="form-row">
                <div class="form-col">
                    <label for="id_entrega">Entrega Pendiente:</label>
                    <select id="id_entrega" name="id_entrega" required>
                        <option value="">Seleccione una entrega...</option>
                        <?php foreach ($entregas as $en): ?>
                            <option value="<?php echo htmlspecialchars($en['id_entrega']); ?>">
                                <?php echo htmlspecialchars($en['nombre_alumno'] . " - " . $en['nombre_tipo'] . " (" . $en['nombre_curso'] . ")"); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-col">
                    <label for="nota">Nota:</label>
                    <input type="number" step="0.01" min="0" id="nota" name="nota" placeholder="Ej: 95.00" required>
                </div>
            </div>
            <div>
                <label for="comentarios_profesor">Comentarios del Profesor:</label>
                <textarea id="comentarios_profesor" name="comentarios_profesor" placeholder="Observaciones sobre el trabajo..."></textarea>
            </div>
            <div class="form-actions">
                <a class="btn btn-cancel" href="index.php?action=calificaciones">Cancelar</a>
                <button class="btn btn-submit" type="submit">Guardar Calificación</button>
            </div>
        </form>
    </div>
</body>
</html>
