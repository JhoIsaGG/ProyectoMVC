<?php
class CalificacionModel {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function getCalificacionModels(): array {
        $sql = "SELECT c.*, 
                       te.nombre AS nombre_tipo,
                       cur.nombre AS nombre_curso,
                       CONCAT(u.nombres, ' ', u.apellidos) AS nombre_alumno,
                       ev.punteo AS punteo_maximo
                FROM calificaciones c
                JOIN entregas en ON c.id_entrega = en.id_entrega
                JOIN evaluaciones ev ON en.id_evaluacion = ev.id_evaluacion
                JOIN tipos_evaluacion te ON ev.id_tipo_evaluacion = te.id_tipo_evaluacion
                JOIN cursos cur ON ev.id_curso = cur.id_curso
                JOIN alumnos al ON en.id_alumno = al.id_alumno
                JOIN usuarios u ON al.id_usuario = u.id_usuario
                ORDER BY c.id_calificacion DESC";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $items = [];
        while ($row = $result->fetch_assoc()) {
            $items[] = $row;
        }
        return $items;
    }

    public function getcalificacionById(int $id): ?array {
        $sql = "SELECT * FROM calificaciones WHERE id_calificacion = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc() ?: null;
    }

    public function crearcalificacion(array $datos): bool|string {
        $sql = "INSERT INTO calificaciones (id_entrega, nota, comentarios_profesor) VALUES (?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);
        if (!$stmt) return false;
        
        $stmt->bind_param("ids", $datos['id_entrega'], $datos['nota'], $datos['comentarios_profesor']);
        
        try {
            $stmt->execute();
            return true;
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() == 1062) return "Esta entrega ya ha sido calificada.";
            return false;
        }
    }

    public function actualizarcalificacion(array $datos): bool|string {
        $sql = "UPDATE calificaciones SET id_entrega = ?, nota = ?, comentarios_profesor = ? WHERE id_calificacion = ?";
        $stmt = $this->conexion->prepare($sql);
        if (!$stmt) return false;
        
        $stmt->bind_param("idsi", $datos['id_entrega'], $datos['nota'], $datos['comentarios_profesor'], $datos['id_calificacion']);
        
        try {
            $stmt->execute();
            return true;
        } catch (mysqli_sql_exception $e) {
            return false;
        }
    }

    public function eliminarcalificacion(int $id): bool {
        $sql = "DELETE FROM calificaciones WHERE id_calificacion = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>
