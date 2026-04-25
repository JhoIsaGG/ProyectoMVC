<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio — Administrador | Academia de Idiomas</title>
    <link rel="stylesheet" href="./assets/css/styles.css">
</head>
<body>
    <?php include __DIR__ . '/navbar.php'; ?>

    <main style="margin-top: 100px; padding: 30px;">
        <div class="mainContainer">
            <h2 class="user-management-title">Todos los Cursos Activos</h2>
            <p style="color:#aaa; margin-bottom:24px;">Vista de administrador — todos los cursos disponibles con su profesor asignado.</p>

            <?php if (!empty($cursos)): ?>
                <div class="courses-grid">
                    <?php foreach ($cursos as $curso): ?>
                        <div class="course-card">
                            <div class="course-card-header">
                                <span class="course-lang-badge"><?php echo htmlspecialchars($curso['nombre_idioma']); ?></span>
                                <span class="course-level-badge"><?php echo htmlspecialchars($curso['nombre_nivel']); ?></span>
                            </div>
                            <h3 class="course-card-title"><?php echo htmlspecialchars($curso['nombre']); ?></h3>
                            <p class="course-card-teacher">👨‍🏫 <?php echo htmlspecialchars($curso['nombre_profesor']); ?></p>
                            <div class="course-card-meta">
                                <span>📅 <?php echo htmlspecialchars($curso['fecha_inicio']); ?> — <?php echo htmlspecialchars($curso['fecha_fin']); ?></span>
                                <span>🕐 <?php echo htmlspecialchars($curso['horario']); ?></span>
                                <span>👥 Cupo: <?php echo htmlspecialchars($curso['cupo_maximo']); ?></span>
                            </div>
                            <a class="btn btn-edit-sm" href="index.php?action=curso_edit&codigo=<?php echo urlencode($curso['id_curso']); ?>" style="margin-top:12px;display:inline-block;">Editar</a>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="empty-state">No hay cursos activos registrados.</div>
            <?php endif; ?>
        </div>
    </main>

    <footer>
        <p>&copy; 2026 Academia de Idiomas. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
