<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./assets/css/styles.css">
    <title>Editar Horario</title>
</head>
<body class="user-body-bg">
    <?php include __DIR__ . '/../navbar.php'; ?>

    <div class="form-container" style="margin-top: 100px;">
        <h2 class="form-title">Editar Horario de Curso</h2>

        <?php if (isset($error)): ?>
            <div class="alert-error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form action="index.php?action=horario_curso_update" method="POST" class="user-form">
            <input type="hidden" name="id_horario" value="<?php echo htmlspecialchars($horario['id_horario']); ?>">

            <div class="form-row">
                <div class="form-col">
                    <label for="id_curso">Curso:</label>
                    <select id="id_curso" name="id_curso" required>
                        <option value="">Seleccione un curso...</option>
                        <?php foreach ($cursos as $curso): ?>
                            <option value="<?php echo htmlspecialchars($curso['id_curso']); ?>"
                                <?php echo ($horario['id_curso'] == $curso['id_curso']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($curso['nombre']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-col">
                    <label for="dia_semana">Día:</label>
                    <select id="dia_semana" name="dia_semana" required>
                        <?php foreach ($dias as $val => $label): ?>
                            <option value="<?php echo $val; ?>" <?php echo ($horario['dia_semana'] == $val) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($label); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-col">
                    <label for="hora_inicio">Hora Inicio:</label>
                    <input type="time" id="hora_inicio" name="hora_inicio"
                        value="<?php echo htmlspecialchars(substr($horario['hora_inicio'], 0, 5)); ?>" required>
                </div>
                <div class="form-col">
                    <label for="hora_fin">Hora Fin:</label>
                    <input type="time" id="hora_fin" name="hora_fin"
                        value="<?php echo htmlspecialchars(substr($horario['hora_fin'], 0, 5)); ?>" required>
                </div>
            </div>
            <div class="form-actions">
                <a class="btn btn-cancel" href="index.php?action=horarios">Cancelar</a>
                <button class="btn btn-update" type="submit">Actualizar</button>
            </div>
        </form>
    </div>
</body>
</html>
