<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Curso | Academia</title>
    <link rel="stylesheet" href="./assets/css/styles.css">
</head>
<body class="user-body-bg">
    <?php include __DIR__ . '/../navbar.php'; ?>

    <main style="margin-top: 100px; padding: 30px;">
        <div class="mainContainer" style="max-width: 1000px;">
            
            <div class="dashboard-header" style="border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 20px;">
                <div>
                    <?php if($_SESSION['usuario']['id_rol'] == 1): ?>
                    <a href="index.php?action=cursos_por_nivel&id_nivel=<?php echo urlencode($curso['id_nivel']); ?>" class="btn btn-cancel" style="display:inline-block; margin-bottom: 15px;">← Volver al Nivel</a>
                    <?php elseif($_SESSION['usuario']['id_rol'] == 2): ?>
                    <a href="index.php?action=home" class="btn btn-cancel" style="display:inline-block; margin-bottom: 15px;">← Volver a Mis Cursos</a>
                    <?php endif; ?>
                    <h2 class="user-management-title" style="margin-bottom: 5px; border-bottom: none; padding-bottom: 0;"><?php echo htmlspecialchars($curso['nombre']); ?></h2>
                    <div class="dashboard-meta">
                        📅 <?php echo htmlspecialchars($curso['fecha_inicio']); ?> a <?php echo htmlspecialchars($curso['fecha_fin']); ?> | 
                        👨‍🏫 Profesor: <?php echo htmlspecialchars($curso['nombre_profesor']); ?>
                    </div>
                </div>
                <div>
                    <a href="index.php?action=curso_edit&codigo=<?php echo urlencode($curso['id_curso']); ?>" class="btn btn-update">✏️ Editar Curso</a>
                </div>
            </div>

            <div class="dashboard-options">
                <a href="index.php?action=curso_evaluaciones&id_curso=<?php echo urlencode($curso['id_curso']); ?>" class="dashboard-card">
                    <span class="dashboard-icon">📝</span>
                    <span class="dashboard-title">Evaluaciones</span>
                    <p style="margin-top: 10px; color: #ccc;">Gestionar tipos, evaluaciones y calificaciones.</p>
                </a>
                
                <a href="index.php?action=curso_asistencias&id_curso=<?php echo urlencode($curso['id_curso']); ?>" class="dashboard-card">
                    <span class="dashboard-icon">✅</span>
                    <span class="dashboard-title">Asistencia</span>
                    <p style="margin-top: 10px; color: #ccc;">Tomar asistencia por fecha de clases.</p>
                </a>
                
                <?php if($_SESSION['usuario']['id_rol'] == 1): ?>
                <a href="index.php?action=curso_alumnos&id_curso=<?php echo urlencode($curso['id_curso']); ?>" class="dashboard-card">
                    <span class="dashboard-icon">👥</span>
                    <span class="dashboard-title">Alumnos</span>
                    <p style="margin-top: 10px; color: #ccc;">Inscribir y gestionar alumnos del curso.</p>
                </a>
                <?php endif; ?>

                  <a href="index.php?action=curso_top_alumnos&id_curso=<?php echo urlencode($curso['id_curso']); ?>" class="dashboard-card">
                    <span class="dashboard-icon">✅</span>
                    <span class="dashboard-title">Top 10 Alumnos</span>
                    <p style="margin-top: 10px; color: #ccc;">Ver los 10 mejores alumnos del curso.</p>
                </a>
            </div>

        </div>
    </main>

    <footer>
        <p>&copy; 2026 Academia de Idiomas. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
