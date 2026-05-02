CREATE TABLE roles (
    id_rol INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    estado BOOLEAN NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nombres VARCHAR(100) NOT NULL,
    apellidos VARCHAR(100) NOT NULL,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100)  NOT NULL UNIQUE,
    telefono VARCHAR(20) NOT NULL,
    fecha_nacimiento DATE NOT NULL,
    direccion TINYTEXT NOT NULL,
    id_rol INT NOT NULL,
    estado BOOLEAN NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_rol) REFERENCES roles(id_rol)
);

CREATE TABLE alumnos (
    id_alumno INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
);

CREATE TABLE profesores (
    id_profesor INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
);

CREATE TABLE idiomas (
    id_idioma INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    estado BOOLEAN,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);


CREATE TABLE profesores_idiomas (
    id_profesor_idioma INT AUTO_INCREMENT PRIMARY KEY,
    id_profesor INT NOT NULL,
    id_idioma INT NOT NULL,
    FOREIGN KEY (id_profesor) REFERENCES profesores(id_profesor),
    FOREIGN KEY (id_idioma) REFERENCES idiomas(id_idioma),
    UNIQUE (id_profesor, id_idioma)
);

CREATE TABLE niveles (
    id_nivel INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50),
    descripcion TEXT,
    estado BOOLEAN, 
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE cursos (
    id_curso INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100),
    id_idioma INT NOT NULL,
    id_nivel INT NOT NULL,
    id_profesor INT NOT NULL,
    id_aula INT NOT NULL,
    fecha_inicio DATE,
    fecha_fin DATE,
    estado BOOLEAN,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_idioma) REFERENCES idiomas(id_idioma),
    FOREIGN KEY (id_nivel) REFERENCES niveles(id_nivel),
    FOREIGN KEY (id_profesor) REFERENCES profesores(id_profesor),
    FOREIGN KEY (id_aula) REFERENCES aulas(id_aula)
);

CREATE TABLE inscripciones (
    id_inscripcion INT AUTO_INCREMENT PRIMARY KEY,
    id_alumno INT NOT NULL,
    id_curso INT NOT NULL,
    fecha_inscripcion DATETIME DEFAULT CURRENT_TIMESTAMP,
    estado BOOLEAN NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_alumno) REFERENCES alumnos(id_alumno),
    FOREIGN KEY (id_curso) REFERENCES cursos(id_curso),
    UNIQUE (id_alumno, id_curso)
);

CREATE TABLE tipos_evaluacion (
    id_tipo_evaluacion INT AUTO_INCREMENT PRIMARY KEY, 
    nombre VARCHAR(100),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE evaluaciones (
    id_evaluacion INT AUTO_INCREMENT PRIMARY KEY,
    id_curso INT NOT NULL,
    punteo DECIMAL(5,2),
    id_tipo_evaluacion INT NOT NULL,
    fecha_publicacion DATE,
    fecha_entrega DATE,
    observaciones TEXT,
    estado BOOLEAN,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_curso) REFERENCES cursos(id_curso),
    FOREIGN KEY (id_tipo_evaluacion) REFERENCES tipos_evaluacion(id_tipo_evaluacion)
);

CREATE TABLE entregas (
    id_entrega INT AUTO_INCREMENT PRIMARY KEY,
    id_evaluacion INT NOT NULL,
    id_alumno INT NOT NULL,
    fecha_entrega DATETIME DEFAULT CURRENT_TIMESTAMP,
    estado BOOLEAN DEFAULT TRUE,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_evaluacion) REFERENCES evaluaciones(id_evaluacion),
    FOREIGN KEY (id_alumno) REFERENCES alumnos(id_alumno)
);

CREATE TABLE calificaciones (
    id_calificacion INT AUTO_INCREMENT PRIMARY KEY,
    id_entrega INT NOT NULL,
    nota DECIMAL(5,2) NOT NULL,
    comentarios_profesor TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_entrega) REFERENCES entregas(id_entrega),
    UNIQUE (id_entrega)
);



CREATE TABLE asistencias (
    id_asistencia INT AUTO_INCREMENT PRIMARY KEY,
    id_curso INT NOT NULL,
    id_alumno INT NOT NULL,
    fecha DATE NOT NULL,
    estado INT NOT NULL,
    observaciones VARCHAR(255),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_curso) REFERENCES cursos(id_curso),
    FOREIGN KEY (id_alumno) REFERENCES alumnos(id_alumno),
    UNIQUE (id_curso, id_alumno, fecha)
);

CREATE TABLE aulas (
    id_aula INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    capacidad INT NOT NULL,
    tipo INT NOT NULL,
    estado BOOLEAN DEFAULT TRUE,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);


CREATE TABLE horarios_curso (
    id_horario INT AUTO_INCREMENT PRIMARY KEY,
    id_curso INT NOT NULL,
    dia_semana INT NOT NULL,
    hora_inicio TIME NOT NULL,
    hora_fin TIME NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_curso) REFERENCES cursos(id_curso)
);