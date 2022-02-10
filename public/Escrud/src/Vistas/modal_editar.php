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

use function Escrud\Funciones\obtenerCasillaEncabezado;

$peticion = file_get_contents('php://input');
$peticion = json_decode($peticion);
$peticion->textos = (array) $peticion->textos;
$peticion->registro = (array) $peticion->registro;
$elementoId = $peticion->atributos->elementoId;
$encabezado = json_encode($peticion->encabezado);
$atributos = json_encode($peticion->atributos);
$config = json_encode($peticion->config);
$textos = json_encode($peticion->textos);

?>

<div id="<?='modal-editar'.$elementoId; ?>" class="modal">
    <div class="encabezado">
        <span class="titulo"><?=$peticion->textos['EDITAR_REGISTRO']; ?></span>
        <span onclick="cerrarModal('<?='modal-editar'.$elementoId; ?>')" class="cerrar-modal">&times;</span>
    </div>

    <div class="contenido-modal">
        <div class="contenido">
            <?php

            foreach ($peticion->encabezado as $columna) :
                $condicion = (
                    (
                        $columna != $peticion->atributos->creadoEn
                        && $columna != $peticion->atributos->actualizadoEn
                        && in_array($columna, $peticion->atributos->actualizables)
                    )
                    || 
                    (
                        $columna != $peticion->atributos->creadoEn
                        && $columna != $peticion->atributos->actualizadoEn
                        && empty($peticion->atributos->actualizables)
                    )
                );

                if ($condicion) :

            ?>
                <label>
                    <?=obtenerCasillaEncabezado($columna, $peticion->atributos) ?? $columna; ?>
                    <input
                        type="text"
                        id="<?='campo-'.$columna.$elementoId; ?>"
                        value="<?=$peticion->registro[$columna]; ?>"
                        class="campo-texto"
                    />
                </label>
                <br>
            <?php
                endif;

            endforeach;

            ?>
        </div>
    </div>

    <div class="pie-pagina">
        <div class="contenido-pie-pagina">
            <button
                id="<?='btn-editar'.$elementoId; ?>"
                onclick='editar({
                    btnId: "<?='btn-editar'.$elementoId; ?>",
                    modalId: "<?='modal-editar'.$elementoId; ?>",
                    btnTexto: "<?=$peticion->textos['GUARDAR_CAMBIOS']; ?>",
                    valorLlavePrimaria: <?=$peticion->valorLlavePrimaria; ?>,
                    encabezado: <?=$encabezado; ?>,
                    atributos: <?=$atributos; ?>,
                    config: <?=$config; ?>,
                    textos: <?=$textos; ?>
                })'
                class="btn btn-guardar-cambios">
                <?=$peticion->textos['GUARDAR_CAMBIOS']; ?>
            </button>
        </div>		
    </div>
</div>
