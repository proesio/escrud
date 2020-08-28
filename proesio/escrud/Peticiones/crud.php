<?php
/*
 * Autor: Juan Felipe Valencia Murillo
 * Fecha inicio de creación: 31-05-2020
 * Fecha última modificación: 27-08-2020
 * Versión: 1.1.0
 * Sitio web: https://escrud.proes.tk
 *
 * Copyright (C) 2020 Juan Felipe Valencia Murillo <juanfe0245@gmail.com>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to
 * deal in the Software without restriction, including without limitation the
 * rights to use, copy, modify, merge, publish, distribute, sublicense, and/or
 * sell copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS
 * IN THE SOFTWARE.
   
 * Traducción al español de la licencia MIT
   
 * Copyright (C) 2020 Juan Felipe Valencia Murillo <juanfe0245@gmail.com>

 * Se concede permiso por la presente, libre de cargos, a cualquier persona
 * que obtenga una copia de este software y de los archivos de documentación asociados 
 * (el "Software"), a utilizar el Software sin restricción, incluyendo sin limitación 
 * los derechos a usar, copiar, modificar, fusionar, publicar, distribuir, sublicenciar, 
 * y/o vender copias del Software, y a permitir a las personas a las que se les proporcione 
 * el Software a hacer lo mismo, sujeto a las siguientes condiciones:

 * El aviso de copyright anterior y este aviso de permiso se incluirán 
 * en todas las copias o partes sustanciales del Software.

 * EL SOFTWARE SE PROPORCIONA "COMO ESTÁ", SIN GARANTÍA DE NINGÚN TIPO, EXPRESA O IMPLÍCITA,
 * INCLUYENDO PERO NO LIMITADO A GARANTÍAS DE COMERCIALIZACIÓN, IDONEIDAD PARA UN PROPÓSITO
 * PARTICULAR E INCUMPLIMIENTO. EN NINGÚN CASO LOS AUTORES O PROPIETARIOS DE LOS DERECHOS DE AUTOR
 * SERÁN RESPONSABLES DE NINGUNA RECLAMACIÓN, DAÑOS U OTRAS RESPONSABILIDADES, YA SEA EN UNA ACCIÓN
 * DE CONTRATO, AGRAVIO O CUALQUIER OTRO MOTIVO, DERIVADAS DE, FUERA DE O EN CONEXIÓN
 * CON EL SOFTWARE O SU USO U OTRO TIPO DE ACCIONES EN EL SOFTWARE.
 */

$entorno = require __DIR__.'/../Entorno/entorno.php';
require $entorno['RUTA_VENDOR'];
require __DIR__.'/../Funciones/tabla.php';
require __DIR__.'/../Clases/CRUD.php';

use Escrud\Clases\CRUD;

if(isset($_GET['api'])){
    $peticion = json_decode(json_encode($_GET));
    switch($_GET['api']){
        case 'registros-obtener':
            $crud = new CRUD($peticion);
            echo $crud->obtenerRegistros();
        break;
        case 'registro-obtener':
            $crud = new CRUD($peticion);
            echo $crud->obtenerRegistro();
        break;
        case 'paginado-obtener':
            $crud = new CRUD($peticion);
            echo $crud->obtenerPaginado();
        break;
    }
}

if(isset($_POST['api'])){
    $peticion = json_decode(json_encode($_POST));
    switch($_POST['api']){
        case 'crear':
            $crud = new CRUD($peticion);
            echo $crud->crear();
        break;
    }
}

if($_SERVER['REQUEST_METHOD'] == 'PUT'){
    $peticion = file_get_contents('php://input');
    $peticion = json_decode($peticion);
    switch($peticion->api){
        case 'editar':
            $crud = new CRUD($peticion);
            echo $crud->editar();
        break;
    }
}

if($_SERVER['REQUEST_METHOD'] == 'DELETE'){
    $peticion = file_get_contents('php://input');
    $peticion = json_decode($peticion);
    switch($peticion->api){
        case 'eliminar':
            $crud = new CRUD($peticion);
            echo $crud->eliminar();
        break;
    }
}