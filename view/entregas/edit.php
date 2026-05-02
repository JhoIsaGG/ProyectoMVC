<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./assets/css/styles.css">
    <title>Editar Entrega</title>
</head>
<body class="user-body-bg">
    <?php include __DIR__ . '/../navbar.php'; ?>

    <div class="form-container" style="margin-top: 100px;">
        <h2 class="form-title">Editar Entrega</h2>

        <?php if (isset($error)): ?>
            <div class="alert-error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form action="index.php?action=entrega_update" method="POST" class="user-form">
            <input type="hidden" name="id_entrega" value="<?php echo htmlspecialchars($entrega['id_entrega']); ?>">

            <div class="form-row">
                <div class="form-col">
                    <label for="id_evaluacion">Evaluación:</label>
                    <select id="id_evaluacion" name="id_evaluacion" required>
                        <?php foreach ($evaluaciones as $ev): ?>
                            <option value="<?php echo htmlspecialchars($ev['id_evaluacion']); ?>" <?php echo ($entrega['id_evaluacion'] == $ev['id_evaluacion']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($ev['nombre_curso'] . ' — ' . $ev['nombre_tipo']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-col">
                    <label for="id_alumno">Alumno:</label>
                    <select id="id_alumno" name="id_alumno" required>
                        <?php foreach ($alumnos as $alumno): ?>
                            <option value="<?php echo htmlspecialchars($alumno['id_alumno']); ?>" <?php echo ($entrega['id_alumno'] == $alumno['id_alumno']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($alumno['nombres'] . ' ' . $alumno['apellidos']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-col">
                    <label for="estado">Estado:</label>
                    <select id="estado" name="estado">
                        <option value="1" <?php echo ($entrega['estado'] == 1) ? 'selected' : ''; ?>>Entregado</option>
                        <option value="0" <?php echo ($entrega['estado'] == 0) ? 'selected' : ''; ?>>Anulado / Pendiente</option>
                    </select>
                </div>
            </div>
            <div class="form-actions">
                <a class="btn btn-cancel" href="index.php?action=entregas">Cancelar</a>
                <button class="btn btn-update" type="submit">Actualizar</button>
            </div>
        </form>
    </div>
</body>
</html>
