<?php
class InscripcionModel {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function getInscripcionModels(): array {
        $sql = "SELECT i.*, CONCAT(u.nombres, ' ', u.apellidos) AS nombre_alumno,
                       c.nombre AS nombre_curso
                FROM inscripciones i
                JOIN alumnos a ON i.id_alumno = a.id_alumno
                JOIN usuarios u ON a.id_usuario = u.id_usuario
                JOIN cursos c ON i.id_curso = c.id_curso
                ORDER BY i.id_inscripcion DESC";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $items = [];
        while ($row = $result->fetch_assoc()) {
            $items[] = $row;
        }
        return $items;
    }

    public function getinscripcionById(int $id): ?array {
        $sql = "SELECT * FROM inscripciones WHERE id_inscripcion = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc() ?: null;
    }

    public function crearinscripcion(array $datos): bool|string {
        $sql = "INSERT INTO inscripciones (id_alumno, id_curso, estado) VALUES (?, ?, 1)";
        $stmt = $this->conexion->prepare($sql);
        if (!$stmt) return false;
        
        $stmt->bind_param("ii", $datos['id_alumno'], $datos['id_curso']);
        
        try {
            $stmt->execute();
            return true;
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() == 1062) return "Registro duplicado.";
            return false;
        }
    }

    public function actualizarinscripcion(array $datos): bool|string {
        $sql = "UPDATE inscripciones SET id_alumno = ?, id_curso = ? WHERE id_inscripcion = ?";
        $stmt = $this->conexion->prepare($sql);
        if (!$stmt) return false;
        
        $stmt->bind_param("iii", $datos['id_alumno'], $datos['id_curso'], $datos['id_inscripcion']);
        
        try {
            $stmt->execute();
            return true;
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() == 1062) return "Registro duplicado.";
            return false;
        }
    }

    public function eliminarinscripcion(int $id): bool {
        $sql = "UPDATE inscripciones SET estado = 0 WHERE id_inscripcion = ?";
        $stmt = $this->conexion->prepare($sql);
        if (!$stmt) return false;
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function reactivarinscripcion(int $id): bool {
        $sql = "UPDATE inscripciones SET estado = 1 WHERE id_inscripcion = ?";
        $stmt = $this->conexion->prepare($sql);
        if (!$stmt) return false;
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>