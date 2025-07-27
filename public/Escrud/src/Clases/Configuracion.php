<?php

/**
 * Este archivo es parte del proyecto Escrud.
 * 
 * PHP versión 8. 
 * 
 * @author    Juan Felipe Valencia Murillo  <juanfe0245@gmail.com>
 * @copyright 2020 - presente  Juan Felipe Valencia Murillo
 * @license   https://opensource.org/licenses/MIT  MIT License
 * @version   GIT:  3.0.0
 * @link      https://escrud.proes.io
 * @since     Fecha inicio de creación del proyecto  2020-05-31
 */

namespace Escrud\Clases;

use Exception;
use PDOException;
use PIPE\Clases\Excepciones\ORM;
use PIPE\Clases\Excepciones\SQL;
use Escrud\Clases\Excepciones\Escrud;
use PIPE\Clases\Configuracion as PIPEConfig;
use function Escrud\Funciones\obtenerEntorno;

class Configuracion
{
    /**
     * Establece el id del elemento HTML.
     *
     * @var int
     */
    public static $elementoId = 0;

    /**
     * Establece las configuraciones de Escrud.
     *
     * @var array
     */
    private static $_configs = [];

    /**
     * Establece la configuración de Escrud actual.
     *
     * @var array
     */
    private static $_config = [];

    /**
     * Inicializa la configuración de Escrud.
     *
     * @param array       $configs        config
     * @param string|null $predeterminado predeterminado
     * 
     * @return void
     * 
     * @throws \Exception
     */
    public static function inicializar($configs, $predeterminado = null)
    {
        if (is_array($configs)) {
            if (self::_validarMatrizBidimencional($configs) 
                && array_key_exists($predeterminado, $configs)
            ) {
                self::$_configs = $configs;
                self::$_config = $configs[$predeterminado];
                self::_incluirArchivos();
                self::_inicializarPIPE();
            } elseif (!self::_validarMatrizBidimencional($configs)) {
                self::$_configs = $configs;
                self::$_config = $configs;
                self::_incluirArchivos();
                self::_inicializarPIPE();
            } else {
                throw new Exception('Inicialización de configuración incorrecta.');
            }
        } else {
            throw new Exception('Inicialización de configuración incorrecta.');
        }
    }

    /**
     * Obtiene una variable de la configuración de Escrud.
     *
     * @param string      $nombre         nombre
     * @param string|null $predeterminado predeterminado
     * 
     * @return string|null
     */
    public static function config($nombre, $predeterminado = null)
    {
        $valor = $predeterminado;

        if (array_key_exists($nombre, self::$_config)
            && !empty(self::$_config[$nombre])
        ) {
            $valor = self::$_config[$nombre];
        }

        return $valor;
    }

    /**
     * Inicializa la configuración de Escrud definiendo un nombre.
     *
     * @param string $nombre nombre
     * 
     * @return void
     */
    public static function inicializarConfig($nombre)
    {
        self::inicializar(self::$_configs, $nombre);
    }

    /**
     * Inicializa la configuración del ORM PIPE.
     *
     * @return void
     * 
     * @throws \Escrud\Clases\Excepciones\Escrud
     */
    private static function _inicializarPIPE()
    {
        try {
            PIPEConfig::inicializar(
                [
                    'BD_CONTROLADOR' => self::config('BD_CONTROLADOR'),
                    'BD_HOST' => self::config('BD_HOST'),
                    'BD_PUERTO' => self::config('BD_PUERTO'),
                    'BD_USUARIO' => self::config('BD_USUARIO'),
                    'BD_CONTRASENA' => self::config('BD_CONTRASENA'),
                    'BD_BASEDATOS' => self::config('BD_BASEDATOS'),
                    'BD_DATOS_DSN' => self::config('BD_DATOS_DSN'),
                    'IDIOMA' => self::config('IDIOMA'),
                    'RUTA_MODELOS' => __DIR__.'/Modelos',
                    'ZONA_HORARIA' => self::config('ZONA_HORARIA'),
                    'COMANDO_INICIAL' => self::config('COMANDO_INICIAL'),
                    'TIPO_RETORNO' => PIPEConfig::OBJETO,
                    'OPCIONES' => self::config('OPCIONES') ?? []
                ]
            );
        } catch (ORM $excepcion) {
            throw new Escrud($excepcion->getMessage());
        } catch (SQL $excepcion) {
            throw new Escrud($excepcion->getMessage());
        } catch (Exception $excepcion) {
            throw new Escrud($excepcion->getMessage());
        } catch (PDOException $excepcion) {
            throw new Escrud($excepcion->getMessage());
        }
    }

    /**
     * Incluye los archivos de la herramienta Escrud.
     *
     * @return void
     */
    private static function _incluirArchivos()
    {
        include_once __DIR__.'/../Funciones/util.php';

        $entorno = include obtenerEntorno();

        include_once $entorno['RUTA_VENDOR'];
        include_once __DIR__.'/../Funciones/tabla.php';
        include_once __DIR__.'/Excepciones/Escrud.php';
        include_once __DIR__.'/HTML.php';
        include_once __DIR__.'/Escrud.php';
        include_once __DIR__.'/Peticion.php';
        include_once __DIR__.'/Texto.php';

        self::_instanciarClases();
    }

    /**
     * Instancia las clases al inicio de la configuración.
     *
     * @return void
     */
    private static function _instanciarClases()
    {
        new Texto();
    }

    /**
     * Valida que un arreglo sea una matriz bidimencional.
     *
     * @param array $matriz matriz
     * 
     * @return boolean
     */
    private static function _validarMatrizBidimencional($matriz)
    {
        $esMatrizBidimencional = true;

        foreach ($matriz as $elemento) {
            if (!is_array($elemento)) {
                $esMatrizBidimencional = false;
            }
        }

        return $esMatrizBidimencional;
    }
}
