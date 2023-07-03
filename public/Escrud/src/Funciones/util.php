<?php

/**
 * Este archivo es parte del proyecto Escrud.
 * 
 * PHP versions 7 and 8 
 * 
 * @author    Juan Felipe Valencia Murillo  <juanfe0245@gmail.com>
 * @copyright 2020 - presente  Juan Felipe Valencia Murillo
 * @license   https://opensource.org/licenses/MIT  MIT License
 * @version   GIT:  2.6.0
 * @link      https://escrud.proes.io
 * @since     Fecha inicio de creación del proyecto  2020-05-31
 */

namespace Escrud\Funciones;

use ReflectionFunction;

/**
 * Obtiene la url base con la ruta especificada.
 *
 * @param string $ruta ruta
 * 
 * @return string
 */
function urlBase($ruta = '')
{
    $protocolo = 'http';

    if ((isset($_SERVER['HTTP_X_FORWARDED_PROTO'])
        && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')
        || isset($_SERVER['HTTPS'])
    ) {
        $protocolo = 'https';
    }

    $httpHost = $_SERVER['HTTP_HOST'];
    $rutaBase = dirname(dirname(__FILE__));
    $rutaBase = str_replace('\\', '/', $rutaBase);
    $rutaBase = str_replace($_SERVER['DOCUMENT_ROOT'], '', $rutaBase);
    $urlBase = $protocolo.'://'.$httpHost.$rutaBase.'/'.$ruta;

    return $urlBase;
}

/**
 * Obtiene el archivo de configuración dependiendo el entorno configurado.
 * 
 * @return string
 */
function obtenerEntorno()
{
    $archivoPredeterminado = __DIR__.'/../Entorno/entorno.prod.php';

    if ($carpeta = opendir(__DIR__.'/../Entorno')) {
        while (($archivo = readdir($carpeta)) !== false) {
            if ($archivo == 'entorno.php') {
                return __DIR__.'/../Entorno/'.$archivo;
            }
        }

        closedir($carpeta);
    }

    return $archivoPredeterminado;
}

/**
 * Obtiene los datos de la petición.
 * 
 * @return object
 */
function obtenerPeticion()
{
    if ($_GET) {
        return decodificarPeticion((object) $_GET);
    }

    if ($_POST) {
        return decodificarPeticion((object) $_POST);
    }

    if ($_SERVER['REQUEST_METHOD'] == 'PUT'
        || $_SERVER['REQUEST_METHOD'] == 'DELETE'
    ) {
        return decodificarPeticion(
            json_decode(file_get_contents('php://input'))
        );
    }
}

/**
 * Decodifica la petición.
 *
 * @param string $peticion peticion
 * 
 * @return object
 */
function decodificarPeticion($peticion)
{
    $peticion->config = json_decode($peticion->config, true);
    $peticion->atributos = json_decode($peticion->atributos, true);

    if (isset($peticion->busqueda)) {
        $peticion->busqueda = json_decode($peticion->busqueda, true);
    }

    return $peticion;
}

/**
 * Convierte una función anónima (Closure) en una cadena de texto.
 *
 * @param Closure $closure closure
 * 
 * @return string
 */
function encadenarClosure($closure)
{
    $reflectionFunction = new ReflectionFunction($closure);
    $contenidoArchivo = file_get_contents($reflectionFunction->getFileName());
    $contenidoPartes = explode(PHP_EOL, $contenidoArchivo);

    $contenidoClosurePartes = array_slice(
        $contenidoPartes, 
        ($reflectionFunction->getStartLine() - 1), 
        ($reflectionFunction->getEndLine() 
        - ($reflectionFunction->getStartLine() - 1))
    );

    $contenidoClosurePartes[0] = (
        'function'.explode('function', $contenidoClosurePartes[0])[1]
    );

    $contenidoClosurePartes[count($contenidoClosurePartes) - 1] = (
        explode(
            '}', $contenidoClosurePartes[count($contenidoClosurePartes) - 1]
        )[0].'}'
    );

    return implode(PHP_EOL, $contenidoClosurePartes);
}

/**
 * Serializa una función anónima (Closure).
 *
 * @param Closure $closure closure
 * 
 * @return string
 */
function serializarClosure($closure)
{
    $closureCadena = encadenarClosure($closure);

    $closureCadena = str_replace(
        ['<', '>'], ['__MENOR_QUE__', '__MAYOR_QUE__'], $closureCadena
    );

    return base64_encode($closureCadena);
}

/**
 * Deserializa una función anónima (Closure).
 *
 * @param string $closureSerial closureSerial
 * 
 * @return Closure
 */
function deserializarClosure($closureSerial)
{
    $closureCadena = base64_decode($closureSerial);

    $closureCadena = str_replace(
        ['__MENOR_QUE__', '__MAYOR_QUE__'], ['<', '>'], $closureCadena
    );

    eval('$closure = '.$closureCadena.';');

    return $closure;
}
