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
 * Realiza una petición para editar un registro en la tabla.
 *
 * @param object datos
 * 
 * @return void
 */
function editar(datos) {
  const url = `${datos.config.ENTORNO.RUTA_PETICIONES}`;

  establecerEstadoCargando(datos.btnId, datos.textos.CARGANDO);

  const xhr = new XMLHttpRequest();
  xhr.open('PUT', url, true);
  xhr.setRequestHeader('content-type', 'application/json; charset=UTF-8');
  xhr.send(JSON.stringify({
    api: 'editar',
    registro: obtenerDatosRegistro(datos.encabezado, datos.propiedades, 'actualizables'),
    config: JSON.stringify(datos.config),
    propiedades: JSON.stringify(datos.propiedades),
    valorLlavePrimaria: datos.valorLlavePrimaria
  }));
  xhr.onreadystatechange = () => {
    if (xhr.readyState == 4) {
      procesarRespuesta(xhr.responseText, datos, datos.textos.REGISTRO_EDITADO_EXITOSAMENTE);
      establecerEstadoCargando(datos.btnId, datos.btnTexto, false);
    }
  }
}
