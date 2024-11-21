<?php

use PHPUnit\Framework\TestCase;
use PDO;
use PDOStatement;

class TestAlumno extends TestCase
{
    private $daoAlumno;
    private $mockConexion;

    protected function setUp(): void
    {
        $this->mockConexion = $this->createMock(PDO::class);
        $this->daoAlumno = $this->getMockBuilder(DAOAlumno::class)
            ->onlyMethods(['conectar'])
            ->getMock();

        $this->daoAlumno->method('conectar')->willReturn($this->mockConexion);
    }

    public function testAutenticarAl_CredencialesCorrectas_RetornaObjetoAlumno()
    {
        $mockStatement = $this->createMock(PDOStatement::class);

        $mockStatement->expects($this->once())
            ->method('execute')
            ->with(['usuario_prueba', 'password_prueba']);

        $mockStatement->expects($this->once())
            ->method('fetch')
            ->willReturn((object) [
                'nocontrol' => '12345',
                'nombre' => 'Juan',
                'apellidos' => 'Pérez',
            ]);

        $this->mockConexion->expects($this->once())
            ->method('prepare')
            ->with("SELECT nocontrol,nombre,apellidos FROM alumno WHERE nocontrol=? AND password=sha224(?)")
            ->willReturn($mockStatement);

        $resultado = $this->daoAlumno->autenticarAl('usuario_prueba', 'password_prueba');

        $this->assertNotNull($resultado);
        $this->assertEquals('12345', $resultado->noControl);
        $this->assertEquals('Juan', $resultado->Nombre);
        $this->assertEquals('Pérez', $resultado->Apellidos);
    }

    public function testAutenticarAl_CredencialesIncorrectas_RetornaNull()
    {
        $mockStatement = $this->createMock(PDOStatement::class);

        $mockStatement->expects($this->once())
            ->method('execute')
            ->with(['usuario_incorrecto', 'password_incorrecto']);

        $mockStatement->expects($this->once())
            ->method('fetch')
            ->willReturn(false);

        $this->mockConexion->expects($this->once())
            ->method('prepare')
            ->with("SELECT nocontrol,nombre,apellidos FROM alumno WHERE nocontrol=? AND password=sha224(?)")
            ->willReturn($mockStatement);

        $resultado = $this->daoAlumno->autenticarAl('usuario_incorrecto', 'password_incorrecto');

        $this->assertNull($resultado);
    }

    public function testObtenerMaterias()
    {
        $id = 12345;
        $expectedResult = [
            (object)[
                'idclase' => 1,
                'codigogrupo' => 'A1',
                'horainicio' => '08:00',
                'horafin' => '10:00',
                'nombre' => 'Matemáticas'
            ],
            (object)[
                'idclase' => 2,
                'codigogrupo' => 'B2',
                'horainicio' => '10:00',
                'horafin' => '12:00',
                'nombre' => 'Historia'
            ],
        ];

        $mockStatement = $this->createMock(PDOStatement::class);
        $mockStatement->expects($this->once())
                      ->method('execute')
                      ->with([$id]);
        $mockStatement->expects($this->once())
                      ->method('fetchAll')
                      ->with(PDO::FETCH_OBJ)
                      ->willReturn($expectedResult);

        $this->mockConexion->expects($this->once())
                           ->method('prepare')
                           ->with($this->stringContains("SELECT c.idClase,c.CodigoGrupo,c.HoraInicio,c.HoraFin,c.Nombre FROM"))
                           ->willReturn($mockStatement);

        $result = $this->daoAlumno->obtenerMaterias($id);

        $this->assertCount(2, $result);
        $this->assertEquals('Matemáticas', $result[0]->Nombre);
        $this->assertEquals('Historia', $result[1]->Nombre);
    }

    public function testObtenerAsistencias()
    {
        $id = 12345;
        $expectedResult = [
            (object)[
                'clase_id' => 1,
                'asistencia' => 'Presente',
                'fecha' => '2024-11-20'
            ],
            (object)[
                'clase_id' => 2,
                'asistencia' => 'Ausente',
                'fecha' => '2024-11-21'
            ],
        ];

        $mockStatement = $this->createMock(PDOStatement::class);
        $mockStatement->expects($this->once())
                      ->method('execute')
                      ->with([$id]);
        $mockStatement->expects($this->once())
                      ->method('fetchAll')
                      ->with(PDO::FETCH_OBJ)
                      ->willReturn($expectedResult);

        $this->mockConexion->expects($this->once())
                           ->method('prepare')
                           ->with($this->stringContains("SELECT clase_id, asistencia,fecha FROM Registro"))
                           ->willReturn($mockStatement);

        $result = $this->daoAlumno->obtenerAsistencias($id);

        $this->assertCount(2, $result);
        $this->assertEquals('Presente', $result[0]->Asistencia);
        $this->assertEquals('Ausente', $result[1]->Asistencia);
    }

}


?>