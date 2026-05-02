<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./assets/css/styles.css">
    <title>Editar Asistencia</title>
</head>
<body class="user-body-bg">
    <?php include __DIR__ . '/../navbar.php'; ?>

    <div class="form-container" style="margin-top: 100px;">
        <h2 class="form-title">Editar Asistencia</h2>

        <?php if (isset($error)): ?>
            <div class="alert-error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form action="index.php?action=asistencia_update" method="POST" class="user-form">
            <input type="hidden" name="id_asistencia" value="<?php echo htmlspecialchars($asistencia['id_asistencia']); ?>">

            <div class="form-row">
                <div class="form-col">
                    <label for="id_curso">Curso:</label>
                    <select id="id_curso" name="id_curso" required>
                        <option value="">Seleccione un curso...</option>
                        <?php foreach ($cursos as $curso): ?>
                            <option value="<?php echo htmlspecialchars($curso['id_curso']); ?>"
                                <?php echo ($asistencia['id_curso'] == $curso['id_curso']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($curso['nombre']); ?>
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
                                <?php echo ($asistencia['id_alumno'] == $alumno['id_alumno']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($alumno['id_alumno'] . ' - ' . $alumno['nombres'] . ' ' . $alumno['apellidos']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-col">
                    <label for="fecha">Fecha:</label>
                    <input type="date" id="fecha" name="fecha" value="<?php echo htmlspecialchars($asistencia['fecha']); ?>" required>
                </div>
                <div class="form-col">
                    <label for="estado">Estado:</label>
                    <select id="estado" name="estado" required>
                        <?php foreach ($estados as $val => $label): ?>
                            <option value="<?php echo $val; ?>" <?php echo ($asistencia['estado'] == $val) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($label); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div>
                <label for="observaciones">Observaciones:</label>
                <input type="text" id="observaciones" name="observaciones"
                    value="<?php echo htmlspecialchars($asistencia['observaciones'] ?? ''); ?>">
            </div>
            <div class="form-actions">
                <a class="btn btn-cancel" href="index.php?action=asistencias">Cancelar</a>
                <button class="btn btn-update" type="submit">Actualizar</button>
            </div>
        </form>
    </div>
</body>
</html>
