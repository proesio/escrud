<?php

/**
 * Este archivo es parte del proyecto Escrud.
 * 
 * PHP versions 7 and 8 
 * 
 * @author    Juan Felipe Valencia Murillo  <juanfe0245@gmail.com>
 * @copyright 2020 - presente  Juan Felipe Valencia Murillo
 * @license   https://opensource.org/licenses/MIT  MIT License
 * @version   GIT:  2.0.0
 * @link      https://escrud.proes.io
 * @since     Fecha inicio de creación del proyecto  2020-05-31
 */

namespace Escrud\Clases;

use PIPE\Clases\PIPE;
use Escrud\Clases\Excepciones\Escrud;
use function Escrud\Funciones\obtenerEntorno;

class HTML
{
    /**
     * Indica el id del elemento HTML.
     *
     * @var int
     */
    private $_elementoId = 0;

    /**
     * Nombre de la tabla en la base de datos.
     *
     * @var string
     */
    private $_tabla = '';

    /**
     * Llave primaria de la tabla.
     *
     * @var string
     */
    private $_llavePrimaria = 'id';

    /**
     * Indica los campos que se mostrarán en la renderización de la tabla.
     *
     * @var array
     */
    private $_visibles = [];

    /**
     * Indica los campos que no se mostrarán en la renderización de la tabla.
     *
     * @var array
     */
    private $_ocultos = [];

    /**
     * Indica los campos que pueden ser insertados.
     *
     * @var array
     */
    private $_insertables = [];

    /**
     * Indica los campos que pueden ser actualizados.
     *
     * @var array
     */
    private $_actualizables = [];

    /**
     * Indica los campos que pueden ser buscados.
     *
     * @var array
     */
    private $_buscables = [];

    /**
     * Indica los campos que no pueden ser buscados.
     *
     * @var array
     */
    private $_noBuscables = [];

    /**
     * Indica los alias para cada campo que 
     * se mostrarán en la renderización de la tabla.
     *
     * @var array
     */
    private $_alias = [];

    /**
     * Nombre del campo donde se registra el tiempo de la creación del registro.
     *
     * @var string
     */
    private $_creadoEn = 'creado_en';

    /**
     * Nombre del campo donde se registra el tiempo de la actualización del registro.
     *
     * @var string
     */
    private $_actualizadoEn = 'actualizado_en';

    /**
     * Ordenamiento del resultado de la consulta SQL.
     *
     * @var array
     */
    private $_ordenarPor = [];

    /**
     * Indica las acciones que serán gestionadas.
     *
     * @var array
     */
    private $_acciones = [
        'acciones' => true,
        'crear' => true,
        'editar' => true,
        'eliminar' => true
    ];

    /**
     * Título de la tabla.
     *
     * @var string
     */
    private $_titulo = '';

    /**
     * Crea una nueva instancia de la clase HTML.
     *
     * @param string $tabla tabla
     * 
     * @return void
     * 
     * @throws \Escrud\Clases\Excepciones\Escrud
     */
    public function __construct($tabla)
    {
        $this->_tabla = $tabla;

        if (!empty($this->_tabla) && !$this->_obtenerCamposTabla()) {
            throw new Escrud(
                Texto::$textos['TABLA_NO_EXISTE'].' '.$this->_tabla
            );
        }

        $this->_elementoId = Configuracion::$elementoId++;
    }

    /**
     * Establece la llave primaria referente a la tabla especificada.
     *
     * @param string $llavePrimaria llavePrimaria
     * 
     * @return $this
     */
    public function llavePrimaria($llavePrimaria)
    {
        $this->_verificarCamposExisten([$llavePrimaria], __FUNCTION__);

        $this->_llavePrimaria = $llavePrimaria;

        return $this;
    }

    /**
     * Establece los campos que se mostrarán en la renderización de la tabla.
     *
     * @return $this
     */
    public function visibles()
    {
        $parametros = func_get_args();

        $this->_verificarCamposExisten($parametros, __FUNCTION__);

        $this->_visibles = $parametros;

        return $this;
    }

    /**
     * Establece los campos que no se mostrarán en la renderización de la tabla.
     *
     * @return $this
     */
    public function ocultos()
    {
        $parametros = func_get_args();

        $this->_verificarCamposExisten($parametros, __FUNCTION__);

        $this->_ocultos = $parametros;

        return $this;
    }

    /**
     * Establece los campos que podrán ser insertados.
     *
     * @return $this
     */
    public function insertables()
    {
        $parametros = func_get_args();

        $this->_verificarCamposExisten($parametros, __FUNCTION__);

        $this->_insertables = $parametros;

        return $this;
    }

    /**
     * Establece los campos que podrán ser actualizados.
     *
     * @return $this
     */
    public function actualizables()
    {
        $parametros = func_get_args();

        $this->_verificarCamposExisten($parametros, __FUNCTION__);

        $this->_actualizables = $parametros;

        return $this;
    }

    /**
     * Establece los campos que podrán ser buscados.
     *
     * @return $this
     */
    public function buscables()
    {
        $parametros = func_get_args();

        $this->_verificarCamposExisten($parametros, __FUNCTION__);

        $this->_buscables = $parametros;

        return $this;
    }

    /**
     * Establece los campos que no podrán ser buscados.
     *
     * @return $this
     */
    public function noBuscables()
    {
        $parametros = func_get_args();

        $this->_verificarCamposExisten($parametros, __FUNCTION__);

        $this->_noBuscables = $parametros;

        return $this;
    }

    /**
     * Establece los alias para cada campo 
     * que se mostrarán en la renderización de la tabla.
     *
     * @param array $alias alias
     * 
     * @return $this
     */
    public function alias($alias)
    {
        $this->_verificarCamposExisten($alias, __FUNCTION__, true);

        $this->_alias = $alias;

        return $this;
    }

    /**
     * Establece el nombre del campo donde se 
     * registra el tiempo de la creación del registro.
     *
     * @param string $creadoEn creadoEn
     * 
     * @return $this
     */
    public function creadoEn($creadoEn)
    {
        $this->_verificarCamposExisten([$creadoEn], __FUNCTION__);

        $this->_creadoEn = $creadoEn;

        return $this;
    }

    /**
     * Establece el nombre del campo donde se 
     * registra el tiempo de la actualización del registro.
     *
     * @param string $actualizadoEn actualizadoEn
     * 
     * @return $this
     */
    public function actualizadoEn($actualizadoEn)
    {
        $this->_verificarCamposExisten([$actualizadoEn], __FUNCTION__);

        $this->_actualizadoEn = $actualizadoEn;

        return $this;
    }

    /**
     * Ordena el resultado de la consulta SQL.
     *
     * @param string|array $campo campo
     * @param string       $tipo  tipo
     * 
     * @return $this
     */
    public function ordenarPor($campo, $tipo = 'asc')
    {
        $ordenes = is_array($campo) && !empty($campo) ? $campo : [$campo];

        $this->_verificarCamposExisten($ordenes, __FUNCTION__);

        $this->_ordenarPor = ['ordenes' => $ordenes, 'tipo' => $tipo];

        return $this;
    }

    /**
     * Establece las acciones que serán gestionadas.
     *
     * @param array $acciones acciones
     * 
     * @return $this
     */
    public function acciones($acciones)
    {
        $this->_acciones = [
            'acciones' => $acciones['acciones'] ?? true,
            'crear' => $acciones['crear'] ?? true,
            'editar' => $acciones['editar'] ?? true,
            'eliminar' => $acciones['eliminar'] ?? true,
        ];

        return $this;
    }

    /**
     * Establece el título de la tabla.
     *
     * @param string $titulo titulo
     * 
     * @return $this
     */
    public function titulo($titulo)
    {
        $this->_titulo = $titulo;

        return $this;
    }

    /**
     * Renderiza la tabla especificada con su respectiva configuración.
     *
     * @return void
     */
    public function renderizar()
    {
        $html = $this;

        include __DIR__.'/../Vistas/tabla.php';
    }

    // Inicio métodos privados.

    /**
     * Verifica que los campos existan en la tabla especificada.
     *
     * @param array   $campos     campos
     * @param string  $metodo     metodo
     * @param boolean $asociativo asociativo
     * 
     * @return boolean
     * 
     * @throws \Escrud\Clases\Excepciones\Escrud
     */
    private function _verificarCamposExisten($campos, $metodo, $asociativo = false)
    {
        $camposTabla = $this->_obtenerCamposTabla();

        foreach ($campos as $clave => $valor) {
            $campo = $asociativo ? $clave : $valor;

            if (!in_array($campo, $camposTabla)) {
                throw new Escrud(
                    $metodo
                    .' - '.Texto::$textos['CAMPO_NO_EXISTE']
                    .' '.$campo
                );
            }
        }

        return true;
    }

    /**
     * Obtiene el encabezado de la tabla según los campos.
     *
     * @return string
     */
    private function _obtenerEncabezado()
    {
        $encabezado = $this->_obtenerCamposTabla();

        return json_encode($encabezado);
    }

    /**
     * Obtiene todos los campos de la tabla en la base de datos.
     *
     * @return array
     */
    private function _obtenerCamposTabla()
    {
        $controlador = Configuracion::config('BD_CONTROLADOR');

        if ($controlador == 'mysql') {
            $campoEsquema = 'table_schema';
        } else {
            $campoEsquema = 'table_catalog';
        }

        $consultaColumna = (
            'select 
                column_name
            from
                information_schema.columns
            where
                '.$campoEsquema.' = '."'".Configuracion::config('BD_BASEDATOS')."'".'
                and table_name = '."'".$this->_tabla."'"
        );

        $columna = 0;

        if ($controlador == 'sqlite') {
            $columna = 1;
            $consultaColumna = 'pragma table_info('.$this->_tabla.')';
        }

        $pdo = PIPE::obtenerPDO();

        $consulta = $pdo->query($consultaColumna);

        return $consulta->fetchAll(\PDO::FETCH_COLUMN, $columna);
    }

    /**
     * Obtiene los atributos de la clase HTML.
     *
     * @return string
     */
    private function _obtenerAtributos()
    {
        $atributos = [
            'elementoId' => $this->_elementoId,
            'tabla' => $this->_tabla,
            'llavePrimaria' => $this->_llavePrimaria,
            'visibles' => $this->_visibles,
            'ocultos' => $this->_ocultos,
            'insertables' => $this->_insertables,
            'actualizables' => $this->_actualizables,
            'buscables' => $this->_buscables,
            'noBuscables' => $this->_noBuscables,
            'alias' => $this->_alias,
            'creadoEn' => $this->_creadoEn,
            'actualizadoEn' => $this->_actualizadoEn,
            'ordenarPor' => $this->_ordenarPor,
            'acciones' => $this->_acciones,
            'titulo' => $this->_titulo
        ];

        return json_encode($atributos);
    }

    /**
     * Obtiene las variables de configuración.
     *
     * @return string
     */
    private function _obtenerConfiguracion()
    {
        $entorno = include obtenerEntorno();

        $config = [
            'BD_CONTROLADOR' => Configuracion::config('BD_CONTROLADOR'),
            'BD_HOST' => Configuracion::config('BD_HOST'),
            'BD_PUERTO' => Configuracion::config('BD_PUERTO'),
            'BD_USUARIO' => Configuracion::config('BD_USUARIO'),
            'BD_CONTRASENA' => Configuracion::config('BD_CONTRASENA'),
            'BD_BASEDATOS' => Configuracion::config('BD_BASEDATOS'),
            'IDIOMA' => Configuracion::config('IDIOMA'),
            'RUTA_MODELOS' => __DIR__.'/Modelos',
            'ZONA_HORARIA' => Configuracion::config('ZONA_HORARIA'),
            'COMANDO_INICIAL' => Configuracion::config('COMANDO_INICIAL'),
            'TIPO_RETORNO' => PIPE::OBJETO,
            'OPCIONES' => Configuracion::config('OPCIONES') ?? [],
            'BD_TABLA' => $this->_tabla,
            'ENTORNO' => $entorno
        ];

        return json_encode($config);
    }

    // Fin métodos privados.
}
