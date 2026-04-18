<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Rol</title>
</head>
<body>

<h1>Crear nuevo rol</h1>
<a href="index.php?action=roles">Volver a la lista de roles</a>

<form action="index.php?action=rol_create" method="POST">

    <label for="nombre">Nombre:</label>
    <input type="text" id="nombre" name="nombre" required><br><br>

    <button type="submit">Crear rol</button>

</form>

</body>
</html>