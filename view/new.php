<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<h1>Crear nuevo usuario</h1>
<a href="index.php?action=usuarios">Volver a la lista de usuarios</a>
<form action="index.php?action=usuario_create" method="POST">
    <label for="codigo">Código:</label>
    <input type="text" id="codigo" name="codigo" required><br><br>

    <label for="nombre">Nombre:</label>
    <input type="text" id="nombre" name="nombre" required><br><br>

    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required><br><br>

    <label for="password">Clave:</label>
    <input type="password" id="clave" name="clave" required><br><br>

    <button type="submit" value="Crear Usuario">Crear usuario</button>
</body>
</html>