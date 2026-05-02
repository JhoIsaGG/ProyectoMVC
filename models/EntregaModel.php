<?php
class EntregaModel {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function getEntregaModels(): array {
        $sql = "SELECT en.*, 
                       te.nombre AS nombre_tipo,
                       c.nombre AS nombre_curso,
                       CONCAT(u.nombres, ' ', u.apellidos) AS nombre_alumno
                FROM entregas en
                JOIN evaluaciones e ON en.id_evaluacion = e.id_evaluacion
                JOIN tipos_evaluacion te ON e.id_tipo_evaluacion = te.id_tipo_evaluacion
                JOIN cursos c ON e.id_curso = c.id_curso
                JOIN alumnos a ON en.id_alumno = a.id_alumno
                JOIN usuarios u ON a.id_usuario = u.id_usuario
                ORDER BY en.fecha_entrega DESC";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $items = [];
        while ($row = $result->fetch_assoc()) {
            $items[] = $row;
        }
        return $items;
    }

    /** Entregas que aún no han sido calificadas */
    public function getEntregasPendientesCalificar(): array {
        $sql = "SELECT en.*, 
                       te.nombre AS nombre_tipo,
                       c.nombre AS nombre_curso,
                       CONCAT(u.nombres, ' ', u.apellidos) AS nombre_alumno
                FROM entregas en
                JOIN evaluaciones e ON en.id_evaluacion = e.id_evaluacion
                JOIN tipos_evaluacion te ON e.id_tipo_evaluacion = te.id_tipo_evaluacion
                JOIN cursos c ON e.id_curso = c.id_curso
                JOIN alumnos a ON en.id_alumno = a.id_alumno
                JOIN usuarios u ON a.id_usuario = u.id_usuario
                LEFT JOIN calificaciones cal ON en.id_entrega = cal.id_entrega
                WHERE cal.id_calificacion IS NULL
                ORDER BY en.fecha_entrega DESC";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $items = [];
        while ($row = $result->fetch_assoc()) {
            $items[] = $row;
        }
        return $items;
    }

    public function getentregaById(int $id): ?array {
        $sql = "SELECT en.*, 
                       te.nombre AS nombre_tipo,
                       c.nombre AS nombre_curso,
                       CONCAT(u.nombres, ' ', u.apellidos) AS nombre_alumno,
                       ev.punteo AS punteo_maximo
                FROM entregas en
                JOIN evaluaciones ev ON en.id_evaluacion = ev.id_evaluacion
                JOIN tipos_evaluacion te ON ev.id_tipo_evaluacion = te.id_tipo_evaluacion
                JOIN cursos c ON ev.id_curso = c.id_curso
                JOIN alumnos a ON en.id_alumno = a.id_alumno
                JOIN usuarios u ON a.id_usuario = u.id_usuario
                WHERE en.id_entrega = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc() ?: null;
    }

    public function crearentrega(array $datos): bool|string {
        $sql = "INSERT INTO entregas (id_evaluacion, id_alumno, fecha_entrega, estado) VALUES (?, ?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);
        if (!$stmt) return false;
        
        $fecha = $datos['fecha_entrega'] ?? date('Y-m-d H:i:s');
        $estado = $datos['estado'] ?? 1;
        
        $stmt->bind_param("iisi", $datos['id_evaluacion'], $datos['id_alumno'], $fecha, $estado);
        
        try {
            $stmt->execute();
            return true;
        } catch (mysqli_sql_exception $e) {
            return "Error al registrar entrega: " . $e->getMessage();
        }
    }

    public function actualizarentrega(array $datos): bool|string {
        $sql = "UPDATE entregas SET id_evaluacion = ?, id_alumno = ?, fecha_entrega = ?, estado = ? WHERE id_entrega = ?";
        $stmt = $this->conexion->prepare($sql);
        if (!$stmt) return false;
        
        $stmt->bind_param("iisii", $datos['id_evaluacion'], $datos['id_alumno'], $datos['fecha_entrega'], $datos['estado'], $datos['id_entrega']);
        
        try {
            $stmt->execute();
            return true;
        } catch (mysqli_sql_exception $e) {
            return false;
        }
    }

    public function eliminarentrega(int $id): bool {
        $sql = "DELETE FROM entregas WHERE id_entrega = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>
