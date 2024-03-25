<?php

/**
 * Este archivo es parte del proyecto Escrud.
 * 
 * PHP versions 7 and 8 
 * 
 * @author    Juan Felipe Valencia Murillo  <juanfe0245@gmail.com>
 * @copyright 2020 - presente  Juan Felipe Valencia Murillo
 * @license   https://opensource.org/licenses/MIT  MIT License
 * @version   GIT:  2.6.7
 * @link      https://escrud.proes.io
 * @since     Fecha inicio de creación del proyecto  2020-05-31
 */

namespace Escrud\Clases\Modelos;

use PIPE\Clases\Modelo;

class Tabla extends Modelo
{
    /**
     * Establece el nombre de la tabla en la base de datos.
     *
     * @var string
     */
    public static $tabla = '';

    /**
     * Establece el nombre de la llave primaria de la tabla.
     *
     * @var string
     */
    public static $llavePrimaria = 'id';

    /**
     * Establece el nombre del campo donde se 
     * registra el tiempo de la creación del registro.
     *
     * @var string
     */
    public static $creadoEn = 'creado_en';

    /**
     * Establece el nombre del campo donde se 
     * registra el tiempo de la actualización del registro.
     *
     * @var string
     */
    public static $actualizadoEn = 'actualizado_en';
}
