/**
 * Este archivo es parte del proyecto Escrud.
 * 
 * @author    Juan Felipe Valencia Murillo  <juanfe0245@gmail.com>
 * @copyright 2020 - presente  Juan Felipe Valencia Murillo
 * @license   https://opensource.org/licenses/MIT  MIT License
 * @version   GIT:  2.0.0
 * @link      https://escrud.proes.io
 * @since     Fecha inicio de creación del proyecto  2020-05-31
 */

var menu = null;

document.onclick = () => {
  if (menu) {
    menu.style.display = 'none';
    menu = null;
  }
}

/**
 * Abre un menú contextual.
 *
 * @param string menuId
 * 
 * @return void
 */
function abrirMenu(menuId) {
  setTimeout(() => {
    menu = document.getElementById(menuId);
    menu.style.display = 'flex';
  });
}
