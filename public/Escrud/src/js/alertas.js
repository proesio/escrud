/**
 * Este archivo es parte del proyecto Escrud.
 * 
 * @author    Juan Felipe Valencia Murillo  <juanfe0245@gmail.com>
 * @copyright 2020 - presente  Juan Felipe Valencia Murillo
 * @license   https://opensource.org/licenses/MIT  MIT License
 * @version   GIT:  3.0.0
 * @link      https://escrud.proes.io
 * @since     Fecha inicio de creación del proyecto  2020-05-31
 */

/**
 * Muestra una alerta según la configuración suministrada.
 *
 * @param object datos
 * 
 * @return void
 */
function alerta(datos) {
  datos = validarDatos(datos);
  const alerta = document.getElementById(`escrud-alerta${datos.elementoId}`);

  alerta.style.display = 'block';

  const html = `<div class="escrud-alerta escrud-alerta-${datos.tipo}">
    <div class="escrud-contenido">${datos.texto}</div>
    <div class="escrud-cerrar-alerta" onclick="cerrarAlerta(${datos.elementoId})">&times;</div>
  </div>`;

  alerta.innerHTML = html;

  setTimeout(() => {
    cerrarAlerta(datos.elementoId);
  }, datos.tiempo);
}

/**
 * Valida los datos de la configuración para la alerta.
 *
 * @param object datos
 * 
 * @return object
 */
function validarDatos(datos) {
  datos.texto = datos.texto ? datos.texto : '';
  datos.tipo = datos.tipo ? datos.tipo : 'info';
  datos.tiempo = datos.tiempo ? datos.tiempo : 5000;

  return datos;
}

/**
 * Cierra una alerta.
 *
 * @param number elementoId
 * 
 * @return void
 */
function cerrarAlerta(elementoId) {
  const alerta = document.getElementById(`escrud-alerta${elementoId}`);

  if (alerta) {
    alerta.style.display = 'none';
  }
}
