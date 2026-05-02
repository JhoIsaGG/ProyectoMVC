<?php
class AulaModel {
    private $conexion;
    const TIPOS = [
        1 => 'Presencial',
        2 => 'Virtual',
    ];

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function getAulaModels(): array {
        $sql = "SELECT * FROM aulas ORDER BY id_aula DESC";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $items = [];
        while ($row = $result->fetch_assoc()) {
            $items[] = $row;
        }
        return $items;
    }

    public function getAulasActivas(): array {
        $sql = "SELECT * FROM aulas WHERE estado = 1 ORDER BY nombre ASC";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $items = [];
        while ($row = $result->fetch_assoc()) {
            $items[] = $row;
        }
        return $items;
    }

    public function getaulaById(int $id): ?array {
        $sql = "SELECT * FROM aulas WHERE id_aula = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc() ?: null;
    }

    public function crearaula(array $datos): bool|string {
        $sql = "INSERT INTO aulas (nombre, capacidad, tipo, estado) VALUES (?, ?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);
        if (!$stmt) return false;
        $estado = $datos['estado'] ?? 1;
        $stmt->bind_param("siii",
            $datos['nombre'],
            $datos['capacidad'],
            $datos['tipo'],
            $estado
        );
        try {
            $stmt->execute();
            return true;
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() == 1062) return "Ya existe un aula con ese nombre.";
            return false;
        }
    }

    public function actualizaraula(array $datos): bool|string {
        $sql = "UPDATE aulas SET nombre = ?, capacidad = ?, tipo = ?, estado = ? WHERE id_aula = ?";
        $stmt = $this->conexion->prepare($sql);
        if (!$stmt) return false;
        $stmt->bind_param("siiii",
            $datos['nombre'],
            $datos['capacidad'],
            $datos['tipo'],
            $datos['estado'],
            $datos['id_aula']
        );
        try {
            $stmt->execute();
            return true;
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() == 1062) return "Ya existe un aula con ese nombre.";
            return false;
        }
    }

    public function eliminaraula(int $id): bool {
        $sql = "UPDATE aulas SET estado = 0 WHERE id_aula = ?";
        $stmt = $this->conexion->prepare($sql);
        if (!$stmt) return false;
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function reactivaraula(int $id): bool {
        $sql = "UPDATE aulas SET estado = 1 WHERE id_aula = ?";
        $stmt = $this->conexion->prepare($sql);
        if (!$stmt) return false;
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>
