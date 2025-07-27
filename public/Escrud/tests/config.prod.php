<?php

/**
 * Este archivo es parte del proyecto Escrud.
 * 
 * Cree una copia de este archivo con el nombre config.php 
 * para sobrescribir la configuración en modo desarrollo.
 * En el directorio ./SQL encontrará las sentencias SQL para
 * crear las tablas por cada controlador.
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

require __DIR__.'/../src/inicializador.php';
require __DIR__.'/funciones.php';

use Escrud\Clases\Configuracion;
use Escrud\Clases\Excepciones\Escrud;

$conexiones = [
    'mysql' => [
        'BD_CONTROLADOR' => 'mysql',
        'BD_HOST' => 'mysql',
        'BD_PUERTO' => 3306,
        'BD_USUARIO' => 'root',
        'BD_CONTRASENA' => '',
        'BD_BASEDATOS' => 'escrud',
        'BD_DATOS_DSN' => '',
        'IDIOMA' => 'es',
        'ZONA_HORARIA' => 'America/Bogota',
        'COMANDO_INICIAL' => 'set names utf8mb4 collate utf8mb4_unicode_ci',
        'OPCIONES' => [
            PDO::MYSQL_ATTR_LOCAL_INFILE => 1
        ]
    ],
    'pgsql' => [
        'BD_CONTROLADOR' => 'pgsql',
        'BD_HOST' => 'postgresql',
        'BD_PUERTO' => 5432,
        'BD_USUARIO' => 'root',
        'BD_CONTRASENA' => '',
        'BD_BASEDATOS' => 'escrud',
        'BD_DATOS_DSN' => '',
        'IDIOMA' => 'es',
        'ZONA_HORARIA' => 'America/Bogota'
    ],
    'sqlite' => [
        'BD_CONTROLADOR' => 'sqlite',
        'BD_BASEDATOS' => __DIR__.'/ruta/a/mi/basedatos.sqlite',
        'IDIOMA' => 'es',
        'ZONA_HORARIA' => 'America/Bogota'
    ],
    'sqlsrv' => [
        'BD_CONTROLADOR' => 'sqlsrv',
        'BD_HOST' => 'sqlserver',
        'BD_PUERTO' => 1433,
        'BD_USUARIO' => 'sa',
        'BD_CONTRASENA' => '',
        'BD_BASEDATOS' => 'escrud',
        'BD_DATOS_DSN' => '',
        'IDIOMA' => 'es',
        'ZONA_HORARIA' => 'America/Bogota'
    ]
];

try {
    Configuracion::inicializar($conexiones, 'mysql');
} catch (Escrud $e) {
    d($e->getMessage());
} catch (Exception $e) {
    d($e->getMessage());
}
