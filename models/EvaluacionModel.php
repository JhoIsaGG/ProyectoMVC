<?php
class EvaluacionModel {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function getEvaluacionModels(): array {
        $sql = "SELECT * FROM evaluaciones ORDER BY id_evaluacion DESC";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $items = [];
        while ($row = $result->fetch_assoc()) {
            $items[] = $row;
        }
        return $items;
    }

    public function getevaluacionById(int $id): ?array {
        $sql = "SELECT * FROM evaluaciones WHERE id_evaluacion = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc() ?: null;
    }

    public function crearevaluacion(array $datos): bool|string {
        $sql = "INSERT INTO evaluaciones (id_inscripcion, nota, id_tipo_evaluacion, fecha_publicacion, fecha_entrega, observaciones, estado) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);
        if (!$stmt) return false;
        
        $datos['estado'] = 1;
        
        $stmt->bind_param("idisssi", $datos['id_inscripcion'], $datos['nota'], $datos['id_tipo_evaluacion'], $datos['fecha_publicacion'], $datos['fecha_entrega'], $datos['observaciones'], $datos['estado']);
        
        try {
            $stmt->execute();
            return true;
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() == 1062) return "Registro duplicado.";
            return false;
        }
    }

    public function actualizarevaluacion(array $datos): bool|string {
        $sql = "UPDATE evaluaciones SET id_inscripcion = ?, nota = ?, id_tipo_evaluacion = ?, fecha_publicacion = ?, fecha_entrega = ?, observaciones = ?, estado = ? WHERE id_evaluacion = ?";
        $stmt = $this->conexion->prepare($sql);
        if (!$stmt) return false;
        
        $stmt->bind_param("idisssii", $datos['id_inscripcion'], $datos['nota'], $datos['id_tipo_evaluacion'], $datos['fecha_publicacion'], $datos['fecha_entrega'], $datos['observaciones'], $datos['estado'], $datos['id_evaluacion']);
        
        try {
            $stmt->execute();
            return true;
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() == 1062) return "Registro duplicado.";
            return false;
        }
    }

    public function eliminarevaluacion(int $id): bool {
        $sql = "UPDATE evaluaciones SET estado = 0 WHERE id_evaluacion = ?";
        $stmt = $this->conexion->prepare($sql);
        if (!$stmt) return false;
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function reactivarevaluacion(int $id): bool {
        $sql = "UPDATE evaluaciones SET estado = 1 WHERE id_evaluacion = ?";
        $stmt = $this->conexion->prepare($sql);
        if (!$stmt) return false;
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>