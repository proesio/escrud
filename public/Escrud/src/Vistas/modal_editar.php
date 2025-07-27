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

require __DIR__.'/../Funciones/tabla.php';

use function Escrud\Funciones\obtenerCasillaEncabezado;

$peticion = file_get_contents('php://input');
$peticion = json_decode($peticion);
$peticion->textos = (array) $peticion->textos;
$peticion->registro = (array) $peticion->registro;
$elementoId = $peticion->propiedades->elementoId;
$encabezado = json_encode($peticion->encabezado);
$propiedades = json_encode($peticion->propiedades);
$config = json_encode($peticion->config);
$textos = json_encode($peticion->textos);

?>

<div id="<?='escrud-modal-editar'.$elementoId; ?>" class="escrud-modal">
    <div class="escrud-encabezado">
        <span class="escrud-titulo"><?=$peticion->textos['EDITAR_REGISTRO']; ?></span>
        <span onclick="cerrarModal('<?='escrud-modal-editar'.$elementoId; ?>')" class="escrud-cerrar-modal">&times;</span>
    </div>

    <div class="escrud-contenido-modal">
        <div class="escrud-contenido">
            <?php

            foreach ($peticion->encabezado as $columna) :
                $condicion = (
                    (
                        $columna != $peticion->propiedades->creadoEn
                        && $columna != $peticion->propiedades->actualizadoEn
                        && in_array($columna, $peticion->propiedades->actualizables)
                    )
                    || 
                    (
                        $columna != $peticion->propiedades->creadoEn
                        && $columna != $peticion->propiedades->actualizadoEn
                        && empty($peticion->propiedades->actualizables)
                    )
                );

                if ($condicion) :

            ?>
                <label class="escrud-etiqueta">
                    <?=obtenerCasillaEncabezado($columna, $peticion->propiedades) ?? $columna; ?>
                    <input
                        type="text"
                        id="<?='escrud-campo-'.$columna.$elementoId; ?>"
                        value="<?=$peticion->registro[$columna]; ?>"
                        class="escrud-campo-texto"
                    />
                </label>
                <br>
            <?php
                endif;

            endforeach;

            ?>
        </div>
    </div>

    <div class="escrud-pie-pagina">
        <div class="escrud-contenido-pie-pagina">
            <button
                id="<?='escrud-btn-editar'.$elementoId; ?>"
                onclick='editar({
                    btnId: "<?='escrud-btn-editar'.$elementoId; ?>",
                    modalId: "<?='escrud-modal-editar'.$elementoId; ?>",
                    btnTexto: "<?=$peticion->textos['GUARDAR_CAMBIOS']; ?>",
                    valorLlavePrimaria: <?=$peticion->valorLlavePrimaria; ?>,
                    encabezado: <?=$encabezado; ?>,
                    propiedades: <?=$propiedades; ?>,
                    config: <?=$config; ?>,
                    textos: <?=$textos; ?>
                })'
                class="escrud-btn escrud-btn-editar escrud-float-right">
                <?=$peticion->textos['GUARDAR_CAMBIOS']; ?>
            </button>
        </div>		
    </div>
</div>
