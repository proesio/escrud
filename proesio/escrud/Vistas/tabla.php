<?php
/*
 * Autor: Juan Felipe Valencia Murillo
 * Fecha inicio de creación: 31-05-2020
 * Fecha última modificación: 27-08-2020
 * Versión: 1.1.0
 * Sitio web: https://escrud.proes.tk
 *
 * Copyright (C) 2020 Juan Felipe Valencia Murillo <juanfe0245@gmail.com>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to
 * deal in the Software without restriction, including without limitation the
 * rights to use, copy, modify, merge, publish, distribute, sublicense, and/or
 * sell copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS
 * IN THE SOFTWARE.
   
 * Traducción al español de la licencia MIT
   
 * Copyright (C) 2020 Juan Felipe Valencia Murillo <juanfe0245@gmail.com>

 * Se concede permiso por la presente, libre de cargos, a cualquier persona
 * que obtenga una copia de este software y de los archivos de documentación asociados 
 * (el "Software"), a utilizar el Software sin restricción, incluyendo sin limitación 
 * los derechos a usar, copiar, modificar, fusionar, publicar, distribuir, sublicenciar, 
 * y/o vender copias del Software, y a permitir a las personas a las que se les proporcione 
 * el Software a hacer lo mismo, sujeto a las siguientes condiciones:

 * El aviso de copyright anterior y este aviso de permiso se incluirán 
 * en todas las copias o partes sustanciales del Software.

 * EL SOFTWARE SE PROPORCIONA "COMO ESTÁ", SIN GARANTÍA DE NINGÚN TIPO, EXPRESA O IMPLÍCITA,
 * INCLUYENDO PERO NO LIMITADO A GARANTÍAS DE COMERCIALIZACIÓN, IDONEIDAD PARA UN PROPÓSITO
 * PARTICULAR E INCUMPLIMIENTO. EN NINGÚN CASO LOS AUTORES O PROPIETARIOS DE LOS DERECHOS DE AUTOR
 * SERÁN RESPONSABLES DE NINGUNA RECLAMACIÓN, DAÑOS U OTRAS RESPONSABILIDADES, YA SEA EN UNA ACCIÓN
 * DE CONTRATO, AGRAVIO O CUALQUIER OTRO MOTIVO, DERIVADAS DE, FUERA DE O EN CONEXIÓN
 * CON EL SOFTWARE O SU USO U OTRO TIPO DE ACCIONES EN EL SOFTWARE.
 */

use Escrud\Clases\Texto;

$config = json_decode($html->obtenerConfiguracion(),true);
$entorno = $config['ENTORNO'];

?>

<!DOCTYPE html>

<html>

<head>
    <link rel="stylesheet" href="<?=$entorno['URL_BASE'].'css/tabla.css'; ?>"/> 
    <link rel="stylesheet" href="<?=$entorno['URL_BASE'].'css/modal.css'; ?>"/>
    <link rel="stylesheet" href="<?=$entorno['URL_BASE'].'css/alertas.css'; ?>"/>
    <link rel="stylesheet" href="<?=$entorno['URL_BASE'].'css/barra-cargando.css'; ?>"/>
</head>

<body>

<div class="contenedor">

<div class="contenedor-barra">

<?php include 'barra_cargando.php'; ?>

</div>

<button
    onclick='abrirModalCrear({
        encabezado:<?=$html->obtenerEncabezado(); ?>,
        atributos:<?=$html->obtenerAtributos(); ?>,
        config:<?=$html->obtenerConfiguracion(); ?>,
        textos:<?=Texto::obtenerTextos(); ?>,
    })'
    class="btn btn-crear"
>
    <?=Texto::$textos['CREAR_REGISTRO']; ?>
</button>

<?php include 'tabla_buscador.php'; ?>

<div id="<?='tabla'.$html->elementoId; ?>"></div>

</div>

<div id="<?='modal'.$html->elementoId; ?>"></div>

<div id="<?='alerta'.$html->elementoId; ?>"></div>

<script type="text/javascript" src="<?=$entorno['URL_BASE'].'js/util.js'; ?>"></script>
<script type="text/javascript" src="<?=$entorno['URL_BASE'].'js/tabla.js'; ?>"></script>
<script type="text/javascript" src="<?=$entorno['URL_BASE'].'js/modal.js'; ?>"></script>
<script type="text/javascript" src="<?=$entorno['URL_BASE'].'js/alertas.js'; ?>"></script>
<script type="text/javascript" src="<?=$entorno['URL_BASE'].'js/crear.js'; ?>"></script>
<script type="text/javascript" src="<?=$entorno['URL_BASE'].'js/consultar.js'; ?>"></script>
<script type="text/javascript" src="<?=$entorno['URL_BASE'].'js/editar.js'; ?>"></script>
<script type="text/javascript" src="<?=$entorno['URL_BASE'].'js/eliminar.js'; ?>"></script>

<script type="text/javascript">

inicializarTabla({
    inicio: 0,
    cantidad: 5,
    busqueda: '',
    encabezado: <?=$html->obtenerEncabezado(); ?>,
    atributos: <?=$html->obtenerAtributos(); ?>,
    config: <?=$html->obtenerConfiguracion(); ?>,
    textos: <?=Texto::obtenerTextos(); ?>,
    cargaInicial: true
});

async function inicializarTabla(datos){
    let elementoId = datos.atributos.elementoId;
    barraCargando(`barra-cargando${elementoId}`);
    registros = datos.cargaInicial
        ? <?=$html->obtenerRegistros(); ?>
        : (await obtenerRegistros(datos)).datos;
    paginado = datos.cargaInicial
        ? <?=$html->obtenerPaginado(); ?>
        : (await obtenerPaginado(datos)).datos;
    datos.registros = registros;
    datos.paginado = paginado;
    if(datos.cargaInicial){
        setTimeout(() => {
            renderizarTabla(datos);
        }, (elementoId)*1000);
    }
    else{
        renderizarTabla(datos);
    }
}

</script>

</body>

</html>