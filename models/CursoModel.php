<?php
class CursoModel {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function getCursoModels(): array {
        $sql = "SELECT * FROM cursos ORDER BY id_curso DESC";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $items = [];
        while ($row = $result->fetch_assoc()) {
            $items[] = $row;
        }
        return $items;
    }

    public function getcursoById(int $id): ?array {
        $sql = "SELECT * FROM cursos WHERE id_curso = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc() ?: null;
    }

    public function crearcurso(array $datos): bool|string {
        $sql = "INSERT INTO cursos (nombre, id_idioma, id_nivel, id_profesor, fecha_inicio, fecha_fin, horario, cupo_maximo, estado) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);
        if (!$stmt) return false;
        
        $datos['estado'] = 1;
        
        $stmt->bind_param("siiisssii", $datos['nombre'], $datos['id_idioma'], $datos['id_nivel'], $datos['id_profesor'], $datos['fecha_inicio'], $datos['fecha_fin'], $datos['horario'], $datos['cupo_maximo'], $datos['estado']);
        
        try {
            $stmt->execute();
            return true;
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() == 1062) return "Registro duplicado.";
            return false;
        }
    }

    public function actualizarcurso(array $datos): bool|string {
        $sql = "UPDATE cursos SET nombre = ?, id_idioma = ?, id_nivel = ?, id_profesor = ?, fecha_inicio = ?, fecha_fin = ?, horario = ?, cupo_maximo = ?, estado = ? WHERE id_curso = ?";
        $stmt = $this->conexion->prepare($sql);
        if (!$stmt) return false;
        
        $stmt->bind_param("siiisssiii", $datos['nombre'], $datos['id_idioma'], $datos['id_nivel'], $datos['id_profesor'], $datos['fecha_inicio'], $datos['fecha_fin'], $datos['horario'], $datos['cupo_maximo'], $datos['estado'], $datos['id_curso']);
        
        try {
            $stmt->execute();
            return true;
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() == 1062) return "Registro duplicado.";
            return false;
        }
    }

    public function eliminarcurso(int $id): bool {
        $sql = "UPDATE cursos SET estado = 0 WHERE id_curso = ?";
        $stmt = $this->conexion->prepare($sql);
        if (!$stmt) return false;
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function reactivarcurso(int $id): bool {
        $sql = "UPDATE cursos SET estado = 1 WHERE id_curso = ?";
        $stmt = $this->conexion->prepare($sql);
        if (!$stmt) return false;
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>