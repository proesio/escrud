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

require __DIR__.'/../Funciones/tabla.php';

use function Escrud\Funciones\obtenerCasillaEncabezado;

$peticion = file_get_contents('php://input');
$peticion = json_decode($peticion);
$peticion->textos = (array) $peticion->textos;
$elementoId = $peticion->atributos->elementoId;
$encabezado = json_encode($peticion->encabezado);
$atributos = json_encode($peticion->atributos);
$config = json_encode($peticion->config);
$textos = json_encode($peticion->textos);

?>

<div id="<?='modal-crear'.$elementoId; ?>" class="escrud-modal">
    <div class="escrud-encabezado">
        <span class="escrud-titulo"><?=$peticion->textos['CREAR_REGISTRO']; ?></span>
        <span onclick="cerrarModal('<?='modal-crear'.$elementoId; ?>')" class="escrud-cerrar-modal">&times;</span>
    </div>

    <div class="escrud-contenido-modal">
        <div class="escrud-contenido">
            <?php

            foreach ($peticion->encabezado as $columna) :
                $condicion = (
                    (
                        $columna != $peticion->atributos->creadoEn
                        && $columna != $peticion->atributos->actualizadoEn
                        && in_array($columna, $peticion->atributos->insertables)
                    )
                    || 
                    (
                        $columna != $peticion->atributos->creadoEn
                        && $columna != $peticion->atributos->actualizadoEn
                        && empty($peticion->atributos->insertables)
                    )
                );

                if ($condicion) :

            ?>
                <label class="escrud-etiqueta">
                    <?=obtenerCasillaEncabezado($columna, $peticion->atributos) ?? $columna; ?>
                    <input
                        type="text"
                        id="<?='campo-'.$columna.$elementoId; ?>"
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
                id="<?='btn-guardar'.$elementoId; ?>"
                onclick='crear({
                    btnId: "<?='btn-guardar'.$elementoId; ?>",
                    modalId: "<?='modal-crear'.$elementoId; ?>",
                    btnTexto: "<?=$peticion->textos['GUARDAR']; ?>",
                    encabezado: <?=$encabezado; ?>,
                    atributos: <?=$atributos; ?>,
                    config: <?=$config; ?>,
                    textos: <?=$textos; ?>
                })'
                class="escrud-btn escrud-btn-crear escrud-float-right">
                <?=$peticion->textos['GUARDAR']; ?>
            </button>
        </div>		
    </div>
</div>
