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

class HTML{
    
    /*
    * Indica el id del elemento HTML.
    * @tipo int
    */
    private $elementoId = 0;
    
    /*
    * Nombre de la tabla en la base de datos.
    * @tipo string
    */
    private $tabla = '';
    
    /*
    * Constructor de consultas del ORM PIPE.
    * @tipo \PIPE\Clases\ConstructorConsulta|null
    */
    private $constructor = null;
    
    /*
    * Llave primaria de la tabla.
    * @tipo string
    */
    private $llavePrimaria = 'id';
    
    /*
    * Indica los campos que se mostrarán en la renderización de la tabla.
    * @tipo array
    */
    private $visibles = [];
    
    /*
    * Indica los campos que no se mostrarán en la renderización de la tabla.
    * @tipo array
    */
    private $ocultos = [];
    
    /*
    * Indica los campos que pueden ser insertados.
    * @tipo array
    */
    private $insertables = [];
    
    /*
    * Indica los campos que pueden ser actualizados.
    * @tipo array
    */
    private $actualizables = [];
    
    /*
    * Indica los alias para cada campo que se mostrarán en la renderización de la tabla.
    * @tipo array
    */
    private $alias = [];
    
    /*
    * Nombre del campo donde se registra el tiempo de la creación del registro.
    * @tipo string
    */
    private $creadoEn = 'creado_en';
    
    /*
    * Nombre del campo donde se registra el tiempo de la actualización del registro.
    * @tipo string
    */
    private $actualizadoEn = 'actualizado_en';
    
    /*
    * Crea una nueva instancia de la clase HTML.
    *
    * @parametro string $tabla
    * @retorno void
    */
    public function __construct($tabla){
        if(!$this->verificarTablaExiste($tabla))
            exit(Texto::$textos['TABLA_NO_EXISTE'].' <b>'.$tabla.'</b>.');
        $this->tabla = $tabla;
        $this->asignarConstructor();
        $this->elementoId = Configuracion::$elementoId++;
    }
    
    /*
    * Establece la llave primaria referente a la tabla especificada.
    *
    * @parametro string $llavePrimaria
    * @retorno $this
    */
    public function llavePrimaria($llavePrimaria){
        $verificacion = $this->verificarCamposExisten([$llavePrimaria]);
        $metodo = $this->obtenerMetodoLlamado(debug_backtrace());
        if(!$verificacion['existen'])
            exit($metodo.' - '.Texto::$textos['CAMPO_NO_EXISTE'].' <b>'.$verificacion['campo'].'</b>.');
        $this->llavePrimaria = $llavePrimaria;
        return $this;
    }
    
    /*
    * Establece los campos que se mostrarán en la renderización de la tabla.
    *
    * @retorno $this
    */
    public function visibles(){
        $parametros = func_get_args();
        $verificacion = $this->verificarCamposExisten($parametros);
        $metodo = $this->obtenerMetodoLlamado(debug_backtrace());
        if(!$verificacion['existen'])
            exit($metodo.' - '.Texto::$textos['CAMPO_NO_EXISTE'].' <b>'.$verificacion['campo'].'</b>.');
        $this->visibles = $parametros;
        return $this;
    }
    
    /*
    * Establece los campos que no se mostrarán en la renderización de la tabla.
    *
    * @retorno $this
    */
    public function ocultos(){
        $parametros = func_get_args();
        $verificacion = $this->verificarCamposExisten($parametros);
        $metodo = $this->obtenerMetodoLlamado(debug_backtrace());
        if(!$verificacion['existen'])
            exit($metodo.' - '.Texto::$textos['CAMPO_NO_EXISTE'].' <b>'.$verificacion['campo'].'</b>.');
        $this->ocultos = $parametros;
        return $this;
    }
    
    /*
    * Establece los campos que podrán ser insertados.
    *
    * @retorno $this
    */
    public function insertables(){
        $parametros = func_get_args();
        $verificacion = $this->verificarCamposExisten($parametros);
        $metodo = $this->obtenerMetodoLlamado(debug_backtrace());
        if(!$verificacion['existen'])
            exit($metodo.' - '.Texto::$textos['CAMPO_NO_EXISTE'].' <b>'.$verificacion['campo'].'</b>.');
        $this->insertables = $parametros;
        return $this;
    }
    
    /*
    * Establece los campos que podrán ser actualizados.
    *
    * @retorno $this
    */
    public function actualizables(){
        $parametros = func_get_args();
        $verificacion = $this->verificarCamposExisten($parametros);
        $metodo = $this->obtenerMetodoLlamado(debug_backtrace());
        if(!$verificacion['existen'])
            exit($metodo.' - '.Texto::$textos['CAMPO_NO_EXISTE'].' <b>'.$verificacion['campo'].'</b>.');
        $this->actualizables = $parametros;
        return $this;
    }
    
    /*
    * Establece los alias para cada campo que se mostrarán en la renderización de la tabla.
    *
    * @retorno $this
    */
    public function alias($alias){
        $verificacion = $this->verificarCamposExisten($alias,true);
        $metodo = $this->obtenerMetodoLlamado(debug_backtrace());
        if(!$verificacion['existen'])
            exit($metodo.' - '.Texto::$textos['CAMPO_NO_EXISTE'].' <b>'.$verificacion['campo'].'</b>.');
        $this->alias = $alias;
        return $this;
    }
    
    /*
    * Establece el nombre del campo donde se registra el tiempo de la creación del registro.
    *
    * @retorno $this
    */
    public function creadoEn($creadoEn){
        $verificacion = $this->verificarCamposExisten([$creadoEn]);
        $metodo = $this->obtenerMetodoLlamado(debug_backtrace());
        if(!$verificacion['existen'])
            exit($metodo.' - '.Texto::$textos['CAMPO_NO_EXISTE'].' <b>'.$verificacion['campo'].'</b>.');
        $this->creadoEn = $creadoEn;
        return $this;
    }
    
    /*
    * Establece el nombre del campo donde se registra el tiempo de la actualización del registro.
    *
    * @retorno $this
    */
    public function actualizadoEn($actualizadoEn){
        $verificacion = $this->verificarCamposExisten([$actualizadoEn]);
        $metodo = $this->obtenerMetodoLlamado(debug_backtrace());
        if(!$verificacion['existen'])
            exit($metodo.' - '.Texto::$textos['CAMPO_NO_EXISTE'].' <b>'.$verificacion['campo'].'</b>.');
        $this->actualizadoEn = $actualizadoEn;
        return $this;
    }
    
    /*
    * Renderiza la tabla especificada con su respectiva configuración.
    *
    * @retorno void
    */
    public function renderizar(){
        $html = $this;
        require __DIR__.'/../Vistas/tabla.php';
    }
    
    //Inicio métodos privados.
    /*
    * Verifica que la tabla especificada exista en la base de datos.
    *
    * @parametro string $tabla
    * @retorno boolean
    */
    private function verificarTablaExiste($tabla){
        $pdo = PIPE::obtenerPDO();
        $consulta = $pdo->query('select * from '.$tabla);
        $existe = $consulta ? true : false;
        return $existe;
    }
    
    /*
    * Verifica que los campos existan en la tabla especificada.
    *
    * @parametro array $campos
    * @parametro boolean $asociativo
    * @retorno array
    */
    private function verificarCamposExisten($campos, $asociativo = false){
        $camposTabla = $this->obtenerCamposTabla();
        foreach($campos as $clave => $valor){
            $campo = $asociativo ? $clave : $valor;
            if(!in_array($campo, $camposTabla)) return ['existen' => false, 'campo' => $campo];
        }
        return ['existen' => true];
    }
    
    /*
    * Asigna el constructor de consultas del ORM PIPE.
    *
    * @retorno void
    */
    private function asignarConstructor(){
        $constructor = PIPE::tabla($this->tabla);
        $this->constructor = $constructor;
    }
    
    /*
    * Obtiene el encabezado de la tabla según los campos.
    *
    * @retorno json
    */
    private function obtenerEncabezado(){
        $encabezado = $this->obtenerCamposTabla();
        return json_encode($encabezado);	
    }
    
    /*
    * Obtiene los registros de la tabla especificada.
    *
    * @retorno json
    */
    private function obtenerRegistros(){
        $registros = $this->constructor->todo(PIPE::JSON);
        return $registros;
    }
    
    /*
    * Obtiene el paginado automático según los registros de la tabla.
    *
    * @retorno json
    */
    private function obtenerPaginado(){
        $cantRegistros = count($this->constructor->todo());
        $registrosPorPagina = ['total' => $cantRegistros];
        if($cantRegistros >= 100)
            $registrosPorPagina['paginado'] = [5, 10, 25, 50, 100];
        else if($cantRegistros >= 50 && $cantRegistros < 100)
            $registrosPorPagina['paginado'] = [5, 10, 25, 50];
        else if($cantRegistros >= 25 && $cantRegistros < 50)
            $registrosPorPagina['paginado'] = [5, 10, 25];
        else if($cantRegistros >= 10 && $cantRegistros < 25)
            $registrosPorPagina['paginado'] = [5, 10];
        else
            $registrosPorPagina['paginado'] = null;
        return json_encode($registrosPorPagina);
    }
    
    /*
    * Obtiene todos los campos de la tabla en la base de datos.
    *
    * @retorno array
    */
    private function obtenerCamposTabla(){
        $pdo = PIPE::obtenerPDO();
        switch(Configuracion::obtenerVariable('BD_CONTROLADOR')){
            case 'mysql':
                $consulta = $pdo->query('describe '.$this->tabla);
                $atributo = 'Field';
            break;
            case 'pgsql':
                $consulta = $pdo->query(
                    'select 
                        column_name
                    from
                        information_schema.columns
                    where
                        table_name='."'".$this->tabla."'"
                );
                $atributo = 'column_name';
            break;
            case 'sqlite':
                $consulta = $pdo->query('pragma table_info('.$this->tabla.')');
                $atributo = 'name';
            break;
            case 'sqlsrv':
                $consulta = $pdo->query(
                    'select
                        column_name
                    from
                        information_schema.columns
                    where
                        table_name='."'".$this->tabla."'"
                );
                $atributo = 'column_name';
            break;
        }
        $campos = [];
        foreach($consulta->fetchAll() as $datos){
            $campos[] = $datos[$atributo];
        }
        return $campos;
    }
    
    /*
    * Obtiene los atributos de la clase HTML.
    *
    * @retorno json
    */
    private function obtenerAtributos(){
        $atributos = [
            'elementoId' => $this->elementoId,
            'tabla' => $this->tabla,
            'llavePrimaria' => $this->llavePrimaria,
            'visibles' => $this->visibles,
            'ocultos' => $this->ocultos,
            'insertables' => $this->insertables,
            'actualizables' => $this->actualizables,
            'actualizables' => $this->actualizables,
            'alias' => $this->alias,
            'creadoEn' => $this->creadoEn,
            'actualizadoEn' => $this->actualizadoEn
        ];
        return json_encode($atributos);
    }
    
    /*
    * Obtiene las variables de configuración.
    *
    * @retorno json
    */
    private function obtenerConfiguracion(){
        $entorno = require __DIR__.'/../Entorno/entorno.php';
        $config = [
            'BD_TABLA' => $this->tabla,
            'BD_CONTROLADOR' => Configuracion::obtenerVariable('BD_CONTROLADOR'),
            'BD_HOST' => Configuracion::obtenerVariable('BD_HOST'),
            'BD_PUERTO' => Configuracion::obtenerVariable('BD_PUERTO'),
            'BD_USUARIO' => Configuracion::obtenerVariable('BD_USUARIO'),
            'BD_CONTRASENA' => Configuracion::obtenerVariable('BD_CONTRASENA'),
            'BD_BASEDATOS' => Configuracion::obtenerVariable('BD_BASEDATOS'),
            'BD_CODIFICACION' => Configuracion::obtenerVariable('BD_CODIFICACION'),
            'IDIOMA' => Configuracion::obtenerVariable('IDIOMA'),
            'ZONA_HORARIA' => Configuracion::obtenerVariable('ZONA_HORARIA'),
            'ENTORNO' => $entorno
        ];
        return json_encode($config);
    }
    
    /*
    * Obtiene el nombre del método invocado.
    *
    * @retorno string
    */
    private function obtenerMetodoLlamado($depuracion){
        $metodo = $depuracion[0]['function'];
        return $metodo;
    }
    //Fin métodos privados.
}