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

class Escrud
{  
    /**
     * Autor de la herramienta Escrud.
     *
     * @var string
     */
    const AUTOR = 'Juan Felipe Valencia Murillo';

    /**
     * Versión actual de la herramienta Escrud.
     *
     * @var string
     */
    const VERSION = '3.0.0';

    /**
     * Crea una instancia de la clase HTML con el nombre de la tabla.
     *
     * @param string $tabla tabla
     * 
     * @return \Escrud\Clases\HTML
     */
    public static function tabla($tabla)
    {
        return new HTML($tabla);
    }

    /**
     * Establece la conexión según el nombre definido.
     *
     * @param string $nombre nombre
     * 
     * @return self
     */
    public static function conexion($nombre)
    {
        Configuracion::inicializarConfig($nombre);

        return new self();
    }
}
