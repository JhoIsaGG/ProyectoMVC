<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./assets/css/styles.css">
    <title>Editar Nivel</title>
</head>
<body class="user-body-bg">

    <?php include __DIR__ . '/../navbar.php'; ?>

    <div class="form-container" style="margin-top: 100px;">
        <h2 class="form-title">Editar Nivel</h2>
        
        <?php if (isset($error)): ?>
            <div class="alert-error">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <form action="index.php?action=nivel_update" method="POST" class="user-form">
            <input type="hidden" name="id_nivel" value="<?php echo htmlspecialchars($nivel['id_nivel']); ?>">
            <div class="form-col">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($nivel['nombre']); ?>" required>
            </div>
            <div class="form-col">
                <label for="descripcion">Descripcion:</label>
                <input type="text" id="descripcion" name="descripcion" value="<?php echo htmlspecialchars($nivel['descripcion']); ?>" required>
            </div>
            <div class="form-col">
                <label for="estado">Estado:</label>
                <select id="estado" name="estado">
                    <option value="1" <?php echo ($nivel['estado'] == 1) ? 'selected' : ''; ?>>Activo</option>
                    <option value="0" <?php echo ($nivel['estado'] == 0) ? 'selected' : ''; ?>>Inactivo</option>
                </select>
            </div>
            <div class="form-actions">
                <a class="btn btn-cancel" href="index.php?action=niveles">Cancelar</a>
                <button class="btn btn-update" type="submit">Actualizar</button>
            </div>
        </form>
    </div>
</body>
</html>