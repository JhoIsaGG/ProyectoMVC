<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle del Curso | Academia de Idiomas</title>
    <link rel="stylesheet" href="./assets/css/styles.css">
</head>
<body>
    <?php include __DIR__ . '/../navbar.php'; ?>

    <main style="margin-top: 100px; padding: 30px;">
        <div class="mainContainer">
            <a href="index.php?action=home" class="btn btn-cancel" style="margin-bottom:20px;display:inline-block;">← Volver</a>

            <h3 class="user-management-title">Evaluaciones del Curso</h3>

            <?php if (!empty($evaluaciones)): ?>
                <div class="table-responsive">
                    <table class="users-table-modern">
                        <thead>
                            <tr>
                                <th>Tipo</th>
                                <th>Punteo</th>
                                <th>Fecha Publicación</th>
                                <th>Fecha Entrega</th>
                                <th>Observaciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($evaluaciones as $ev): ?>
                                <tr class="element-user">
                                    <td><strong><?php echo htmlspecialchars($ev['nombre_tipo']); ?></strong></td>
                                    <td><?php echo $ev['punteo'] !== null ? htmlspecialchars($ev['punteo']) : '<em style="color:#aaa">Pendiente</em>'; ?></td>
                                    <td><?php echo htmlspecialchars($ev['fecha_publicacion'] ?? '—'); ?></td>
                                    <td><?php echo htmlspecialchars($ev['fecha_entrega'] ?? '—'); ?></td>
                                    <td><?php echo htmlspecialchars($ev['observaciones'] ?? '—'); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="empty-state">No hay evaluaciones registradas para este curso.</div>
            <?php endif; ?>
        </div>
    </main>

    <footer>
        <p>&copy; 2026 Academia de Idiomas. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
