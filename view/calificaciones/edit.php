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

            <input type="hidden" name="id_entrega" value="<?php echo htmlspecialchars($calificacion['id_entrega']); ?>">
            
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
                    <input type="number" step="0.01" min="0" max="<?php echo htmlspecialchars($entrega['punteo_maximo'] ?? '100'); ?>" id="nota" name="nota" 
                           value="<?php echo htmlspecialchars($calificacion['nota']); ?>" required>
                </div>
            </div>
            <div>
                <label for="comentarios_profesor">Comentarios del Profesor:</label>
                <textarea id="comentarios_profesor" name="comentarios_profesor"><?php echo htmlspecialchars($calificacion['comentarios_profesor'] ?? ''); ?></textarea>
            </div>
            <div class="form-actions">
                <a class="btn btn-cancel" href="javascript:history.back()">Cancelar</a>
                <button class="btn btn-update" type="submit">Actualizar</button>
            </div>
        </form>
    </div>
</body>
</html>
