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

namespace Escrud\Funciones;

/**
 * Obtiene el paginado automático según los registros de la tabla.
 *
 * @param int $cantidadRegistros cantidadRegistros
 * 
 * @return array
 */
function obtenerPaginado($cantidadRegistros)
{
    $paginado = ['total' => $cantidadRegistros];

    if ($cantidadRegistros >= 100) {
        $paginado['paginado'] = [5, 10, 25, 50, 100];
    } elseif ($cantidadRegistros >= 50 && $cantidadRegistros < 100) {
        $paginado['paginado'] = [5, 10, 25, 50];
    } elseif ($cantidadRegistros >= 25 && $cantidadRegistros < 50) {
        $paginado['paginado'] = [5, 10, 25];
    } elseif ($cantidadRegistros >= 10 && $cantidadRegistros < 25) {
        $paginado['paginado'] = [5, 10];
    } else {
        $paginado['paginado'] = null;
    }

    return $paginado;
}

/**
 * Verifica y obtiene la casilla del encabezado 
 * según los atributos visibles y ocultos.
 *
 * @param string $columna   columna
 * @param object $atributos atributos
 * 
 * @return string|null
 */
function obtenerCasillaEncabezado($columna, $atributos)
{
    $condicion = !empty($atributos->visibles)
        ? in_array($columna, $atributos->visibles)
        : !in_array($columna, $atributos->ocultos);

    if ($condicion) {
        foreach ($atributos->alias as $clave => $valor) {
            if ($columna == $clave) {
                $columna = $valor;
                break;
            }
        }

        return $columna;
    }

    return null;
}

/**
 * Verifica las columnas que pueden ser buscadas.
 *
 * @param string $columna   columna
 * @param object $atributos atributos
 * 
 * @return boolean
 */
function validarCampoBuscable($columna, $atributos)
{
    return !empty($atributos->buscables)
        ? in_array($columna, $atributos->buscables)
        : !in_array($columna, $atributos->noBuscables);
}

/**
 * Valida la casilla del registro según los atributos visibles y ocultos.
 *
 * @param string $columna   columna
 * @param object $atributos atributos
 * 
 * @return boolean
 */
function validarCasillaRegistro($columna, $atributos)
{
    $condicion = !empty($atributos->visibles)
        ? in_array($columna, $atributos->visibles)
        : !in_array($columna, $atributos->ocultos);

    if ($condicion && $columna != '__ID__') {
        return true;
    }

    return false;
}

/**
 * Resalta el criterio de búsqueda en los registros de la tabla renderizada.
 *
 * @param string $dato     dato
 * @param string $busqueda busqueda
 * 
 * @return string
 */
function resaltarBusqueda($dato, $busqueda)
{
    if (stripos($dato, $busqueda) > -1) {
        $inicio = stripos($dato, $busqueda);
        $longitud = strlen($busqueda);
        $caracter = substr($dato, $inicio, $longitud);
        $dato = str_ireplace($busqueda, '<b>'.$caracter.'</b>', $dato);
    }

    return $dato;
}