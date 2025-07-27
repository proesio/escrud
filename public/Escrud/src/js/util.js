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
 * Establece el estado cargando en un elemento HTML.
 *
 * @param string elementoId
 * @param string textoCargando
 * 
 * @return void
 */
function establecerEstadoCargando(elementoId, textoCargando, activo = true) {
  const elemento = document.getElementById(elementoId);

  if (elemento) {
    elemento.disabled = activo;
    elemento.innerHTML = textoCargando;
  }
}

/**
 * Convierte un objeto en una cadena con formato URL.
 *
 * @param object json
 * 
 * @return string
 */
function convertirJsonAUrl(json) {
  let url = '';

  for (dato in json) {
    url = `${url}${dato}=${json[dato]}&`;
  }

  return url.slice(0, -1);
}

/**
 * Verifica una cadena con formato JSON válido.
 *
 * @param string json
 * 
 * @return boolean
 */
function verificarJSON(json) {
  try {
    JSON.parse(json);
  }
  catch (e) {
    return false;
  }

  return true;
}

/**
 * Activa o desactiva la barra cargando de la tabla.
 *
 * @param string elementoId
 * @param boolean activar
 * 
 * @return void
 */
function barraCargando(elementoId, activar = true) {
  const barraSuperior = document.getElementById(elementoId);
  const barraInferior = document.getElementById(elementoId);

  if (barraSuperior && barraInferior) {
    const estado = activar ? 'block' : 'none';

    barraSuperior.style.display = estado;
    barraInferior.style.display = estado;
  }
}

/**
 * Filtra y obtiene los registros en regla para ser gestionados.
 *
 * @param object encabezado
 * @param object propiedades
 * @param string contexto
 * 
 * @return object
 */
function obtenerDatosRegistro(encabezado, propiedades, contexto) {
  const registro = {};

  encabezado.forEach((columna) => {
    if ((
      columna != propiedades.creadoEn
      && columna != propiedades.actualizadoEn
      && propiedades[contexto].includes(columna)
    )
      ||
      (
        columna != propiedades.creadoEn
        && columna != propiedades.actualizadoEn
        && propiedades[contexto].length == 0
      )
    ) {
      valor = document.getElementById(`escrud-campo-${columna}${propiedades.elementoId}`).value;
      registro[columna] = valor ? valor : null;
    }
  });

  return registro;
}

/**
 * Procesa la respuesta de la petición.
 *
 * @param string respuesta
 * @param object datos
 * @param string textoExitoso
 * 
 * @return void
 */
function procesarRespuesta(respuesta, datos, textoExitoso) {
  if (verificarJSON(respuesta)) {
    respuesta = JSON.parse(respuesta);

    if (respuesta.estado) {
      inicializarTabla({
        inicio: 0,
        cantidad: 5,
        busqueda: '',
        encabezado: datos.encabezado,
        propiedades: datos.propiedades,
        config: datos.config,
        textos: datos.textos
      });

      alerta({
        texto: textoExitoso,
        tipo: 'exito',
        elementoId: datos.propiedades.elementoId
      });
    } else {
      alerta({
        texto: respuesta.mensaje,
        tipo: 'error',
        elementoId: datos.propiedades.elementoId
      });
    }
  } else {
    alerta({
      texto: datos.textos.ERROR_DETECTADO,
      tipo: 'error',
      elementoId: datos.propiedades.elementoId
    });
  }

  cerrarModal(datos.modalId);
}

var timeout = null;

/**
 * Realiza una búsqueda en los registros de la tabla.
 *
 * @param object datos
 * @param number i
 * 
 * @return void
 */
function buscar(datos, i = 1) {
  if (timeout) {
    clearTimeout(timeout);
  }

  if (i <= 10) {
    timeout = setTimeout(() => {
      i++;
      buscar(datos, i);
    }, 100);
  } else {
    inicializarTabla(datos);
  }
}

var registrosTabla = [];

/**
 * Selecciona todos los registros mediante una casilla de verificación.
 *
 * @param object registros
 * @param object propiedades
 * 
 * @return void
 */
function chequearTodo(registros, propiedades) {
  registrosTabla = registros;

  const chequeador = document.getElementById(
    `escrud-check${propiedades.elementoId}`
  );

  const btnEliminarSeleccion = document.getElementById(
    `escrud-btn-eliminar-seleccion${propiedades.elementoId}`
  );

  registros.forEach((elemento) => {
    const check = document.getElementById(
      `escrud-check${propiedades.elementoId}${elemento[propiedades.llavePrimaria]}`
    );

    if (check) {
      if (chequeador.checked) {
        check.checked = true;
        btnEliminarSeleccion.style.display = 'inline';
      } else {
        check.checked = false;
        btnEliminarSeleccion.style.display = 'none';
      }
    }
  });
}

/**
 * Selecciona cada registro mediante una casilla de verificación.
 *
 * @param object registros
 * @param object propiedades
 * @param string elementoId
 * 
 * @return void
 */
function chequearRegistro(registros, propiedades, elementoId) {
  registrosTabla = registros;

  const check = document.getElementById(elementoId);

  const chequeador = document.getElementById(
    `escrud-check${propiedades.elementoId}`
  );

  const btnEliminarSeleccion = document.getElementById(
    `escrud-btn-eliminar-seleccion${propiedades.elementoId}`
  );

  let chequeado = 0;

  registros.forEach((elemento) => {
    const checkPivote = document.getElementById(
      `escrud-check${propiedades.elementoId}${elemento[propiedades.llavePrimaria]}`
    );

    if (checkPivote && checkPivote.checked) {
      chequeado++;
    }
  });

  if (check && check.checked && registros.length == chequeado) {
    chequeador.checked = true;
    btnEliminarSeleccion.style.display = 'inline';
  } else if (check && check.checked) {
    btnEliminarSeleccion.style.display = 'inline';
  } else if (check && !check.checked && chequeado == 0) {
    chequeador.checked = false;
    btnEliminarSeleccion.style.display = 'none';
  } else {
    chequeador.checked = false;
  }
}
