<?php
class EvaluacionModel {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function getEvaluacionModels(): array {
        $sql = "SELECT e.*, c.nombre AS nombre_curso, te.nombre AS nombre_tipo
                FROM evaluaciones e
                JOIN cursos c ON e.id_curso = c.id_curso
                JOIN tipos_evaluacion te ON e.id_tipo_evaluacion = te.id_tipo_evaluacion
                ORDER BY e.id_evaluacion DESC";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $items = [];
        while ($row = $result->fetch_assoc()) {
            $items[] = $row;
        }
        return $items;
    }

    public function getEvaluacionesByCurso(int $id_curso): array {
        $sql = "SELECT e.*, te.nombre AS nombre_tipo
                FROM evaluaciones e
                JOIN tipos_evaluacion te ON e.id_tipo_evaluacion = te.id_tipo_evaluacion
                WHERE e.id_curso = ? AND e.estado = 1
                ORDER BY e.id_evaluacion DESC";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $id_curso);
        $stmt->execute();
        $result = $stmt->get_result();
        $items = [];
        while ($row = $result->fetch_assoc()) {
            $items[] = $row;
        }
        return $items;
    }

    public function getEvaluacionesConNotas(int $id_curso, int $id_alumno): array {
        $sql = "SELECT e.*, te.nombre AS nombre_tipo, c.nota AS nota_obtenida
                FROM evaluaciones e
                JOIN tipos_evaluacion te ON e.id_tipo_evaluacion = te.id_tipo_evaluacion
                LEFT JOIN calificaciones c ON e.id_evaluacion = c.id_evaluacion AND c.id_alumno = ?
                WHERE e.id_curso = ? AND e.estado = 1
                ORDER BY e.id_evaluacion DESC";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("ii", $id_alumno, $id_curso);
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
        $sql = "INSERT INTO evaluaciones (id_curso, punteo, id_tipo_evaluacion, fecha_publicacion, fecha_entrega, observaciones, estado) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);
        if (!$stmt) return false;
        
        $datos['estado'] = 1;
        
        $stmt->bind_param("idisssi", $datos['id_curso'], $datos['punteo'], $datos['id_tipo_evaluacion'], $datos['fecha_publicacion'], $datos['fecha_entrega'], $datos['observaciones'], $datos['estado']);
        
        try {
            $stmt->execute();
            return true;
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() == 1062) return "Registro duplicado.";
            return false;
        }
    }

    public function actualizarevaluacion(array $datos): bool|string {
        $sql = "UPDATE evaluaciones SET id_curso = ?, punteo = ?, id_tipo_evaluacion = ?, fecha_publicacion = ?, fecha_entrega = ?, observaciones = ?, estado = ? WHERE id_evaluacion = ?";
        $stmt = $this->conexion->prepare($sql);
        if (!$stmt) return false;
        
        $stmt->bind_param("idisssii", $datos['id_curso'], $datos['punteo'], $datos['id_tipo_evaluacion'], $datos['fecha_publicacion'], $datos['fecha_entrega'], $datos['observaciones'], $datos['estado'], $datos['id_evaluacion']);
        
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