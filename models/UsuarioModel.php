<?php

class UsuarioModel {
    private $conexion;

    public function __construct($p_conexion) {
        $this->conexion = $p_conexion;
    }

    public function getUsuarios(): array {
        $sql = "SELECT u.*, r.nombre AS rol 
                FROM usuarios u
                JOIN roles r ON u.id_rol = r.id_rol
                ORDER BY u.id_usuario ASC";

        $resultado = $this->conexion->query($sql);

        // Verificar si la consulta falló
        if (!$resultado) {
            die("Error en la consulta: " . $this->conexion->error);
        }

        $usuarios = [];

        while ($fila = $resultado->fetch_assoc()) {
            $usuarios[] = $fila;
        }

        return $usuarios;
    }

    /**
     * @return: devuelve un usuario
     * @param string $codigo: el codigo del usuario a buscar
     */

    public function getUsuario(string $id): ?array {
        $sql = "SELECT u.*, r.nombre AS rol 
                FROM usuarios u
                JOIN roles r ON u.id_rol = r.id_rol
                WHERE u.id_usuario = ? AND u.estado = 1 
                LIMIT 1";

        $stmt = $this->conexion->prepare($sql);
        
        if(!$stmt) {
            return null; // Error al preparar la consulta
        }
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $usuario = $resultado->fetch_assoc() ?: null;
                print_r($usuario);

        if ($resultado->num_rows === 0) {
            return null;
        }

        return $usuario;
    }

    public function buscarUsuarioNombre(string $nombre): array{
        $sql = "SELECT * FROM usuarios WHERE nombre LIKE ? AND estado = ?";
        $stmt = $this->conexion->prepare($sql);
        $estado = 1; // Solo buscamos usuarios activos
        if (!$stmt) {
            return []; // Error al preparar la consulta
        }
        $likeNombre = '%' . $nombre . '%';
        $stmt->bind_param("si", $likeNombre, $estado);
        $stmt->execute();
        $resultado = $stmt->get_result();

        $usuarios = [];
        while ($fila = $resultado->fetch_assoc()) {
            $usuarios[] = $fila;
        }

        return $usuarios;
    }

    public function crearUsuario(array $datos): bool {
        $sql = "INSERT INTO usuarios (codigo, nombre, username, clave, estado) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);
        if (!$stmt) {
            return false; // Error al preparar la consulta
        }
        $estado = 1; 
        $stmt->bind_param("ssssi", $datos['codigo'], $datos['nombre'], $datos['username'], $datos['clave'], $estado);
        $stmt->execute();
    }

      public function actualizarPassword(int $id_usuario, string $password): bool {
        $sql = "UPDATE usuarios SET password = ? WHERE id_usuario = ?";

        $stmt = $this->conexion->prepare($sql);

        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("si", $password, $id_usuario);

        return $stmt->execute();
    }

    public function eliminarUsuario(int $id): bool {
        // Mejor usar borrado lógico
        $sql = "UPDATE usuarios SET estado = 0 WHERE id_usuario = ?";

        $stmt = $this->conexion->prepare($sql);

        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("i", $id);

        return $stmt->execute();
    }
}