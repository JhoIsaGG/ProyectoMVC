<?php
class InscripcionModel {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function getInscripcionModels(): array {
        $sql = "SELECT * FROM inscripciones ORDER BY id_inscripcion DESC";
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
        $sql = "INSERT INTO inscripciones (id_alumno, id_curso) VALUES (?, ?)";
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
        $sql = "DELETE FROM inscripciones WHERE id_inscripcion = ?";
        $stmt = $this->conexion->prepare($sql);
        if (!$stmt) return false;
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

}
?>