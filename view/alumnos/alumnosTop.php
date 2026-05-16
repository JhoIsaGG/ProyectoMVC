<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./assets/css/styles.css">
    <title>Alumnos</title>
</head>
<body>

    <?php include __DIR__ . '/../navbar.php'; ?>

    <div class="mainContainer user-management-container" style="margin-top: 100px;">
        <h2 class="user-management-title">Gestión de Alumnos</h2>
        
        <div class="table-responsive">
            <table class="users-table-modern">
                <thead>
                    <tr>
                        <th>ID_alumno</th>
                        <th>Puntaje</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($alumnos)): ?>
                        <?php foreach ($alumnos as $alumno): ?>
                            <tr class="element-user">
                                <td><?php echo htmlspecialchars($alumno['id_alumno']); ?></td>
                                <td><span class="user-chip user-chip-admin"><?php echo htmlspecialchars($alumno['nota']); ?></span></td>
                                </td>
                                <td>
                                    </form>
                                    <iframe name="fakeFrame" class="fakeFrame" style="display:none;"></iframe>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="10" style="text-align: center; padding: 30px; color: #6c757d;">No se encontraron registros.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <script>
        function confirmacionEliminar() {
            var respuesta = confirm("¿Estás seguro de que deseas eliminar este registro?");
            if (respuesta) { setTimeout(() => window.location.reload(), 500); }
            return respuesta;
        }
        function confirmacionReactivar() {
            var respuesta = confirm("¿Estás seguro de que deseas reactivar este registro?");
            if (respuesta) { setTimeout(() => window.location.reload(), 500); }
            return respuesta;
        }
    </script>
</body>
</html>