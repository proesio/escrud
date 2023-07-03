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

namespace Escrud\Clases;

use Escrud\Clases\Excepciones\Escrud;

class Texto
{
    /**
     * Textos según el idioma establecido.
     *
     * @var array
     */
    public static $textos = [];

    /**
     * Crea una nueva instancia de la clase Texto.
     *
     * @return void
     */
    public function __construct()
    {
        $this->asignarTextos();
    }

    /**
     * Asigna los textos según el idioma establecido.
     *
     * @return void
     * 
     * @throws \Escrud\Clases\Excepciones\Escrud
     */
    public function asignarTextos()
    {
        $idioma = Configuracion::config('IDIOMA');

        if ($idioma) {
            switch ($idioma) {
            case 'es':
                self::$textos = include __DIR__.'/../Idiomas/es.php';
                break;
            case 'en':
                self::$textos = include __DIR__.'/../Idiomas/en.php';
                break;
            default:
                throw new Escrud(
                    'IDIOMA '.$idioma.' desconocido. Idiomas admitidos: es, en.'
                );
                break;
            }
        } else {
            throw new Escrud(
                'La constante IDIOMA debe ser inicializada en el método Configuracion::inicializar().'
            );
        }
    }

    /**
     * Obtiene los textos según el idioma establecido.
     *
     * @return string
     */
    public static function obtenerTextos()
    {
        return json_encode(self::$textos);
    }
}
