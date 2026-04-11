<?php

class UsuarioModel {
    private $conexion;

    public function __construct($p_conexion) {
        $this->conexion = $p_conexion;
    }

    public function getUsuarios(): array {
        $sql = "SELECT * FROM usuarios ORDER BY codigo ASC";
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

    public function getUsuario(string $codigo): ?array {
        $sql = "SELECT * FROM usuarios WHERE codigo = ? and estado = ? limit 1";
        $stmt = $this->conexion->prepare($sql);
        $estado = 1; // Solo buscamos usuarios activos
        if(!$stmt) {
            return null; // Error al preparar la consulta
        }
        $stmt->bind_param("si", $codigo, $estado);
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

    public function actualizarUsuario(array $datos): bool {
        $sql = "UPDATE usuarios SET codigo = ?, nombre = ?, username = ?, clave = ?, estado = ? WHERE codigo = ?";
        $stmt = $this->conexion->prepare($sql);
        if (!$stmt) {
            return false; // Error al preparar la consulta
        }
        
        $stmt->bind_param("ssssss", $datos['codigo'], $datos['nombre'], $datos['username'], $datos['clave'], $datos['estado'], $datos['codigo']);
        return $stmt->execute();
    }

    public function eliminarUsuario(string $codigo): bool {
        $sql = "DELETE FROM usuarios WHERE codigo = ?";
        $stmt = $this->conexion->prepare($sql);
        if(!$stmt) {
            return false; // Error al preparar la consulta
        }
        $stmt->bind_param("s", $codigo);
        $stmt->execute();
        $resultado = $stmt->affected_rows();

        return $resultado > 0;
    }
}