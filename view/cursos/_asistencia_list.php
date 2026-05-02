<?php
// Script para calcular fechas de clases y renderizar la interfaz de asistencia

$fecha_inicio_curso = new DateTime($curso['fecha_inicio']);
$fecha_fin_curso = new DateTime($curso['fecha_fin']);
$hoy = new DateTime();
$hoy->setTime(0, 0, 0); // Para comparar solo fechas

// Mapear días de la semana de PHP (1 = Lunes, 7 = Domingo) a como estén en la BD (Asumiendo 1=Lunes, 2=Martes...)
$dias_clase_bd = [];
foreach ($horarios as $h) {
    $dias_clase_bd[] = (int)$h['dia_semana'];
}

$clases_programadas = [];
if (!empty($dias_clase_bd)) {
    $intervalo = new DateInterval('P1D'); // Avanzar día por día
    $periodo = new DatePeriod($fecha_inicio_curso, $intervalo, $fecha_fin_curso->modify('+1 day'));
    
    $numero_clase = 1;
    foreach ($periodo as $fecha) {
        $dia_semana_php = (int)$fecha->format('N'); // 1 (Lunes) - 7 (Domingo)
        
        if (in_array($dia_semana_php, $dias_clase_bd)) {
            $clases_programadas[] = [
                'numero' => $numero_clase,
                'fecha_obj' => $fecha,
                'fecha_str' => $fecha->format('Y-m-d'),
                'fecha_format' => $fecha->format('d / m / Y'),
                'pasada_o_hoy' => ($fecha <= $hoy) // true si ya pasó o es hoy, false si es futuro
            ];
            $numero_clase++;
        }
    }
}
?>

<?php if (empty($horarios)): ?>
    <div class="empty-state">
        Debe configurar los horarios de este curso primero para calcular las asistencias.
        <br><br>
        <a href="index.php?action=horarios" class="btn btn-update">Ir a Horarios</a>
    </div>
<?php elseif (empty($clases_programadas)): ?>
    <div class="empty-state">No se encontraron clases en el rango de fechas establecido con los horarios actuales.</div>
<?php else: ?>
    
    <?php foreach ($clases_programadas as $clase): ?>
        <?php 
        $es_activa = $clase['pasada_o_hoy'];
        $clase_css = $es_activa ? '' : 'opacity: 0.5; pointer-events: none;';
        $badge = $es_activa ? '<span class="badge-active">Disponible</span>' : '<span class="badge-disabled">Futura (Inactiva)</span>';
        ?>
        
        <div class="accordion-item" style="<?php echo $clase_css; ?>">
            <div class="accordion-header" <?php if($es_activa) echo 'onclick="toggleAccordion(this)"'; ?>>
                <div style="color:white; font-size:1.1em;">
                    <strong>Clase <?php echo $clase['numero']; ?></strong> — <?php echo $clase['fecha_format']; ?>
                </div>
                <div>
                    <?php echo $badge; ?>
                    <?php if($es_activa): ?> <span style="color:#aaa; margin-left:10px;">▼</span> <?php endif; ?>
                </div>
            </div>
            
            <?php if ($es_activa): ?>
            <div class="accordion-body">
                <form action="index.php?action=asistencia_batch" method="POST">
                    <input type="hidden" name="id_curso" value="<?php echo $curso['id_curso']; ?>">
                    <input type="hidden" name="fecha" value="<?php echo $clase['fecha_str']; ?>">
                    
                    <table class="usersTable table-inner" style="width:100%;">
                        <thead>
                            <tr>
                                <th>Alumno</th>
                                <th>Estado de Asistencia</th>
                                <th>Observaciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($inscripciones_curso)): ?>
                                <?php foreach ($inscripciones_curso as $ins): ?>
                                    <?php 
                                        $id_alum = $ins['id_alumno'];
                                        $fecha_str = $clase['fecha_str'];
                                        $previo = $asistencias_previas[$fecha_str][$id_alum] ?? null;
                                        
                                        $estado_sel = $previo ? $previo['estado'] : 1; // 1 por defecto (Presente)
                                        $obs_val = $previo ? $previo['observaciones'] : '';
                                    ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($ins['nombre_alumno']); ?></td>
                                        <td>
                                            <!-- Estados: 1=Presente, 2=Ausente, 3=Justificado, 4=Tarde (Basado en AsistenciaModel) -->
                                            <select name="asistencia[<?php echo $id_alum; ?>][estado]" style="padding:5px; border-radius:4px;">
                                                <option value="1" <?php echo ($estado_sel == 1) ? 'selected' : ''; ?>>Presente</option>
                                                <option value="2" <?php echo ($estado_sel == 2) ? 'selected' : ''; ?>>Ausente</option>
                                                <option value="4" <?php echo ($estado_sel == 4) ? 'selected' : ''; ?>>Llegada Tarde</option>
                                                <option value="3" <?php echo ($estado_sel == 3) ? 'selected' : ''; ?>>Falta Justificada</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" name="asistencia[<?php echo $id_alum; ?>][observacion]" value="<?php echo htmlspecialchars($obs_val); ?>" placeholder="Nota opcional..." style="padding:5px; width:100%; box-sizing:border-box; border-radius:4px; border:1px solid #ccc;">
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="3" style="text-align:center; padding:15px; color:#aaa;">No hay alumnos inscritos en este curso.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                    
                    <?php if (!empty($inscripciones_curso)): ?>
                    <div style="text-align:right; margin-top:15px;">
                        <button type="submit" class="btn btn-create-user">Guardar Asistencia del Día</button>
                    </div>
                    <?php endif; ?>
                </form>
            </div>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>

<?php endif; ?>
