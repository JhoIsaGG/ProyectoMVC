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
            <input type="hidden" name="id_entrega" value="<?php echo htmlspecialchars($entrega['id_entrega']); ?>">
            
            <div class="form-row">
                <div class="form-col">
                    <label>Alumno:</label>
                    <div style="color:#ffd166; font-weight:bold; margin-top:5px;">
                        <?php echo htmlspecialchars($entrega['nombre_alumno']); ?>
                    </div>
                </div>
                <div class="form-col">
                    <label>Evaluación:</label>
                    <div style="color:#ccc; margin-top:5px;">
                        <?php echo htmlspecialchars($entrega['nombre_tipo'] . " (" . $entrega['nombre_curso'] . ")"); ?>
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-col">
                    <label for="nota">Nota (Máx: <?php echo htmlspecialchars($entrega['punteo_maximo'] ?? '100'); ?>):</label>
                    <input type="number" step="0.01" min="0" max="<?php echo htmlspecialchars($entrega['punteo_maximo'] ?? '100'); ?>" id="nota" name="nota" placeholder="Ej: 95.00" required>
                </div>
            </div>
            <div>
                <label for="comentarios_profesor">Comentarios del Profesor:</label>
                <textarea id="comentarios_profesor" name="comentarios_profesor" placeholder="Observaciones sobre el trabajo..."></textarea>
            </div>
            <div class="form-actions">
                <a class="btn btn-cancel" href="javascript:history.back()">Cancelar</a>
                <button class="btn btn-submit" type="submit">Guardar Calificación</button>
            </div>
        </form>
    </div>
</body>
</html>
