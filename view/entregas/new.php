<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./assets/css/styles.css">
    <title>Registrar Entrega</title>
</head>
<body class="user-body-bg">
    <?php include __DIR__ . '/../navbar.php'; ?>

    <div class="form-container" style="margin-top: 100px;">
        <h2 class="form-title">Registrar Entrega</h2>

        <?php if (isset($error)): ?>
            <div class="alert-error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form action="index.php?action=entrega_create" method="POST" class="user-form">
            <div class="form-row">
                <div class="form-col">
                    <label for="id_evaluacion">Evaluación:</label>
                    <select id="id_evaluacion" name="id_evaluacion" required>
                        <option value="">Seleccione una evaluación...</option>
                        <?php foreach ($evaluaciones as $ev): ?>
                            <option value="<?php echo htmlspecialchars($ev['id_evaluacion']); ?>">
                                <?php echo htmlspecialchars($ev['nombre_curso'] . ' — ' . $ev['nombre_tipo']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-col">
                    <label for="id_alumno">Alumno:</label>
                    <select id="id_alumno" name="id_alumno" required>
                        <option value="">Seleccione un alumno...</option>
                        <?php foreach ($alumnos as $alumno): ?>
                            <option value="<?php echo htmlspecialchars($alumno['id_alumno']); ?>">
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
                        <option value="1">Entregado</option>
                        <option value="0">Anulado / Pendiente</option>
                    </select>
                </div>
            </div>
            <div class="form-actions">
                <a class="btn btn-cancel" href="index.php?action=entregas">Cancelar</a>
                <button class="btn btn-submit" type="submit">Guardar Entrega</button>
            </div>
        </form>
    </div>
</body>
</html>
