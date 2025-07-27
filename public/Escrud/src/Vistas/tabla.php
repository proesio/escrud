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

use Escrud\Clases\Texto;
use function Escrud\Funciones\urlBase;

$propiedades = json_decode($html->_obtenerPropiedades(), true);

?>

<!DOCTYPE html>

<html>

<head>
    <link rel="stylesheet" href="<?=urlBase('css/tabla.css'); ?>"/>
    <link rel="stylesheet" href="<?=urlBase('css/modal.css'); ?>"/>
    <link rel="stylesheet" href="<?=urlBase('css/alertas.css'); ?>"/>
    <link rel="stylesheet" href="<?=urlBase('css/barra-cargando.css'); ?>"/>
</head>

<body class="escrud-cuerpo">

<div class="escrud-contenedor">

<div class="escrud-contenedor-barra">

<?php $barraCargandoId = 'superior'.$html->_elementoId; ?>
<?php include 'barra_cargando.php'; ?>

</div>

<div class="escrud-contenedor-titulo">
    <strong>
        <?=$propiedades['titulo'] 
            ? substr($propiedades['titulo'], 0, 60) 
            : substr($propiedades['tabla'], 0, 60); ?>
    </strong>
</div>

<div class="escrud-contenedor-acciones">

<?php if ($propiedades['acciones']['acciones'] && $propiedades['acciones']['crear']) : ?>

<button
    onclick='abrirModalCrear({
        encabezado: <?=$html->_obtenerEncabezado(); ?>,
        propiedades: <?=$html->_obtenerPropiedades(); ?>,
        config: <?=$html->_obtenerConfiguracion(); ?>,
        textos: <?=Texto::obtenerTextos(); ?>
    })'
    class="escrud-btn escrud-btn-crear">
    <?=Texto::$textos['CREAR_REGISTRO']; ?>
</button>

<?php endif; ?>

<button 
    id="<?='escrud-btn-eliminar-seleccion'.$html->_elementoId; ?>" 
    class="escrud-btn escrud-btn-eliminar escrud-display-none"
    onclick='abrirModalEliminar({
        modalId: "<?='escrud-modal-eliminar'.$html->_elementoId; ?>",
        encabezado: <?=$html->_obtenerEncabezado(); ?>,
        propiedades: <?=$html->_obtenerPropiedades(); ?>,
        config: <?=$html->_obtenerConfiguracion(); ?>,
        textos: <?=Texto::obtenerTextos(); ?>,
        masivo: true
    })'>
    <?=Texto::$textos['ELIMINAR']; ?>
</button>

</div>

<div id="<?='escrud-tabla'.$html->_elementoId; ?>"></div>

<div class="escrud-contenedor-barra">

<?php $barraCargandoId = 'inferior'.$html->_elementoId; ?>
<?php require 'barra_cargando.php'; ?>

</div>

</div>

<div id="<?='escrud-modal'.$html->_elementoId; ?>"></div>

<div id="<?='escrud-alerta'.$html->_elementoId; ?>"></div>

<script type="text/javascript" src="<?=urlBase('js/util.js'); ?>"></script>
<script type="text/javascript" src="<?=urlBase('js/tabla.js'); ?>"></script>
<script type="text/javascript" src="<?=urlBase('js/modal.js'); ?>"></script>
<script type="text/javascript" src="<?=urlBase('js/alertas.js'); ?>"></script>
<script type="text/javascript" src="<?=urlBase('js/crear.js'); ?>"></script>
<script type="text/javascript" src="<?=urlBase('js/consultar.js'); ?>"></script>
<script type="text/javascript" src="<?=urlBase('js/editar.js'); ?>"></script>
<script type="text/javascript" src="<?=urlBase('js/eliminar.js'); ?>"></script>

<script type="text/javascript">

setTimeout(() => {
    inicializarTabla({
        inicio: 0,
        cantidad: 5,
        busqueda: '',
        encabezado: <?=$html->_obtenerEncabezado(); ?>,
        propiedades: <?=$html->_obtenerPropiedades(); ?>,
        config: <?=$html->_obtenerConfiguracion(); ?>,
        textos: <?=Texto::obtenerTextos(); ?>,
        cargaInicial: true
    });
}, (<?=$html->_elementoId; ?>) * 100);

async function inicializarTabla(datos) {
    const elementoId = Number(datos.propiedades.elementoId);

    barraCargando(`escrud-barra-cargando-superior${elementoId}`);
    barraCargando(`escrud-barra-cargando-inferior${elementoId}`);

    if (datos.busqueda && datos.busqueda.valor) {
        const busqueda = document.getElementById(
            `escrud-busqueda${datos.busqueda.campo}${elementoId}`
        );

        busqueda.disabled = true;
    }

    datos.registros = (await obtenerRegistros(datos)).datos;
    datos.paginado = (await obtenerPaginado(datos)).datos;

    renderizarTabla(datos);
}

</script>

</body>

</html>
