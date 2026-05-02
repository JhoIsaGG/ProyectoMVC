<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./assets/css/styles.css">
    <title>Crear Curso</title>
</head>
<body class="user-body-bg">

    <?php include __DIR__ . '/../navbar.php'; ?>

    <div class="form-container" style="margin-top: 100px;">
        <h2 class="form-title">Crear Curso</h2>
        
        <?php if (isset($error)): ?>
            <div class="alert-error">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <form action="index.php?action=curso_create" method="POST" class="user-form">
            <div class="form-col">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" required>
            </div>
            <div class="form-col">
                <label for="id_idioma">Idioma:</label>
                <select id="id_idioma" name="id_idioma" required>
                    <option value="">Seleccione un idioma...</option>
                    <?php foreach ($idiomas as $idioma): ?>
                        <option value="<?php echo htmlspecialchars($idioma['id_idioma']); ?>"><?php echo htmlspecialchars($idioma['nombre']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-col">
                <label for="id_nivel">Nivel:</label>
                <?php $nivel_get = $_GET['id_nivel'] ?? null; ?>
                <?php if ($nivel_get): ?>
                    <input type="hidden" name="id_nivel" value="<?php echo htmlspecialchars($nivel_get); ?>">
                <?php endif; ?>
                <select id="id_nivel" name="id_nivel" <?php echo $nivel_get ? 'disabled' : 'required'; ?>>
                    <option value="">Seleccione un nivel...</option>
                    <?php foreach ($niveles as $nivel): ?>
                        <option value="<?php echo htmlspecialchars($nivel['id_nivel']); ?>" <?php echo ($nivel_get == $nivel['id_nivel']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($nivel['nombre']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-col">
                <label for="id_profesor">Profesor:</label>
                <select id="id_profesor" name="id_profesor" required>
                    <option value="">Seleccione un profesor...</option>
                    <?php foreach ($profesores as $prof): ?>
                        <option value="<?php echo htmlspecialchars($prof['id_profesor']); ?>"><?php echo htmlspecialchars($prof['id_profesor'] . ' - ' . $prof['nombres'] . ' ' . $prof['apellidos']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-col">
                <label for="id_aula">Aula:</label>
                <select id="id_aula" name="id_aula" required>
                    <option value="">Seleccione un aula...</option>
                    <?php foreach ($aulas as $aula): ?>
                        <option value="<?php echo htmlspecialchars($aula['id_aula']); ?>">
                            <?php echo htmlspecialchars($aula['nombre'] . " (Capacidad: " . $aula['capacidad'] . ")"); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-col">
                <label for="fecha_inicio">Fecha_inicio:</label>
                <input type="date" id="fecha_inicio" name="fecha_inicio" required>
            </div>
            <div class="form-col">
                <label for="fecha_fin">Fecha Fin:</label>
                <input type="date" id="fecha_fin" name="fecha_fin" required>
            </div>

            <hr style="border: 0; border-top: 1px solid rgba(255,255,255,0.1); margin: 20px 0;">
            <h3 style="color: #ffd166; margin-bottom: 15px;">Horario del Curso</h3>

            <div class="form-row" style="display: flex; gap: 15px;">
                <div class="form-col" style="flex: 1;">
                    <label for="dia_semana">Día de la semana:</label>
                    <select id="dia_semana" name="dia_semana" required>
                        <option value="">Seleccione un día...</option>
                        <option value="1">Lunes</option>
                        <option value="2">Martes</option>
                        <option value="3">Miércoles</option>
                        <option value="4">Jueves</option>
                        <option value="5">Viernes</option>
                        <option value="6">Sábado</option>
                        <option value="7">Domingo</option>
                    </select>
                </div>
                <div class="form-col" style="flex: 1;">
                    <label for="hora_inicio">Hora Inicio:</label>
                    <input type="time" id="hora_inicio" name="hora_inicio" required>
                </div>
                <div class="form-col" style="flex: 1;">
                    <label for="hora_fin">Hora Fin:</label>
                    <input type="time" id="hora_fin" name="hora_fin" required>
                </div>
            </div>

            <div class="form-col" style="margin-top: 20px;">
                <label for="estado">Estado:</label>
                <select id="estado" name="estado">
                    <option value="1">Activo</option>
                    <option value="0">Inactivo</option>
                </select>
            </div>
            <div class="form-actions">
                <a class="btn btn-cancel" href="javascript:history.back()">Cancelar</a>
                <button class="btn btn-submit" type="submit">Guardar</button>
            </div>
        </form>
    </div>
</body>
</html>