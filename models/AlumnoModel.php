<?php
class AlumnoModel {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function getAlumnoModels(): array {
        $sql = "SELECT a.id_alumno, a.id_usuario, u.nombres, u.apellidos, u.username, 
                       GROUP_CONCAT(c.nombre SEPARATOR ', ') as cursos_inscritos
                FROM alumnos a
                JOIN usuarios u ON a.id_usuario = u.id_usuario
                LEFT JOIN inscripciones i ON a.id_alumno = i.id_alumno
                LEFT JOIN cursos c ON i.id_curso = c.id_curso
                GROUP BY a.id_alumno
                ORDER BY a.id_alumno DESC";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $items = [];
        while ($row = $result->fetch_assoc()) {
            $items[] = $row;
        }
        return $items;
    }

    public function getalumnoById(int $id): ?array {
        $sql = "SELECT a.*, u.nombres, u.apellidos, u.username, u.email, u.telefono, u.fecha_nacimiento, u.direccion, u.estado, u.id_rol 
                FROM alumnos a 
                JOIN usuarios u ON a.id_usuario = u.id_usuario
                WHERE a.id_alumno = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc() ?: null;
    }

    public function crearalumno(array $datos): bool|string {
        $sql = "INSERT INTO alumnos (id_usuario) VALUES (?)";
        $stmt = $this->conexion->prepare($sql);
        if (!$stmt) return false;
        
        
        
        $stmt->bind_param("i", $datos['id_usuario']);
        
        try {
            $stmt->execute();
            return true;
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() == 1062) return "Registro duplicado.";
            return false;
        }
    }

    public function actualizaralumno(array $datos): bool|string {
        $sql = "UPDATE alumnos SET id_usuario = ? WHERE id_alumno = ?";
        $stmt = $this->conexion->prepare($sql);
        if (!$stmt) return false;
        
        $stmt->bind_param("ii", $datos['id_usuario'], $datos['id_alumno']);
        
        try {
            $stmt->execute();
            return true;
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() == 1062) return "Registro duplicado.";
            return false;
        }
    }

    public function eliminaralumno(int $id): bool {
        $sql = "DELETE FROM alumnos WHERE id_alumno = ?";
        $stmt = $this->conexion->prepare($sql);
        if (!$stmt) return false;
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

}
?>