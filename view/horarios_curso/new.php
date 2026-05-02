<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./assets/css/styles.css">
    <title>Crear Horario</title>
</head>
<body class="user-body-bg">
    <?php include __DIR__ . '/../navbar.php'; ?>

    <div class="form-container" style="margin-top: 100px;">
        <h2 class="form-title">Agregar Horario de Curso</h2>

        <?php if (isset($error)): ?>
            <div class="alert-error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form action="index.php?action=horario_curso_create" method="POST" class="user-form">
            <div class="form-row">
                <div class="form-col">
                    <label for="id_curso">Curso:</label>
                    <select id="id_curso" name="id_curso" required>
                        <option value="">Seleccione un curso...</option>
                        <?php foreach ($cursos as $curso): ?>
                            <option value="<?php echo htmlspecialchars($curso['id_curso']); ?>">
                                <?php echo htmlspecialchars($curso['nombre']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-col">
                    <label for="id_aula">Aula:</label>
                    <select id="id_aula" name="id_aula" required>
                        <option value="">Seleccione un aula...</option>
                        <?php foreach ($aulas as $aula): ?>
                            <option value="<?php echo htmlspecialchars($aula['id_aula']); ?>">
                                <?php echo htmlspecialchars($aula['nombre'] . ' (cap. ' . $aula['capacidad'] . ')'); ?>
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
                            <option value="<?php echo $val; ?>"><?php echo htmlspecialchars($label); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-col">
                    <label for="hora_inicio">Hora Inicio:</label>
                    <input type="time" id="hora_inicio" name="hora_inicio" required>
                </div>
                <div class="form-col">
                    <label for="hora_fin">Hora Fin:</label>
                    <input type="time" id="hora_fin" name="hora_fin" required>
                </div>
            </div>
            <div class="form-actions">
                <a class="btn btn-cancel" href="index.php?action=horarios">Cancelar</a>
                <button class="btn btn-submit" type="submit">Guardar</button>
            </div>
        </form>
    </div>
</body>
</html>
