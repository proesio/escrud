/**
 * Este archivo es parte del proyecto Escrud.
 * 
 * @author    Juan Felipe Valencia Murillo  <juanfe0245@gmail.com>
 * @copyright 2020 - presente  Juan Felipe Valencia Murillo
 * @license   https://opensource.org/licenses/MIT  MIT License
 * @version   GIT:  2.6.0
 * @link      https://escrud.proes.io
 * @since     Fecha inicio de creación del proyecto  2020-05-31
 */

/**
 * Abre un modal para la creación de un registro.
 *
 * @param object datos
 * 
 * @return void
 */
function abrirModalCrear(datos) {
  const elementoId = datos.atributos.elementoId;
  const url = `${datos.config.ENTORNO.URL_BASE}Vistas/modal_crear.php`;

  barraCargando(`barra-cargando-superior${elementoId}`);
  barraCargando(`barra-cargando-inferior${elementoId}`);

  const xhr = new XMLHttpRequest();
  xhr.open('POST', url, true);
  xhr.setRequestHeader('content-type', 'application/json; charset=UTF-8');
  xhr.send(JSON.stringify(datos));
  xhr.onreadystatechange = () => {
    if (xhr.readyState == 4) {
      document.getElementById(
        `modal${elementoId}`
      ).innerHTML = xhr.responseText;

      barraCargando(`barra-cargando-superior${elementoId}`, false);
      barraCargando(`barra-cargando-inferior${elementoId}`, false);
    }
  }
}

/**
 * Abre un modal para la edición de un registro.
 *
 * @param object datos
 * 
 * @return void
 */
async function abrirModalEditar(datos) {
  const elementoId = datos.atributos.elementoId;
  const url = `${datos.config.ENTORNO.URL_BASE}Vistas/modal_editar.php`;

  barraCargando(`barra-cargando-superior${elementoId}`);
  barraCargando(`barra-cargando-inferior${elementoId}`);

  const respuesta = await obtenerRegistro(datos);
  datos.registro = respuesta.datos;

  const xhr = new XMLHttpRequest();
  xhr.open('POST', url, true);
  xhr.setRequestHeader('content-type', 'application/json; charset=UTF-8');
  xhr.send(JSON.stringify(datos));
  xhr.onreadystatechange = () => {
    if (xhr.readyState == 4) {
      document.getElementById(
        `modal${elementoId}`
      ).innerHTML = xhr.responseText;

      barraCargando(`barra-cargando-superior${elementoId}`, false);
      barraCargando(`barra-cargando-inferior${elementoId}`, false);
    }
  }
}

/**
 * Abre un modal para la eliminación de un registro.
 *
 * @param object datos
 * 
 * @return void
 */
function abrirModalEliminar(datos) {
  const elementoId = datos.atributos.elementoId;
  const url = `${datos.config.ENTORNO.URL_BASE}Vistas/modal_eliminar.php`;

  barraCargando(`barra-cargando-superior${elementoId}`);
  barraCargando(`barra-cargando-inferior${elementoId}`);

  if (datos.masivo) {
    let i = 0;

    datos.valorLlavesPrimarias = [];

    registrosTabla.forEach((elemento) => {
      const check = document.getElementById(
        `check${elementoId}${elemento[datos.atributos.llavePrimaria]}`
      );

      if (check.checked) {
        datos.valorLlavesPrimarias[i] = isNaN(elemento[datos.atributos.llavePrimaria])
          ? elemento[datos.atributos.llavePrimaria] : Number(elemento[datos.atributos.llavePrimaria]);
        i++;
      }
    });
  }

  const xhr = new XMLHttpRequest();
  xhr.open('POST', url, true);
  xhr.setRequestHeader('content-type', 'application/json; charset=UTF-8');
  xhr.send(JSON.stringify(datos));
  xhr.onreadystatechange = () => {
    if (xhr.readyState == 4) {
      document.getElementById(`modal${elementoId}`).innerHTML = xhr.responseText;
    }

    barraCargando(`barra-cargando-superior${elementoId}`, false);
    barraCargando(`barra-cargando-inferior${elementoId}`, false);
  }
}

/**
 * Cierra un modal.
 *
 * @param string modalId
 * 
 * @return void
 */
function cerrarModal(modalId) {
  const modal = document.getElementById(modalId);

  if (modal) {
    modal.style.display = 'none';
  }
}
