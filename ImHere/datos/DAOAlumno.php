<?php
//importa la clase conexión y el modelo para usarlos
require_once __DIR__ . '/conexion.php';
require_once __DIR__ . '/../modelos/Alumno.php';
require_once __DIR__ . '/../modelos/Asistencia.php';
require_once __DIR__ . '/../modelos/Grupo.php';

class DAOALumno
{

    private $conexion;

    /**
     * Permite obtener la conexión a la BD
     */
    private function conectar()
    {
        try {
            $this->conexion = Conexion::conectar();
        } catch (Exception $e) {
            die($e->getMessage()); /*Si la conexion no se establece se cortara el flujo enviando un mensaje con el error*/
        }
    }

    public function autenticarAl($user, $password)
    {
        try {
            $this->conectar();

            //Almacenará el registro obtenido de la BD
            $obj = null;

            $sentenciaSQL = $this->conexion->prepare("SELECT nocontrol,nombre,apellidos FROM alumno WHERE nocontrol=? AND password=sha224(?)");
            //Se ejecuta la sentencia sql con los parametros dentro del arreglo 
            $sentenciaSQL->execute([$user, $password]);

            /*Obtiene los datos*/
            $fila = $sentenciaSQL->fetch(PDO::FETCH_OBJ);
            if ($fila) {
                $obj = new Alumno();
                $obj->noControl = $fila->nocontrol;
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

    public function obtenerMaterias($id)
    {
        try {
            $this->conectar();

            $lista = array();
            /*Se arma la sentencia sql para seleccionar todos los registros de la base de datos*/
            $sentenciaSQL = $this->conexion->prepare("SELECT c.idClase,c.CodigoGrupo,c.HoraInicio,c.HoraFin,c.Nombre FROM
            Alumno a JOIN AlumnoClase ac ON a.noControl = ac.Alumno_noControl JOIN Clase c ON ac.Clase_Id = c.idClase
            WHERE a.noControl = ?");

            //Se ejecuta la sentencia sql, retorna un cursor con todos los elementos
            $sentenciaSQL->execute($id);

            //$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
            $resultado = $sentenciaSQL->fetchAll(PDO::FETCH_OBJ);

            foreach ($resultado as $fila) {
                $obj = new Grupo();
                $obj->idClase = $fila->idclase;
                $obj->CodigoGrupo = $fila->codigogrupo;
                $obj->HoraInicio = $fila->horainicio;
                $obj->HoraFin = $fila->horafin;
                $obj->Nombre = $fila->nombre;
                
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


    public function obtenerAsistencias($id)
    {
        try {
            $this->conectar();

            $lista = array();
            /*Se arma la sentencia sql para seleccionar todos los registros de la base de datos*/
            $sentenciaSQL = $this->conexion->prepare("SELECT clase_id, asistencia,fecha FROM Registro WHERE Alumno_noControl = ?");

            //Se ejecuta la sentencia sql, retorna un cursor con todos los elementos
            $sentenciaSQL->execute($id);

            //$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
            $resultado = $sentenciaSQL->fetchAll(PDO::FETCH_OBJ);
            foreach ($resultado as $fila) {
                $obj = new Asistencia();
                $obj->idClase = $fila->clase_id;
                $obj->Asistencia = $fila->asistencia;
                $obj->Fecha = $fila->fecha;
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
    public function setConexion($conexion)
    {
        $this->conexion = $conexion;
    }
}
