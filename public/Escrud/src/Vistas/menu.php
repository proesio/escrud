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

$menuId = 'menu'.$elementoId.($registro->{$peticion->atributos->llavePrimaria}); 

?>

<div>
    <span class="puntos" onclick="abrirMenu('<?=$menuId; ?>')"></span>

    <ul id="<?=$menuId; ?>" class="menu">

        <?php if ($peticion->atributos->acciones->editar) : ?>

        <li 
            onclick='abrirModalEditar({
                modalId: "<?='modal-editar'.$elementoId; ?>",
                valorLlavePrimaria: <?=$registro->{$peticion->atributos->llavePrimaria}; ?>,
                encabezado: <?=$encabezado; ?>,
                atributos: <?=$atributos; ?>,
                config: <?=$config; ?>,
                textos: <?=$textos; ?>
            })'
            class="editar"><?=$peticion->textos['EDITAR']; ?></li>

        <?php endif; ?>

        <?php if ($peticion->atributos->acciones->eliminar) : ?>

        <li 
            class="eliminar"
            onclick='abrirModalEliminar({
                modalId: "<?='modal-eliminar'.$elementoId; ?>",
                valorLlavesPrimarias: [<?=$registro->{$peticion->atributos->llavePrimaria}; ?>],
                encabezado: <?=$encabezado; ?>,
                atributos: <?=$atributos; ?>,
                config: <?=$config; ?>,
                textos: <?=$textos; ?>
            })'><?=$peticion->textos['ELIMINAR']; ?></li>

        <?php endif; ?>
    </ul>
</div>
