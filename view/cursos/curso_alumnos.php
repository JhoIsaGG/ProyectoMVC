<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alumnos del Curso | Academia</title>
    <link rel="stylesheet" href="./assets/css/styles.css">
</head>
<body class="user-body-bg">
    <?php include __DIR__ . '/../navbar.php'; ?>

    <main style="margin-top: 100px; padding: 30px;">
        <div class="mainContainer" style="max-width: 1000px;">
            
            <div class="dashboard-header">
                <div>
                    <a href="index.php?action=curso_dashboard&id_curso=<?php echo urlencode($curso['id_curso']); ?>" class="btn btn-cancel" style="display:inline-block; margin-bottom: 15px;">← Volver al Dashboard</a>
                    <h2 class="user-management-title" style="margin-bottom: 5px;">Alumnos: <?php echo htmlspecialchars($curso['nombre']); ?></h2>
                </div>
            </div>

            <div class="tabs-container">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:15px;">
                    <h3 style="color:#ffd166;">Alumnos Inscritos</h3>
                    
                    <form action="index.php?action=inscripcion_create" method="POST" style="display:flex; gap:10px;">
                        <input type="hidden" name="id_curso" value="<?php echo $curso['id_curso']; ?>">
                        <select name="id_alumno" required style="padding:6px; border-radius:4px; min-width:200px;">
                            <option value="">Seleccione un alumno para inscribir...</option>
                            <?php foreach ($todos_los_alumnos as $al): ?>
                                <option value="<?php echo $al['id_alumno']; ?>">
                                    <?php echo htmlspecialchars($al['nombres'] . ' ' . $al['apellidos']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <button type="submit" class="btn btn-create-user" style="padding: 6px 15px;">Inscribir</button>
                    </form>
                </div>

                <?php if (!empty($inscripciones_curso)): ?>
                    <table class="users-table-modern">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Alumno</th>
                                <th>Fecha Inscripción</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($inscripciones_curso as $ins): ?>
                                <tr class="element-user">
                                    <td><?php echo $ins['id_alumno']; ?></td>
                                    <td><?php echo htmlspecialchars($ins['nombre_alumno']); ?></td>
                                    <td><?php echo htmlspecialchars($ins['fecha_inscripcion']); ?></td>
                                    <td>
                                        <form action="index.php?action=inscripcion_delete" method="POST" style="display:inline;">
                                            <input type="hidden" name="codigo" value="<?php echo $ins['id_inscripcion']; ?>">
                                            <button class="btn btn-delete-sm" type="submit" onclick="return confirm('¿Desactivar/Expulsar a este alumno del curso?');">Desactivar</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="empty-state" style="padding:30px;">Aún no hay alumnos inscritos en este curso.</div>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <footer>
        <p>&copy; 2026 Academia de Idiomas. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
