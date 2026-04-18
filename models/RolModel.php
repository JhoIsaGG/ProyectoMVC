<?php

class RolModel {
    private $conexion;

    public function __construct($p_conexion) {
        $this->conexion = $p_conexion;
    }

    public function getRoles(): array {
        $sql = "SELECT *
                FROM roles
                WHERE estado = 1";

        $resultado = $this->conexion->query($sql);

        // Verificar si la consulta falló
        if (!$resultado) {
            die("Error en la consulta: " . $this->conexion->error);
        }

        $roles = [];

        while ($fila = $resultado->fetch_assoc()) {
            $roles[] = $fila;
        }

        return $roles;
    }

    /**
     * @return: devuelve un rol
     * @param string $codigo: el codigo del rol a buscar
     */

    public function getRol(string $id): ?array {
        $sql = "SELECT *
                FROM roles
                WHERE id_rol = ? and estado = 1";

        $stmt = $this->conexion->prepare($sql);
        
        if(!$stmt) {
            return null; // Error al preparar la consulta
        }
        
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $rol = $resultado->fetch_assoc() ?: null;

        if ($resultado->num_rows === 0) {
            return null;
        }

        return $rol;
    }


    public function crearRol(array $datos): bool {
        $sql = "INSERT INTO roles (nombre, estado) VALUES (?, ?)";
        $stmt = $this->conexion->prepare($sql);
        if (!$stmt) {
            return false; // Error al preparar la consulta
        }
        $estado = 1; 
        $stmt->bind_param("si", $datos['nombre'], $estado);
        $stmt->execute();
        return true;
    }

        public function actualizarRol(array $datos): bool {
        $sql = "UPDATE roles 
                SET nombres = ?, 
                    estado = ?
                WHERE id_rol = ?";

        $stmt = $this->conexion->prepare($sql);

        if (!$stmt) {
            return false;
        }

        $stmt->bind_param(
            "ssssiii",
            $datos['nombres'],
            $datos['estado']
        );

        return $stmt->execute();
    }


    public function eliminarRol(int $id): bool {
        // Mejor usar borrado lógico
        $sql = "UPDATE roles 
                SET estado = 0 
                WHERE id_rol = ?";

        $stmt = $this->conexion->prepare($sql);

        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("i", $id);

        return $stmt->execute();
    }
}