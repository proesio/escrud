<?php

/**
 * Este archivo es parte del proyecto Escrud.
 * 
 * PHP versions 7 and 8 
 * 
 * @author    Juan Felipe Valencia Murillo  <juanfe0245@gmail.com>
 * @copyright 2020 - presente  Juan Felipe Valencia Murillo
 * @license   https://opensource.org/licenses/MIT  MIT License
 * @version   GIT:  2.6.7
 * @link      https://escrud.proes.io
 * @since     Fecha inicio de creación del proyecto  2020-05-31
 */

$peticion = file_get_contents('php://input');
$peticion = json_decode($peticion);
$peticion->textos = (array) $peticion->textos;
$elementoId = $peticion->propiedades->elementoId;
$encabezado = json_encode($peticion->encabezado);
$propiedades = json_encode($peticion->propiedades);
$config = json_encode($peticion->config);
$textos = json_encode($peticion->textos);

?>

<div id="<?='escrud-modal-eliminar'.$elementoId; ?>" class="escrud-modal">
    <div class="escrud-encabezado">
        <span class="escrud-titulo"></span>
        <span onclick="cerrarModal('<?='escrud-modal-eliminar'.$elementoId; ?>')" class="escrud-cerrar-modal">&times;</span>
    </div>

    <div class="escrud-contenido-modal">
        <div class="escrud-contenido">
            <p align="center" class="escrud-fuente-modal-eliminar">
                <?=sprintf($peticion->textos['CONFIRMACION_ELIMINACION_REGISTRO'], count($peticion->valorLlavesPrimarias)); ?>
            </p>
        </div>
    </div>

    <div class="escrud-pie-pagina">
        <div class="escrud-contenido-pie-pagina">
            <div class="escrud-contenedor-btns-eliminar">
                <button
                    onclick="cerrarModal('<?='escrud-modal-eliminar'.$elementoId; ?>')"
                    class="escrud-btn escrud-btn-cancelar">
                    <?=$peticion->textos['CANCELAR']; ?>
                </button>
                <button
                    id="<?='escrud-btn-confirmar'.$elementoId; ?>"
                    onclick='eliminar({
                        btnId: "<?='escrud-btn-confirmar'.$elementoId; ?>",
                        modalId: "<?='escrud-modal-eliminar'.$elementoId; ?>",
                        btnTexto: "<?=$peticion->textos['CONFIRMAR']; ?>",
                        valorLlavesPrimarias: <?=json_encode($peticion->valorLlavesPrimarias); ?>,
                        encabezado: <?=$encabezado; ?>,
                        propiedades: <?=$propiedades; ?>,
                        config: <?=$config; ?>,
                        textos: <?=$textos; ?>
                    })'
                    class="escrud-btn escrud-btn-eliminar">
                    <?=$peticion->textos['CONFIRMAR']; ?>
                </button>
            </div>
        </div>
    </div>
</div>
