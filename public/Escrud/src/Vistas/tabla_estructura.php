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

require __DIR__.'/../Funciones/tabla.php';

use function Escrud\Funciones\resaltarBusqueda;
use function Escrud\Funciones\validarCampoBuscable;
use function Escrud\Funciones\validarCasillaRegistro;
use function Escrud\Funciones\obtenerCasillaEncabezado;

$peticion = file_get_contents('php://input');
$peticion = json_decode($peticion);
$peticion->textos = (array) $peticion->textos;
$elementoId = $peticion->atributos->elementoId;
$encabezado = json_encode($peticion->encabezado);
$registros = json_encode($peticion->registros);
$atributos = json_encode($peticion->atributos);
$config = json_encode($peticion->config);
$textos = json_encode($peticion->textos);
$busqueda = json_encode($peticion->busqueda);

?>

<div class="contenedor-tabla">

<table class="tabla">
    <thead>
        <tr>

        <?php

        if ($peticion->atributos->acciones->acciones) :
            echo '<th>'.$peticion->textos['ACCIONES'].'</th>';
        endif;

        foreach ($peticion->encabezado as $columna) :
            $titulo = obtenerCasillaEncabezado($columna, $peticion->atributos);

            if ($titulo) :
                echo '<th>'.$titulo.'</th>';
            endif;
        endforeach;

        ?>

        </tr>
        <tr>

        <?php if ($peticion->atributos->acciones->acciones) : ?>
            <th>

            <?php if ($peticion->atributos->acciones->eliminar) : ?>
            <input 
                id="<?='check'.$elementoId; ?>" 
                type="checkbox" 
                onclick='chequearTodo(<?=$registros; ?>, <?=$atributos; ?>)' 
            />
            <?php endif; ?>

            </th>

        <?php endif; ?>

        <?php

        foreach ($peticion->encabezado as $columna) :
            $titulo = obtenerCasillaEncabezado($columna, $peticion->atributos);
            $buscable = validarCampoBuscable($columna, $peticion->atributos);

            if ($titulo && $buscable) :

        ?>
            <th>
                <input
                    type="text" 
                    id="<?=$columna.$elementoId; ?>"
                    class="buscador"
                    placeholder="<?=$peticion->textos['BUSQUEDA_RAPIDA']; ?>"
                    onkeyup='buscar({
                        inicio: <?=$peticion->inicio; ?>,
                        cantidad: <?=$peticion->cantidad; ?>,
                        busqueda: { campo: "<?=$columna; ?>", valor: this.value },
                        encabezado: <?=$encabezado; ?>,
                        atributos: <?=$atributos; ?>,
                        config: <?=$config; ?>,
                        textos: <?=$textos; ?>
                    })'
                />
            </th>
        <?php

            elseif ($titulo) :
                echo '<th><input type="text" class="buscador" disabled/></th>';
            endif;

        endforeach;

        ?>
        </tr>
    </thead>
    <tbody>

    <?php foreach ($peticion->registros as $registro) : ?>
    <?php $registroPivote = json_encode($registro); ?>
        <tr class="tr">

        <?php if ($peticion->atributos->acciones->acciones) : ?>    
            <td>
                <div class="display-flex">

                <?php if ($peticion->atributos->acciones->eliminar) : ?>
                    <input 
                        id="<?='check'.$elementoId.($registro->{$peticion->atributos->llavePrimaria}); ?>" 
                        onclick='chequearRegistro(
                            <?=$registros; ?>, 
                            <?=$atributos; ?>,
                            "<?='check'.$elementoId.($registro->{$peticion->atributos->llavePrimaria}); ?>"
                        )'
                        type="checkbox" 
                        class="m-r-20"/>
                <?php endif; ?>
                <?php include 'menu.php'; ?>

                </div>
            </td>
        <?php endif; ?>

        <?php

        foreach ($registro as $clave => $dato) :
            $casilla = validarCasillaRegistro($clave, $peticion->atributos);

            if ($casilla) :
                if ($peticion->busqueda && !empty($peticion->busqueda->valor)
                    && $peticion->busqueda->campo == $clave
                ) :
                    $dato = resaltarBusqueda($dato, $peticion->busqueda->valor);
                endif;

                echo '<td>'.$dato.'</td>';
            endif;
        endforeach;

        ?>

        </tr>

    <?php endforeach; ?>

    </tbody>
</table>

</div>

<?php require 'tabla_paginador.php'; ?>
