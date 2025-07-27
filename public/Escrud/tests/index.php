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

require __DIR__.'/config.php';

use Escrud\Clases\Escrud;
use Escrud\Clases\Excepciones\Escrud as EscrudExcepcion;

?>

<!DOCTYPE html>

<html>

<head>

<title>Escrud - CRUD en Español</title>

</head>

<body>

<?php

try {
    Escrud::tabla('usuarios')
        ->visibles('nombres', 'apellidos', 'correo', 'telefono', 'creado_en', 'actualizado_en')
        ->insertables('nombres', 'apellidos', 'correo', 'telefono')
        ->actualizables('nombres', 'apellidos', 'correo', 'telefono')
        ->buscables('nombres', 'apellidos', 'correo', 'telefono')
        ->alias(
            [
                'nombres' => 'Nombres', 
                'apellidos' => 'Apellidos', 
                'correo' => 'Correo electrónico', 
                'telefono' => 'Teléfono',
                'creado_en' => 'Creación',
                'actualizado_en' => 'Actualización'
            ]
        )
        ->ordenarPor('id', 'desc')
        ->titulo('Mysql - usuarios')
        ->mutadores(
            [
                'nombres' => function ($valor) {
                    return strtoupper($valor);
                },
                'apellidos' => function ($valor) {
                    return strtoupper($valor);
                }
            ]
        )
        ->accesores(
            [
                'creado_en' => function ($valor) {
                    $dateTime = new DateTime($valor);
                    return $dateTime->format('d-m-Y H:i:s');
                },
                'actualizado_en' => function ($valor) {
                    $dateTime = new DateTime($valor);
                    return $dateTime->format('d-m-Y H:i:s');
                }
            ]
        )
        ->renderizar();

    Escrud::conexion('pgsql')
        ->tabla('usuarios')
        ->ocultos('id')
        ->insertables('nombres', 'apellidos', 'correo', 'telefono')
        ->actualizables('nombres', 'apellidos', 'correo', 'telefono')
        ->noBuscables('creado_en', 'actualizado_en')
        ->alias(
            [
                'nombres' => 'Nombres', 
                'apellidos' => 'Apellidos', 
                'correo' => 'Correo electrónico', 
                'telefono' => 'Teléfono',
                'creado_en' => 'Creación',
                'actualizado_en' => 'Actualización'
            ]
        )
        ->ordenarPor('id', 'desc')
        ->titulo('Pgsql - usuarios')
        ->mutadores(
            [
                'nombres' => function ($valor) {
                    return strtoupper($valor);
                },
                'apellidos' => function ($valor) {
                    return strtoupper($valor);
                }
            ]
        )
        ->accesores(
            [
                'creado_en' => function ($valor) {
                    $dateTime = new DateTime($valor);
                    return $dateTime->format('d-m-Y H:i:s');
                },
                'actualizado_en' => function ($valor) {
                    $dateTime = new DateTime($valor);
                    return $dateTime->format('d-m-Y H:i:s');
                }
            ]
        )
        ->renderizar();

    Escrud::conexion('sqlite')
        ->tabla('usuarios')
        ->visibles('nombres', 'apellidos', 'correo', 'telefono', 'creado_en', 'actualizado_en')
        ->insertables('nombres', 'apellidos', 'correo', 'telefono')
        ->actualizables('nombres', 'apellidos', 'correo', 'telefono')
        ->buscables('nombres', 'apellidos', 'correo', 'telefono')
        ->alias(
            [
                'nombres' => 'Nombres', 
                'apellidos' => 'Apellidos', 
                'correo' => 'Correo electrónico', 
                'telefono' => 'Teléfono',
                'creado_en' => 'Creación',
                'actualizado_en' => 'Actualización'
            ]
        )
        ->ordenarPor('id', 'desc')
        ->titulo('Sqlite - usuarios')
        ->mutadores(
            [
                'nombres' => function ($valor) {
                    return strtoupper($valor);
                },
                'apellidos' => function ($valor) {
                    return strtoupper($valor);
                }
            ]
        )
        ->accesores(
            [
                'creado_en' => function ($valor) {
                    $dateTime = new DateTime($valor);
                    return $dateTime->format('d-m-Y H:i:s');
                },
                'actualizado_en' => function ($valor) {
                    $dateTime = new DateTime($valor);
                    return $dateTime->format('d-m-Y H:i:s');
                }
            ]
        )
        ->renderizar();

    Escrud::conexion('sqlsrv')
        ->tabla('usuarios')
        ->visibles('nombres', 'apellidos', 'correo', 'telefono', 'creado_en', 'actualizado_en')
        ->insertables('nombres', 'apellidos', 'correo', 'telefono')
        ->actualizables('nombres', 'apellidos', 'correo', 'telefono')
        ->buscables('nombres', 'apellidos', 'correo', 'telefono')
        ->alias(
            [
                'nombres' => 'Nombres', 
                'apellidos' => 'Apellidos', 
                'correo' => 'Correo electrónico', 
                'telefono' => 'Teléfono',
                'creado_en' => 'Creación',
                'actualizado_en' => 'Actualización'
            ]
        )
        ->ordenarPor('id', 'desc')
        ->titulo('Sqlsrv - usuarios')
        ->mutadores(
            [
                'nombres' => function ($valor) {
                    return strtoupper($valor);
                },
                'apellidos' => function ($valor) {
                    return strtoupper($valor);
                }
            ]
        )
        ->accesores(
            [
                'creado_en' => function ($valor) {
                    $dateTime = new DateTime($valor);
                    return $dateTime->format('d-m-Y H:i:s');
                },
                'actualizado_en' => function ($valor) {
                    $dateTime = new DateTime($valor);
                    return $dateTime->format('d-m-Y H:i:s');
                }
            ]
        )
        ->renderizar();

    Escrud::conexion('mysql')
        ->tabla('usuario')
        ->llavePrimaria('codigo')
        ->visibles('nombres', 'apellidos', 'correo', 'telefono', 'fecha_creacion', 'fecha_actualizacion')
        ->insertables('nombres', 'apellidos', 'correo', 'telefono')
        ->actualizables('nombres', 'apellidos', 'correo', 'telefono')
        ->buscables('nombres', 'apellidos', 'correo', 'telefono')
        ->alias(
            [
                'nombres' => 'Nombres', 
                'apellidos' => 'Apellidos', 
                'correo' => 'Correo electrónico', 
                'telefono' => 'Teléfono',
                'fecha_creacion' => 'Creación',
                'fecha_actualizacion' => 'Actualización'
            ]
        )
        ->creadoEn('fecha_creacion')
        ->actualizadoEn('fecha_actualizacion')
        ->ordenarPor('codigo', 'desc')
        ->titulo('Mysql - usuario')
        ->mutadores(
            [
                'nombres' => function ($valor) {
                    return strtoupper($valor);
                },
                'apellidos' => function ($valor) {
                    return strtoupper($valor);
                }
            ]
        )
        ->accesores(
            [
                'fecha_creacion' => function ($valor) {
                    $dateTime = new DateTime($valor);
                    return $dateTime->format('d-m-Y H:i:s');
                },
                'fecha_actualizacion' => function ($valor) {
                    $dateTime = new DateTime($valor);
                    return $dateTime->format('d-m-Y H:i:s');
                }
            ]
        )
        ->renderizar();

    Escrud::conexion('pgsql')
        ->tabla('usuario')
        ->llavePrimaria('codigo')
        ->ocultos('codigo')
        ->insertables('nombres', 'apellidos', 'correo', 'telefono')
        ->actualizables('nombres', 'apellidos', 'correo', 'telefono')
        ->noBuscables('fecha_creacion', 'fecha_actualizacion')
        ->alias(
            [
                'nombres' => 'Nombres', 
                'apellidos' => 'Apellidos', 
                'correo' => 'Correo electrónico', 
                'telefono' => 'Teléfono',
                'fecha_creacion' => 'Creación',
                'fecha_actualizacion' => 'Actualización'
            ]
        )
        ->creadoEn('fecha_creacion')
        ->actualizadoEn('fecha_actualizacion')
        ->ordenarPor('codigo', 'desc')
        ->titulo('Pgsql - usuario')
        ->mutadores(
            [
                'nombres' => function ($valor) {
                    return strtoupper($valor);
                },
                'apellidos' => function ($valor) {
                    return strtoupper($valor);
                }
            ]
        )
        ->accesores(
            [
                'fecha_creacion' => function ($valor) {
                    $dateTime = new DateTime($valor);
                    return $dateTime->format('d-m-Y H:i:s');
                },
                'fecha_actualizacion' => function ($valor) {
                    $dateTime = new DateTime($valor);
                    return $dateTime->format('d-m-Y H:i:s');
                }
            ]
        )
        ->renderizar();

    Escrud::conexion('sqlite')
        ->tabla('usuario')
        ->llavePrimaria('codigo')
        ->visibles('nombres', 'apellidos', 'correo', 'telefono', 'fecha_creacion', 'fecha_actualizacion')
        ->insertables('nombres', 'apellidos', 'correo', 'telefono')
        ->actualizables('nombres', 'apellidos', 'correo', 'telefono')
        ->buscables('nombres', 'apellidos', 'correo', 'telefono')
        ->alias(
            [
                'nombres' => 'Nombres', 
                'apellidos' => 'Apellidos', 
                'correo' => 'Correo electrónico', 
                'telefono' => 'Teléfono',
                'fecha_creacion' => 'Creación',
                'fecha_actualizacion' => 'Actualización'
            ]
        )
        ->creadoEn('fecha_creacion')
        ->actualizadoEn('fecha_actualizacion')
        ->ordenarPor('codigo', 'desc')
        ->titulo('Sqlite - usuario')
        ->mutadores(
            [
                'nombres' => function ($valor) {
                    return strtoupper($valor);
                },
                'apellidos' => function ($valor) {
                    return strtoupper($valor);
                }
            ]
        )
        ->accesores(
            [
                'fecha_creacion' => function ($valor) {
                    $dateTime = new DateTime($valor);
                    return $dateTime->format('d-m-Y H:i:s');
                },
                'fecha_actualizacion' => function ($valor) {
                    $dateTime = new DateTime($valor);
                    return $dateTime->format('d-m-Y H:i:s');
                }
            ]
        )
        ->renderizar();

    Escrud::conexion('sqlsrv')
        ->tabla('usuario')
        ->llavePrimaria('codigo')
        ->visibles('nombres', 'apellidos', 'correo', 'telefono', 'fecha_creacion', 'fecha_actualizacion')
        ->insertables('nombres', 'apellidos', 'correo', 'telefono')
        ->actualizables('nombres', 'apellidos', 'correo', 'telefono')
        ->buscables('nombres', 'apellidos', 'correo', 'telefono')
        ->alias(
            [
                'nombres' => 'Nombres', 
                'apellidos' => 'Apellidos', 
                'correo' => 'Correo electrónico', 
                'telefono' => 'Teléfono',
                'fecha_creacion' => 'Creación',
                'fecha_actualizacion' => 'Actualización'
            ]
        )
        ->creadoEn('fecha_creacion')
        ->actualizadoEn('fecha_actualizacion')
        ->ordenarPor('codigo', 'desc')
        ->titulo('Sqlsrv - usuario')
        ->mutadores(
            [
                'nombres' => function ($valor) {
                    return strtoupper($valor);
                },
                'apellidos' => function ($valor) {
                    return strtoupper($valor);
                }
            ]
        )
        ->accesores(
            [
                'fecha_creacion' => function ($valor) {
                    $dateTime = new DateTime($valor);
                    return $dateTime->format('d-m-Y H:i:s');
                },
                'fecha_actualizacion' => function ($valor) {
                    $dateTime = new DateTime($valor);
                    return $dateTime->format('d-m-Y H:i:s');
                }
            ]
        )
        ->renderizar();
} catch (EscrudExcepcion $e) {
    dd($e->getMessage());
} catch (Exception $e) {
    dd($e->getMessage());
}

?>

</body>

</html>
