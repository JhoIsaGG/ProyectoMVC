<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Cursos — Profesor | Academia de Idiomas</title>
    <link rel="stylesheet" href="./assets/css/styles.css">
</head>
<body>
    <?php include __DIR__ . '/../navbar.php'; ?>

    <main style="margin-top: 100px; padding: 30px;">
        <div class="mainContainer">
            <h2 class="user-management-title">Mis Cursos Asignados</h2>
            <p style="color:#aaa; margin-bottom:24px;">Hola, <strong><?php echo htmlspecialchars($_SESSION['usuario']['nombres'] ?? 'Profesor'); ?></strong>. Estos son los cursos que tienes a cargo.</p>

            <?php if (!empty($cursos)): ?>
                <div class="courses-grid">
                    <?php foreach ($cursos as $curso): ?>
                        <div class="course-card">
                            <a href="index.php?action=curso_dashboard&id_curso=<?php echo htmlspecialchars($curso['id_curso']); ?>" style="text-decoration: none; color: inherit;">
                                <div class="course-card-header">
                                    <span class="course-lang-badge"><?php echo htmlspecialchars($curso['nombre_idioma']); ?></span>
                                    <span class="course-level-badge"><?php echo htmlspecialchars($curso['nombre_nivel']); ?></span>
                                </div>
                                <h3 class="course-card-title"><?php echo htmlspecialchars($curso['nombre']); ?></h3>
                                <div class="course-card-meta">
                                    <span>📅 <?php echo htmlspecialchars($curso['fecha_inicio']); ?> — <?php echo htmlspecialchars($curso['fecha_fin']); ?></span>
                                </div>
                            </a>
                        </div>
                        
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="empty-state">No tienes cursos asignados actualmente.</div>
            <?php endif; ?>
        </div>
    </main>

    <footer>
        <p>&copy; 2026 Academia de Idiomas. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
