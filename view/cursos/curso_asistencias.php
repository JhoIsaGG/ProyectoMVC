<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asistencia del Curso | Academia</title>
    <link rel="stylesheet" href="./assets/css/styles.css">
</head>
<body class="user-body-bg">
    <?php include __DIR__ . '/../navbar.php'; ?>

    <main style="margin-top: 100px; padding: 30px;">
        <div class="mainContainer" style="max-width: 1000px;">
            
            <div class="dashboard-header">
                <div>
                    <a href="index.php?action=curso_dashboard&id_curso=<?php echo urlencode($curso['id_curso']); ?>" class="btn btn-cancel" style="display:inline-block; margin-bottom: 15px;">← Volver al Dashboard</a>
                    <h2 class="user-management-title" style="margin-bottom: 5px;">Asistencia: <?php echo htmlspecialchars($curso['nombre']); ?></h2>
                </div>
            </div>

            <div class="tabs-container">
                <h3 style="margin-bottom:15px; color:#ffd166;">Registro de Asistencia</h3>
                <p style="color:#aaa; margin-bottom: 20px;">Haga clic en una clase para tomar asistencia. Las clases futuras están deshabilitadas.</p>
                
                <?php include __DIR__ . '/_asistencia_list.php'; ?>
            </div>
        </div>
    </main>

    <footer>
        <p>&copy; 2026 Academia de Idiomas. Todos los derechos reservados.</p>
    </footer>

    <script>
        function toggleAccordion(element) {
            var parent = element.parentElement;
            parent.classList.toggle("active");
            var symbol = element.querySelector("span");
            if (symbol) {
                symbol.innerHTML = parent.classList.contains("active") ? "▲" : "▼";
            }
        }
    </script>
</body>
</html>
