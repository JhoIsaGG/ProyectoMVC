<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cursos de <?php echo htmlspecialchars($nivel['nombre']); ?> | Academia</title>
    <link rel="stylesheet" href="./assets/css/styles.css">
</head>
<body class="user-body-bg">
    <?php include __DIR__ . '/../navbar.php'; ?>

    <main style="margin-top: 100px; padding: 30px;">
        <div class="mainContainer">
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px;">
                <div>
                    <a href="index.php?action=home" class="btn btn-cancel" style="display:inline-block; margin-bottom: 15px;">← Volver a Niveles</a>
                    <h2 class="user-management-title">Cursos del nivel: <?php echo htmlspecialchars($nivel['nombre']); ?></h2>
                </div>
            </div>

            <?php if (!empty($cursos)): ?>
                <div class="courses-grid">
                    <?php foreach ($cursos as $curso): ?>
                        <div class="course-card">
                            <!-- Aquí en el futuro enlazaremos al dashboard del curso -->
                            <a href="index.php?action=curso_dashboard&id_curso=<?php echo urlencode($curso['id_curso']); ?>" style="text-decoration: none; color: inherit;">
                                <div class="course-card-header">
                                    <span class="course-lang-badge"><?php echo htmlspecialchars($curso['nombre_idioma']); ?></span>
                                    <?php if ($curso['estado'] == 1): ?>
                                        <span class="badge-active">Activo</span>
                                    <?php else: ?>
                                        <span class="badge-inactive">Inactivo</span>
                                    <?php endif; ?>
                                </div>
                                <h3 class="course-card-title"><?php echo htmlspecialchars($curso['nombre']); ?></h3>
                                <p class="course-card-teacher">👨‍🏫 <?php echo htmlspecialchars($curso['nombre_profesor']); ?></p>
                                <div class="course-card-meta" style="margin-top:10px;">
                                    <span>🏫 Aula: <?php echo htmlspecialchars($curso['nombre_aula']); ?></span><br>
                                    <span>📅 <?php echo htmlspecialchars($curso['fecha_inicio']); ?> — <?php echo htmlspecialchars($curso['fecha_fin']); ?></span>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="empty-state">No hay cursos registrados para este nivel.</div>
            <?php endif; ?>
        </div>
    </main>

    <footer>
        <p>&copy; 2026 Academia de Idiomas. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
