<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./assets/css/styles.css">
    <title>Crear Tipo_evaluacion</title>
</head>
<body class="user-body-bg">

    <?php include __DIR__ . '/../navbar.php'; ?>

    <div class="form-container" style="margin-top: 100px;">
        <h2 class="form-title">Crear Tipo_evaluacion</h2>
        
        <?php if (isset($error)): ?>
            <div class="alert-error">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <form action="index.php?action=tipo_evaluacion_create" method="POST" class="user-form">
            <div class="form-col">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" required>
            </div>
            <div class="form-actions">
                <a class="btn btn-cancel" href="index.php?action=tipos_evaluacion">Cancelar</a>
                <button class="btn btn-submit" type="submit">Guardar</button>
            </div>
        </form>
    </div>
</body>
</html>