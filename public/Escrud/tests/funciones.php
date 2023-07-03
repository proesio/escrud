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

/**
 * Debuguea un elemento sin detener la ejecución.
 * 
 * @return void
 */
function d()
{
    debuguear(...func_get_args());
}

/**
 * Debuguea un elemento deteniendo la ejecución.
 * 
 * @return void
 */
function dd()
{
    debuguear(...func_get_args());
    exit();
}

/**
 * Debuguea un elemento.
 * 
 * @return void
 */
function debuguear()
{
    $argumentos = func_get_args();

    foreach ($argumentos as $argumento) {
        echo "\n";
        var_dump($argumento);
        echo "\n";
    }
}
