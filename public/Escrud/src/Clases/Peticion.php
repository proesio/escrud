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

use Exception;
use PDOException;
use PIPE\Clases\PIPE;
use Escrud\Clases\Modelos\Tabla;
use PIPE\Clases\Excepciones\ORM;
use PIPE\Clases\Excepciones\SQL;
use function Escrud\Funciones\obtenerPaginado;
use function Escrud\Funciones\deserializarClosure;

class Peticion
{
    /**
     * Datos de la petición realizada.
     *
     * @var object|null
     */
    private $_peticion = null;

    /**
     * Crea una nueva instancia de la clase Peticion.
     *
     * @param object $peticion peticion
     * 
     * @return void
     */
    public function __construct($peticion)
    {
        $this->_peticion = $peticion;

        Tabla::$tabla = $peticion->config['BD_TABLA'];
        Tabla::$llavePrimaria = $peticion->atributos['llavePrimaria'];
        Tabla::$creadoEn = $peticion->atributos['creadoEn'];
        Tabla::$actualizadoEn = $peticion->atributos['actualizadoEn'];
    }

    /**
     * Obtiene los registros de la tabla especificada.
     *
     * @return string
     */
    public function obtenerRegistros()
    {
        $tabla = Tabla::seleccionar('*');

        $ordenes = $this->_peticion->atributos['ordenarPor'];

        if (is_array($ordenes) && !empty($ordenes)) {
            $tabla->ordenarPor($ordenes['ordenes'], $ordenes['tipo']);
        }

        if ($busqueda = $this->_peticion->busqueda) {
            $tabla->donde($busqueda['campo']." like '%".$busqueda['valor']."%'");
        }

        $tabla->limite(
            $this->_peticion->cantidad, $this->_peticion->inicio
        );

        $registros = $tabla->obtener();
        $accesores = $this->_peticion->atributos['accesores'];

        if ($accesores) {
            foreach ($registros as $claveRegistro => $valorRegistro) {
                foreach ($accesores as $claveAccesor => $valorAccesor) {
                    $closure = deserializarClosure($valorAccesor);

                    $registros[$claveRegistro]->{$claveAccesor} = (
                        $closure($valorRegistro->{$claveAccesor})
                    );
                }
            }
        }

        return $this->_respuesta(true, $registros);
    }

    /**
     * Obtiene un registro de la tabla especificada.
     *
     * @return string
     */
    public function obtenerRegistro()
    {
        $registro = Tabla::donde(
            $this->_peticion->atributos['llavePrimaria'].' = ?',
            [$this->_peticion->valorLlavePrimaria]
        )->primero();

        return $this->_respuesta(true, $registro);
    }

    /**
     * Crea un nuevo registro en la tabla especificada.
     *
     * @return string
     */
    public function crear()
    {
        try {
            $registro = json_decode($this->_peticion->registro, true);
            $mutadores = $this->_peticion->atributos['mutadores'];

            if ($mutadores) {
                foreach ($mutadores as $clave => $valor) {
                    $closure = deserializarClosure($valor);
                    $registro[$clave] = $closure($registro[$clave]);
                }
            }

            $tabla = new Tabla();
            $insercion = $tabla->insertar($registro);

            return $this->_respuesta($insercion ? true : false);
        } catch (ORM $excepcion) {
            return $this->_respuesta(false, null, $excepcion->getMessage());
        } catch (SQL $excepcion) {
            return $this->_respuesta(false, null, $excepcion->getMessage());
        } catch (Exception $excepcion) {
            return $this->_respuesta(false, null, $excepcion->getMessage());
        } catch (PDOException $excepcion) {
            return $this->_respuesta(false, null, $excepcion->getMessage());
        }
    }

    /**
     * Edita un registro en la tabla especificada.
     *
     * @return string
     */
    public function editar()
    {
        try {
            $registro = (array) $this->_peticion->registro;
            $mutadores = $this->_peticion->atributos['mutadores'];

            if ($mutadores) {
                foreach ($mutadores as $clave => $valor) {
                    $closure = deserializarClosure($valor);
                    $registro[$clave] = $closure($registro[$clave]);
                }
            }

            Tabla::donde(
                $this->_peticion->atributos['llavePrimaria'].' = ?',
                [$this->_peticion->valorLlavePrimaria]
            )
            ->actualizar($registro);

            return $this->_respuesta(true);
        } catch (ORM $excepcion) {
            return $this->_respuesta(false, null, $excepcion->getMessage());
        } catch (SQL $excepcion) {
            return $this->_respuesta(false, null, $excepcion->getMessage());
        } catch (Exception $excepcion) {
            return $this->_respuesta(false, null, $excepcion->getMessage());
        } catch (PDOException $excepcion) {
            return $this->_respuesta(false, null, $excepcion->getMessage());
        }
    }

    /**
     * Elimina un registro en la tabla especificada.
     *
     * @return string
     */
    public function eliminar()
    {
        try {
            Tabla::destruir($this->_peticion->valorLlavesPrimarias);

            return $this->_respuesta(true);
        } catch (ORM $excepcion) {
            return $this->_respuesta(false, null, $excepcion->getMessage());
        } catch (SQL $excepcion) {
            return $this->_respuesta(false, null, $excepcion->getMessage());
        } catch (Exception $excepcion) {
            return $this->_respuesta(false, null, $excepcion->getMessage());
        } catch (PDOException $excepcion) {
            return $this->_respuesta(false, null, $excepcion->getMessage());
        }
    }

    /**
     * Obtiene el paginado automático según los registros de la tabla.
     *
     * @return string
     */
    public function obtenerPaginado()
    {
        $pipe = PIPE::tabla($this->_peticion->config['BD_TABLA']);

        if ($busqueda = $this->_peticion->busqueda) {
            $pipe->donde($busqueda['campo']." like '%".$busqueda['valor']."%'");
        }

        $paginado = obtenerPaginado($pipe->contar());

        return $this->_respuesta(true, $paginado);
    }

    /**
     * Formatea la respuesta a una petición.
     * 
     * @param boolean           $estado  estado
     * @param null|array|object $datos   datos
     * @param null|string       $mensaje mensaje
     *
     * @return string
     */
    private function _respuesta($estado, $datos = null, $mensaje = null)
    {
        return json_encode(
            [
                'estado' => $estado,
                'datos' => $datos,
                'mensaje' => $mensaje
            ]
        );
    }
}
