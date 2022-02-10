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

require_once __DIR__.'/../inicializador.php';
require_once __DIR__.'/../Funciones/util.php';

use Escrud\Clases\Peticion;
use Escrud\Clases\Configuracion;
use function Escrud\Funciones\obtenerPeticion;

if (isset($_GET['api'])) {
    $peticion = obtenerPeticion();

    Configuracion::inicializar($peticion->config);

    switch ($_GET['api']) {
    case 'registros-obtener':
        $crud = new Peticion($peticion);
        echo $crud->obtenerRegistros();
        break;
    case 'registro-obtener':
        $crud = new Peticion($peticion);
        echo $crud->obtenerRegistro();
        break;
    case 'paginado-obtener':
        $crud = new Peticion($peticion);
        echo $crud->obtenerPaginado();
        break;
    }
}

if (isset($_POST['api'])) {
    $peticion = obtenerPeticion();

    Configuracion::inicializar($peticion->config);

    switch ($_POST['api']) {
    case 'crear':
        $crud = new Peticion($peticion);
        echo $crud->crear();
        break;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    $peticion = obtenerPeticion();

    Configuracion::inicializar($peticion->config);

    switch ($peticion->api) {
    case 'editar':
        $crud = new Peticion($peticion);
        echo $crud->editar();
        break;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    $peticion = obtenerPeticion();

    Configuracion::inicializar($peticion->config);

    switch ($peticion->api) {
    case 'eliminar':
        $crud = new Peticion($peticion);
        echo $crud->eliminar();
        break;
    }
}
