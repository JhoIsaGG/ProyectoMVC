<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
</head>
<body>

<h1>Editar usuario</h1>
<a href="index.php?action=usuarios">Volver a la lista de usuarios</a>

<form action="index.php?action=usuario_update" method="POST">

    <input type="hidden" name="id_usuario" value="<?php echo htmlspecialchars($usuario['id_usuario']); ?>">

    <label for="nombres">Nombres:</label>
    <input type="text" id="nombres" name="nombres" value="<?php echo htmlspecialchars($usuario['nombres']); ?>" required><br><br>

    <label for="apellidos">Apellidos:</label>
    <input type="text" id="apellidos" name="apellidos" value="<?php echo htmlspecialchars($usuario['apellidos']); ?>" required><br><br>

    <label for="username">Username:</label>
    <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($usuario['username']); ?>" required><br><br>

    <label for="email">Correo:</label>
    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($usuario['email']); ?>" required><br><br>

    <label for="id_rol">Rol:</label>
    <select id="id_rol" name="id_rol" required>
        <option value="1" <?php echo ($usuario['id_rol'] == 1) ? 'selected' : ''; ?>>Administrador</option>
        <option value="2" <?php echo ($usuario['id_rol'] == 2) ? 'selected' : ''; ?>>Usuario</option>
    </select><br><br>

    <label for="estado">Estado:</label>
    <select id="estado" name="estado">
        <option value="1" <?php echo ($usuario['estado'] == 1) ? 'selected' : ''; ?>>Activo</option>
        <option value="0" <?php echo ($usuario['estado'] == 0) ? 'selected' : ''; ?>>Inactivo</option>
    </select><br><br>

    <label for="password">Nueva clave (opcional):</label>
    <input type="password" id="password" name="password"><br><br>

    <button type="submit">Actualizar usuario</button>

</form>

</body>
</html>