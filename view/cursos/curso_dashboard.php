<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Curso | Academia</title>
    <link rel="stylesheet" href="./assets/css/styles.css">
    <style>
        .dashboard-options {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
            margin-top: 30px;
        }
        .dashboard-card {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            padding: 40px 20px;
            text-align: center;
            transition: all 0.3s ease;
            text-decoration: none;
            color: white;
            display: block;
        }
        .dashboard-card:hover {
            transform: translateY(-5px);
            background: rgba(255, 255, 255, 0.1);
            border-color: #ffd166;
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        }
        .dashboard-icon {
            font-size: 3em;
            margin-bottom: 15px;
            display: block;
        }
        .dashboard-title {
            font-size: 1.5em;
            font-weight: bold;
            color: #ffd166;
        }
    </style>
</head>
<body class="user-body-bg">
    <?php include __DIR__ . '/../navbar.php'; ?>

    <main style="margin-top: 100px; padding: 30px;">
        <div class="mainContainer" style="max-width: 1000px;">
            
            <div class="dashboard-header" style="border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 20px;">
                <div>
                    <a href="index.php?action=cursos_por_nivel&id_nivel=<?php echo urlencode($curso['id_nivel']); ?>" class="btn btn-cancel" style="display:inline-block; margin-bottom: 15px;">← Volver al Nivel</a>
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
                
                <a href="index.php?action=curso_alumnos&id_curso=<?php echo urlencode($curso['id_curso']); ?>" class="dashboard-card">
                    <span class="dashboard-icon">👥</span>
                    <span class="dashboard-title">Alumnos</span>
                    <p style="margin-top: 10px; color: #ccc;">Inscribir y gestionar alumnos del curso.</p>
                </a>
            </div>

        </div>
    </main>

    <footer>
        <p>&copy; 2026 Academia de Idiomas. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
