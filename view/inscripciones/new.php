<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./assets/css/styles.css">
    <title>Crear Inscripcion</title>
</head>
<body class="user-body-bg">

    <?php include __DIR__ . '/../navbar.php'; ?>

    <div class="form-container" style="margin-top: 100px;">
        <h2 class="form-title">Crear Inscripcion</h2>
        
        <?php if (isset($error)): ?>
            <div class="alert-error">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <form action="index.php?action=inscripcion_create" method="POST" class="user-form">
            <div class="form-col">
                <label for="id_alumno">Alumno (ID):</label>
                <select id="id_alumno" name="id_alumno" required>
                    <option value="">Seleccione un alumno...</option>
                    <?php foreach ($alumnos as $alumno): ?>
                        <option value="<?php echo htmlspecialchars($alumno['id_alumno']); ?>"><?php echo htmlspecialchars($alumno['id_alumno']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-col">
                <label for="id_curso">Curso:</label>
                <select id="id_curso" name="id_curso" required>
                    <option value="">Seleccione un curso...</option>
                    <?php foreach ($cursos as $curso): ?>
                        <option value="<?php echo htmlspecialchars($curso['id_curso']); ?>"><?php echo htmlspecialchars($curso['nombre']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-actions">
                <a class="btn btn-cancel" href="index.php?action=inscripciones">Cancelar</a>
                <button class="btn btn-submit" type="submit">Guardar</button>
            </div>
        </form>
    </div>
</body>
</html>