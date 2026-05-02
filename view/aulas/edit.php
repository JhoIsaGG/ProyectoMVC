<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./assets/css/styles.css">
    <title>Editar Aula</title>
</head>
<body class="user-body-bg">
    <?php include __DIR__ . '/../navbar.php'; ?>

    <div class="form-container" style="margin-top: 100px;">
        <h2 class="form-title">Editar Aula</h2>

        <?php if (isset($error)): ?>
            <div class="alert-error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form action="index.php?action=aula_update" method="POST" class="user-form">
            <input type="hidden" name="id_aula" value="<?php echo htmlspecialchars($aula['id_aula']); ?>">

            <div class="form-row">
                <div class="form-col">
                    <label for="nombre">Nombre del Aula:</label>
                    <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($aula['nombre']); ?>" required>
                </div>
                <div class="form-col">
                    <label for="capacidad">Capacidad:</label>
                    <input type="number" id="capacidad" name="capacidad" min="1" value="<?php echo htmlspecialchars($aula['capacidad']); ?>" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-col">
                    <label for="tipo">Tipo:</label>
                    <select id="tipo" name="tipo" required>
                        <?php foreach ($tipos as $val => $label): ?>
                            <option value="<?php echo $val; ?>" <?php echo ($aula['tipo'] == $val) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($label); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-col">
                    <label for="estado">Estado:</label>
                    <select id="estado" name="estado">
                        <option value="1" <?php echo ($aula['estado'] == 1) ? 'selected' : ''; ?>>Activa</option>
                        <option value="0" <?php echo ($aula['estado'] == 0) ? 'selected' : ''; ?>>Inactiva</option>
                    </select>
                </div>
            </div>
            <div class="form-actions">
                <a class="btn btn-cancel" href="index.php?action=aulas">Cancelar</a>
                <button class="btn btn-update" type="submit">Actualizar</button>
            </div>
        </form>
    </div>
</body>
</html>
