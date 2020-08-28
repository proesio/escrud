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

namespace Escrud\Clases;

use PIPE\Clases\PIPE;
use PIPE\Clases\Configuracion;
use function Escrud\Funciones\obtenerPaginado;

class CRUD{
    
    /*
    * Datos de la petición realizada.
    * @tipo object|null
    */
    private $peticion = null;
    
    /*
    * Crea una nueva instancia de la clase CRUD.
    *
    * @parametro object $peticion
    * @retorno void
    */
    public function __construct($peticion){
        $peticion->config = json_decode($peticion->config, true);
        $this->peticion = $peticion;
        $this->inicializarPIPE($peticion->config);
    }
    
    /*
    * Obtiene los registros de la tabla especificada.
    *
    * @retorno json
    */
    public function obtenerRegistros(){
        $registros = PIPE::tabla($this->peticion->config['BD_TABLA'])->todo();
        $respuesta['estado'] = 'exito';
        $respuesta['datos'] = $registros;
        return json_encode($respuesta);
    }
    
    /*
    * Obtiene un registro de la tabla especificada.
    *
    * @retorno json
    */
    public function obtenerRegistro(){
        $registros = PIPE::tabla($this->peticion->config['BD_TABLA'])->todo();
        $registro = null;
        foreach($registros as $clave => $registroPivote){
            if($this->peticion->registroId == $clave){
                $registro = $registroPivote;
                break;
            }
        }
        $respuesta['estado'] = 'exito';
        $respuesta['datos'] = $registro;
        return json_encode($respuesta);
    }
    
    /*
    * Crea un nuevo registro en la tabla especificada.
    *
    * @retorno json
    */
    public function crear(){
        $registro = json_decode($this->peticion->registro, true);
        $insercion = PIPE::tabla($this->peticion->config['BD_TABLA'])->insertar($registro);
        $respuesta['estado'] = $insercion ? 'exito' : 'error';
        return json_encode($respuesta);
    }
    
    /*
    * Edita un registro en la tabla especificada.
    *
    * @retorno json
    */
    public function editar(){
        $registro = PIPE::tabla($this->peticion->config['BD_TABLA'])
            ->encontrar($this->peticion->valorLlavePrimaria, $this->peticion->llavePrimaria);
        if($registro) $registro->actualizar((array) $this->peticion->registro);
        $respuesta['estado'] = 'exito';
        return json_encode($respuesta);
    }
    
    /*
    * Elimina un registro en la tabla especificada.
    *
    * @retorno json
    */
    public function eliminar(){
        $registro = PIPE::tabla($this->peticion->config['BD_TABLA'])
            ->encontrar($this->peticion->valorLlavePrimaria, $this->peticion->llavePrimaria);
        if($registro) $registro->eliminar();
        $respuesta['estado'] = 'exito';
        return json_encode($respuesta);
    }
    
    /*
    * Obtiene el paginado automático según los registros de la tabla.
    *
    * @retorno json
    */
    public function obtenerPaginado(){
        $registros = PIPE::tabla($this->peticion->config['BD_TABLA'])->todo();
        $paginado = obtenerPaginado($registros);
        $respuesta['estado'] = 'exito';
        $respuesta['datos'] = $paginado;
        return json_encode($respuesta);
    }
    
    //Inicio métodos privados.
    /*
    * Inicializa la configuración del ORM PIPE.
    *
    * @parametro array $config
    * @retorno void
    */
    private function inicializarPIPE($config){
        Configuracion::inicializar([
            'BD_CONTROLADOR' => $config['BD_CONTROLADOR'] ?? null,
            'BD_HOST' => $config['BD_HOST'] ?? null,
            'BD_PUERTO' => $config['BD_PUERTO'] ?? null,
            'BD_USUARIO' => $config['BD_USUARIO'] ?? null,
            'BD_CONTRASENA' => $config['BD_CONTRASENA'] ?? null,
            'BD_BASEDATOS' => $config['BD_BASEDATOS'] ?? null,
            'BD_CODIFICACION' => $config['BD_CODIFICACION'] ?? null,
            'IDIOMA' => $config['IDIOMA'] ?? null,
            'ZONA_HORARIA' => $config['ZONA_HORARIA'] ?? null
        ]);
    }
    //Fin métodos privados.
}