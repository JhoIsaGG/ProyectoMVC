<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Academia de Idiomas</title>
    <link rel="stylesheet" href="./assets/css/styles.css"></head>
<body>
    <header>
        <nav>
            <div class="logo">Academia de Idiomas</div>
            <ul class="nav-links">
                <li><a href="index.php?action=home">Inicio</a></li>
                <li><a href="index.php?action=cursos">Cursos</a></li>
                <li><a href="index.php?action=evaluaciones">Evaluaciones</a></li>
                <li><a href="index.php?action=idiomas">Idiomas</a></li>
                <li><a href="index.php?action=inscripciones">Inscripciones</a></li>
                <li><a href="index.php?action=niveles">Niveles</a></li>
                <li><a href="index.php?action=profesores">Profesores</a></li>
                <li><a href="index.php?action=usuarios">Usuarios</a></li>
                <li><a href="index.php?action=roles">Roles</a></li>
                <li><a href="index.php?action=tipos_evaluacion">Tipos Evaluación</a></li>
            </ul>
            <?php if (isset($_SESSION['usuario'])): ?>
                <a href="index.php?action=logout" class="btn">Cerrar Sesión</a>
            <?php endif; ?>
            <?php if (!isset($_SESSION['usuario'])): ?>
                <a href="index.php?action=login" class="btn">Iniciar Sesión</a>
            <?php endif; ?>

        </nav>
    </header>

    <main>
        <section class="hero">
            <div class="hero-content">
                <h1>Bienvenido a la Academia de Idiomas</h1>
                <p>
                    Aprende nuevos idiomas con cursos dinámicos, evaluaciones personalizadas
                    y un equipo de profesores especializados para cada nivel.
                </p>
                </div>
        </section>

    <footer>
        <p>&copy; 2026 Academia de Idiomas. Todos los derechos reservados.</p>
    </footer>

</body>
</html>