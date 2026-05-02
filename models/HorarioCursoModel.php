<?php
class HorarioCursoModel {
    private $conexion;

    const DIAS = [
        1 => 'Lunes',
        2 => 'Martes',
        3 => 'Miércoles',
        4 => 'Jueves',
        5 => 'Viernes',
        6 => 'Sábado',
        7 => 'Domingo',
    ];

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function getHorarioCursoModels(): array {
        $sql = "SELECT h.*,
                       c.nombre AS nombre_curso,
                       au.nombre AS nombre_aula,
                       au.capacidad AS capacidad_aula
                FROM horarios_curso h
                JOIN cursos c ON h.id_curso = c.id_curso
                JOIN aulas au ON h.id_aula = au.id_aula
                ORDER BY h.id_curso, h.dia_semana, h.hora_inicio";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $items = [];
        while ($row = $result->fetch_assoc()) {
            $items[] = $row;
        }
        return $items;
    }

    public function getHorariosByCurso(int $id_curso): array {
        $sql = "SELECT h.*, au.nombre AS nombre_aula, au.capacidad AS capacidad_aula
                FROM horarios_curso h
                JOIN aulas au ON h.id_aula = au.id_aula
                WHERE h.id_curso = ?
                ORDER BY h.dia_semana, h.hora_inicio";
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

    public function gethorarioById(int $id): ?array {
        $sql = "SELECT h.*, c.nombre AS nombre_curso, au.nombre AS nombre_aula
                FROM horarios_curso h
                JOIN cursos c ON h.id_curso = c.id_curso
                JOIN aulas au ON h.id_aula = au.id_aula
                WHERE h.id_horario = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc() ?: null;
    }

    public function crearhorario(array $datos): bool|string {
        $sql = "INSERT INTO horarios_curso (id_curso, id_aula, dia_semana, hora_inicio, hora_fin) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);
        if (!$stmt) return false;
        $stmt->bind_param("iiiss",
            $datos['id_curso'],
            $datos['id_aula'],
            $datos['dia_semana'],
            $datos['hora_inicio'],
            $datos['hora_fin']
        );
        try {
            $stmt->execute();
            return true;
        } catch (mysqli_sql_exception $e) {
            return false;
        }
    }

    public function actualizarhorario(array $datos): bool|string {
        $sql = "UPDATE horarios_curso SET id_curso = ?, id_aula = ?, dia_semana = ?, hora_inicio = ?, hora_fin = ? WHERE id_horario = ?";
        $stmt = $this->conexion->prepare($sql);
        if (!$stmt) return false;
        $stmt->bind_param("iiissi",
            $datos['id_curso'],
            $datos['id_aula'],
            $datos['dia_semana'],
            $datos['hora_inicio'],
            $datos['hora_fin'],
            $datos['id_horario']
        );
        try {
            $stmt->execute();
            return true;
        } catch (mysqli_sql_exception $e) {
            return false;
        }
    }

    public function eliminarhorario(int $id): bool {
        $sql = "DELETE FROM horarios_curso WHERE id_horario = ?";
        $stmt = $this->conexion->prepare($sql);
        if (!$stmt) return false;
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>
