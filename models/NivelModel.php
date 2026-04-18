<?php

class NivelModel {
    private $conexion;

    public function __construct($p_conexion) {
        $this->conexion = $p_conexion;
    }

    public function getNiveles(): array {
        $sql = "SELECT *
                FROM niveles";

        $resultado = $this->conexion->query($sql);

        // Verificar si la consulta falló
        if (!$resultado) {
            die("Error en la consulta: " . $this->conexion->error);
        }

        $niveles = [];

        while ($fila = $resultado->fetch_assoc()) {
            $niveles[] = $fila;
        }

        return $niveles;
    }

    /**
     * @return: devuelve un nivel
     * @param string $codigo: el codigo del nivel a buscar
     */

    public function getNivel(string $id): ?array {
        $sql = "SELECT *   
                FROM niveles
                WHERE id_nivel = ? and estado = 1";

        $stmt = $this->conexion->prepare($sql);
        
        if(!$stmt) {
            return null; // Error al preparar la consulta
        }
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $nivel = $resultado->fetch_assoc() ?: null;

        if ($resultado->num_rows === 0) {
            return null;
        }

        return $nivel;
    }


    public function crearNivel(array $datos): bool {
        $sql = "INSERT INTO niveles (nombre, descripcion, estado) VALUES (?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);
        if (!$stmt) {
            return false; // Error al preparar la consulta
        }
        $estado = 1; 
        $stmt->bind_param("ssi", $datos['nombre'], $datos['descripcion'], $estado);
        $stmt->execute();
        return true;
    }

        public function actualizarUsuario(array $datos): bool {
        $sql = "UPDATE niveles 
                SET nombre = ?
                    descripcion = ?
                WHERE id_nivel = ?";

        $stmt = $this->conexion->prepare($sql);

        if (!$stmt) {
            return false;
        }

        $stmt->bind_param(
            "ssssiii",
            $datos['nombre'],
            $datos['descripcion']
        );

        return $stmt->execute();
    }

    public function eliminarNivel(int $id): bool {
        // Mejor usar borrado lógico
        $sql = "UPDATE niveles 
                SET estado = 0 
                WHERE id_nivel = ?";

        $stmt = $this->conexion->prepare($sql);

        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("i", $id);

        return $stmt->execute();
    }
}