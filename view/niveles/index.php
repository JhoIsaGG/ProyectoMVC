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
    <p><a class="buttonCreateUser" href="index.php?action=nivel_new">Crear nuevo nivel</a></p>
    </form>
    <table class="usersTable">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Descripcion</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($niveles as $nivel): ?>
                <tr class="elementUser">
                    <td><?php echo htmlspecialchars($nivel['nombre']); ?></td>
                    <td><?php echo htmlspecialchars($nivel['descripcion']); ?></td>
                    <td><?php echo ($nivel['estado'] == 1) ? "Activo" : "Inactivo"; ?></td>                    
                    <td><a class="buttonEditUser" href="index.php?action=nivel_edit&codigo=<?php echo urlencode($nivel['id_nivel']); ?>">Editar</a>
                    <form target="fakeFrame" action="index.php?action=nivel_edit" method="POST" style="display:inline;">
                        <input type="hidden" name="codigo" value="<?php echo htmlspecialchars($nivel['id_nivel']); ?>">
                        <button class="buttonDeleteUser" type="submit" onclick="return confirmacionEliminar('<?php echo $nivel['nombre']; ?>');">Eliminar</button>
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