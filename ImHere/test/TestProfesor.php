<?php
use PHPUnit\Framework\TestCase;
require_once __DIR__ . '/../datos/DAOAlumno.php';

class TestProfesor extends TestCase
{
    private $daoProfesor;

    protected function setUp(): void
    {
        $this->daoProfesor = $this->createMock(DAOProfesor::class);

        $mockPDO = $this->createMock(PDO::class);

        $this->daoProfesor->setConexion($mockPDO);
    }


    public function testAutenticarPf_UsuarioValido_RetornaProfesor()
    {
        $mockStatement = $this->createMock(PDOStatement::class);
        $mockStatement->method('fetch')->willReturn((object)[
            'idprofesor' => 'P123',
            'nombre' => 'Juan',
            'apellidos' => 'Pérez'
        ]);

        $mockPDO = $this->createMock(PDO::class);

        $mockPDO->method('prepare')->willReturn($mockStatement);

        $this->daoProfesor->setConexion($mockPDO);

        $result = $this->daoProfesor->autenticarPf('P123', 'password123');

        $this->assertNotNull($result);
        $this->assertEquals('P123', $result->idprofesor);
        $this->assertEquals('Juan', $result->nombre);
        $this->assertEquals('Pérez', $result->apellidos);
    }



    public function testObtenerGrupos_ProfesorConGrupos_RetornaListaDeGrupos()
    {
        $mockConexion = $this->createMock(PDO::class);
        $mockStatement = $this->createMock(PDOStatement::class);

        $mockStatement->method('fetchAll')->willReturn([
            (object)[
                'idclase' => 1,
                'codigogrupo' => 'A1',
                'horainicio' => '08:00',
                'horafin' => '10:00',
                'nombre' => 'Matemáticas',
                'profesor_id' => 'P123'
            ]
        ]);

        $mockConexion->method('prepare')->willReturn($mockStatement);

        $this->daoProfesor->setConexion($mockConexion);

        $result = $this->daoProfesor->obtenerGrupos('P123');

        $this->assertIsArray($result);
        $this->assertCount(1, $result);
        $this->assertEquals(1, $result[0]->idClase);
        $this->assertEquals('A1', $result[0]->CodigoGrupo);
        $this->assertEquals('Matemáticas', $result[0]->Nombre);
    }

    public function testObtenerClasePorId_ClaseValida_RetornaClase()
    {
        $mockConexion = $this->createMock(PDO::class);
        $mockStatement = $this->createMock(PDOStatement::class);

        $mockStatement->method('fetch')->willReturn((object)[
            'idclase' => 1,
            'codigogrupo' => 'A1',
            'horainicio' => '08:00',
            'horafin' => '10:00',
            'nombre' => 'Matemáticas',
            'profesor_id' => 'P123'
        ]);

        $mockConexion->method('prepare')->willReturn($mockStatement);

        $this->daoProfesor->setConexion($mockConexion);

        $result = $this->daoProfesor->obtenerClasePorId(1, 'P123');

        $this->assertNotNull($result);
        $this->assertEquals(1, $result->idClase);
        $this->assertEquals('A1', $result->CodigoGrupo);
        $this->assertEquals('Matemáticas', $result->Nombre);
    }

    public function testObtenerAlumnos_ClaseConAlumnos_RetornaListaDeAlumnos()
    {
        $mockConexion = $this->createMock(PDO::class);
        $mockStatement = $this->createMock(PDOStatement::class);

        $mockStatement->method('fetchAll')->willReturn([
            (object)[
                'nocontrol' => 'A001',
                'nombre' => 'Carlos',
                'apellidos' => 'González'
            ],
            (object)[
                'nocontrol' => 'A002',
                'nombre' => 'María',
                'apellidos' => 'López'
            ]
        ]);

        $mockConexion->method('prepare')->willReturn($mockStatement);

        $this->daoProfesor->setConexion($mockConexion);

        $result = $this->daoProfesor->obtenerAlumnos(1, 'P123');

        $this->assertIsArray($result);
        $this->assertCount(2, $result);
        $this->assertEquals('A001', $result[0]->noControl);
        $this->assertEquals('Carlos', $result[0]->Nombre);
        $this->assertEquals('López', $result[1]->Apellidos);
    }
}



?>