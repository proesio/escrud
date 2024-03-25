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
 * Realiza una petición para obtener todos los registros de la tabla.
 *
 * @param object datos
 * 
 * @return Promise
 */
function obtenerRegistros(datos) {
  const datosPeticion = convertirJsonAUrl({
    api: 'registros-obtener',
    config: JSON.stringify(datos.config),
    propiedades: JSON.stringify(datos.propiedades),
    inicio: datos.inicio,
    cantidad: datos.cantidad,
    busqueda: JSON.stringify(datos.busqueda)
  });

  const url = `${datos.config.ENTORNO.RUTA_PETICIONES}?${datosPeticion}`;

  return new Promise((respuesta) => {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', url, true);
    xhr.send();
    xhr.onreadystatechange = () => {
      if (xhr.readyState == 4) {
        respuesta(JSON.parse(xhr.responseText));
      }
    }
  });
}

/**
 * Realiza una petición para obtener un registro de la tabla.
 *
 * @param object datos
 * 
 * @return Promise
 */
function obtenerRegistro(datos) {
  const datosPeticion = convertirJsonAUrl({
    api: 'registro-obtener',
    valorLlavePrimaria: datos.valorLlavePrimaria,
    config: JSON.stringify(datos.config),
    propiedades: JSON.stringify(datos.propiedades)
  });

  const url = `${datos.config.ENTORNO.RUTA_PETICIONES}?${datosPeticion}`;

  return new Promise((respuesta) => {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', url, true);
    xhr.send();
    xhr.onreadystatechange = () => {
      if (xhr.readyState == 4) {
        respuesta(JSON.parse(xhr.responseText));
      }
    }
  });
}

/**
 * Realiza una petición para obtener el paginado 
 * automático según los registros de la tabla.
 *
 * @param object datos
 * 
 * @return Promise
 */
function obtenerPaginado(datos) {
  const datosPeticion = convertirJsonAUrl({
    api: 'paginado-obtener',
    config: JSON.stringify(datos.config),
    propiedades: JSON.stringify(datos.propiedades),
    busqueda: JSON.stringify(datos.busqueda)
  });

  const url = `${datos.config.ENTORNO.RUTA_PETICIONES}?${datosPeticion}`;

  return new Promise((respuesta) => {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', url, true);
    xhr.send();
    xhr.onreadystatechange = () => {
      if (xhr.readyState == 4) {
        respuesta(JSON.parse(xhr.responseText));
      }
    }
  });
}
