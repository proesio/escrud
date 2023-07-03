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
 * Realiza una petición para crear un registro en la tabla.
 *
 * @param object datos
 * 
 * @return void
 */
function crear(datos) {
  const url = `${datos.config.ENTORNO.RUTA_PETICIONES}`;

  establecerEstadoCargando(datos.btnId, datos.textos.CARGANDO);

  const xhr = new XMLHttpRequest();
  xhr.open('POST', url, true);
  xhr.setRequestHeader('content-type', 'application/x-www-form-urlencoded; charset=UTF-8');
  xhr.send(convertirJsonAUrl({
    api: 'crear',
    registro: JSON.stringify(obtenerDatosRegistro(datos.encabezado, datos.atributos, 'insertables')),
    config: JSON.stringify(datos.config),
    atributos: JSON.stringify(datos.atributos)
  }));
  xhr.onreadystatechange = () => {
    if (xhr.readyState == 4) {
      procesarRespuesta(xhr.responseText, datos, datos.textos.REGISTRO_CREADO_EXITOSAMENTE);
      establecerEstadoCargando(datos.btnId, datos.btnTexto, false);
    }
  }
}
