<?php

/**
 * Este archivo es parte del proyecto Escrud.
 * 
 * Cree una copia de este archivo con el nombre entorno.php 
 * para sobrescribir la configuración en modo desarrollo.
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

use function Escrud\Funciones\urlBase;

return [
    'URL_BASE' => urlBase(),
    'RUTA_PETICIONES' => urlBase('Peticiones/peticion.php'),
    'RUTA_VENDOR' => __DIR__.'/../../../../vendor/autoload.php',
    'CIFRADO_METODO' => 'AES-128-CBC',
    'CIFRADO_CLAVE' => base64_encode(json_encode($_SERVER))
];
