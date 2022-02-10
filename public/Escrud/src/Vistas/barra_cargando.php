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

?>

<div id="<?='barra-cargando-'.$barraCargandoId; ?>" class="barra">
    <div class="animacion">

    <?php for ($i = 1; $i <= 100; $i++) : ?>
        <div class="lineas"></div>
    <?php endfor; ?>

    </div>
</div>
