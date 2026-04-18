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
    <p><a class="buttonCreateUser" href="index.php?action=rol_new">Crear nuevo rol</a></p>
    </form>
    <table class="usersTable">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($roles as $rol): ?>
                <tr class="elementUser">
                    <td><?php echo htmlspecialchars($rol['nombre']); ?></td>
                    <td><?php echo ($rol['estado'] == 1) ? "Activo" : "Inactivo"; ?></td>                    
                    <td><a class="buttonEditUser" href="index.php?action=rol_edit&codigo=<?php echo urlencode($rol['id_rol']); ?>">Editar</a>
                    <form target="fakeFrame" action="index.php?action=rol_delete" method="POST" style="display:inline;">
                        <input type="hidden" name="codigo" value="<?php echo htmlspecialchars($rol['id_rol']); ?>">
                        <button class="buttonDeleteUser" type="submit" onclick="return confirmacionEliminar('<?php echo $rol['nombre']; ?>');">Eliminar</button>
                    </form>
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