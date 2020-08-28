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

namespace Escrud\Funciones;

/*
 * Pagina los registros basado en un índice de inicio y una cantidad de registros a paginar.
 *
 * @parametro array $registros
 * @parametro int $inicio
 * @parametro int|string $cantidad
 * @retorno array
 */
function paginar($registros, $inicio, $cantidad = ''){
    if($cantidad === ''){
        $cantidad = $inicio;
        $inicio = 0;
    }	
    $contador = 0;
    $datos = [];
    foreach($registros as $clave => $valor){
        if($clave >= $inicio && $contador < $cantidad){
            $datos[] = $valor;
            $contador++;
        }
    }
    return $datos;
}

/*
 * Filtra y obtiene los registros que coincidan con un criterio de búsqueda.
 *
 * @parametro object $peticion
 * @retorno array
 */
function obtenerFiltroBuscador($peticion){
	foreach($peticion->registros as $clave => $valor){
		$registro = (array) $valor;
		$registro = array_values($registro);
		$registro = json_encode($registro);
		if(!(stripos($registro, $peticion->busqueda) > -1)) unset($peticion->registros[$clave]);
	}
	return array_values($peticion->registros);
}

/*
 * Obtiene el paginado automático según los registros de la tabla.
 *
 * @parametro array $registros
 * @retorno array
 */
function obtenerPaginado($registros){
    $cantRegistros = count($registros);
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
    return $registrosPorPagina;
}

/*
 * Verifica y obtiene la casilla del encabezado según los atributos $visibles y $ocultos.
 *
 * @parametro string $columna
 * @parametro object $atributos
 * @retorno string|null
 */
function obtenerCasillaEncabezado($columna, $atributos){
    $condicion = !empty($atributos->visibles)
        ? in_array($columna, $atributos->visibles)
        : !in_array($columna, $atributos->ocultos);
    if($condicion){
        foreach($atributos->alias as $clave => $valor){
            if($columna == $clave){
                $columna = $valor;
                break;
            }
        }
        return $columna;
    }
    return null;
}

/*
 * Valida la casilla del registro según los atributos $visibles y $ocultos.
 *
 * @parametro string $columna
 * @parametro object $atributos
 * @retorno boolean
 */
function validarCasillaRegistro($columna, $atributos){
    $condicion = !empty($atributos->visibles)
        ? in_array($columna, $atributos->visibles)
        : !in_array($columna, $atributos->ocultos);
    if($condicion && $columna != '__ID__') return true;
    return false;
}

/*
 * Resalta el criterio de búsqueda en los registros de la tabla renderizada.
 *
 * @parametro string $dato
 * @parametro string $busqueda
 * @retorno string
 */
function resaltarBusqueda($dato, $busqueda){
    if(stripos($dato, $busqueda) > -1){
        $inicio = stripos($dato, $busqueda);
        $longitud = strlen($busqueda);
        $caracter = substr($dato, $inicio, $longitud);
        $dato = str_ireplace($busqueda, '<b>'.$caracter.'</b>', $dato);
    }
    return $dato;
}

/*
 * Asigna un id a cada registro según la clave correspondiente en el arreglo.
 *
 * @parametro array $registros
 * @retorno array
 */
function asignarIdRegistros($registros){
    foreach($registros as $clave => $registro){
        $registro->__ID__ = $clave;
    }
    return $registros;
}