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

$peticion = file_get_contents('php://input');
$peticion = json_decode($peticion);
$peticion->textos = (array) $peticion->textos;
$elementoId = $peticion->atributos->elementoId;
$encabezado = json_encode($peticion->encabezado);
$atributos = json_encode($peticion->atributos);
$config = json_encode($peticion->config);
$textos = json_encode($peticion->textos);

?>

<div id="<?='modal-eliminar'.$elementoId; ?>" class="modal">
    <div class="encabezado">
        <span class="titulo"></span>
        <span onclick="cerrarModal('<?='modal-eliminar'.$elementoId; ?>')" class="cerrar-modal">&times;</span>
    </div>

    <div class="contenido-modal">
        <div class="contenido">
            <p align="center" class="fuente-modal-eliminar">
                <?=$peticion->textos['CONFIRMACION_ELIMINACION_REGISTRO']; ?>
            </p>
        </div>
    </div>

    <div class="pie-pagina">
        <div class="contenido-pie-pagina">
            <div class="contenedor-btns-eliminar">
                <button
                    onclick="cerrarModal('<?='modal-eliminar'.$elementoId; ?>')"
                    class="btn btn-cancelar">
                    <?=$peticion->textos['CANCELAR']; ?>
                </button>
                <button
                    id="<?='btn-confirmar'.$elementoId; ?>"
                    onclick='eliminar({
                        btnId: "<?='btn-confirmar'.$elementoId; ?>",
                        modalId: "<?='modal-eliminar'.$elementoId; ?>",
                        btnTexto: "<?=$peticion->textos['CONFIRMAR']; ?>",
                        valorLlavesPrimarias: <?=json_encode($peticion->valorLlavesPrimarias); ?>,
                        encabezado: <?=$encabezado; ?>,
                        atributos: <?=$atributos; ?>,
                        config: <?=$config; ?>,
                        textos: <?=$textos; ?>
                    })'
                    class="btn btn-confirmar">
                    <?=$peticion->textos['CONFIRMAR']; ?>
                </button>
            </div>
        </div>
    </div>
</div>
