<?php
class TipoEvaluacionModel {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function getTipoEvaluacionModels(): array {
        $sql = "SELECT * FROM tipos_evaluacion ORDER BY id_tipo_evaluacion DESC";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $items = [];
        while ($row = $result->fetch_assoc()) {
            $items[] = $row;
        }
        return $items;
    }

    public function gettipo_evaluacionById(int $id): ?array {
        $sql = "SELECT * FROM tipos_evaluacion WHERE id_tipo_evaluacion = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc() ?: null;
    }

    public function creartipo_evaluacion(array $datos): bool|string {
        $sql = "INSERT INTO tipos_evaluacion (nombre) VALUES (?)";
        $stmt = $this->conexion->prepare($sql);
        if (!$stmt) return false;
        
        
        
        $stmt->bind_param("s", $datos['nombre']);
        
        try {
            $stmt->execute();
            return true;
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() == 1062) return "Registro duplicado.";
            return false;
        }
    }

    public function actualizartipo_evaluacion(array $datos): bool|string {
        $sql = "UPDATE tipos_evaluacion SET nombre = ? WHERE id_tipo_evaluacion = ?";
        $stmt = $this->conexion->prepare($sql);
        if (!$stmt) return false;
        
        $stmt->bind_param("si", $datos['nombre'], $datos['id_tipo_evaluacion']);
        
        try {
            $stmt->execute();
            return true;
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() == 1062) return "Registro duplicado.";
            return false;
        }
    }

    public function eliminartipo_evaluacion(int $id): bool {
        $sql = "DELETE FROM tipos_evaluacion WHERE id_tipo_evaluacion = ?";
        $stmt = $this->conexion->prepare($sql);
        if (!$stmt) return false;
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

}
?>