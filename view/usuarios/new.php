<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Usuario</title>
</head>
<body>

<h1>Crear nuevo usuario</h1>
<a href="index.php?action=usuarios">Volver a la lista de usuarios</a>

<form action="index.php?action=usuario_create" method="POST">

    <label for="nombres">Nombres:</label>
    <input type="text" id="nombres" name="nombres" required><br><br>

    <label for="apellidos">Apellidos:</label>
    <input type="text" id="apellidos" name="apellidos" required><br><br>

    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required><br><br>

    <label for="password">Clave:</label>
    <input type="password" id="password" name="password" required><br><br>

    <label for="email">Correo:</label>
    <input type="email" id="email" name="email" required><br><br>

    <label for="id_rol">Rol:</label>
    <select id="id_rol" name="id_rol" required>
        <option value="">Seleccione un rol</option>
        <option value="1">Administrador</option>
        <option value="2">Usuario</option>
    </select><br><br>

    <button type="submit">Crear usuario</button>

</form>

</body>
</html>