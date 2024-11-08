CREATE TABLE Alumno (
    noControl CHAR(9) PRIMARY KEY,
    Password BYTEA NOT NULL,
    Nombre VARCHAR(45) NOT NULL,
    Apellidos VARCHAR(45) NOT NULL,
    Sexo BOOLEAN NOT NULL, -- FALSE: Masculino, TRUE: Femenino
    Direccion VARCHAR(100),
    Telefono CHAR(10) NOT NULL
);

CREATE TABLE Profesor (
    idProfesor CHAR(5) PRIMARY KEY,
    Password BYTEA NOT NULL,
    Nombre VARCHAR(45) NOT NULL,
    Apellidos VARCHAR(45) NOT NULL,
    Telefono CHAR(10),
    Direccion VARCHAR(100),
    Sexo BOOLEAN NOT NULL -- FALSE: Masculino, TRUE: Femenino
);

CREATE TABLE Clase (
    idClase SERIAL PRIMARY KEY,
    codigoGrupo CHAR(4) NOT NULL,
    HoraInicio TIME(0) NOT NULL,
	HoraFin TIME(0) NOT NULL,
    Nombre VARCHAR(100) NOT NULL,
    Profesor_Id CHAR(5),
    CONSTRAINT fk_profesor
        FOREIGN KEY (Profesor_Id)
        REFERENCES Profesor (idProfesor)
);

CREATE TABLE AlumnoClase (
    Alumno_noControl CHAR(9),
    Clase_Id INT,
    CONSTRAINT fk_alumno
        FOREIGN KEY (Alumno_noControl)
        REFERENCES Alumno (noControl)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    CONSTRAINT fk_clase
        FOREIGN KEY (Clase_Id)
        REFERENCES Clase (idClase)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    PRIMARY KEY (Alumno_noControl, Clase_Id)
);

CREATE TABLE Registro (
    Alumno_noControl CHAR(9),
    Clase_Id INT,
    Asistencia BOOLEAN NOT NULL,  -- TRUE: si, FALSE: no
    Fecha DATE NOT NULL,
    CONSTRAINT fk_alumno
        FOREIGN KEY (Alumno_noControl)
        REFERENCES Alumno (noControl)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    CONSTRAINT fk_clase
        FOREIGN KEY (Clase_Id)
        REFERENCES Clase (idClase)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    PRIMARY KEY (Alumno_noControl, Clase_Id, Fecha)
);

CREATE INDEX idx_clase_profesor_id ON Clase (Profesor_Id);