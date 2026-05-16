<?php
class CursoModel {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }


    public function getAlumnosTop($id_curso): array {
    $sql = "SELECT en.id_alumno, SUM(c.nota) as nota
            FROM evaluaciones ev
            JOIN entregas en ON en.id_evaluacion = ev.id_evaluacion
            JOIN calificaciones c ON c.id_entrega = en.id_entrega
            WHERE ev.id_curso = ?
            GROUP BY en.id_alumno
            ORDER BY c.nota DESC
            LIMIT 10
            ";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param("s", $id_curso);

            $stmt->execute();
            $result = $stmt->get_result();
            $items = [];
            while ($row = $result->fetch_assoc()) {
                $alumnos[] = $row;
            }
            return $alumnos;

    }


    public function getCursoModels(): array {
        $sql = "SELECT c.*, i.nombre AS nombre_idioma, n.nombre AS nombre_nivel, 
                       CONCAT(u.nombres, ' ', u.apellidos) AS nombre_profesor,
                       a.nombre AS nombre_aula
                FROM cursos c
                JOIN idiomas i ON c.id_idioma = i.id_idioma
                JOIN niveles n ON c.id_nivel = n.id_nivel
                JOIN profesores p ON c.id_profesor = p.id_profesor
                JOIN usuarios u ON p.id_usuario = u.id_usuario
                JOIN aulas a ON c.id_aula = a.id_aula
                ORDER BY c.id_curso DESC";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $items = [];
        while ($row = $result->fetch_assoc()) {
            $items[] = $row;
        }
        return $items;
    }

    public function getCursosByNivel(int $id_nivel): array {
        $sql = "SELECT c.*, i.nombre AS nombre_idioma, n.nombre AS nombre_nivel, 
                       CONCAT(u.nombres, ' ', u.apellidos) AS nombre_profesor,
                       a.nombre AS nombre_aula
                FROM cursos c
                JOIN idiomas i ON c.id_idioma = i.id_idioma
                JOIN niveles n ON c.id_nivel = n.id_nivel
                JOIN profesores p ON c.id_profesor = p.id_profesor
                JOIN usuarios u ON p.id_usuario = u.id_usuario
                JOIN aulas a ON c.id_aula = a.id_aula
                WHERE c.id_nivel = ?
                ORDER BY c.id_curso DESC";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $id_nivel);
        $stmt->execute();
        $result = $stmt->get_result();
        $items = [];
        while ($row = $result->fetch_assoc()) {
            $items[] = $row;
        }
        return $items;
    }

    public function getCursosActivos(): array {
        $sql = "SELECT c.*, i.nombre AS nombre_idioma, n.nombre AS nombre_nivel,
                       CONCAT(u.nombres, ' ', u.apellidos) AS nombre_profesor
                FROM cursos c
                JOIN idiomas i ON c.id_idioma = i.id_idioma
                JOIN niveles n ON c.id_nivel = n.id_nivel
                JOIN profesores p ON c.id_profesor = p.id_profesor
                JOIN usuarios u ON p.id_usuario = u.id_usuario
                WHERE c.estado = 1
                ORDER BY c.id_curso DESC";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $items = [];
        while ($row = $result->fetch_assoc()) {
            $items[] = $row;
        }
        return $items;
    }

    public function getCursosByProfesor(int $id_profesor): array {
        $sql = "SELECT c.*, i.nombre AS nombre_idioma, n.nombre AS nombre_nivel
                FROM cursos c
                JOIN idiomas i ON c.id_idioma = i.id_idioma
                JOIN niveles n ON c.id_nivel = n.id_nivel
                WHERE c.id_profesor = ? AND c.estado = 1
                ORDER BY c.id_curso DESC";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $id_profesor);
        $stmt->execute();
        $result = $stmt->get_result();
        $items = [];
        while ($row = $result->fetch_assoc()) {
            $items[] = $row;
        }
        return $items;
    }

    public function getCursosByAlumno(int $id_alumno): array {
        $sql = "SELECT c.*, i.nombre AS nombre_idioma, n.nombre AS nombre_nivel,
                       CONCAT(u.nombres, ' ', u.apellidos) AS nombre_profesor,
                       ins.id_inscripcion
                FROM inscripciones ins
                JOIN cursos c ON ins.id_curso = c.id_curso
                JOIN idiomas i ON c.id_idioma = i.id_idioma
                JOIN niveles n ON c.id_nivel = n.id_nivel
                JOIN profesores p ON c.id_profesor = p.id_profesor
                JOIN usuarios u ON p.id_usuario = u.id_usuario
                WHERE ins.id_alumno = ?
                ORDER BY c.id_curso DESC";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $id_alumno);
        $stmt->execute();
        $result = $stmt->get_result();
        $items = [];
        while ($row = $result->fetch_assoc()) {
            $items[] = $row;
        }
        return $items;
    }

    public function getcursoById(int $id): ?array {
        $sql = "SELECT 
                    c.*, 
                    i.nombre AS nombre_idioma, 
                    n.nombre AS nombre_nivel,
                    CONCAT(u.nombres, ' ', u.apellidos) AS nombre_profesor
                FROM cursos c
                JOIN idiomas i ON c.id_idioma = i.id_idioma
                JOIN niveles n ON c.id_nivel = n.id_nivel
                JOIN profesores p ON c.id_profesor = p.id_profesor
                JOIN usuarios u ON p.id_usuario = u.id_usuario
                WHERE c.estado = 1 AND c.id_curso = ?
                ORDER BY c.id_curso DESC;";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc() ?: null;
    }

    public function crearcurso(array $datos): int|string {
        $sql = "INSERT INTO cursos (nombre, id_idioma, id_nivel, id_profesor, id_aula, fecha_inicio, fecha_fin, estado) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);
        if (!$stmt) return "Error preparando la consulta.";
        
        $datos['estado'] = 1;
        
        $stmt->bind_param("siiiissi", $datos['nombre'], $datos['id_idioma'], $datos['id_nivel'], $datos['id_profesor'], $datos['id_aula'], $datos['fecha_inicio'], $datos['fecha_fin'], $datos['estado']);
        
        try {
            $stmt->execute();
            return $stmt->insert_id;
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() == 1062) return "Registro duplicado.";
            return $e->getMessage();
        }
    }

    public function actualizarcurso(array $datos): bool|string {
        $sql = "UPDATE cursos SET nombre = ?, id_idioma = ?, id_nivel = ?, id_profesor = ?, id_aula = ?, fecha_inicio = ?, fecha_fin = ?, estado = ? WHERE id_curso = ?";
        $stmt = $this->conexion->prepare($sql);
        if (!$stmt) return false;
        
        $stmt->bind_param("siiiissii", $datos['nombre'], $datos['id_idioma'], $datos['id_nivel'], $datos['id_profesor'], $datos['id_aula'], $datos['fecha_inicio'], $datos['fecha_fin'], $datos['estado'], $datos['id_curso']);
        
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