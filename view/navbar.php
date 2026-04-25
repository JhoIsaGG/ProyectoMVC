<header>
    <nav>
        <div class="logo">Academia de Idiomas</div>
        <?php if (isset($_SESSION['usuario'])): ?>
        <ul class="nav-links">
            <?php if ($_SESSION['usuario']['id_rol'] == '1'): ?>
            <li><a href="index.php?action=home">Inicio</a></li>
            <li><a href="index.php?action=cursos">Cursos</a></li>
            <li><a href="index.php?action=evaluaciones">Evaluaciones</a></li>
            <li><a href="index.php?action=idiomas">Idiomas</a></li>
            <li><a href="index.php?action=inscripciones">Inscripciones</a></li>
            <li><a href="index.php?action=niveles">Niveles</a></li>
            <li><a href="index.php?action=alumnos">Alumnos</a></li>
            <li><a href="index.php?action=profesores">Profesores</a></li>
            <li><a href="index.php?action=usuarios">Usuarios</a></li>
            <li><a href="index.php?action=roles">Roles</a></li>
            <li><a href="index.php?action=tipos_evaluacion">Tipos Evaluación</a></li>
            <?php elseif ($_SESSION['usuario']['id_rol'] == '2'): ?>
                <li><a href="index.php?action=home">Inicio</a></li>
            <?php elseif ($_SESSION['usuario']['id_rol'] == '3'): ?>
                <li><a href="index.php?action=home">Inicio</a></li>
            <?php endif; ?>
        </ul>
        <?php endif; ?>
        <?php if (isset($_SESSION['usuario'])): ?>
            <a href="index.php?action=logout" class="btn">Cerrar Sesión</a>
        <?php endif; ?>
        <?php if (!isset($_SESSION['usuario'])): ?>
            <a href="index.php?action=login" class="btn">Iniciar Sesión</a>
        <?php endif; ?>
    </nav>
</header>
