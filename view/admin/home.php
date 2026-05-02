<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio — Administrador | Academia de Idiomas</title>
    <link rel="stylesheet" href="./assets/css/styles.css">
</head>
<body class="user-body-bg">
    <?php include __DIR__ . '/../navbar.php'; ?>

    <main style="margin-top: 100px; padding: 30px;">
        <div class="mainContainer">
            <h2 class="user-management-title">Niveles Educativos</h2>
            <p style="color:#aaa; margin-bottom:24px;">Seleccione un nivel para gestionar sus cursos asociados.</p>

            <?php if (!empty($niveles)): ?>
                <div class="courses-grid">
                    <?php foreach ($niveles as $nivel): ?>
                        <div class="course-card">
                            <a href="index.php?action=cursos_por_nivel&id_nivel=<?php echo urlencode($nivel['id_nivel']); ?>" style="text-decoration: none; color: inherit;">
                                <div class="course-card-header" style="justify-content: space-between;">
                                    <span class="course-level-badge" style="font-size: 1.2em;"><?php echo htmlspecialchars($nivel['nombre']); ?></span>
                                    <span class="badge-active" style="background-color: var(--primary-accent);"><?php echo htmlspecialchars($nivel['cursos_activos']); ?> Cursos Activos</span>
                                </div>
                                <p class="course-card-teacher" style="margin-top: 15px; color: #ccc;">
                                    <?php echo htmlspecialchars($nivel['descripcion'] ?? 'Sin descripción'); ?>
                                </p>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="empty-state">No hay niveles activos registrados en el sistema.</div>
            <?php endif; ?>
        </div>
    </main>

    <footer>
        <p>&copy; 2026 Academia de Idiomas. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
