<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evaluaciones del Curso | Academia</title>
    <link rel="stylesheet" href="./assets/css/styles.css">
</head>
<body class="user-body-bg">
    <?php include __DIR__ . '/../navbar.php'; ?>

    <main style="margin-top: 100px; padding: 30px;">
        <div class="mainContainer" style="max-width: 1000px;">
            
            <div class="dashboard-header">
                <div>
                    <a href="index.php?action=curso_dashboard&id_curso=<?php echo urlencode($curso['id_curso']); ?>" class="btn btn-cancel" style="display:inline-block; margin-bottom: 15px;">← Volver al Dashboard</a>
                    <h2 class="user-management-title" style="margin-bottom: 5px;">Evaluaciones: <?php echo htmlspecialchars($curso['nombre']); ?></h2>
                </div>
            </div>

            <div class="tabs-container">
                <h3 style="margin-bottom:15px; color:#ffd166;">Gestión de Evaluaciones</h3>
                
                <?php foreach ($tipos_evaluacion as $tipo): ?>
                    <div class="accordion-item">
                        <div class="accordion-header" onclick="toggleAccordion(this)">
                            <strong style="font-size:1.1em; color:white;"><?php echo htmlspecialchars($tipo['nombre']); ?></strong>
                            <span style="color:#aaa;">▼</span>
                        </div>
                        <div class="accordion-body">
                            <div style="text-align: right; margin-bottom: 10px;">
                                <a href="index.php?action=evaluacion_new&id_curso=<?php echo $curso['id_curso']; ?>&id_tipo=<?php echo $tipo['id_tipo_evaluacion']; ?>" class="btn btn-create-user" style="padding: 6px 12px; font-size: 0.9em;">+ Agregar Evaluación</a>
                            </div>
                            
                            <?php 
                            $evs_del_tipo = array_filter($evaluaciones_curso, function($e) use ($tipo) {
                                return $e['id_tipo_evaluacion'] == $tipo['id_tipo_evaluacion'];
                            });
                            ?>

                            <?php if (!empty($evs_del_tipo)): ?>
                                <?php foreach ($evs_del_tipo as $ev): ?>
                                    <div class="accordion-item" style="border-color: #ffd166;">
                                        <div class="accordion-header" onclick="toggleAccordion(this)" style="background: rgba(255,209,102,0.1);">
                                            <div style="color:#fff;">
                                                <strong>Evaluación #<?php echo $ev['id_evaluacion']; ?></strong> - Punteo Máx: <?php echo htmlspecialchars($ev['punteo']); ?>
                                            </div>
                                            <div>
                                                <a href="index.php?action=evaluacion_edit&codigo=<?php echo $ev['id_evaluacion']; ?>" class="btn btn-edit-sm" onclick="event.stopPropagation();">Editar</a>
                                                <form action="index.php?action=evaluacion_delete" method="POST" style="display:inline;" onclick="event.stopPropagation();">
                                                    <input type="hidden" name="codigo" value="<?php echo $ev['id_evaluacion']; ?>">
                                                    <button class="btn btn-delete-sm" type="submit" onclick="return confirm('¿Desactivar esta evaluación?');">Desactivar</button>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="accordion-body">
                                            <h4 style="margin-bottom:10px; color:#aaa;">Entregas de los alumnos</h4>
                                            <?php 
                                            $entregas = $entregas_por_evaluacion[$ev['id_evaluacion']] ?? [];
                                            ?>
                                            <?php if (!empty($entregas)): ?>
                                                <table class="usersTable table-inner" style="width:100%; font-size:0.9em;">
                                                    <thead>
                                                        <tr>
                                                            <th>Alumno</th>
                                                            <th>Fecha</th>
                                                            <th>Punteo</th>
                                                            <th>Calificar / Editar</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($entregas as $ent): ?>
                                                            <tr>
                                                                <td><?php echo htmlspecialchars($ent['nombre_alumno']); ?></td>
                                                                <td><?php echo htmlspecialchars($ent['fecha_entrega']); ?></td>
                                                                <td><?php echo htmlspecialchars($ent['punteo_obtenido'] ?? 'No calificado'); ?></td>
                                                                <td>
                                                                    <a href="index.php?action=calificacion_new&id_entrega=<?php echo $ent['id_entrega']; ?>" class="btn btn-edit-sm">Calificar / Editar Punteo</a>
                                                                </td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    </tbody>
                                                </table>
                                            <?php else: ?>
                                                <p style="color:#888; font-size:0.9em;">No hay entregas para esta evaluación.</p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p style="color:#888;">No hay evaluaciones de este tipo asignadas al curso.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </main>

    <footer>
        <p>&copy; 2026 Academia de Idiomas. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
