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
                <div>
                    <a href="index.php?action=curso_new&id_nivel=<?php echo urlencode($nivel['id_nivel']); ?>" class="btn btn-create">➕ Crear Curso</a>
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
                            <div style="display: flex; gap: 10px; margin-top: 15px; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 15px;">
                                <a href="index.php?action=curso_edit&codigo=<?php echo $curso['id_curso']; ?>" class="btn btn-edit-sm" style="flex: 1; text-align: center;">Editar</a>
                                <?php if ($curso['estado'] == 1): ?>
                                    <form action="index.php?action=curso_delete" method="POST" style="flex: 1; margin: 0;">
                                        <input type="hidden" name="codigo" value="<?php echo $curso['id_curso']; ?>">
                                        <button class="btn btn-delete-sm" type="submit" style="width: 100%;" onclick="return confirm('¿Seguro que desea desactivar este curso?');">Desactivar</button>
                                    </form>
                                <?php else: ?>
                                    <form action="index.php?action=curso_reactivate" method="POST" style="flex: 1; margin: 0;">
                                        <input type="hidden" name="codigo" value="<?php echo $curso['id_curso']; ?>">
                                        <button class="btn btn-edit-sm" type="submit" style="width: 100%; background-color: #ffd166; color: #1a1a2e;" onclick="return confirm('¿Seguro que desea reactivar este curso?');">Reactivar</button>
                                    </form>
                                <?php endif; ?>
                            </div>
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
