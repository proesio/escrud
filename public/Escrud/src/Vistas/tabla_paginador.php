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

?>

<div class="escrud-contenedor-paginador">

<?php if ($peticion->paginado->paginado) : ?>

    <span class="escrud-fuente-paginador">
        <?=$peticion->textos['REGISTROS_POR_PAGINA']; ?>
    </span>

    <select
        class="escrud-select escrud-select-primario"
        onchange='inicializarTabla({
            inicio: 0,
            cantidad: this.value,
            busqueda: <?=$busqueda; ?>,
            encabezado: <?=$encabezado; ?>,
            propiedades: <?=$propiedades; ?>,
            config: <?=$config; ?>,
            textos: <?=$textos; ?>
        })'>
        <option value="<?=$peticion->cantidad; ?>"><?=$peticion->cantidad; ?></option>
        <?php foreach ($peticion->paginado->paginado as $paginado) : ?>
            <option
                value="<?=$paginado; ?>"
                <?=$paginado == $peticion->cantidad ? 'disabled' : ''; ?>>
                <?=$paginado; ?>
            </option>
        <?php endforeach; ?>
    </select>

<?php endif; ?>

<?php

$ultimaPagina = (
    ($peticion->inicio + $peticion->cantidad) >= $peticion->paginado->total ? true : false
);

$cantidadPaginas = ($peticion->paginado->total ? $peticion->inicio + 1 : 0)
    .' - '
    .($ultimaPagina ? $peticion->paginado->total : $peticion->inicio + $peticion->cantidad)
    .' '.$peticion->textos['DE']
    .' '.$peticion->paginado->total;

?>

<span class="escrud-fuente-paginador"><?=$cantidadPaginas; ?></span>

<button
    onclick='inicializarTabla({
        inicio: <?=$peticion->inicio - $peticion->cantidad; ?>,
        cantidad: <?=$peticion->cantidad; ?>,
        busqueda: <?=$busqueda; ?>,
        encabezado: <?=$encabezado; ?>,
        propiedades: <?=$propiedades; ?>,
        config: <?=$config; ?>,
        textos: <?=$textos; ?>
    })'
    class="escrud-btn escrud-btn-primario"
    <?=$peticion->inicio < 5 ? 'disabled' : ''; ?>
    <?=$peticion->inicio < 5 ? 'style="cursor: default;"' : ''; ?>>
    <?=$peticion->textos['ANTERIOR']; ?>
</button>

<button
    onclick='inicializarTabla({
        inicio: <?=$peticion->inicio + $peticion->cantidad; ?>,
        cantidad: <?=$peticion->cantidad; ?>,
        busqueda: <?=$busqueda; ?>,
        encabezado: <?=$encabezado; ?>,
        propiedades: <?=$propiedades; ?>,
        config: <?=$config; ?>,
        textos: <?=$textos; ?>
    })'
    class="escrud-btn escrud-btn-primario"
    <?=$ultimaPagina ? 'disabled' : ''; ?>
    <?=$ultimaPagina ? 'style="cursor: default;"' : ''; ?>>
    <?=$peticion->textos['SIGUIENTE']; ?>
</button>

</div>
