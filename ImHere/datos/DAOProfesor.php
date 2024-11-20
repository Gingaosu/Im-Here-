<?php
//importa la clase conexión y el modelo para usarlos

use LDAP\Result;

require_once __DIR__ . '/conexion.php';
require_once __DIR__ . '/../modelos/Profesor.php';
require_once __DIR__ . '/../modelos/Grupo.php';
require_once __DIR__ . '/../modelos/Alumno.php';
require_once __DIR__ . '/../modelos/Asistencia.php';

class DAOProfesor
{

    private $conexion;

    private function conectar()
    {
        try {
            $this->conexion = Conexion::conectar();
        } catch (Exception $e) {
            die($e->getMessage()); /*Si la conexion no se establece se cortara el flujo enviando un mensaje con el error*/
        }
    }

    public function autenticarPf($user, $password)
    {
        try {
            $this->conectar();

            $obj = null;

            $sentenciaSQL = $this->conexion->prepare("SELECT idProfesor,Nombre,Apellidos FROM Profesor WHERE idProfesor=? AND password=sha224(?)");

            $sentenciaSQL->execute([$user, $password]);

            /*Obtiene los datos*/
            $fila = $sentenciaSQL->fetch(PDO::FETCH_OBJ);
            if ($fila) {
                //var_dump($fila); // Verifica si se está obteniendo el registro de la base de datos correctamente
                $obj = new Profesor();
                $obj->idProfesor = $fila->idprofesor;
                $obj->Nombre = $fila->nombre;
                $obj->Apellidos = $fila->apellidos;
            }

            return $obj;
        } catch (Exception $e) {
            var_dump($e);
            return null;
        } finally {
            Conexion::desconectar();
        }
    }

    public function obtenerGrupos($id)
    {
        try {
            $this->conectar();

            $lista = array();
            /*Se arma la sentencia sql para seleccionar todos los registros de la base de datos*/
            $sentenciaSQL = $this->conexion->prepare("SELECT idClase,codigoGrupo,HoraInicio,HoraFin,Nombre,Profesor_Id FROM Clase
            where Profesor_Id=?");
            //var_dump($id);
            //Se ejecuta la sentencia sql, retorna un cursor con todos los elementos
            $sentenciaSQL->execute($id);

            //$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
            $resultado = $sentenciaSQL->fetchAll(PDO::FETCH_OBJ);
            /*Podemos obtener un cursor resultado con todos los renglones como 
            un arreglo de arreglos asociativos o un arreglo de objetos*/
            /*Se recorre el cursor para obtener los datos*/
            foreach ($resultado as $fila) {
                $obj = new Grupo();
                $obj->idClase = $fila->idclase;
                $obj->CodigoGrupo = $fila->codigogrupo;
                $obj->HoraInicio = $fila->horainicio;
                $obj->HoraFin = $fila->horafin;
                $obj->Nombre = $fila->nombre;
                $obj->idProfesor = $fila->profesor_id;

                $lista[] = $obj;
            }

            return $lista;
        } catch (PDOException $e) {
            //var_dump("". $e->getMessage());
            return null;
        } finally {
            Conexion::desconectar();
        }
    }

    public function obtenerClasePorId($idClase, $idProfesor)
    {
        try {
            $this->conectar();

            // Se arma la sentencia SQL para seleccionar una clase específica por su idClase
            $sentenciaSQL = $this->conexion->prepare("SELECT idClase, CodigoGrupo, HoraInicio, HoraFin, Nombre, Profesor_Id FROM Clase WHERE idClase = ? AND Profesor_Id = ?");
            // Se ejecuta la sentencia SQL, retorna un cursor con el elemento
            $sentenciaSQL->execute(array($idClase, $idProfesor));

            // Se obtiene el resultado como un objeto
            $resultado = $sentenciaSQL->fetch(PDO::FETCH_OBJ);

            if ($resultado) {
                $obj = new Grupo();
                $obj->idClase = $resultado->idclase;
                $obj->CodigoGrupo = $resultado->codigogrupo;
                $obj->HoraInicio = $resultado->horainicio;
                $obj->HoraFin = $resultado->horafin;
                $obj->Nombre = $resultado->nombre;
                $obj->idProfesor = $resultado->profesor_id;

                return $obj;
            } else {
                return null;
            }
        } catch (PDOException $e) {
            //var_dump("". $e->getMessage());
            return null;
        } finally {
            Conexion::desconectar();
        }
    }

    public function obtenerAlumnos($clse, $profesor)
    {
        try {
            $this->conectar();

            $lista = array();
            /*Se arma la sentencia sql para seleccionar todos los registros de la base de datos*/
            $sentenciaSQL = $this->conexion->prepare("SELECT a.noControl, a.Nombre, a.Apellidos
            FROM Alumno a
            JOIN AlumnoClase ac ON a.noControl = ac.Alumno_noControl
            JOIN Clase c ON ac.Clase_Id = c.idClase
            JOIN Profesor p ON c.Profesor_Id = p.idProfesor
            WHERE c.idClase=? AND p.idProfesor=?");
            //Se ejecuta la sentencia sql, retorna un cursor con todos los elementos
            $sentenciaSQL->execute([$clse, $profesor]);

            //$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
            $resultado = $sentenciaSQL->fetchAll(PDO::FETCH_OBJ);
            /*Podemos obtener un cursor resultado con todos los renglones como 
            un arreglo de arreglos asociativos o un arreglo de objetos*/
            /*Se recorre el cursor para obtener los datos*/
            foreach ($resultado as $fila) {
                $obj = new Alumno();
                $obj->noControl = $fila->nocontrol;
                $obj->Nombre = $fila->nombre;
                $obj->Apellidos = $fila->apellidos;
                $lista[] = $obj;
            }

            return $lista;
        } catch (PDOException $e) {
            //var_dump("". $e->getMessage());
            return null;
        } finally {
            Conexion::desconectar();
        }
    }

    public function obtenerAsistencias($idClase, $fecha)
    {
        try {
            $this->conectar();

            $lista = array();
            /* Se arma la sentencia sql para seleccionar todos los registros de asistencia 
               de una clase específica en una fecha específica */
            $sentenciaSQL = $this->conexion->prepare("SELECT Alumno_noControl, asistencia, fecha FROM Registro WHERE clase_id = ? AND DATE(fecha) = DATE(?)");

            // Se ejecuta la sentencia sql, retorna un cursor con todos los elementos
            $sentenciaSQL->execute([$idClase, $fecha]);

            //$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
            $resultado = $sentenciaSQL->fetchAll(PDO::FETCH_OBJ);
            /* Podemos obtener un cursor resultado con todos los renglones como 
               un arreglo de arreglos asociativos o un arreglo de objetos */
            /* Se recorre el cursor para obtener los datos */
            foreach ($resultado as $fila) {
                $obj = new Asistencia2();
                $obj->noControl = $fila->alumno_nocontrol;
                $obj->Asistencia = $fila->asistencia;
                $obj->Fecha = $fila->fecha;
                $lista[] = $obj;
            }

            return $lista;
        } catch (PDOException $e) {
            return null;
        } finally {
            Conexion::desconectar();
        }
    }


    public function agregarGrupo($NombreMateria, $Grupo, $HoraInicio, $HoraFin, $idProfesor)
    {
        try {
            $this->conectar();

            //Almacenará el registro obtenido de la BD
            $resultado = null;

            $sentenciaSQL = $this->conexion->prepare("INSERT INTO clase (codigogrupo, horainicio, horafin, nombre, profesor_Id)
            VALUES (?, ?, ?, ?, ?)");
            //Se ejecuta la sentencia sql con los parametros dentro del arreglo 
            $sentenciaSQL->execute([$Grupo, $HoraInicio, $HoraFin, $NombreMateria, $idProfesor]);

            /*Obtiene los datos*/
            $resultado = $this->conexion->lastInsertId();
            return $resultado;
        } catch (Exception $e) {
            var_dump($e);
            return null;
        } finally {
            Conexion::desconectar();
        }
    }

    public function editarGrupo($idClase, $NombreMateria, $Grupo, $HoraInicio, $HoraFin)
    {
        try {
            $this->conectar();

            // Almacenará el resultado de la operación
            $resultado = null;

            $sentenciaSQL = $this->conexion->prepare("UPDATE Clase SET Nombre = ?, codigoGrupo = ?, HoraInicio = ?, HoraFin = ? WHERE idClase = ?");
            // Se ejecuta la sentencia SQL con los parámetros dentro del arreglo 
            $sentenciaSQL->execute([$NombreMateria, $Grupo, $HoraInicio, $HoraFin, $idClase]);

            /* Verifica si la actualización se realizó correctamente */
            if ($sentenciaSQL->rowCount() > 0) {
                $resultado = true;
            } else {
                $resultado = false;
            }

            return $resultado;
        } catch (Exception $e) {
            var_dump($e);
            return null;
        } finally {
            Conexion::desconectar();
        }
    }

    public function eliminarGrupo($grupo)
    {
        try {
            $conn = Conexion::conectar();


            $sql = "DELETE FROM clase WHERE idClase = :grupo";


            $stmt = $conn->prepare($sql);


            $stmt->bindParam(':grupo', $grupo);

            $stmt->execute();


            if ($stmt->rowCount() > 0) {

                return true;
            } else {

                return false;
            }
        } catch (PDOException $e) {

            echo "Error al eliminar el grupo: " . $e->getMessage();
            return false;
        } finally {

            Conexion::desconectar();
        }
    }

    public function registrarAsistenciaFaltas($idClase, $fecha)
    {
        try {
            $this->conectar();

            // Obtener los alumnos inscritos en la clase
            $alumnos = $this->obtenerAlumnosPorClase($idClase);
            error_log("Alumnos obtenidos: " . print_r($alumnos, true));

            foreach ($alumnos as $alumno) {
                $sentenciaSQL = $this->conexion->prepare("
                INSERT INTO registro (alumno_nocontrol, clase_id, asistencia, fecha)
                VALUES (?, ?, false, ?)
                ON DUPLICATE KEY UPDATE asistencia = VALUES(asistencia)
            ");
                $sentenciaSQL->execute([$alumno->noControl, $idClase, $fecha]);
            }

            return true;
        } catch (PDOException $e) {
            error_log("Error en registrarAsistenciaFaltas: " . $e->getMessage());
            return false;
        } finally {
            Conexion::desconectar();
        }
    }




    public function agregarAlumno($noControl, $idClase)
    {
        try {
            $this->conectar();

            $sentenciaSQL = $this->conexion->prepare("INSERT INTO AlumnoClase VALUES (?,?)");
            // Se ejecuta la sentencia SQL con los parámetros dentro del arreglo 
            $sentenciaSQL->execute([$noControl, $idClase]);

            // Retorna true si la inserción fue exitosa
            return true;
        } catch (Exception $e) {
            // Manejo de excepción
            var_dump($e);
            error_log($e->getMessage()); // Registrando el error
            return false;
        } finally {
            Conexion::desconectar();
        }
    }

    public function eliminarAlumno($noControl, $idClase)
    {
        try {
            $this->conectar();

            $sentenciaSQL = $this->conexion->prepare("DELETE FROM AlumnoClase
                WHERE Alumno_noControl = (?) AND Clase_Id = (?);");
            // Se ejecuta la sentencia SQL con los parámetros dentro del arreglo 
            $sentenciaSQL->execute([$noControl, $idClase]);

            // Retorna true si la inserción fue exitosa
            return true;
        } catch (Exception $e) {
            // Manejo de excepción
            //var_dump($e);
            error_log($e->getMessage()); // Registrando el error
            return false;
        } finally {
            Conexion::desconectar();
        }
    }

    public function obtenerAlumnoPorClase($noControl, $idGrupo)
    {
        try {
            $this->conectar();

            // Se arma la sentencia SQL para seleccionar una clase específica por su idClase
            $sentenciaSQL = $this->conexion->prepare("SELECT a.noControl, a.Nombre, a.Apellidos FROM Alumno a JOIN AlumnoClase ac 
            ON a.noControl = ac.Alumno_noControl JOIN Clase c ON ac.Clase_Id = c.idClase
            WHERE  a.noControl = ? AND c.idClase = ?");
            // Se ejecuta la sentencia SQL, retorna un cursor con el elemento
            $sentenciaSQL->execute([$noControl, $idGrupo]);

            // Se obtiene el resultado como un objeto
            $resultado = $sentenciaSQL->fetch(PDO::FETCH_OBJ);

            if ($resultado) {
                $obj = new Alumno();
                $obj->noControl = $resultado->nocontrol;
                $obj->Nombre = $resultado->nombre;
                $obj->Apellidos = $resultado->apellidos;

                return $obj;
            } else {
                return null;
            }
        } catch (PDOException $e) {
            //var_dump("". $e->getMessage());
            return null;
        } finally {
            Conexion::desconectar();
        }
    }

    /*public function actualizarAsistenciay($alumnoNoControl, $claseId, $fechaHoy)
    {
        try {
            $this->conectar();

            // Obtener la fecha actual sin incluir la hora exacta
            $sentenciaSQL = $this->conexion->prepare("SELECT asistencia FROM Registro WHERE Alumno_noControl = ? AND clase_id = ? AND DATE(fecha) = ?");
            $sentenciaSQL->execute([$alumnoNoControl, $claseId, $fechaHoy]);
            // Obtener la fecha actual sin incluir la hora exacta
            $sentenciaSQL = $this->conexion->prepare("UPDATE Registro SET asistencia = true WHERE Alumno_noControl = ? AND clase_id = ? AND DATE(fecha) = ?");
            $resultado = $sentenciaSQL->execute([$alumnoNoControl, $claseId, $fechaHoy]);
            //var_dump($resultado.' when c papau');
            $filasActualizadas = $sentenciaSQL->rowCount();

            // Verificar si al menos una fila fue actualizada
            if ($filasActualizadas > 0) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            var_dump($e->getMessage());
            return false;
        } finally {
            Conexion::desconectar();
        }
    }*/

    public function actualizarAsistencia($alumnoNoControl, $claseId, $fechaHoy)
    {
        try {
            $this->conectar();

            // Obtener la fecha actual sin incluir la hora exacta
            $sentenciaSQL = $this->conexion->prepare("SELECT asistencia FROM Registro WHERE Alumno_noControl = ? AND clase_id = ? AND DATE(fecha) = ?");
            $sentenciaSQL->execute([$alumnoNoControl, $claseId, $fechaHoy]);

            // Obtener el estado actual de la asistencia
            $resultado = $sentenciaSQL->fetch(PDO::FETCH_ASSOC);
            if ($resultado === false) {
                // Si no se encuentra el registro, devolver false
                return false;
            }

            $asistenciaActual = $resultado['asistencia'];
            if ($asistenciaActual) {
                // Actualizar el estado de asistencia
                $sentenciaSQL = $this->conexion->prepare("UPDATE Registro SET asistencia = false WHERE Alumno_noControl = ? AND clase_id = ? AND DATE(fecha) = ?");
                $sentenciaSQL->execute([$alumnoNoControl, $claseId, $fechaHoy]);
            } else {
                $sentenciaSQL = $this->conexion->prepare("UPDATE Registro SET asistencia = true WHERE Alumno_noControl = ? AND clase_id = ? AND DATE(fecha) = ?");
                $sentenciaSQL->execute([$alumnoNoControl, $claseId, $fechaHoy]);
            }
            $filasActualizadas = $sentenciaSQL->rowCount();

            // Verificar si al menos una fila fue actualizada
            if ($filasActualizadas > 0) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            var_dump($e->getMessage());
            return false;
        } finally {
            Conexion::desconectar();
        }
    }




    public function verificarAsistenciaRegistrada($idClase, $fecha)
    {
        try {
            $this->conectar();

            $fechaBuscar = '';
            if ($fecha) {
                $fechaBuscar = $fecha;
            } else {
                $fechaBuscar = date('Y-m-d');
            }

            $sentenciaSQL = $this->conexion->prepare("SELECT COUNT(*) as count FROM Registro WHERE clase_id = ? AND DATE(fecha) = ?");
            $sentenciaSQL->execute([$idClase, $fechaBuscar]);

            $resultado = $sentenciaSQL->fetch(PDO::FETCH_OBJ);
            return $resultado->count > 0;
        } catch (PDOException $e) {
            var_dump($e->getMessage());
            return false;
        } finally {
            Conexion::desconectar();
        }
    }

    public function registrarAsistenciaAlumnos($idClase, $fecha)
    {
        try {
            $this->conectar();

            // Obtener la lista de alumnos de la clase
            $alumnos = $this->obtenerAlumnosPorClase($idClase);
            //var_dump($alumnos);
            foreach ($alumnos as $alumno) {
                // Registrar asistencia de los alumnos ausentes
                $sentenciaSQL = $this->conexion->prepare("INSERT INTO Registro (Alumno_noControl, clase_id, asistencia, fecha) VALUES (?, ?, false, ?)");
                //var_dump($alumno->noControl.' '.$idClase.' '.false.' tiling');
                $sentenciaSQL->execute([$alumno->noControl, $idClase, $fecha]);
            }

            return true; // Éxito al registrar la asistencia
        } catch (PDOException $e) {
            var_dump($e->getMessage());
            return false; // Error al registrar la asistencia
        } finally {
            Conexion::desconectar();
        }
    }

    public function obtenerAlumnosPorClase($idClase)
    {
        try {
            $this->conectar();

            $lista = array();

            $sentenciaSQL = $this->conexion->prepare("SELECT a.noControl, a.Nombre, a.Apellidos
                FROM Alumno a
                JOIN AlumnoClase ac ON a.noControl = ac.Alumno_noControl
                WHERE ac.Clase_Id = ?");
            $sentenciaSQL->execute([$idClase]);

            $resultado = $sentenciaSQL->fetchAll(PDO::FETCH_OBJ);

            foreach ($resultado as $fila) {
                $obj = new Alumno();
                $obj->noControl = $fila->nocontrol;
                $obj->Nombre = $fila->nombre;
                $obj->Apellidos = $fila->apellidos;
                $lista[] = $obj;
            }

            return $lista;
        } catch (PDOException $e) {
            var_dump($e->getMessage());
            return null;
        } finally {
            Conexion::desconectar();
        }
    }
}
