<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Academia de Idiomas</title>
    <link rel="stylesheet" href="./assets/css/styles.css">
</head>
<body>


    <div class="login-container">
        <div class="login-box">
            <div class="btn-back">
                <a href="index.php?action=home">← Volver a Inicio</a>
            </div>
            <h2>Academia de Idiomas</h2>
            <p>Iniciar Sesión</p>

            <?php if (isset($errorLogin)): ?>
                <div class="error-message" style="color: #dc3545; background-color: #f8d7da; padding: 10px; border-radius: 5px; margin-bottom: 15px; text-align: center; border: 1px solid #f5c6cb;">
                    <?= htmlspecialchars($errorLogin) ?>
                </div>
            <?php endif; ?>

            <form action="index.php?action=usuario_login" method="POST">
                <div class="input-group">
                    <label>Usuario</label>
                    <input type="text" name="username" placeholder="Ingrese su usuario" required>
                </div>

                <div class="input-group">
                    <label>Contraseña</label>
                    <input type="password" name="password" placeholder="Ingrese su contraseña" required>
                </div>

                <button type="submit" class="btn-login">Ingresar</button>
            </form>
        </div>
    </div>

</body>
</html>