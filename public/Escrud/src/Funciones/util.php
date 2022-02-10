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

namespace Escrud\Funciones;

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
