<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./assets/css/styles.css">
    <title>Crear Evaluacion</title>
</head>
<body class="user-body-bg">

    <?php include __DIR__ . '/../navbar.php'; ?>

    <div class="form-container" style="margin-top: 100px;">
        <h2 class="form-title">Crear Evaluacion</h2>
        
        <?php if (isset($error)): ?>
            <div class="alert-error">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <form action="index.php?action=evaluacion_create" method="POST" class="user-form">
            <div class="form-col">
                <label for="id_curso">Curso:</label>
                <select id="id_curso" name="id_curso" required>
                    <option value="">Seleccione un curso...</option>
                    <?php foreach ($cursos as $curso): ?>
                        <option value="<?php echo htmlspecialchars($curso['id_curso']); ?>"><?php echo htmlspecialchars($curso['nombre']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-col">
                <label for="punteo">Punteo:</label>
                <input type="text" id="punteo" name="punteo" required>
            </div>
            <div class="form-col">
                <label for="id_tipo_evaluacion">Tipo de Evaluación:</label>
                <select id="id_tipo_evaluacion" name="id_tipo_evaluacion" required>
                    <option value="">Seleccione un tipo...</option>
                    <?php foreach ($tipos as $tipo): ?>
                        <option value="<?php echo htmlspecialchars($tipo['id_tipo_evaluacion']); ?>"><?php echo htmlspecialchars($tipo['nombre']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-col">
                <label for="fecha_publicacion">Fecha_publicacion:</label>
                <input type="date" id="fecha_publicacion" name="fecha_publicacion" required>
            </div>
            <div class="form-col">
                <label for="fecha_entrega">Fecha_entrega:</label>
                <input type="date" id="fecha_entrega" name="fecha_entrega" required>
            </div>
            <div class="form-col">
                <label for="observaciones">Observaciones:</label>
                <input type="text" id="observaciones" name="observaciones" required>
            </div>
            <div class="form-col">
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