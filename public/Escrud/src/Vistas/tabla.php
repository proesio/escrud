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

use Escrud\Clases\Texto;
use function Escrud\Funciones\urlBase;

$config = json_decode($html->_obtenerConfiguracion(), true);
$atributos = json_decode($html->_obtenerAtributos(), true);

?>

<!DOCTYPE html>

<html>

<head>
    <link rel="stylesheet" href="<?=urlBase('css/tabla.css'); ?>"/>
    <link rel="stylesheet" href="<?=urlBase('css/modal.css'); ?>"/>
    <link rel="stylesheet" href="<?=urlBase('css/alertas.css'); ?>"/>
    <link rel="stylesheet" href="<?=urlBase('css/barra-cargando.css'); ?>"/>
    <link rel="stylesheet" href="<?=urlBase('css/menu.css'); ?>"/>
</head>

<body>

<div class="contenedor">

<div class="contenedor-barra">

<?php $barraCargandoId = 'superior'.$html->_elementoId; ?>
<?php include 'barra_cargando.php'; ?>

</div>

<div class="contenedor-titulo">
    <strong>
        <?=$atributos['titulo'] 
            ? substr($atributos['titulo'], 0, 60) 
            : substr($atributos['tabla'], 0, 60); ?>
    </strong>
</div>

<div class="contenedor-acciones">

<?php if ($atributos['acciones']['acciones'] && $atributos['acciones']['crear']) : ?>

<button
    onclick='abrirModalCrear({
        encabezado: <?=$html->_obtenerEncabezado(); ?>,
        atributos: <?=$html->_obtenerAtributos(); ?>,
        config: <?=$html->_obtenerConfiguracion(); ?>,
        textos: <?=Texto::obtenerTextos(); ?>
    })'
    class="btn btn-crear">
    <?=Texto::$textos['CREAR_REGISTRO']; ?>
</button>

<?php endif; ?>

<button 
    id="<?='btn-eliminar-seleccion'.$html->_elementoId; ?>" 
    class="btn btn-eliminar btn-crear display-none"
    onclick='abrirModalEliminar({
        modalId: "<?='modal-eliminar'.$html->_elementoId; ?>",
        encabezado: <?=$html->_obtenerEncabezado(); ?>,
        atributos: <?=$html->_obtenerAtributos(); ?>,
        config: <?=$html->_obtenerConfiguracion(); ?>,
        textos: <?=Texto::obtenerTextos(); ?>,
        masivo: true
    })'>
    <?=Texto::$textos['ELIMINAR']; ?>
</button>

</div>

<div id="<?='tabla'.$html->_elementoId; ?>"></div>

<div class="contenedor-barra">

<?php $barraCargandoId = 'inferior'.$html->_elementoId; ?>
<?php require 'barra_cargando.php'; ?>

</div>

</div>

<div id="<?='modal'.$html->_elementoId; ?>"></div>

<div id="<?='alerta'.$html->_elementoId; ?>"></div>

<script type="text/javascript" src="<?=urlBase('js/util.js'); ?>"></script>
<script type="text/javascript" src="<?=urlBase('js/tabla.js'); ?>"></script>
<script type="text/javascript" src="<?=urlBase('js/modal.js'); ?>"></script>
<script type="text/javascript" src="<?=urlBase('js/alertas.js'); ?>"></script>
<script type="text/javascript" src="<?=urlBase('js/crear.js'); ?>"></script>
<script type="text/javascript" src="<?=urlBase('js/consultar.js'); ?>"></script>
<script type="text/javascript" src="<?=urlBase('js/editar.js'); ?>"></script>
<script type="text/javascript" src="<?=urlBase('js/eliminar.js'); ?>"></script>
<script type="text/javascript" src="<?=urlBase('js/menu.js'); ?>"></script>

<script type="text/javascript">

setTimeout(() => {
    inicializarTabla({
        inicio: 0,
        cantidad: 5,
        busqueda: '',
        encabezado: <?=$html->_obtenerEncabezado(); ?>,
        atributos: <?=$html->_obtenerAtributos(); ?>,
        config: <?=$html->_obtenerConfiguracion(); ?>,
        textos: <?=Texto::obtenerTextos(); ?>,
        cargaInicial: true
    });
}, (<?=$html->_elementoId; ?>) * 1000);

async function inicializarTabla(datos) {
    const elementoId = Number(datos.atributos.elementoId);

    barraCargando(`barra-cargando-superior${elementoId}`);
    barraCargando(`barra-cargando-inferior${elementoId}`);

    if (datos.busqueda && datos.busqueda.valor) {
        const busqueda = document.getElementById(
            `${datos.busqueda.campo}${elementoId}`
        );

        busqueda.disabled = true;
    }

    const registros = (await obtenerRegistros(datos)).datos;
    const paginado = (await obtenerPaginado(datos)).datos;

    datos.registros = registros;
    datos.paginado = paginado;

    renderizarTabla(datos);
}

</script>

</body>

</html>
