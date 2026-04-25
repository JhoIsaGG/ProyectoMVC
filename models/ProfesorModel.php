<?php
class ProfesorModel {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function getProfesorModels(): array {
        $sql = "SELECT p.id_profesor, p.id_usuario, u.nombres, u.apellidos, u.username, 
                       (SELECT GROUP_CONCAT(c.nombre SEPARATOR ', ') FROM cursos c WHERE c.id_profesor = p.id_profesor) as cursos_dictados,
                       (SELECT GROUP_CONCAT(i.nombre SEPARATOR ', ') FROM profesores_idiomas pi JOIN idiomas i ON pi.id_idioma = i.id_idioma WHERE pi.id_profesor = p.id_profesor) as idiomas_hablados
                FROM profesores p
                JOIN usuarios u ON p.id_usuario = u.id_usuario
                ORDER BY p.id_profesor DESC";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $items = [];
        while ($row = $result->fetch_assoc()) {
            $items[] = $row;
        }
        return $items;
    }

    public function getprofesorById(int $id): ?array {
        $sql = "SELECT p.*, u.nombres, u.apellidos, u.username, u.email, u.telefono, u.fecha_nacimiento, u.direccion, u.estado, u.id_rol 
                FROM profesores p 
                JOIN usuarios u ON p.id_usuario = u.id_usuario
                WHERE p.id_profesor = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc() ?: null;
    }

    public function getProfesorByUsuario(int $id_usuario): ?array {
        $sql = "SELECT * FROM profesores WHERE id_usuario = ? LIMIT 1";
        $stmt = $this->conexion->prepare($sql);
        if (!$stmt) return null;
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc() ?: null;
    }

    public function vincularIdiomas(int $id_profesor, array $id_idiomas): bool {
        $sqlDelete = "DELETE FROM profesores_idiomas WHERE id_profesor = ?";
        $stmtDel = $this->conexion->prepare($sqlDelete);
        if ($stmtDel) {
            $stmtDel->bind_param("i", $id_profesor);
            $stmtDel->execute();
        }

        if (empty($id_idiomas)) return true;

        $sqlInsert = "INSERT INTO profesores_idiomas (id_profesor, id_idioma) VALUES (?, ?)";
        $stmtIns = $this->conexion->prepare($sqlInsert);
        if (!$stmtIns) return false;
        
        foreach ($id_idiomas as $id_idioma) {
            $stmtIns->bind_param("ii", $id_profesor, $id_idioma);
            $stmtIns->execute();
        }
        return true;
    }

    public function getIdiomasByProfesor(int $id_profesor): array {
        $sql = "SELECT id_idioma FROM profesores_idiomas WHERE id_profesor = ?";
        $stmt = $this->conexion->prepare($sql);
        if (!$stmt) return [];
        $stmt->bind_param("i", $id_profesor);
        $stmt->execute();
        $result = $stmt->get_result();
        $idiomas = [];
        while ($row = $result->fetch_assoc()) {
            $idiomas[] = $row['id_idioma'];
        }
        return $idiomas;
    }

    public function crearprofesor(array $datos): bool|string {
        $sql = "INSERT INTO profesores (id_usuario) VALUES (?)";
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

    public function actualizarprofesor(array $datos): bool|string {
        $sql = "UPDATE profesores SET id_usuario = ? WHERE id_profesor = ?";
        $stmt = $this->conexion->prepare($sql);
        if (!$stmt) return false;
        
        $stmt->bind_param("ii", $datos['id_usuario'], $datos['id_profesor']);
        
        try {
            $stmt->execute();
            return true;
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() == 1062) return "Registro duplicado.";
            return false;
        }
    }

    public function eliminarprofesor(int $id): bool {
        $sql = "DELETE FROM profesores WHERE id_profesor = ?";
        $stmt = $this->conexion->prepare($sql);
        if (!$stmt) return false;
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

}
?>