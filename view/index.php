<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./assets/css/styles.css">
    <title>Document</title>
</head>
<body>
    <div class="mainContainer">
    <p><a class="buttonCreateUser" href="index.php?action=usuario_new">Crear nuevo usuario</a></p>
    <form method="POST" action="index.php?action=usuario_search">
        <input class="buscadorUser" type="text" name="nombre" placeholder="Buscar por nombre...">
        <button class="buttonCreateUser" type="submit">Buscar</button>
    </form>
    <table class="usersTable">
        <thead>
            <tr>
                <th>codigo</th>
                <th>nombre</th>
                <th>Username</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($usuarios as $user): ?>
                <tr class="elementUser">
                    <td><?php echo htmlspecialchars($user['codigo']); ?></td>
                    <td><?php echo htmlspecialchars($user['nombre']); ?></td>
                    <td><?php echo htmlspecialchars($user['username']); ?></td>
                    <td><?php echo htmlspecialchars($user['estado']); ?></td>
                    <td><a class="buttonEditUser" href="index.php?action=usuario_edit&codigo=<?php echo urlencode($user['codigo']); ?>">Editar</a>
                    <form target="fakeFrame" action="index.php?action=usuario_delete" method="POST" style="display:inline;">
                        <input type="hidden" name="codigo" value="<?php echo htmlspecialchars($user['codigo']); ?>">
                        <button class="buttonDeleteUser" type="submit" onclick="return confirmacionEliminar('<?php echo $user['nombre']; ?>');">Eliminar</button>
                    </form>s
                    <iframe name="fakeFrame" class="fakeFrame"></iframe>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    </div>
</body>
<script>
    function confirmacionEliminar(nombre) {
        var respuesta = confirm("¿Estás seguro de que deseas eliminar el usuario " + nombre + "?");
        return respuesta;
    }
    </script>
</html>