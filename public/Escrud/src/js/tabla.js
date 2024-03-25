/**
 * Este archivo es parte del proyecto Escrud.
 * 
 * @author    Juan Felipe Valencia Murillo  <juanfe0245@gmail.com>
 * @copyright 2020 - presente  Juan Felipe Valencia Murillo
 * @license   https://opensource.org/licenses/MIT  MIT License
 * @version   GIT:  2.6.7
 * @link      https://escrud.proes.io
 * @since     Fecha inicio de creación del proyecto  2020-05-31
 */

/**
 * Renderiza la interfaz de la tabla.
 *
 * @param object datos
 * 
 * @return void
 */
function renderizarTabla(datos) {
  const elementoId = datos.propiedades.elementoId;
  const url = `${datos.config.ENTORNO.URL_BASE}Vistas/tabla_estructura.php`;

  const xhr = new XMLHttpRequest();
  xhr.open('POST', url, true);
  xhr.setRequestHeader('content-type', 'application/json; charset=UTF-8');
  xhr.send(JSON.stringify(datos));
  xhr.onreadystatechange = () => {
    if (xhr.readyState == 4) {
      document.getElementById(`escrud-tabla${elementoId}`).innerHTML = xhr.responseText;
      document.getElementById(`escrud-btn-eliminar-seleccion${elementoId}`).style.display = 'none';
      barraCargando(`escrud-barra-cargando-superior${elementoId}`, false);
      barraCargando(`escrud-barra-cargando-inferior${elementoId}`, false);

      if (datos.busqueda && datos.busqueda.valor) {
        const busqueda = document.getElementById(`escrud-busqueda${datos.busqueda.campo}${elementoId}`);

        busqueda.value = datos.busqueda.valor;
        busqueda.focus();
      }
    }
  }
}
