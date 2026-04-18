<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Nivel</title>
</head>
<body>

<h1>Crear nuevo nivel</h1>
<a href="index.php?action=niveles">Volver a la lista de niveles</a>

<form action="index.php?action=nivel_create" method="POST">

    <label for="nombre">Nombre:</label>
    <input type="text" id="nombre" name="nombre" required><br><br>

    <label for="descripcion">Descripcion:</label>
    <input type="text" id="descripcion" name="descripcion" required><br><br>

    <button type="submit">Crear nivel</button>

</form>

</body>
</html>